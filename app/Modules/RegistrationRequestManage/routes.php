<?php

/*
|--------------------------------------------------------------------------
| Registration Request Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'admin/registration','middleware' => ['permission:registration'], 'namespace' => 'App\Modules\RegistrationRequestManage\Controllers'], function(){

        Route::get('index', 'RegistrationRequestManageController@index')->name('registration.index');

        Route::get('get-registration-request-data', 'RegistrationRequestManageController@getRegistrationRequestData')->name('registration.index');

        Route::post('approve', 'RegistrationRequestManageController@approveRequest')->name('registration.index');

        Route::post('reject', 'RegistrationRequestManageController@rejectRequest')->name('registration.index');

    });

});
