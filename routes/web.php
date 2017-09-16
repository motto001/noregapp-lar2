<?php

Route::get('/', function () {
    if(Auth::guest()){ return redirect('login');}
    else{ return redirect('admin');}
});

include 'baseroutes.php';

Auth::routes();
/*
Route::get('/home', 'HomeController@index')->name('home');
Route::get('cors/login', 'AuthController@authenticate');
Route::get('cors/logout', 'AuthController@logout');

*/



Route::resource('manager/status', 'manager\\StatusController');
Route::resource('manager/workertype', 'manager\\WorkertypeController');
Route::resource('manager/freeday', 'manager\\FreedayController');
Route::resource('manager/timeunit', 'manager\\TimeunitController');