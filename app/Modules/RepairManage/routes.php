<?php

/*
|--------------------------------------------------------------------------
| Admin Repair Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['web']], function()
{
	Route::group(['prefix' => '/admin/repair','middleware' => ['permission:repair'], 'namespace' => 'App\Modules\RepairManage\Controllers'], function(){

	    Route::get('index', 'RepairController@index')->name('admin.repair.list');

	    Route::get('get-repair-list', 'RepairController@getRepairList')->name('admin.repair.list');

	    Route::get('repairTypeList', 'RepairController@repairTypeList')->name('admin.repair.create');

	    Route::get('get-users', 'RepairController@getUsers')->name('admin.repair.index');
	    
	    Route::get('create', 'RepairController@createRepairView')->name('admin.repair.create');

	    Route::post('create', 'RepairController@createRepair')->name('admin.repair.create');

	    Route::post('delete', 'RepairController@deleteRepair')->name('admin.repair.delete');

	    Route::post('update', 'RepairController@updateRepair')->name('admin.repair.update');

	    Route::post('delete-repair-image', 'RepairController@deleteRepairAttachment')->name('admin.repair.update');

	    Route::any('export-data', 'RepairController@exportRepairData')->name('admin.repair.index');

	});
});