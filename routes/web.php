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
    return view('index');
});

Route::get('/vendedor', function () {
    return view('vendedor');
});

Route::post("/vendedor/salvarvendedor", "VendedorController@salvarVendedor");
Route::post("/vendedor/getinformacoesvendedor/{idVendedor}", "VendedorController@getInformacoesVendedor");
Route::post("/vendedor/excluirvendedor/{idVendedor}", "VendedorController@excluirVendedor");
Route::post("/vendedor/atualizarvendedor", "VendedorController@atualizarVendedor");

