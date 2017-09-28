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



Route::resource('workadmin/chworkerday', 'Workadmin\\ChworkerdayController');
Route::resource('workadmin/chworkertimes', 'Workadmin\\ChworkertimesController');
Route::resource('manager/days', 'Manager\\DaysController');
Route::resource('manager/daytypes', 'Manager\\DaytypesController');
Route::resource('manager/timeframes', 'Manager\\TimeframesController');
Route::resource('manager/timetypes', 'Manager\\TimetypesController');
Route::resource('manager/workerdays', 'Manager\\WorkerdaysController');
Route::resource('manager/workergroups', 'Manager\\WorkergroupsController');
Route::resource('manager/workers', 'Manager\\WorkersController');
Route::resource('manager/workergroups', 'Manager\\WorkergroupsController');
Route::resource('manager/workers', 'Manager\\WorkersController');
Route::resource('manager/workertimes', 'Manager\\WorkertimesController');
Route::resource('manager/workertypes', 'Manager\\WorkertypesController');
Route::resource('manager/wroles', 'Manager\\WrolesController');
Route::resource('manager/wroletimes', 'Manager\\WroletimesController');
Route::resource('manager/wroleunits', 'Manager\\WroleunitsController');