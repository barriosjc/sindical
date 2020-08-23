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

Auth::routes([ 'register'=>false ]);

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

// Route::group(['middleware' => ['role:administrativo']], function () {   
    Route::get('/afiliados', 'gestion\AfiliadosController@index')->name('afiliado.index');
    Route::post('/afiliados/guardar', 'gestion\AfiliadosController@guardar')->name('afiliado.guardar');
    Route::get('/afiliados/find/{id?}', 'gestion\AfiliadosController@find')->name('afiliado.find');

    Route::get('/afiliados/buscar/index/{id}', 'gestion\AfiliadosController@buscar_index')->name('afiliado.buscar.index');
    Route::get('/afiliados/buscar', 'gestion\AfiliadosController@buscar')->name('afiliado.buscar');

    Route::get('/afiliados/preguntas/{id}', 'gestion\AfiliadosController@preguntas_index')->name('afiliado.preguntas');
    Route::post('/afiliados/preguntas/guardar', 'gestion\AfiliadosController@preguntas_guardar')->name('afiliado.preguntas.guardar');
    Route::delete('/afiliados/preguntas/borrar/{id}', 'gestion\AfiliadosController@preguntas_borrar')->name('afiliado.preguntas.borrar');

    Route::get('/afiliados/documentos/{id}', 'gestion\AfiliadosController@documentos_index')->name('afiliado.documentos');
    Route::post('/afiliados/documentos/guardar', 'gestion\AfiliadosController@documentos_guardar')->name('afiliado.documentos.guardar');
    Route::delete('/afiliados/documentos/borrar/{id}', 'gestion\AfiliadosController@documentos_borrar')->name('afiliado.documentos.borrar');
    
    Route::get('/afiliados/siguiente', 'gestion\AfiliadosController@nroafilsiguiente')->name('afiliado.siguiente');

    // Route::get('/comunes/volver', 'comunes\comunesController@volver')->name('volver');

    // });