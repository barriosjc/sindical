<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('provincia/{id}/localidades','comunes\comunesController@traer_localidades');
route::get('afiliado/{dni}/buscar','comunes\comunesController@traer_afiliado');
route::get('afiliado/motivos_egresos','comunes\comunesController@traer_motivos_egresos');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
