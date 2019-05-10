<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendedor;
use Illuminate\Database\QueryException;

class VendedorController extends Controller {
    
    public function getListaVendedores(Request $request) {
        $dbDisciplina = new Vendedor();
        
        $dados = $dbDisciplina->getListaVendedores($request);
        
        $total = $dbDisciplina->count();
        
        $listaFormatada = null;
        if(count($dados) > 0) {
            $html = "<button type='button' class='btn btn-xs btn-outline-success btnEditarVendedor'>
                        <i class='material-icons vertical-align-sub md-17'>edit</i> 
                    </button>
                    <button type='button' class='btn btn-xs btn-outline-danger btnExcluirVendedor'>
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
    
    public function salvarVendedor(Request $request) {
        try {
            
            $bdVendedor = new Vendedor();
            $bdVendedor->nome = $request->input("txtNome");
            $bdVendedor->cpf = $request->input("txtCpf");

            $bdVendedor->save();
            
                $msgControleProcessamento["CONTROLE"] = "SUCESSO";
                $msgControleProcessamento["MENSAGEM"] = "Vendedor Cadastrado com sucesso";
                $msgControleProcessamento["ID"] = $bdVendedor->id;  
            
        } catch (QueryException $e) {
            $msgControleProcessamento["CONTROLE"] = "ERRO";
            $msgControleProcessamento["MENSAGEM"] = "ERRO: CPF já está sendo utilizado em outro cadastro.";
            $msgControleProcessamento["ID"] = "";
        }

        return json_encode($msgControleProcessamento, JSON_UNESCAPED_UNICODE);
    }
    
    public function getInformacoesVendedor($idVendedor) {
        return Vendedor::where("id" ,$idVendedor)
                ->first()
                ->toJson(JSON_UNESCAPED_UNICODE);
    }
    
    public function excluirVendedor($idVendedor) {
        $bdVendedor = Vendedor::find($idVendedor);
        
        if(isset($bdVendedor)){
            $bdVendedor->delete();
            
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
    
    public function atualizarVendedor(Request $request) {
        $bdVendedor = Vendedor::find($request->input("hdnIdVendedor"));
        
        if(isset($bdVendedor)){
            try {
                $bdVendedor->nome = $request->input("txtNomeEdicao");
                $bdVendedor->cpf = $request->input("txtCpfEdicao");
                $bdVendedor->save();
                
                $msgControleProcessamento["CONTROLE"] = "SUCESSO";
                $msgControleProcessamento["MENSAGEM"] = "Vendedor Atualizado com sucesso";
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
    
    public function listagemVendedores() {
        return Vendedor::all()
                ->toJson();
    }
}
