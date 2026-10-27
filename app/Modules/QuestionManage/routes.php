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
    Route::group(['prefix' => 'admin/question','middleware' => ['permission:question'], 'namespace' => 'App\Modules\QuestionManage\Controllers'], function(){

        Route::get('index', 'QuestionManageController@index')->name('question.index');

        Route::get('get-question-data', 'QuestionManageController@getQuestionData')->name('question.index');

        Route::post('create', 'QuestionManageController@createQuestion')->name('question.index');

        Route::post('update', 'QuestionManageController@updateQuestion')->name('question.index');

    });

});
