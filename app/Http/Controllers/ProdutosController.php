<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produtos;

class ProdutosController extends Controller {
    
    public function getListaProdutos(Request $request) {
        $dbDisciplina = new Produtos();
        
        $dados = $dbDisciplina->getListaProdutos($request);
        
        $total = $dbDisciplina->count();
        
        $listaFormatada = null;
        if(count($dados) > 0) {
            $html = "<button type='button' class='btn btn-xs btn-outline-success btnEditar'>
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
    
    public function salvarProduto(Request $request) {
        try {
            
            $bd = new Produtos();
            $bd->nome = $request->input("txtNome");
            $bd->departamento = $request->input("txtDepartamento");
            $bd->valor = $request->input("txtValor");

            $bd->save();
            
            $msgControleProcessamento["CONTROLE"] = "SUCESSO";
            $msgControleProcessamento["MENSAGEM"] = "Produto Cadastrado com sucesso";
            $msgControleProcessamento["ID"] = $bd->id;  
            
        } catch (QueryException $e) {
            $msgControleProcessamento["CONTROLE"] = "ERRO";
            $msgControleProcessamento["MENSAGEM"] = "ERRO: Não foi possível inserir um novo produto.";
            $msgControleProcessamento["ID"] = "";
        }

        return json_encode($msgControleProcessamento, JSON_UNESCAPED_UNICODE);
    }
    
    public function getInformacoesProduto($id) {
        return Produtos::where("id", $id)
                ->first()
                ->toJson(JSON_UNESCAPED_UNICODE);
    }
    
    public function excluirProduto($id) {
        $bd = Produtos::find($id);
        
        if(isset($bd)){
            $bd->delete();
            
            $msgControleProcessamento["CONTROLE"] = "SUCESSO";
            $msgControleProcessamento["MENSAGEM"] = "Vendedor Excluído com sucesso";
            $msgControleProcessamento["ID"] = "";
        } else {
            $msgControleProcessamento["CONTROLE"] = "ERRO";
            $msgControleProcessamento["MENSAGEM"] = "ERRO: Não foi possível excluir, tente novamente";
            $msgControleProcessamento["ID"] = "";
        }
        
        return json_encode($msgControleProcessamento, JSON_UNESCAPED_UNICODE);
    }
    
    public function atualizarProduto(Request $request) {
        $bd = Produtos::find($request->input("hdnIdProduto"));
        
        if(isset($bd)){
            try {
                $bd->nome = $request->input("txtNomeEditar");
                $bd->departamento = $request->input("txtDepartamentoEditar");
                $bd->valor = $request->input("txtValorEditar");
                $bd->save();
                
                $msgControleProcessamento["CONTROLE"] = "SUCESSO";
                $msgControleProcessamento["MENSAGEM"] = "Produto atualizado com sucesso";
                $msgControleProcessamento["ID"] = "";
                
            } catch (QueryException $exc) {
                $msgControleProcessamento["CONTROLE"] = "ERRO";
                $msgControleProcessamento["MENSAGEM"] = "ERRO: Não foi possível atualizar, tente novamente.";
                $msgControleProcessamento["ID"] = "";
            }
        } else {
            $msgControleProcessamento["CONTROLE"] = "ERRO";
            $msgControleProcessamento["MENSAGEM"] = "ERRO: Não foi possível atualizar, tente novamente";
            $msgControleProcessamento["ID"] = "";
        }
        
        return json_encode($msgControleProcessamento, JSON_UNESCAPED_UNICODE);
    }
    
    public function autoloadingProduto(Request $request) {
        $nomeDisciplina = $request->input("term");

        $bd = new Produtos();
        $jsonRetorno = $bd->autoloadingProduto($nomeDisciplina);
        
        return $jsonRetorno->toJson(JSON_UNESCAPED_UNICODE);
    }
}
