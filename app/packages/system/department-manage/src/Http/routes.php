<?php
/**
 * MENU MANAGEMENT ROUTES
 *
 * @version 1.0.0
 * @author Yasith Samarawickrama <yazith11@gmail.com>
 * @copyright 2015 Yasith Samarawickrama
 */

/**
 * USER AUTHENTICATION MIDDLEWARE
 */
Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'admin/department','middleware' => ['permission:master.data'], 'namespace' => 'System\Department\Http\Controllers'], function(){

      Route::get('list', 'DepartmentController@listView')->name('department.list');

      Route::post('create', 'DepartmentController@create')->name('department.create');
      
      Route::post('update', 'DepartmentController@update')->name('department.update');

      Route::post('delete', 'DepartmentController@delete')->name('department.delete');

      Route::post('delete/withreleated', 'DepartmentController@deleteWithreleated')->name('department.delete');
      
      Route::get('getDepartments', 'DepartmentController@getDepartments')->name('department.list');
     
      Route::get('getDepartment', 'DepartmentController@getDepartment')->name('department.list');

    });
});