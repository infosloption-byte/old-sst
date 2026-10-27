<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'FrontController@index')->name('index');

Route::get('aboutus', 'FrontController@aboutusView')->name('aboutus');

Route::get('tattoos', 'FrontController@tattooView')->name('tattoos');

Route::get('rateus', 'FrontController@rateusView')->name('rateus');

Route::post('rateus', 'FrontController@rateUs')->name('rateus');

Route::get('piercing', 'FrontController@piercingView')->name('piercing');

Route::get('shop', 'FrontController@shopView')->name('shop');

Route::get('appointment', 'FrontController@bookNowView')->name('appointment');

Route::post('booknow', 'FrontController@bookNow')->name('booknow');

Route::get('contactus', 'FrontController@contactusView')->name('contactus');

Route::post('contactus', 'FrontController@createInquiry')->name('joinus');

Route::post('inquiry-create', 'FrontController@createInquiry')->name('joinus');

Route::get('admin', 'Dashboard\DashboardController@default')->name('admin.dashboard.index');

Route::get('admin/jobSumeryJson', 'Dashboard\DashboardController@jobSumeryJson')->name('admin.dashboard.index');

Route::get('admin/taskSumeryJson', 'Dashboard\DashboardController@taskSumeryJson')->name('admin.dashboard.index');

Route::get('admin/jobSumeryChartJson', 'Dashboard\DashboardController@jobSumeryChartJson')->name('admin.dashboard.index');

Route::get('admin/taskSumeryChartJson', 'Dashboard\DashboardController@taskSumeryChartJson')->name('admin.dashboard.index');

Route::get('admin/costSumeryChartJson', 'Dashboard\DashboardController@costSumeryChartJson')->name('admin.dashboard.index');

Route::get('admin/costTypeSumeryChartJson', 'Dashboard\DashboardController@costTypeSumeryChartJson')->name('admin.dashboard.index');

///////////////////////////////////////////API DATA////////////////////////////////////////////////////
Route::get('auth', 'Api\ApiController@auth')->name('auth');

Route::get('get-job-category-json', 'Api\ApiController@getJobCategoryJson')->name('job');

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

Route::any('create-new-repair-request', 'Api\ApiController@createNewRepair')->name('job');
///////////////////////////////////////////API DATA////////////////////////////////////////////////////

Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');
Route::get('admin/logout', 'Auth\LoginController@logout')->name('logout');


    

