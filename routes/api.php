<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'Api\RegisterController@register');
Route::post('login', 'Api\LoginController@login');
Route::post('logout', 'Api\LoginController@logout')->middleware('auth:api');
Route::get('get-all-companies-json', 'Api\ApiController@getAllCompaniesJson');
Route::any('new-user-signup', 'Api\ApiController@newUserSignup');

Route::group([ 'middleware' =>  ['auth:api', 'json.response'] ],function ()
{
	Route::get('user', 'Api\LoginController@userDetails');

    Route::get('get-job-category-json', 'Api\ApiController@getJobCategoryJson')->name('job');

    Route::get('get-job-section-json', 'Api\ApiController@getJobSectionJson')->name('job');

    Route::get('get-task-category-json', 'Api\ApiController@getTaskCategoryJson')->name('job');

    Route::get('get-clients-json', 'Api\ApiController@getClientsJson')->name('job');

    Route::get('get-technicians-json', 'Api\ApiController@getTechniciansJson')->name('job');

    Route::get('get-all-jobs-json', 'Api\ApiController@getAllJobsJson')->name('job');

    Route::get('get-job-details-json', 'Api\ApiController@getJobDetailsJson')->name('job');

    Route::get('get-all-tasks-json', 'Api\ApiController@getAllTasksJson')->name('job');

    Route::get('get-task-details-json', 'Api\ApiController@getTaskDetailsJson')->name('job');

    Route::any('create-new-task', 'Api\ApiController@createNewTask')->name('job');

    Route::any('start-task', 'Api\ApiController@startTask')->name('job');

    Route::any('end-task', 'Api\ApiController@endTask')->name('job');

    Route::get('get-repair-types-json', 'Api\ApiController@getRepairTypesJson')->name('job');

    Route::get('get-repair-list-json', 'Api\ApiController@getRepairListJson')->name('job');

    Route::any('create-new-repair-request', 'Api\ApiController@createNewRepair')->name('job');

    Route::any('get-inspection-jobs', 'Api\ApiController@getInspectionJobsJson')->name('inspection');

    Route::any('get-inspection-job-sections', 'Api\ApiController@getInspectionJobSectionsJson')->name('inspection');

    Route::any('get-inspection-job-sections-tasks', 'Api\ApiController@getInspectionJobSectionTasksJson')->name('inspection');
    
    Route::any('rate-inspection-task', 'Api\ApiController@rateInspectTask')->name('inspection');

    Route::any('get-regular-job-status', 'Api\ApiController@getRegularJobStatus')->name('job');

    Route::any('change-regular-job-status', 'Api\ApiController@changeRegularJobStatus')->name('job');

    Route::any('start-regular-job', 'Api\ApiController@startRegularJob')->name('job');

    Route::any('end-regular-job', 'Api\ApiController@endRegularJob')->name('job');
});