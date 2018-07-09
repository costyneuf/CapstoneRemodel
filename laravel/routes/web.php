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

Route::prefix('/')->group(function () {
    Route::get('', 'PagesController@getIndex');
    Route::get('about', 'PagesController@getAbout');
    Route::get('contact','PagesController@getContact');
});

Route::prefix('resident')->group(function () {
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
    
    Route::get('instructions','ResidentController@getInstructions');
});

Route::prefix('admin')->group(function () {
    Route::get('/', 'AdminController@getIndex');
    Route::get('home', 'PagesController@getIndex');
    Route::get('about', 'PagesController@getAbout');
    Route::get('contact','PagesController@getContact');

    Route::get('users', 'AdminController@getUsers');
    Route::get('users/{op}/{role}/{email}/{flag}/{name?}', 'AdminController@getUpdateUsers');

    Route::get('schedules', 'AdminController@getSchedules');

    Route::get('postmessage', 'AdminController@getMessages');
});


