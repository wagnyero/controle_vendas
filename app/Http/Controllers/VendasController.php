<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produtos;
use App\Vendas;
use Illuminate\Database\QueryException;

class VendasController extends Controller {
    
    public function salvarVenda(Request $request) {
        try {
            $bdVenda = new Vendas();
            $bdVenda->vendedor_id = $request->input("selVendedor");
            $bdVenda->save();

            $listaProdutos = $request->input("selProdutosInseridos");
            foreach ($listaProdutos as $produto) {
                $idProduto = Produtos::where("nome", $produto)->first();

                $bdVenda->produtos()->attach($idProduto);
            }
            
            $msgControleProcessamento["CONTROLE"] = "SUCESSO";
            $msgControleProcessamento["MENSAGEM"] = "Venda imputada com sucesso!";
            $msgControleProcessamento["ID"] = "";
            
        } catch (QueryException $e) {
            $msgControleProcessamento["CONTROLE"] = "ERRO";
            $msgControleProcessamento["MENSAGEM"] = "ERRO: Problemas ao inserir sua venda.";
            $msgControleProcessamento["ID"] = "";
        }

        return json_encode($msgControleProcessamento, JSON_UNESCAPED_UNICODE);
    }
    
    public function getListagemVendas(Request $request) {
        $db = new Vendas();
        
        $dados = $db->getListagemVendas($request);
        
        $total = $db->count();
        
        $listaFormatada = null;
        if(count($dados) > 0) {
            $html = "<button type='button' class='btn btn-xs btn-outline-dark btnVisualizar'>
                        <i class='material-icons vertical-align-sub md-17'>search</i> 
                    </button>
                    <button type='button' class='btn btn-xs btn-outline-success btnEditar'>
                        <i class='material-icons vertical-align-sub md-17'>edit</i> 
                    </button>
                    <button type='button' class='btn btn-xs btn-outline-danger btnExcluir'>
                        <i class='material-icons vertical-align-sub md-17'>not_interested</i> 
                    </button>";
            
            foreach ($dados as $key => $value) {
                $listaFormatada[$key] = array_values(get_object_vars($dados[$key]));
                array_unshift($listaFormatada[$key], $html);
            } 
        } else {
            $listaFormatada = "";
        }
        
        $listaSolicitacoes = array("draw"               => $request->input("draw"),
                                   "recordsTotal"       => $total,
                                   "recordsFiltered"    => $total,
                                   "data"               => $listaFormatada);
        
        return json_encode($listaSolicitacoes, JSON_UNESCAPED_UNICODE);
    }
    
    public function getListaProdutosVendas(Request $request) {
        $db = new Vendas();
        
        $dados = $db->getListaProdutosVendas($request);
        
        $total = $db->count();
        
        $listaFormatada = null;
        if(count($dados) > 0) {
            foreach ($dados as $key => $value) {
                $listaFormatada[$key] = array_values(get_object_vars($dados[$key]));
            } 
        } else {
            $listaFormatada = "";
        }
        
        $listaSolicitacoes = array("draw"               => $request->input("draw"),
                                   "recordsTotal"       => $total,
                                   "recordsFiltered"    => $total,
                                   "data"               => $listaFormatada);
        
        return json_encode($listaSolicitacoes, JSON_UNESCAPED_UNICODE);
    }
}
