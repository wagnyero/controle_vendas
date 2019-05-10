var FormNovoProduto = (function(){
    "use strict";
    
    var init = function(){
        _load.geral();
    },
    _clickButton = {
        atualizar: function(){
            $("#btnAtualizar").click(function() {
                var json = null,
                    controlePreenchimento = "ok";
                
                //VERIFICANDO SE OS INPUTS E SELECTS ESTÃO PREENCHIDOS
                $("#frmEditar .campoObrigatorio").each(function(){
                    
                    if($(this).val() == "") {
                        $(this).addClass("border border-danger");
                        controlePreenchimento = "nok";
                    } else {
                        $(this).removeClass("border border-danger");
                    }
                });

                if(controlePreenchimento === "nok") {
                    alert("Preencha os campos obrigatórios");
                    
                    return false;
                }
                
                if( confirm("Deseja realmente atualizar?") ) {
                    showLoading();
                    json = _configuracoesGerais.efetuarPost( "/produtos/atualizarproduto", $("#frmEditar").serialize() );
                    json = $.parseJSON(json);

                    if(json.CONTROLE == "SUCESSO"){
                        $("#tabelaProdutos").DataTable().ajax.reload();
                        alert(json.MENSAGEM);
                        $("#modalEditar").modal("hide");
                    } else {
                        alert(json.MENSAGEM);
                    }
                }
            });
        },
        editar: function(){
            $("#tabelaProdutos").on("click", ".btnEditar", function(e){
                var id = $(this).parent().parent().find("td:nth-child(2)").text(),
                    json = "";
                
                showLoading();
                json = _configuracoesGerais.efetuarPost( "/produtos/getinformacoesproduto/" + id, $("#frmNovo").serialize() );
                json = $.parseJSON(json);
                
                $("#txtNomeEditar").val(json.nome);
                $("#txtDepartamentoEditar").val(json.departamento);
                $("#txtValorEditar").val(json.valor);
                $("#hdnIdProduto").val(json.id);

                $("#modalEditar").modal("show");
                
                e.stopPropagation();
                e.stopImmediatePropagation();
                return false;
            });
        },
        excluir: function(){
            $("#tabelaProdutos").on("click", ".btnExcluir", function(e){
                var id = $(this).parent().parent().find("td:nth-child(2)").text(),
                    json = "";
                
                json = _configuracoesGerais.efetuarPost( "/produtos/excluirProduto/" + id, $("#frmNovo").serialize() );
                json = $.parseJSON(json);
                
                if(json.CONTROLE == "SUCESSO") {
                    $("#tabelaProdutos").DataTable().ajax.reload();

                    alert(json.MENSAGEM);
                } else {
                    alert(json.MENSAGEM);
                }
                
                e.stopPropagation();
                e.stopImmediatePropagation();
                return false;
            });
        },
        salvar: function(){
            $("#btnSalvar").click(function() {
                var json = null,
                    controlePreenchimento = "ok";
                
                //VERIFICANDO SE OS INPUTS E SELECTS ESTÃO PREENCHIDOS
                $("#frmNovo .campoObrigatorio").each(function(){
                    
                    if($(this).val() == "") {
                        $(this).addClass("border border-danger");
                        controlePreenchimento = "nok";
                    } else {
                        $(this).removeClass("border border-danger");
                    }
                });

                if(controlePreenchimento === "nok") {
                    alert("Preencha os campos obrigatórios");
                    
                    return false;
                }
                
                if( confirm("Deseja realmente inserir um novo Vendedor?") ) {
                    showLoading();
                    json = _configuracoesGerais.efetuarPost("/produtos/salvarproduto", $("#frmNovo").serialize() );
                    json = $.parseJSON(json);

                    if(json.CONTROLE == "SUCESSO"){
                        $("#divInformacoes input").val("");
                        $("#tabelaProdutos").DataTable().ajax.reload();
                        alert(json.MENSAGEM);
                    } else {
                        alert(json.MENSAGEM);
                    }
                }
            });
        }
    },
    _configuracoesGerais = {
        efetuarPost: function(url, parametros){
            var json;
            
            $.ajax({
                url: url,
                data: parametros,
                beforeSend: function(){
                },
                type: "POST",
                async: false,
                success: function(data){
                    json = data;
                    hideLoading();
                    return false;
                }
            });
            
            return json;
        },
        showDataTables: function(){
            $("#tabelaProdutos").DataTable({
                scrollX: true,
                scrollY: "30vh",
                pageLength: 100,
                destroy: true,
                searching: false,
                processing: false,
                serverSide: true,
                order: false,
                dom: 'Bfrtip',
                columnDefs: [
                        { "width": "10%", "targets": 0 },
                        { "width": "5%", "targets": 1 }
                ],
                ajax: {
                    url: "/api/produtos/getlistaprodutos",
                    type: "POST",
                    beforeSend: function(){
                        showLoading();
                    },
                    complete: function(){
                        hideLoading();
                    }
                },
                buttons: [
                    {
                        responsive: true,
                        extend: "excelHtml5",
                        className: 'btn btn-sm'
                    }
                ],
                language: {
                    "processing": "<img src='" + $("#hdnRootPath").val() + "/images/load_1.gif' align='top' width='48px' height='48px' style='cursor: wait; z-index: 99999999;' />Carregando...",
                    "info":           "Exibindo _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty":      "Exibindo 0 a 0 de 0 registros",
                    "lengthMenu":     "Exibir _MENU_ registros",
                    "oPaginate": {
                        "sNext":        "Próximo",
                        "sPrevious":    "Anterior",
                        "sFirst":       "Primeiro",
                        "sLast":        "Último"
                    }
                }
            });
        },
        somenteNumeros: function(){
            $(".somenteNumeros").keypress(isNumberKey);
        }
    },
    _load = {
        geral: function(){
            _clickButton.atualizar();
            _clickButton.editar();
            _clickButton.excluir();
            _clickButton.salvar();
            _configuracoesGerais.somenteNumeros();
            _configuracoesGerais.showDataTables();
        }
    };
    return {
        init: init
    };
})();