<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/profile', 'seguridad\ProfileController@index')->name('profile');
Route::put('/profile', 'seguridad\ProfileController@update')->name('profile.update');
Route::post('/profile/foto', 'seguridad\ProfileController@updatefoto')->name('profile.update.foto');

/*registro de nuevos usuarios**/
Route::group(['middleware' => ['permission:seguridad']], function () {   
    Route::get('/usuario/{id}/roles/{rolid}/{tarea}', 'seguridad\usuarioController@roles');
    Route::get('/usuario/{id}/roles', 'seguridad\usuarioController@roles');
    Route::get('/usuario/{id}/permisos/{perid}/{tarea}', 'seguridad\usuarioController@permisos');
    Route::get('/usuario/{id}/permisos', 'seguridad\usuarioController@permisos');
    Route::resource('/usuario', 'seguridad\usuarioController');

    Route::get('/roles/{id}/permisos/{perid}/{tarea}', 'seguridad\RoleController@permisos');
    Route::get('/roles/{id}/permisos', 'seguridad\RoleController@permisos');
    Route::get('/roles/{id}/usuarios/{usuid}/{tarea}', 'seguridad\RoleController@usuarios');
    Route::get('/roles/{id}/usuarios', 'seguridad\RoleController@usuarios');
    Route::resource('/roles', 'seguridad\RoleController');

    Route::get('/permisos/{id}/usuarios/{usuid}/{tarea}', 'seguridad\permisosController@usuarios');
    Route::get('/permisos/{id}/usuarios', 'seguridad\permisosController@usuarios');
    Route::get('/permisos/{id}/roles/{rolid}/{tarea}', 'seguridad\permisosController@roles');
    Route::get('/permisos/{id}/roles', 'seguridad\permisosController@roles');
    Route::resource('/permisos', 'seguridad\permisosController');
});