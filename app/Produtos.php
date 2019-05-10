<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produtos extends Model {
    
    function vendas() {
        return $this->belongsToMany("App\Vendas", "venda_produtos", "produtos_id", "vendas_id");
    }
    
    public function getListaProdutos($request){
        DB::statement(DB::raw('set @linha = 0'));
        $lista = DB::table("produtos")
                                ->select(   "id",
                                            "nome", 
                                            "valor", 
                                            "departamento", 
                                            DB::raw('@linha := @linha  + 1 AS rnum') )
                
                                ->orderBy("nome", "asc")
                                ->offset($request->input("start"))
                                ->limit($request->input("length"))
                                ->get();
        
        return $lista;
    }
    
    public function autoloadingProduto($nome) {
        $jsonRetorno = DB::table("produtos")
                            ->select("id", 
                                     "nome AS label",
                                     "nome AS value")
                
                            ->where("nome", "like", "%$nome%")
                            ->get();
        
        return $jsonRetorno;
    }
}
