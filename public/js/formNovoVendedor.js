var FormNovoVendedor = (function(){
    "use strict";
    
    var init = function(){
        _load.geral();
    },
    _clickButton = {
        atualizar: function(){
            $("#btnAtualizarVendedor").click(function() {
                var json = null,
                    controlePreenchimento = "ok";
                
                //VERIFICANDO SE OS INPUTS E SELECTS ESTÃO PREENCHIDOS
                $("#frmEditarVendedor .campoObrigatorio").each(function(){
                    
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
                    json = _configuracoesGerais.efetuarPost( "/vendedor/atualizarvendedor", $("#frmEditarVendedor").serialize() );
                    json = $.parseJSON(json);

                    if(json.CONTROLE == "SUCESSO"){
                        $("#tabelaVendedores").DataTable().ajax.reload();
                        alert(json.MENSAGEM);
                        $("#modalEditarVendedor").modal("hide");
                    } else {
                        alert(json.MENSAGEM);
                    }
                }
            });
        },
        editarVendedor: function(){
            $("#tabelaVendedores").on("click", ".btnEditarVendedor", function(e){
                var idVendedor = $(this).parent().parent().find("td:nth-child(2)").text(),
                    json = "";
                
                showLoading();
                json = _configuracoesGerais.efetuarPost( "/vendedor/getinformacoesvendedor/" + idVendedor, $("#frmNovoVendedor").serialize() );
                json = $.parseJSON(json);
                
                $("#txtNomeEdicao").val(json.nome);
                $("#txtCpfEdicao").val(json.cpf);
                $("#hdnIdVendedor").val(json.id);

                $("#modalEditarVendedor").modal("show");
                
                e.stopPropagation();
                e.stopImmediatePropagation();
                return false;
            });
        },
        excluirVendedor: function(){
            $("#tabelaVendedores").on("click", ".btnExcluirVendedor", function(e){
                var idVendedor = $(this).parent().parent().find("td:nth-child(2)").text(),
                    json = "";
                
                if(confirm("ATENÇÃO: Esse produto também será removido de todas as Vendas")) {
                    json = _configuracoesGerais.efetuarPost( "/vendedor/excluirvendedor/" + idVendedor, $("#frmNovoVendedor").serialize() );
                    json = $.parseJSON(json);

                    if(json.CONTROLE == "SUCESSO") {
                        $("#tabelaVendedores").DataTable().ajax.reload();

                        alert(json.MENSAGEM);
                    } else {
                        alert(json.MENSAGEM);
                    }
                }
                
                e.stopPropagation();
                e.stopImmediatePropagation();
                return false;
            });
        },
        salvar: function(){
            $("#btnSalvarVendedor").click(function() {
                var json = null,
                    controlePreenchimento = "ok";
                
                //VERIFICANDO SE OS INPUTS E SELECTS ESTÃO PREENCHIDOS
                $("#frmNovoVendedor .campoObrigatorio").each(function(){
                    
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
                    json = _configuracoesGerais.efetuarPost( "/vendedor/salvarvendedor", $("#frmNovoVendedor").serialize() );
                    json = $.parseJSON(json);

                    if(json.CONTROLE == "SUCESSO"){
                        $("#divInformacoes input").val("");
                        $("#tabelaVendedores").DataTable().ajax.reload();
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
            $("#tabelaVendedores").DataTable({
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
                    url: "/api/vendedor/getlistavendedores",
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
            _clickButton.editarVendedor();
            _clickButton.excluirVendedor();
            _clickButton.salvar();
            _configuracoesGerais.somenteNumeros();
            _configuracoesGerais.showDataTables();
        }
    };
    return {
        init: init
    };
})();