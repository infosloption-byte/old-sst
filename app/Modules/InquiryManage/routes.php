<?php

/*
|--------------------------------------------------------------------------
| Admin Inquiry Routes
|--------------------------------------------------------------------------
|
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['web']], function()
{
	Route::group(['prefix' => '/admin','middleware' => ['permission:inquiry.list,inquiry.accept,inquiry.reject,inquiry.payment,inquiry.send.mail'], 'namespace' => 'App\Modules\InquiryManage\Controllers'], function(){

	    Route::get('inquiries', 'InquiryController@index')->name('admin.inquiry.list');

	    Route::get('inquiries/get-inquiry-list', 'InquiryController@getInquiryListJson')->name('admin.inquiry.list');

	    Route::get('inquiries/create', 'InquiryController@createInquiryView')->name('admin.inquiry.create');

	    Route::post('inquiries/approve', 'InquiryController@approveInquiry')->name('admin.inquiry.accept');

	    Route::post('inquiries/create-inquiry', 'InquiryController@createInquiryByCustomer')->name('admin.inquiry.create');

	    Route::post('inquiries/reject', 'InquiryController@rejectInquiry')->name('admin.inquiry.reject');

	    Route::post('inquiries/sendMail', 'InquiryController@sendMail')->name('admin.inquiry.list');

	    Route::get('inquiries/mail', 'InquiryController@mail')->name('admin.inquiry.list');

	    Route::get('inquiries/export', 'InquiryController@export')->name('admin.inquiry.list');

	    Route::post('inquiries/create-inquiry', 'InquiryController@createClientInquiry')->name('admin.inquiry.create');
	});
});