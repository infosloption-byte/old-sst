<?php

/*
|--------------------------------------------------------------------------
| Admin Report Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['web']], function()
{
	Route::group(['prefix' => '/admin/report','middleware' => ['permission:report'], 'namespace' => 'App\Modules\ReportManage\Controllers'], function(){

	    Route::get('employee-work-summery', 'ReportController@employeeWorkSummeryReport')->name('admin.report.list');

	    Route::get('employee-work-summery-json-list', 'ReportController@employeeWorkSummeryJsonList')->name('admin.report.list');
	    
	    Route::get('employee-work-summery-export-list', 'ReportController@exportEmployeeWorkSummeryData')->name('admin.report.list');

	});
});