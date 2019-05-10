<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vendas extends Model {
    
    function vendedor() {
        return $this->belongsTo("App\Vendedor", "vendedor_id", "id");
    }
    
    function produtos() {
        return $this->belongsToMany("App\Produtos", "venda_produtos", "vendas_id", "produtos_id");
    }
    
    public function getListagemVendas($request){
        DB::statement(DB::raw('set @linha = 0'));
        $lista = DB::table("vendas")
                    ->join("vendedores", "vendedores.id", "=", "vendas.vendedor_id")
                
                    ->select(   "vendas.id",
                                "vendedores.nome", 
                                "vendas.created_at", 
                                DB::raw('@linha := @linha  + 1 AS rnum') )

                    ->orderBy("nome", "asc")
                    ->offset($request->input("start"))
                    ->limit($request->input("length"))
                    ->get();
        
        return $lista;
    }
    
    public function getListaProdutosVendas($request){
        DB::statement(DB::raw('set @linha = 0'));
        $lista = DB::table("vendas")
                    ->join("vendedores", "vendedores.id", "=", "vendas.vendedor_id")
                    ->join("venda_produtos", "venda_produtos.vendas_id", "=", "vendas.id")
                    ->join("produtos", "venda_produtos.produtos_id", "=", "produtos.id")
                
                    ->select(   "produtos.id",
                                "produtos.nome", 
                                "produtos.departamento", 
                                "produtos.valor", 
                                DB::raw('@linha := @linha  + 1 AS rnum') )

                    ->where("vendas.id", $request->input("txtIdVenda"))
                    ->orderBy("produtos.nome", "asc")
                    ->offset($request->input("start"))
                    ->limit($request->input("length"))
                    ->get();
        
        return $lista;
    }
}
