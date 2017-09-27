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

Route::resource('admin/conf', 'Admin\\ConfController');
Route::resource('workadmin/days', 'Workadmin\\DaysController');
Route::resource('workadmin/daytimechange', 'Workadmin\\DaytimechangeController');
Route::resource('workadmin/daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json', 'Workadmin\\Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.jsonController');
Route::resource('workadmin/daytypechange', 'Workadmin\\DaytypechangeController');
Route::resource('manager/daytypes', 'Manager\\DaytypesController');
Route::resource('manager/statuses', 'Manager\\StatusesController');
Route::resource('manager/timeframes', 'Manager\\TimeframesController');
Route::resource('manager/timeunits', 'Manager\\TimeunitsController');
Route::resource('manager/workergroups', 'Manager\\WorkergroupsController');
Route::resource('manager/workers', 'Manager\\WorkersController');
Route::resource('manager/workertypes', 'Manager\\WorkertypesController');
Route::resource('manager/workroleunits', 'Manager\\WorkroleunitsController');
Route::resource('manager/workroles', 'Manager\\WorkrolesController');
Route::resource('manager/worktimes', 'Manager\\WorktimesController');
Route::resource('manager/worktimetypes', 'Manager\\WorktimetypesController');
Route::resource('manager/worktimeunits', 'Manager\\WorktimeunitsController');
Route::resource('workadmin/daytimes', 'Workadmin\\DaytimesController');