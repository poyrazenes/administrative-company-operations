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

Route::prefix('/administrative-company-operations')->group(function () {
    Route::redirect('/', '/administrative-company-operations/add-new-operation');

    Route::prefix('/add-new-operation')->group(function () {
        Route::get('/', 'AdministrativeCompanyOperationsController@viewAddNewOperation');
        Route::post('/', 'AdministrativeCompanyOperationsController@addNewOperation');
    });
    Route::prefix('/verify-operation')->group(function () {
        Route::get('/', 'AdministrativeCompanyOperationsController@viewVerifyOperation');
        Route::post('/', 'AdministrativeCompanyOperationsController@verifyOperation');
    });
});
