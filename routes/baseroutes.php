<?php

Route::get('admin', 'Admin\AdminController@index',function(){


});

//root-----------------------------------------------------------
Route::group(['prefix' => '/admin','middleware' => ['auth', 'roles'], 'roles' => 'admin'],function()
{
    Route::resource('/users', 'Admin\UsersController');
    Route::resource('/conf', 'Admin\\ConfController');  
    Route::resource('/roles', 'Admin\RolesController');
    Route::resource('/permissions', 'Admin\PermissionsController'); 
    Route::get('/give-role-permissions', 'Admin\AdminController@getGiveRolePermissions');
    Route::get('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);

});
//manageer---------------------------------------------------------------
Route::group(['prefix' => '/manager','middleware' => ['auth', 'roles'], 'roles' => 'manager'],function()
{
    Route::resource('/users', 'Manager\UsersController');
    Route::resource('/workers', 'Manager\\WorkersController');
    Route::resource('/workerusers', 'Manager\\WorkerusersController');
    Route::resource('/workergroups', 'Manager\\WorkergroupsController');
    Route::resource('/workertypes', 'Manager\\WorkertypesController');
    
    Route::resource('/days', 'Manager\\DaysController');
    Route::resource('/daytypes', 'Manager\\DaytypesController');
    Route::resource('/timeframes', 'Manager\\TimeframesController');
    Route::resource('/timetypes', 'Manager\\TimetypesController');
    
    Route::resource('/wroles', 'Manager\\WrolesController');
    Route::resource('/wroleunits', 'Manager\\WroleunitsController');
    Route::resource('/wroletimes', 'Manager\\WroletimesController');
    
});
//workadmin---------------------------------------------------------------
Route::group(['prefix' => '/workadmin','middleware' => ['auth', 'roles'], 'roles' => 'workadmin'],function()
{
    Route::resource('/chworkerday', 'Workadmin\\ChworkerdayController');
    Route::resource('/chworkertimes', 'Workadmin\\ChworkertimesController');
   
    Route::resource('/workerdays', 'Manager\\WorkerdaysController');
    Route::resource('/workertimes', 'Manager\\WorkertimesController');
    
});
Route::group(['prefix' => '/worker','middleware' => ['auth', 'roles'], 'roles' => 'worker'],function()
{
    Route::resource('/personal', 'Worker\\WorkersController');
    Route::resource('/worktime', 'Worker\\WorktimesController');
    Route::get('/worktimes/{year}/{month}/{day}/{user}', 'Worker\\WorktimesController@index2');
    Route::get('/worktimes/create/{year}/{month}/{day}/{user}', 'Worker\\WorktimesController@create');
});
//----------------------------------------------------------------
Route::group(['prefix' => '/user','middleware' => ['auth', 'roles'], 'roles' => 'admin'],function()
{
    Route::resource('/chpassword', 'User\\ChpasswordController');
    Route::resource('/chemail', 'User\\ChemailController');
    //Route::resource('/personal', 'User\\PersonalController');
});
