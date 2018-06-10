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
    Route::get('about', 'PagesController@getAbout');
    Route::get('contact','PagesController@getContact');
   
    Route::get('schedule', 'ResidentController@getSchedule');
    Route::get('schedule/firstday', 'ResidentController@getFirstDay');        
    Route::get('schedule/secondday','ResidentController@getSecondDay');
    Route::get('schedule/thirdday','ResidentController@getThirdDay');
    
    Route::get('instructions','ResidentController@getInstructions');
});

Route::prefix('admin')->group(function () {
    Route::get('/', 'AdminController@getIndex');
    Route::get('about', 'PagesController@getAbout');
    Route::get('contact','PagesController@getContact');
});


