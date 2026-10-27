<?php

/*
|--------------------------------------------------------------------------
| Admin Appointment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['web']], function()
{
	Route::group(['prefix' => '/admin','middleware' => ['permission:appointment.list'], 'namespace' => 'App\Modules\AppointmentManage\Controllers'], function(){

	    Route::get('appointments', 'AppointmentController@index')->name('admin.appointment.list');

	    Route::get('appointments/get-appointment-list', 'AppointmentController@getInquiryListJson')->name('admin.appointment.list');
	});
});