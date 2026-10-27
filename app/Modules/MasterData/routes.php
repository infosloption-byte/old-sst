<?php

/*
|--------------------------------------------------------------------------
| Admin Master Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['web']], function()
{
	Route::group(['prefix' => '/admin/master','middleware' => ['permission:master.data'], 'namespace' => 'App\Modules\MasterData\Controllers'], function()
	{
		//////////////// designation routes /////////////////////

	    Route::get('designation', 'MasterDataController@designationView')->name('master.data.designation');

	    Route::get('get-designation-list', 'MasterDataController@getDesignationList')->name('master.data.designation');
	    
	    Route::post('create-designation', 'MasterDataController@createDesignation')->name('master.data.designation');

	    Route::post('update-designation', 'MasterDataController@updateDesignation')->name('master.data.designation');

	    Route::post('delete-designation', 'MasterDataController@deleteDesignation')->name('master.data.designation');

	    //////////////// Cost type routes /////////////////////

	    Route::get('cost-type', 'MasterDataController@costTypeView')->name('master.data.costType');

	    Route::get('get-cost-type-list', 'MasterDataController@getCostTypeList')->name('master.data.costType');
	    
	    Route::post('create-cost-type', 'MasterDataController@createCostType')->name('master.data.costType');

	    Route::post('update-cost-type', 'MasterDataController@updateCostType')->name('master.data.costType');

	    Route::post('delete-cost-type', 'MasterDataController@deleteCostType')->name('master.data.costType');

	});
});