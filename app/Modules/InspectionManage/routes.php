<?php

/*
|--------------------------------------------------------------------------
| Admin Inspection Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['web']], function()
{
	Route::group(['prefix' => '/admin/inspection','middleware' => ['permission:inspection'], 'namespace' => 'App\Modules\InspectionManage\Controllers'], function(){

	    Route::get('index', 'InspectionController@index')->name('admin.inspection.list');

	    Route::get('get-inspections-list', 'InspectionController@getInspectionList')->name('admin.inspection.list');

	    Route::get('view-details', 'InspectionController@viewDetails')->name('admin.inspection.detail');

	    Route::get('get-inspections-data', 'InspectionController@getInpectionDetails')->name('admin.inspection.detail');

	    Route::get('export-pdf', 'InspectionController@exportReportPdf')->name('admin.inspection.detail');

	});
});