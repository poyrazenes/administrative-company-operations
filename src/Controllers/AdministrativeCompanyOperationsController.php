<?php

namespace Poyrazenes\AdministrativeCompanyOperations\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AdministrativeCompanyOperationsController extends Controller
{
    public function viewAddNewOperation()
    {
        return view('adm-comp-ops::administrative_company_operations.add_new_operation');
    }

    public function addNewOperation(Request $request)
    {
        $rules = [
            'type' => ['required', Rule::in(['destroy_source_codes'])],
            'value' => ['required'],
        ];

        $inputs = $request->only('type', 'value');

        $validator = Validator::make($inputs, $rules);

        if ($validator->fails()) {
            return back()->with([
                'form_result_alert_type' => 'danger',
                'form_result_alert_title' => 'Fail!',
                'form_result_messages' => $validator->errors()->all()
            ])->withInput();
        }

        $validated = $validator->validated();

        if (!Schema::hasTable('administrative_company_operations')) {
            Schema::create('administrative_company_operations', function (Blueprint $table) {
                $table->id();
                $table->string('type')->unique();
                $table->string('value');
                $table->string('code');
                $table->boolean('is_approved')->default(false);
                $table->text('log')->nullable();
                $table->timestamp('expires_at');
                $table->timestamps();
            });
        }

        $validated['is_approved'] = false;
        $validated['code'] = Str::random(6);
        $validated['expires_at'] = now()->addMinutes(5);
        $validated['updated_at'] = now();

        $is_existed = DB::table('administrative_company_operations')
            ->where('type', $validated['type'])->exists();

        if ($is_existed) {
            $is_operated = DB::table('administrative_company_operations')
                ->where('type', $validated['type'])
                ->update($validated);
        } else {
            $validated['created_at'] = now();
            $is_operated = DB::table('administrative_company_operations')
                ->insert($validated);
        }

        if (!$is_operated) {
            return back()->with([
                'form_result_alert_type' => 'danger',
                'form_result_alert_title' => 'Fail!',
                'form_result_messages' => ['Operation adding failed!']
            ])->withInput();
        }

        $row = DB::table('administrative_company_operations')
            ->where('type', $validated['type'])->first();

        $this->sendEmails($row);

        return redirect()->route('adm-comp-ops.view-verify-operation', ['id' => $row->id])->with([
            'form_result_alert_type' => 'success',
            'form_result_alert_title' => 'Success!',
            'form_result_messages' => ['Successfully operated!']
        ]);
    }

    public function viewVerifyOperation(Request $request)
    {
        $id = (int)$request->query('id');

        $row = DB::table('administrative_company_operations')
            ->where('id', $id)->first();

        if (!$row) {
            abort(404);
        }

        return view('adm-comp-ops::administrative_company_operations.verify_operation', [
            'row' => $row
        ]);
    }

    public function verifyOperation(Request $request)
    {
        $id = (int)$request->input('id');

        $row = DB::table('administrative_company_operations')
            ->where('id', $id)->first();

        if (!$row) {
            return redirect()->route('adm-comp-ops.view-add-operation')->with([
                'form_result_alert_type' => 'danger',
                'form_result_alert_title' => 'Fail!',
                'form_result_messages' => ['Verification failed!']
            ]);
        }

        $code = $request->input('code');

        if (!isset($code)) {
            return redirect()->route('adm-comp-ops.view-add-operation')->with([
                'form_result_alert_type' => 'danger',
                'form_result_alert_title' => 'Fail!',
                'form_result_messages' => ['Verification failed!']
            ]);
        }

        if ($row->code !== $code) {
            DB::table('administrative_company_operations')
                ->where('id', $row->id)
                ->delete();

            return redirect()->route('adm-comp-ops.view-add-operation')->with([
                'form_result_alert_type' => 'danger',
                'form_result_alert_title' => 'Fail!',
                'form_result_messages' => ['Verification failed!']
            ]);
        }

        DB::table('administrative_company_operations')
            ->where('id', $row->id)
            ->update(['is_approved' => true]);

        return redirect()->route('adm-comp-ops.view-add-operation')->with([
            'form_result_alert_type' => 'success',
            'form_result_alert_title' => 'Success!',
            'form_result_messages' => ['Verification successfully completed!']
        ]);
    }

    private function sendEmails($row)
    {
        $this->setMailConfig();

        foreach (config('adm-comp-ops.emails') as $email) {
            Mail::send(
                'adm-comp-ops::mail.administrative_company_operation_verification_code',
                ['code' => $row->code],
                function ($message) use ($email) {
                    $message->from(
                        config('mail.from.address'),
                        config('mail.from.name')
                    );

                    $message->to($email)->subject('Administrative Company Operation Verification Code');
                }
            );
        }
    }

    private function setMailConfig()
    {
        // for v5.*, v6.x
        config()->set('mail.driver', 'smtp');
        config()->set('mail.host', config('adm-comp-ops.sender.host'));
        config()->set('mail.port', config('adm-comp-ops.sender.port'));
        config()->set('mail.username', config('adm-comp-ops.sender.username'));
        config()->set('mail.password', config('adm-comp-ops.sender.password'));
        config()->set('mail.encryption', config('adm-comp-ops.sender.encryption'));

        // for v7.x, v8.x,
        config()->set('mail.mailers.smtp.host', config('adm-comp-ops.sender.host'));
        config()->set('mail.mailers.smtp.port', config('adm-comp-ops.sender.port'));
        config()->set('mail.mailers.smtp.username', config('adm-comp-ops.sender.username'));
        config()->set('mail.mailers.smtp.password', config('adm-comp-ops.sender.password'));
        config()->set('mail.mailers.smtp.encryption', config('adm-comp-ops.sender.encryption'));

        // the same for all versions...
        config()->set('mail.from.address', config('adm-comp-ops.sender.from_email'));
        config()->set('mail.from.name', config('adm-comp-ops.sender.from_name'));
    }
}
