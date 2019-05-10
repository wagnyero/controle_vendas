<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vendedor extends Model {
    
    protected $table = "vendedores";
    
    public function getListaVendedores($request){
        DB::statement(DB::raw('set @linha = 0'));
        $lista = DB::table("vendedores")
                                ->select(   "id",
                                            "nome", 
                                            "cpf", 
                                            DB::raw('@linha := @linha  + 1 AS rnum') )
                
                                ->orderBy("nome", "asc")
                                ->offset($request->input("start"))
                                ->limit($request->input("length"))
                                ->get();
        
        return $lista;
    }
}
