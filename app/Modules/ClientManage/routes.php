<?php

/*
|--------------------------------------------------------------------------
| Admin Client route
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['web']], function()
{
	Route::group(['prefix' => 'admin/client','middleware' => ['permission:client'], 'namespace' => 'App\Modules\ClientManage\Controllers'], function(){

		Route::get('index', 'ClientController@listView')->name('admin.client.list');

		Route::post('create', 'ClientController@create')->name('admin.client.create');

		Route::post('update', 'ClientController@update')->name('admin.client.update');

		Route::post('delete', 'ClientController@delete')->name('admin.client.delete');

		Route::post('deleteWithRelations', 'ClientController@deleteWithRelations')->name('admin.client.delete');

		Route::post('resetPassword', 'ClientController@resetPassword')->name('admin.client.list');

		//AJAX
		Route::get('getroles', 'ClientController@getroles')->name('admin.client.list');

		Route::get('getemployee', 'ClientController@getemployee')->name('admin.client.list');

		Route::get('getDepartments', 'ClientController@getDepartments')->name('admin.client.list');

		Route::get('getSupervisors', 'ClientController@getSupervisors')->name('admin.client.list');

		Route::get('send-account-details', 'ClientController@sendAccountDetails')->name('admin.client.list');

	});
});