<?php

Route::get('', 'Admin\AdminController@index');

//root-----------------------------------------------------------
Route::group(['prefix' => '/admin'],function()
{
    Route::resource('conf', 'Admin\\ConfController');  
    Route::resource('/roles', 'Admin\RolesController');
    Route::resource('/permissions', 'Admin\PermissionsController'); 
    Route::get('/give-role-permissions', 'Admin\AdminController@getGiveRolePermissions');
    Route::get('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
//Route::post('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);   
//Route::resource('/users', 'Admin\UsersController');
});
//manageer---------------------------------------------------------------
Route::group(['prefix' => '/manager'],function()
{
    Route::resource('/users', 'Manager\UsersController');
    Route::resource('/workerusers', 'Manager\\WorkerusersController');
  
    Route::resource('daytypes', 'Manager\\DaytypesController');
    Route::resource('statuses', 'Manager\\StatusesController');
    Route::resource('timeframes', 'Manager\\TimeframesController');
    Route::resource('timeunits', 'Manager\\TimeunitsController');
    Route::resource('workergroups', 'Manager\\WorkergroupsController');
    Route::resource('workers', 'Manager\\WorkersController');
    Route::resource('workertypes', 'Manager\\WorkertypesController');
    Route::resource('workroleunits', 'Manager\\WorkroleunitsController');
    Route::resource('workroles', 'Manager\\WorkrolesController');
    Route::resource('worktimes', 'Manager\\WorktimesController');
    Route::resource('worktimetypes', 'Manager\\WorktimetypesController');
    Route::resource('worktimeunits', 'Manager\\WorktimeunitsController');
    
});
//workadmin---------------------------------------------------------------
Route::group(['prefix' => '/workadmin'],function()
{
    Route::resource('days', 'Workadmin\\DaysController');
    Route::resource('daytimechange', 'Workadmin\\DaytimechangeController');
    Route::resource('daytimes', 'Workadmin\\DaytimesController');
    Route::resource('daytypechange', 'Workadmin\\DaytypechangeController');
    
});

//----------------------------------------------------------------
Route::group(['prefix' => '/user'],function()
{
    Route::resource('/chpassword', 'User\\ChpasswordController');
    Route::resource('/chemail', 'User\\ChemailController');
    //Route::resource('/personal', 'User\\PersonalController');
});
Route::group(['prefix' => '/worker'],function()
{
    Route::resource('/personal', 'Worker\\WorkersController');
    Route::resource('/worktime', 'Worker\\WorktimesController');
    Route::get('/worktimes/{year}/{month}/{day}/{user}', 'Worker\\WorktimesController@index2');
    Route::get('/worktimes/create/{year}/{month}/{day}/{user}', 'Worker\\WorktimesController@create');
});