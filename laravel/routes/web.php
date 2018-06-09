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

Route::get('/', function () {
    return view('schedules.index');
});

Route::get('about', function () {
    return view('pages.about');
});

Route::get('contact', function () {
    return view('pages.contact');
});

Route::get('resident', function () {
    return view('schedules.resident.resident');
});

Route::get('admin', function () {
    return view('schedules.admin.admin');
});

Route::get('resident/{page}', function ($page) {
    return view('schedules.resident.'.$page);
});
