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

Route::get('/produtos', function () {
    return view('produtos');
});

Route::get('/vendas', function () {
    return view('vendas');
});

Route::post("/vendedor/salvarvendedor", "VendedorController@salvarVendedor");
Route::post("/vendedor/getinformacoesvendedor/{idVendedor}", "VendedorController@getInformacoesVendedor");
Route::post("/vendedor/excluirvendedor/{idVendedor}", "VendedorController@excluirVendedor");
Route::post("/vendedor/atualizarvendedor", "VendedorController@atualizarVendedor");
Route::get("/vendedor/listagemvendedores", "VendedorController@listagemVendedores");


Route::post("/produtos/salvarproduto", "ProdutosController@salvarProduto");
Route::post("/produtos/getinformacoesproduto/{id}", "ProdutosController@getInformacoesProduto");
Route::post("/produtos/atualizarproduto", "ProdutosController@atualizarProduto");
Route::post("/produtos/excluirProduto/{id}", "ProdutosController@excluirProduto");

Route::post("/vendas/salvarvenda", "VendasController@salvarVenda");
Route::get("/vendas/excluirprodutovenda", "VendasController@excluirProdutoVenda");
Route::get("/vendas/adicionarprodutovenda", "VendasController@adicionarProdutoVenda");
