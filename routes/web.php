<?php


Route::get('/', function () {
    return view('welcome');
});
Route::get('admin', 'Admin\AdminController@index');

//root-----------------------------------------------------------
Route::group(['prefix' => '/root'],function()
{
    Route::get('', 'Admin\AdminController@index');
    Route::resource('/roles', 'Admin\RolesController');
    Route::resource('/permissions', 'Admin\PermissionsController'); 
    Route::get('/give-role-permissions', 'Admin\AdminController@getGiveRolePermissions');
    Route::get('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
    Route::post('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);   
});
//manageer---------------------------------------------------------------
Route::group(['prefix' => '/manager'],function()
{
    Route::resource('/workerusers', 'Manager\\WorkerusersController');
    Route::resource('/workers', 'Manager\\WorkersController');
    Route::resource('/users', 'Manager\\UsersController');
});
//workadmin---------------------------------------------------------------
Route::group(['prefix' => '/workadmin'],function()
{
    Route::get('/workerdays/{year}/{month}/{day}/{user}', 'Workadmin\\WorkerdaysController@index2');
    Route::resource('/workerdays', 'Workadmin\\WorkerdaysController');
    Route::resource('/worktimes', 'Workadmin\\WorktimesController');
    Route::resource('/days', 'Workadmin\\DaysController');
    Route::resource('/workers', 'Workadmin\\WorkersController');
    Route::resource('/worktimes', 'Workadmin\\WorktimesController');
    Route::resource('/users', 'Manager\\UsersController');
});

//----------------------------------------------------------------
Route::group(['prefix' => '/worker'],function()
{
    Route::resource('/workers', 'Worker\\WorkersController');
    Route::resource('/worktimes', 'Worker\\WorktimesController');
    Route::resource('/chpassword', 'User\\chpasswordController');
    Route::resource('/chemail', 'User\\ChemailController');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('cors/login', 'AuthController@authenticate');
Route::get('cors/logout', 'AuthController@logout');




