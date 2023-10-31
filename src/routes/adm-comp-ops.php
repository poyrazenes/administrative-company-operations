<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('/4a-labs-administrative-company-operations')
    ->name('adm-comp-ops.')
    ->middleware([
        \Illuminate\Session\Middleware\StartSession::class
    ])
    ->namespace('Poyrazenes\AdministrativeCompanyOperations\Controllers')
    ->group(function () {
        Route::redirect('/', '/4a-labs-administrative-company-operations/add-new-operation');

        Route::prefix('/add-new-operation')->group(function () {
            Route::get('/', 'AdministrativeCompanyOperationsController@viewAddNewOperation')
                ->name('view-add-operation');

            Route::post('/', 'AdministrativeCompanyOperationsController@addNewOperation')
                ->name('add-new-operation');
        });
        Route::prefix('/verify-operation')->group(function () {
            Route::get('/', 'AdministrativeCompanyOperationsController@viewVerifyOperation')
                ->name('view-verify-operation');

            Route::post('/', 'AdministrativeCompanyOperationsController@verifyOperation')
                ->name('verify-operation');
        });
    });
