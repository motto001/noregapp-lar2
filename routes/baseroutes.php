<?php


//root-----------------------------------------------------------
Route::group(['prefix' => '/admin'],function()
{
    Route::get('', 'Admin\AdminController@index');
    Route::resource('/roles', 'Admin\RolesController');
    Route::resource('/users', 'Admin\UsersController');
    Route::resource('/permissions', 'Admin\PermissionsController'); 
    Route::get('/give-role-permissions', 'Admin\AdminController@getGiveRolePermissions');
    Route::get('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
    Route::post('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);   
});
//manageer---------------------------------------------------------------
Route::group(['prefix' => '/manager'],function()
{
    Route::resource('/users', 'Manager\UsersController');
    Route::resource('/workerusers', 'Manager\\WorkerusersController');
    Route::resource('/workers', 'Manager\\WorkersController');
    //Route::resource('/users', 'Manager\\UsersController');
});
//workadmin---------------------------------------------------------------
Route::group(['prefix' => '/workadmin'],function()
{
    Route::get('/workerdays/{year}/{month}/{day}/{user}', 'Workadmin\\WorkerdaysController@index2');
    Route::get('/workerdays/create/{year}/{month}/{day}/{user}', 'Workadmin\\WorkerdaysController@create');
    Route::get('/workerdays/edit/{year}/{month}/{day}/{user}', 'Workadmin\\WorkerdaysController@index2');
    Route::post('/workerdays/store/{year}/{month}/{day}/{user}', 'Workadmin\\WorkerdaysController@store');
    Route::post('/workerdays/store', 'Workadmin\\WorkerdaysController@store');
    Route::post('/workerdays/update/{id}', 'Workadmin\\WorkerdaysController@update');
    Route::get('/workerdays/del/{id}', 'Workadmin\\WorkerdaysController@delete');
    Route::resource('/workerdays', 'Workadmin\\WorkerdaysController');
    Route::resource('/worktimes', 'Workadmin\\WorktimesController');
    Route::resource('/days', 'Workadmin\\DaysController');
    Route::resource('/workers', 'Workadmin\\WorkersController');
    Route::resource('/worktimes', 'Workadmin\\WorktimesController');
    Route::resource('/users', 'Workadmin\\UsersController');
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