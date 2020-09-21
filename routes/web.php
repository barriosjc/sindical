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
    Route::get('/afiliados/carga', 'gestion\AfiliadosController@index')->name('afiliado.index');
    Route::post('/afiliados/guardar', 'gestion\AfiliadosController@guardar')->name('afiliado.guardar');
    Route::get('/afiliados/find/{id?}', 'gestion\AfiliadosController@find')->name('afiliado.find');

    Route::get('/afiliado/{id?}/buscar/index', 'gestion\AfiliadosController@buscar_index')->name('afiliado.buscar.index');
    Route::get('/afiliado/{id?}/buscar', 'gestion\AfiliadosController@buscar')->name('afiliado.buscar');
    Route::get('/afiliado/{id}/familiar/buscar/index', 'gestion\familiaresController@buscar_index')->name('familiares.buscar.index');
    Route::get('/afiliado/siguiente', 'gestion\AfiliadosController@nroafilsiguiente')->name('afiliado.siguiente');
    Route::get('/familiar/buscar', 'gestion\familiaresController@buscar')->name('familiares.buscar');

    Route::get('/siguiente', 'comunes\comunesController@obtener_siguiente')->name('comunes.siguiente');

    Route::get('/afiliado/{id}/preguntas', 'gestion\AfiliadosController@preguntas_index')->name('afiliado.preguntas');
    Route::post('/afiliado/preguntas/guardar', 'gestion\AfiliadosController@preguntas_guardar')->name('afiliado.preguntas.guardar');
    Route::delete('/afiliado/preguntas/{id}/borrar', 'gestion\AfiliadosController@preguntas_borrar')->name('afiliado.preguntas.borrar');

    Route::get('/afiliado/{id}/documentos', 'gestion\AfiliadosController@documentos_index')->name('afiliado.documentos');
    Route::post('/afiliado/documentos/guardar', 'gestion\AfiliadosController@documentos_guardar')->name('afiliado.documentos.guardar');
    Route::delete('/afiliado/documentos/{id}/borrar', 'gestion\AfiliadosController@documentos_borrar')->name('afiliado.documentos.borrar');
    Route::get('/afiliado/documentos/{id}/descargar', 'gestion\AfiliadosController@download')->name('afiliado.download');
    Route::get('/afiliado/carnet/{id}', 'gestion\AfiliadosController@carnet')->name('afiliado.carnet');
    
    // Route::get('/comunes/volver', 'comunes\comunesController@volver')->name('volver');
    Route::get('/afiliado/{afi_id}/familiar/{id?}', 'gestion\familiaresController@index')->name('familiares.index');
    Route::post('/familiares/guardar', 'gestion\familiaresController@guardar')->name('familiares.guardar');
    Route::get('/afiliado/{id}/familiares/modificar', 'gestion\familiaresController@modificar')->name('familiares.modificar');

    Route::get('/afiliado{afi_id}/familiares{id}/documentos', 'gestion\familiaresController@documentos_index')->name('familiares.documentos');
    Route::post('/familiares/documentos/guardar', 'gestion\familiaresController@documentos_guardar')->name('familiares.documentos.guardar');
    Route::delete('/familiares/documentos/borrar/{id}', 'gestion\familiaresController@documentos_borrar')->name('familiares.documentos.borrar');
    Route::get('/familiares/documentos/id/{id}/descargar', 'gestion\familiaresController@download')->name('familiares.download');

    // });

    Route::get('/empresas/carga', 'gestion\EmpresasController@index')->name('empresa.index');
    Route::post('/empresas/guardar', 'gestion\EmpresasController@guardar')->name('empresa.guardar');
    Route::get('/empresas/find/{id?}', 'gestion\EmpresasController@find')->name('empresa.find');

    Route::get('/empresa/{id}/buscar/index', 'gestion\empresasController@buscar_index')->name('empresa.buscar.index');
    Route::get('/empresa/buscar', 'gestion\empresasController@buscar')->name('empresa.buscar');
    Route::get('/empresa/{id}/familiar/buscar/index', 'gestion\empresasController@buscar_index')->name('empresa.afiliados');
    Route::get('/empresa/siguiente', 'gestion\empresasController@nroEmprSiguiente')->name('empresa.siguiente');

    Route::get('/empresa/{id}/documentos', 'gestion\empresasController@documentos_index')->name('empresa.documentos');
    Route::post('/empresa/documentos/guardar', 'gestion\empresasController@documentos_guardar')->name('empresa.documentos.guardar');
    Route::delete('/empresa/documentos/{id}/borrar', 'gestion\empresasController@documentos_borrar')->name('empresa.documentos.borrar');
    Route::get('/empresa/documentos/{id}/descargar', 'gestion\empresasController@download')->name('empresa.download');


    Route::get('/denuncias/carga', 'gestion\DenunciasController@index')->name('denuncia.index');
    Route::post('/denuncias/guardar', 'gestion\DenunciasController@guardar')->name('denuncia.guardar');
    Route::get('/denuncias/find/{id?}', 'gestion\DenunciasController@find')->name('denuncia.find');

    Route::get('/denuncia/{id}/buscar/index', 'gestion\DenunciasController@buscar_index')->name('denuncia.buscar.index');
    Route::get('/denuncia/buscar', 'gestion\DenunciasController@buscar')->name('denuncia.buscar');
    Route::get('/denuncia/{id}/familiar/buscar/index', 'gestion\DenunciasController@buscar_index')->name('denuncia.afiliados');
    Route::get('/denuncia/siguiente', 'gestion\DenunciasController@nroEmprSiguiente')->name('denuncia.siguiente');

    Route::get('/denuncia/{id}/documentos', 'gestion\DenunciasController@documentos_index')->name('denuncia.documentos');
    Route::post('/denuncia/documentos/guardar', 'gestion\DenunciasController@documentos_guardar')->name('denuncia.documentos.guardar');
    Route::delete('/denuncia/documentos/{id}/borrar', 'gestion\DenunciasController@documentos_borrar')->name('denuncia.documentos.borrar');
    Route::get('/denuncia/documentos/{id}/descargar', 'gestion\DenunciasController@download')->name('denuncia.download');
    
    Route::post('/denuncias/{id}/guardar/movimiento', 'gestion\DenunciasController@guardar_movimiento')->name('denuncia.guardar.movimiento');
    Route::post('/denuncias/borrar/{id}/movimiento', 'gestion\DenunciasController@borrar_movimiento')->name('denuncia.borrar.movimiento');
 