<?php

/*
|--------------------------------------------------------------------------
| Profile Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'admin/profile','middleware' => ['permission:profile'], 'namespace' => 'App\Modules\ProfileManage\Controllers'], function(){

        Route::get('index', 'ProfileManageController@index')->name('profile.manage.index');
        
        Route::get('getChartData', 'ProfileManageController@getChartData')->name('profile.manage.index');

        Route::get('get-body-measurement', 'ProfileManageController@getBodyMeasurement')->name('profile.manage.body.measurement');

        /*****POST*****/

        Route::post('save-basic-details', 'ProfileManageController@saveBasicProfileDetails')->name('profile.manage.save.basic');

        Route::post('resetPassword', 'ProfileManageController@resetPassword')->name('profile.manage.reset.password');

        Route::post('save-body-measure-details', 'ProfileManageController@saveBodyMeasureDetails')->name('profile.manage.save.body.measurement');

    });

});
