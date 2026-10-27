<?php

/*
|--------------------------------------------------------------------------
| Admin Job Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['web']], function()
{
	Route::group(['prefix' => '/admin/job','middleware' => ['permission:job'], 'namespace' => 'App\Modules\JobManage\Controllers'], function(){

	    Route::get('index', 'JobController@index')->name('admin.job.list');

	    Route::get('get-job-list', 'JobController@getJobList')->name('admin.job.list');

	    Route::get('get-job-details', 'JobController@getJobDetails')->name('admin.job.list');

	    Route::get('create', 'JobController@createJobView')->name('admin.job.create');

	    Route::get('getMasterSectionWithTask', 'JobController@getMasterSectionWithTask')->name('admin.job.create');

	    Route::get('master-data-config', 'JobController@configJobSectionWithTask')->name('admin.job.create');

	    Route::post('create', 'JobController@createJob')->name('admin.job.create');

	    Route::post('config', 'JobController@configJob')->name('admin.job.create');

	    Route::post('task/create', 'JobController@createTask')->name('admin.job.task.create');

	    Route::post('task/assign-employee', 'JobController@taskAssignEmployee')->name('admin.job.task.assign');

	    Route::get('task/list', 'JobController@taskList')->name('admin.job.task.list');

	    Route::get('categoryList', 'JobController@jobCategoryList')->name('admin.job.categorylist');

	    Route::get('task/categoryList', 'JobController@taskCategoryList')->name('admin.job.task.categorylist');

	    Route::get('clientList', 'JobController@clientList')->name('admin.job.clientlist');

	    Route::get('get-technicians', 'JobController@getTechnician')->name('admin.job.detail');

	    Route::get('get-job-summery-details', 'JobController@getJobSummeryDetails')->name('admin.job.detail');

	    Route::post('update', 'JobController@updateJob')->name('admin.job.update');

	    Route::post('delete', 'JobController@deleteJob')->name('admin.job.delete');

	    Route::get('export-data', 'JobController@exportJobData')->name('admin.job.delete');
	    
	    Route::get('get-cost-types', 'JobController@getCostTypes')->name('admin.job.index');

	    Route::get('get-job-cost-log-data', 'JobController@getJobCostLogData')->name('admin.job.index');
	    
	    Route::post('create-log-cost', 'JobController@createJobCost')->name('admin.job.cost');

	    Route::post('create-inspection', 'JobController@createInspection')->name('admin.job.inspection');

	    Route::get('export-qr-pdf', 'JobController@exportQRCodesPdf')->name('admin.job.list');

	    Route::get('master-config', 'JobController@viewMasterSectionTasksData')->name('admin.job.master');

	    Route::get('getMasterSectionList', 'JobController@getMasterSectionList')->name('admin.job.master');

	    Route::get('get-master-task-list', 'JobController@getMasterTaskList')->name('admin.job.master');

	    Route::post('master-section-create', 'JobController@createMasterSection')->name('admin.job.master');

	    Route::post('master-task-create', 'JobController@createMasterTask')->name('admin.job.master');

	    Route::post('deleteMasterTask', 'JobController@deleteMasterTask')->name('admin.job.master');

	});

	Route::group(['prefix' => '/admin/section','middleware' => ['permission:section'], 'namespace' => 'App\Modules\JobManage\Controllers'], function(){

	    Route::get('index', 'JobController@indexSection')->name('admin.section.list');

	    Route::get('get-all-sections', 'JobController@getAllSections')->name('admin.section.list');

	    Route::get('get-job-sections', 'JobController@getJobSections')->name('admin');

	    Route::get('create', 'JobController@createSectionView')->name('admin.section.create');

	    Route::post('create', 'JobController@createSection')->name('admin.section.create');

	    Route::get('get-all-jobs', 'JobController@getAllJobs')->name('admin.section.index');

	    Route::post('update', 'JobController@updateSection')->name('admin.section.update');

	    Route::post('delete', 'JobController@deleteSection')->name('admin.section.delete');

	    Route::get('export-data', 'JobController@exportSectionData')->name('admin.section.export');

	});

	Route::group(['prefix' => '/admin/task','middleware' => ['permission:task'], 'namespace' => 'App\Modules\JobManage\Controllers'], function(){

	    Route::get('index', 'JobController@indexTask')->name('admin.task.list');

	    Route::get('get-all-tasks', 'JobController@getAllTasks')->name('admin.task.list');

	    Route::get('create', 'JobController@createTaskView')->name('admin.task.create');

	    Route::post('create', 'JobController@createTask')->name('admin.task.create');

	    Route::post('assign-technician', 'JobController@assignTechnicianToTask')->name('admin.task.assign');

	    Route::get('task/list', 'JobController@taskList')->name('admin.task.list');

	    Route::get('jobCategoryList', 'JobController@jobCategoryList')->name('admin.task.categorylist');

	    Route::get('taskCategoryList', 'JobController@taskCategoryList')->name('admin.task.categorylist');

	    Route::get('clientList', 'JobController@clientList')->name('admin.task.clientlist');

	    Route::get('get-technicians', 'JobController@getTechnician')->name('admin.task.detail');

	    Route::get('get-all-jobs', 'JobController@getAllJobs')->name('admin.task.index');

	    Route::post('update', 'JobController@updateTask')->name('admin.task.update');

	    Route::post('delete', 'JobController@deleteTask')->name('admin.task.delete');

	    Route::post('start', 'JobController@startTask')->name('admin.task.start');

	    Route::post('end', 'JobController@endTask')->name('admin.task.end');

	    Route::get('export-data', 'JobController@exportTaskData')->name('admin.task.delete');

	});
});