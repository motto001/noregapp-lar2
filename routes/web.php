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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('cors/login', 'AuthController@authenticate');
Route::get('cors/logout', 'AuthController@logout');

Route::get('admin', 'Admin\AdminController@index');
Route::get('admin/give-role-permissions', 'Admin\AdminController@getGiveRolePermissions');
//Route::post('admin/give-role-permissions', 'Admin\AdminController@postGiveRolePermissions');
Route::resource('admin/roles', 'Admin\RolesController');
Route::resource('admin/permissions', 'Admin\PermissionsController');
Route::resource('admin/users', 'Admin\UsersController');

Route::get('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
Route::post('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);
Route::get('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
Route::post('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);

Route::resource('manager/workers', 'Manager\\WorkersController');
Route::resource('manager/users', 'Manager\\UsersController');
Route::resource('cors/manager/workers', 'Manager\\WorkersController');
Route::resource('cors/manager/users', 'Manager\\UsersController');
//Route::resource('manager/users', 'Manager\\UsersController');

Route::resource('workadmin/workers', 'Workadmin\\WorkersController');
Route::resource('workadmin/users', 'Workadmin\\UsersController');
Route::resource('workadmin/worktimes', 'Workadmin\\WorktimesController');
Route::resource('cors/workadmin/workers', 'Workadmin\\WorkersController');
Route::resource('cors/workadmin/users', 'Workadmin\\UsersController');
Route::resource('cors/workadmin/worktimes', 'Workadmin\\WorktimesController');
//Route::resource('workadmin/users', 'Workadmin\\UsersController');


Route::resource('worker/workers', 'Worker\\WorkersController');
Route::resource('worker/worktimes', 'Worker\\WorktimesController');
Route::resource('cors/worker/workers', 'Worker\\WorkersController');
Route::resource('cors/worker/worktimes', 'Worker\\WorktimesController');

Route::resource('user/chpassword', 'User\\chpasswordController');
Route::resource('user/chemail', 'User\\ChemailController');
Route::resource('cors/user/chpassword', 'User\\chpasswordController');
Route::resource('cors/user/chemail', 'User\\ChemailController');
Route::resource('cors/global', 'User\\GlobalController');