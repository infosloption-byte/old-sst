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
    Route::group(['prefix' => 'admin/employee','middleware' => ['permission:master.data'], 'namespace' => 'System\Employee\Http\Controllers'], function(){

      Route::get('generateImage', 'EmployeeController@generateImage')->name('employee.list');

      Route::get('list', 'EmployeeController@listView')->name('employee.list');

      Route::post('create', 'EmployeeController@create')->name('employee.create');
      
      Route::post('update', 'EmployeeController@update')->name('employee.update');

      Route::post('delete', 'EmployeeController@delete')->name('employee.delete');
      
      Route::post('deleteWithRelations', 'EmployeeController@deleteWithRelations')->name('employee.delete');

      Route::post('resetPassword', 'EmployeeController@resetPassword')->name('employee.list');

      Route::post('updateProfilePicture', 'EmployeeController@updateProfilePicture')->name('employee.list');

	  //AJAX
      Route::get('getroles', 'EmployeeController@getroles')->name('employee.list');
      
      Route::get('getemployee', 'EmployeeController@getemployee')->name('employee.list');

      Route::get('getDepartments', 'EmployeeController@getDepartments')->name('employee.list');
      
      Route::get('getSupervisors', 'EmployeeController@getSupervisors')->name('employee.list');

      Route::get('getDesignations', 'EmployeeController@getDesignations')->name('employee.list');

      Route::get('send-account-details', 'EmployeeController@sendAccountDetails')->name('employee.list');

    });
});