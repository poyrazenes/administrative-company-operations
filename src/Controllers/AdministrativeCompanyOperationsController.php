<?php

namespace App\Http\Controllers;

use App\Mail\AdministrativeCompanyOperationVerificationCode;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Validation\ValidationException;

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

        $validated = $request->validate($rules, $inputs);

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

        $validated['code'] = Str::random(6);
        $validated['expires_at'] = now()->addMinutes(5);

        $is_existed = DB::table('administrative_company_operations')
            ->where('type', $validated['type'])->exists();

        if ($is_existed) {
            $is_operated = DB::table('administrative_company_operations')
                ->where('type', $validated['type'])
                ->update($validated);
        } else {
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

        //Mail::to(['enes.poyraz@4alabs.io'])->send(new AdministrativeCompanyOperationVerificationCode($row));


        return redirect()->action('AdministrativeCompanyOperationsController@verifyOperation', ['id' => $row->id])->with([
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

        return view('administrative_company_operations.verify_operation', [
            'row' => $row
        ]);
    }

    public function verifyOperation(Request $request)
    {
        $id = (int)$request->input('id');

        $row = DB::table('administrative_company_operations')
            ->where('id', $id)->first();

        if (!$row) {
            return redirect()->action('AdministrativeCompanyOperationsController@viewAddNewOperation')->with([
                'form_result_alert_type' => 'danger',
                'form_result_alert_title' => 'Fail!',
                'form_result_messages' => ['Verification failed!']
            ]);
        }

        $code = $request->input('code');

        if (!isset($code)) {
            return redirect()->action('AdministrativeCompanyOperationsController@viewAddNewOperation')->with([
                'form_result_alert_type' => 'danger',
                'form_result_alert_title' => 'Fail!',
                'form_result_messages' => ['Verification failed!']
            ]);
        }

        if ($row->code !== $code) {
            DB::table('administrative_company_operations')
                ->where('id', $row->id)
                ->delete();

            return redirect()->action('AdministrativeCompanyOperationsController@viewAddNewOperation')->with([
                'form_result_alert_type' => 'danger',
                'form_result_alert_title' => 'Fail!',
                'form_result_messages' => ['Verification failed!']
            ]);
        }

        DB::table('administrative_company_operations')
            ->where('id', $row->id)
            ->update(['is_approved' => true]);

        return redirect()->action('AdministrativeCompanyOperationsController@viewAddNewOperation')->with([
            'form_result_alert_type' => 'success',
            'form_result_alert_title' => 'Success!',
            'form_result_messages' => ['Verification successfully completed!']
        ]);
    }
}
