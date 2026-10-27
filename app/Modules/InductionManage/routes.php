<?php

/*
|--------------------------------------------------------------------------
| Induction Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'admin/induction','middleware' => ['permission:induction'], 'namespace' => 'App\Modules\InductionManage\Controllers'], function(){

        Route::get('index', 'InductionManageController@index')->name('induction.index');

        Route::get('get-employee-certifications', 'InductionManageController@getEmployeeCertifications')->name('induction.index');

        Route::get('view-induction-document', 'InductionManageController@viewPdf')->name('induction.index');

        Route::get('get-induction-questions', 'InductionManageController@getInductionQuestions')->name('induction.index');

        Route::get('get-user-exam-questions', 'InductionManageController@getUserExamQuestions')->name('induction.index');

        Route::get('save-user-exam-answer', 'InductionManageController@saveUserExamAnswer')->name('induction.index');
        
        Route::post('reset-user-exam', 'InductionManageController@resetUserExam')->name('induction.index');

        Route::get('check-user-exam-status', 'InductionManageController@checkUserExamAnswer')->name('induction.index');

        Route::get('get-induction-data', 'InductionManageController@getInductionData')->name('induction.index');

        Route::get('get-user-induction-certificate', 'InductionManageController@getUserInductionCertificate')->name('induction.index');

        Route::get('get-user-image', 'InductionManageController@getUserImage')->name('induction.index');

        Route::get('view-certificate/{id}', 'InductionManageController@viewCertificate')->name('induction.index');
    });
});
