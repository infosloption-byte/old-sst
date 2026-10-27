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
    Route::group(['prefix' => 'admin/user/role','middleware' => ['permission:master.data'],'namespace' => 'System\UserRoles\Http\Controllers'], function(){

      Route::get('list', 'UserRoleController@listView')->name('user.role.list');
      Route::post('create', 'UserRoleController@create')->name('user.role.create');
      Route::post('update', 'UserRoleController@update')->name('user.role.update');
      Route::post('delete', 'UserRoleController@delete')->name('user.role.delete');
      Route::post('deleteWithRelations', 'UserRoleController@deleteWithRelations')->name('user.role.delete');

      
      Route::get('getpermissions', 'UserRoleController@getAllPermissions')->name('user.role.list');
      Route::get('getRole', 'UserRoleController@getRole')->name('user.role.list');


    });
});