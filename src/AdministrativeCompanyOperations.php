<?php

namespace Poyrazenes\AdministrativeCompanyOperations;

use Illuminate\Support\Facades\Http;

class AdministrativeCompanyOperations
{
    public function justDoIt()
    {
        return Http::get('https://littlelunches.com/en/hofsdfsdfme');
    }
}