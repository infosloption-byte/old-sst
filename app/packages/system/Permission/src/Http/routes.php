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
    Route::group(['prefix' => 'admin/permisson','middleware' => ['permission:perm.manage'], 'namespace' => 'System\Permissions\Http\Controllers'], function(){
      Route::get('list', 'PermissionsController@listView')->name('perm.manage.list');
      Route::post('create', 'PermissionsController@create')->name('perm.manage.create');
      Route::post('update', 'PermissionsController@update')->name('perm.manage.update');
      Route::post('delete', 'PermissionsController@delete')->name('perm.manage.delete');
      Route::get('getPerm', 'PermissionsController@getPerm')->name('perm.manage.update');
    });
    
});