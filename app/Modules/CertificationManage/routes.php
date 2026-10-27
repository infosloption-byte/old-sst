<?php

/*
|--------------------------------------------------------------------------
| Certification Managment Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function()
{
    Route::group(['prefix' => 'admin/certification','middleware' => ['permission:certification'], 'namespace' => 'App\Modules\CertificationManage\Controllers'], function(){

        Route::get('index', 'CertificationManageController@index')->name('certification.index');

        Route::get('get-certification-data', 'CertificationManageController@getCertificationData')->name('certification.index');

        Route::get('get-certification-list', 'CertificationManageController@getCertificationList')->name('certification.index');

        Route::get('remove-document', 'CertificationManageController@removeDocument')->name('certification.index');

        Route::post('create', 'CertificationManageController@createCertificate')->name('certification.index');

        Route::post('update', 'CertificationManageController@updateCertificate')->name('certification.index');

        Route::get('question-list', 'CertificationManageController@questionListView')->name('certification.questions');

        Route::get('get-question-data', 'CertificationManageController@getQuestionData')->name('certification.questions');

        Route::post('question/create', 'CertificationManageController@createQuestion')->name('certification.questions');

        Route::post('question/update', 'CertificationManageController@updateQuestion')->name('certification.questions');

        Route::post('question/upload', 'CertificationManageController@uploadQuestions')->name('certification.questions');

    });

});
