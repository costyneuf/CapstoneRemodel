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

/**
 * Home page
 */
Route::prefix('/')->group(function () {
    Route::get('', 'PagesController@getIndex');
    Route::get('about', 'PagesController@getAbout');
    Route::get('contact','PagesController@getContact');
});

/**
 * Resident's page
 */
Route::group(['prefix' => 'resident', 'middleware' => 'resident'], function () {
    Route::get('/', 'ResidentController@getIndex');
    Route::get('home', 'PagesController@getIndex');
    Route::get('about', 'PagesController@getAbout');
    Route::get('contact','PagesController@getContact');
   
    Route::get('schedule', 'ResidentController@getSchedule');
    Route::get('schedule/firstday', 'ScheduleDataController@getFirstDay');        
    Route::get('schedule/secondday','ScheduleDataController@getSecondDay');
    Route::get('schedule/thirdday','ScheduleDataController@getThirdDay');

    Route::get('schedule/firstday/filter/{doctor_start_time_end_time}', 'ScheduleDataController@getFirstDay');        
    Route::get('schedule/secondday/filter/{doctor_start_time_end_time}','ScheduleDataController@getSecondDay');
    Route::get('schedule/thirdday/filter/{doctor_start_time_end_time}','ScheduleDataController@getThirdDay');
    
    Route::get('schedule/secondday/{id}/{choice}/{flag?}', 'ScheduleDataController@getChoice');
    Route::get('schedule/thirdday/{id}/{choice}/{flag?}', 'ScheduleDataController@getChoice');

    Route::post('schedule/{day}/submit', 'ScheduleDataController@postSubmit');
    
    Route::get('instructions','ResidentController@getInstructions');
});

/**
 * Admin's page
 */
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', 'AdminController@getIndex');
    Route::get('home', 'PagesController@getIndex');
    Route::get('about', 'PagesController@getAbout');
    Route::get('contact','PagesController@getContact');

    Route::get('users', 'AdminController@getUsers');
    Route::get('users/{op}/{role}/{email}/{flag}/{name?}', 'AdminController@getUpdateUsers');

    Route::get('schedules', 'AdminController@getSchedules');
    Route::post('updateDB', 'AdminController@postUpdateDB');
    Route::post('addDB', 'AdminController@postAddDB');
    Route::post('editDB', 'AdminController@postEditDB');

    Route::get('postmessage', 'AdminController@getMessages');

    Route::get('download', 'AdminController@getDownload');
});

/**
 * Pre-surgery and post-surgery feedback page
 * 
 * Authorization: residents and attendings
 * 
 */
Route::prefix('survey')->group(function() {
    Route::get('{date}', 'PagesController@getFeedback');
});


