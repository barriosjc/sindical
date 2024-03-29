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

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');

Route::get('/profile', 'seguridad\ProfileController@index')->name('profile');
Route::put('/profile', 'seguridad\ProfileController@update')->name('profile.update');
Route::post('/profile/foto', 'seguridad\ProfileController@updatefoto')->name('profile.update.foto');

/*registro de nuevos usuarios**/
Route::group(['middleware' => ['permission:seguridad consultas']], function () {
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

Route::group(['middleware' => ['permission:consultar afiliado']], function () {
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
    Route::post('/afiliado/carnet/cropfoto', 'gestion\AfiliadosController@crop_foto')->name('afiliado.carnet.crop.foto');
    Route::match(array('GET', 'POST'), '/afiliado/carnet/tomarfoto', 'gestion\AfiliadosController@tomar_foto')->name('afiliado.carnet.tomar_foto');
    Route::get('/afiliado/carnet/view/{id}', 'gestion\AfiliadosController@carnet')->name('afiliado.carnet');
    Route::get('/afiliado/carnet/pdf/{id}', 'gestion\AfiliadosController@carnet_pdf')->name('afiliado.carnet.pdf');
    Route::post('/afiliado/carnet/fotoup', 'gestion\AfiliadosController@file_input_Photo')->name('afiliado.carnet.fotoup');
    Route::post('/afiliado/carnet/foto/guardar', 'gestion\AfiliadosController@foto_guardar')->name('afiliado.carnet.foto.guardar');
//    Route::post('/afiliado/carnet/imprimir', 'gestion\AfiliadosController@imprimir')->name('afiliado.carnet.imprimir');

    Route::get('/afiliado/{id}/empresas/{ae_id?}', 'gestion\AfiliadosController@empresas_index')->name('afiliado.empresas');
    Route::post('/afiliado/empresas/guardar', 'gestion\AfiliadosController@empresas_guardar')->name('afiliado.empresas.guardar');
    Route::delete('/afiliado/empresas/{id}/borrar', 'gestion\AfiliadosController@empresas_borrar')->name('afiliado.empresas.borrar');
    Route::get('/afiliado/{afi_id}/familiar/{id?}', 'gestion\familiaresController@index')->name('familiares.index');
    Route::post('/familiares/guardar', 'gestion\familiaresController@guardar')->name('familiares.guardar');
    Route::get('/afiliado/{id}/familiares/modificar', 'gestion\familiaresController@modificar')->name('familiares.modificar');

    Route::post('/familiar/carnet/fotoup', 'gestion\familiaresController@file_input_Photo')->name('familiar.carnet.fotoup');
    Route::get('/afiliado/{afil_id}/familiar/carnet/pdf/{id}', 'gestion\familiaresController@carnet_pdf')->name('familiar.carnet.pdf');
    Route::post('/familiar/carnet/fotoup', 'gestion\familiaresController@file_input_Photo')->name('familiar.carnet.fotoup');
    Route::post('/familiar/carnet/foto/guardar', 'gestion\familiaresController@foto_guardar')->name('familiar.carnet.foto.guardar');
    Route::match(array('GET', 'POST'), '/familiar/carnet/tomarfoto', 'gestion\familiaresController@tomar_foto')->name('familiar.carnet.tomar_foto');
    Route::post('/familiar/carnet/cropfoto', 'gestion\familiaresController@crop_foto')->name('familiar.carnet.crop.foto');

    Route::get('/afiliado/{afi_id}/familiares/{id}/documentos', 'gestion\familiaresController@documentos_index')->name('familiares.documentos');
    Route::get('/afiliado/{afi_id}/familiares/{id}/carnet', 'gestion\familiaresController@carnet')->name('familiares.carnet');
    Route::post('/familiares/documentos/guardar', 'gestion\familiaresController@documentos_guardar')->name('familiares.documentos.guardar');
    Route::delete('/familiares/documentos/borrar/{id}', 'gestion\familiaresController@documentos_borrar')->name('familiares.documentos.borrar');
    Route::get('/familiares/documentos/id/{id}/descargar', 'gestion\familiaresController@download')->name('familiares.download');
    Route::get('/afiliado/{afi_id}/familiares/{id}/escolaridad', 'gestion\familiaresController@escolaridad_index')->name('familiares.escolaridad');
    Route::post('/familiares/escolaridad/guardar', 'gestion\familiaresController@escolaridad_guardar')->name('familiares.escolaridad.guardar');
    Route::delete('/familiares/escolaridad/borrar/{id}', 'gestion\familiaresController@escolaridad_borrar')->name('familiares.escolaridad.borrar');
    Route::get('/familiares/escolaridad/id/{id}/imprimir', 'gestion\familiaresController@escolaridad_imprimir')->name('familiares.escolaridad.imprimir');

});

Route::group(['middleware' => ['permission:consultar empresas']], function () {
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
});

Route::group(['middleware' => ['permission:consultar denuncias']], function () {
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

    Route::get('/secretariado/importar', 'gestion\SecretariadoController@importar')->name('secretariado.importar');
    Route::post('/secretariado/importar/guardar', 'gestion\SecretariadoController@guardar')->name('secretariado.guardar');
    Route::get('/secretariado/informes', 'gestion\SecretariadoController@informes')->name('secretariado.informes');
    Route::get('/secretariado/informes/ver', 'gestion\SecretariadoController@informesver')->name('secretariado.informes.ver');

    Route::get('/informes', 'gestion\InformesController@index')->name('informes.index');
    Route::post('/informes/generar', 'gestion\InformesController@generar')->name('informes.generar');

});
