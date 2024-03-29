<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/vendedor/getlistavendedores", "VendedorController@getListaVendedores");

Route::post("/produtos/getlistaprodutos", "ProdutosController@getListaProdutos");
Route::get("/produtos/autoloadingproduto", "ProdutosController@autoloadingProduto");

Route::post("/vendas/getlistagemvendas", "VendasController@getListagemVendas");
Route::post("/vendas/getlistaprodutosvendas", "VendasController@getListaProdutosVendas");
Route::post("/vendas/relatoriotopvendas", "VendasController@relatorioTopVendas");