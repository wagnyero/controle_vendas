var FormNovoVenda = (function(){
    "use strict";
    
    var init = function(){
        _load.geral();
    },
    _autoLoading = {
        autoLoadingProduto: function() {
            $("#txtNomeProduto, #txtNomeProdutoEditar").keypress(function(){
                var cache = {};
                
                $(this).autocomplete({
                    source: function(request, response){
                        var term = request.term;
                        if ( term in cache ) {
                            response( cache[ term ] );
                            return;
                        }
                        
                        $.getJSON( "/api/produtos/autoloadingproduto", request, function( data, status, xhr ) {
                            cache[ term ] = data;
                            response( data );
                        });
                    },
                    minLength: 1,
                    select: function(event, ui){
                        $(this).val(ui.item.value);
                    }
                });
            });
        },
        listagemVendedores: function() {
            $.getJSON( "/vendedor/listagemvendedores", "", function( data, status, xhr ) {
                $(data).each(function(i, vendedores) {
                    $("#selVendedor").append("<option value='" + vendedores.id + "'>" + vendedores.nome + "</option>");
                });
            });
        }
    },
    _clickButton = {
        addProduto: function(){
            $("#btnAdicionarProduto").click(function(){
                var produto = $("#txtNomeProduto").val(),
                    produtoRepetido = false;
                
                if(!produto){
                    alert("Erro: Informe o produto desejado.");
                    return false;
                }
                
                if($("#selProdutosInseridos option").length > 0){
                    $("#selProdutosInseridos option").each(function(){
                        var produtoSelecionada = $(this).val();
                        
                        if( produto === produtoSelecionada ) {
                            produtoRepetido = true;
                            return false;
                        }
                    });

                    if(produtoRepetido){
                        alert("ERRO: Produto já consta na listagem");
                        return false;
                    }
                    
                }
                
                $("#selProdutosInseridos").append("<option value='" + produto + "'>" + produto + "</option>");
                
                $("#txtNomeProduto").val("").focus();
            });
        },
        addProdutoEdicao: function(){
            $("#btnAdicionarProdutoEditar").click(function(){
                var parametros = {txtNomeProdutoEditar: $("#txtNomeProdutoEditar").val(),
                                  txtIdVenda: $("#hdnIdVenda").val()};
                
                $.getJSON( "/vendas/adicionarprodutovenda", parametros, function( data, status, xhr ) {
                    if(data.CONTROLE == "SUCESSO") {
                        $("#tabelaEditarItensVenda").DataTable().ajax.reload();

                        alert(data.MENSAGEM);
                    } else {
                        alert(data.MENSAGEM);
                    }
                });
            });
        },
        editar: function(){
            $("#tabelaVendas").on("click", ".btnEditar", function(e){
                var idVenda = $(this).parent().parent().find("td:nth-child(2)").text();
                
                $("#hdnIdVenda").val(idVenda);

                showLoading();
                $("#tabelaEditarItensVenda").DataTable({
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
                            { "width": "5%", "targets": 0 }
                    ],
                    ajax: {
                        url: "/api/vendas/getlistaprodutosvendas",
                        type: "POST",
                        beforeSend: function(){
                            showLoading();
                        },
                        data: function(e){
                            e.txtIdVenda = idVenda;
                            e.acao = "edicao";
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

                $("#modalEditarItens").modal("show");
                
                e.stopPropagation();
                e.stopImmediatePropagation();
                return false;
            });
        },
        excluirProduto: function(){
            $("#tabelaEditarItensVenda").on("click", ".btnExcluirItemVenda", function(e){
                var idProduto = $(this).parent().parent().find("td:nth-child(2)").text(),
                    parametros = {txtIdProduto: idProduto,
                                  txtIdVenda: $("#hdnIdVenda").val()};
                
                $.getJSON( "/vendas/excluirprodutovenda", parametros, function( data, status, xhr ) {
                    if(data.CONTROLE == "SUCESSO") {
                        $("#tabelaEditarItensVenda").DataTable().ajax.reload();

                        alert(data.MENSAGEM);
                    } else {
                        alert(data.MENSAGEM);
                    }
                });

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
                
                if($("#selProdutosInseridos option").length > 0) {
                    $("#selProdutosInseridos").removeClass("border border-danger");
                } else {
                    $("#selProdutosInseridos").addClass("border border-danger");
                    controlePreenchimento = "nok";
                }

                if(controlePreenchimento === "nok") {
                    alert("Preencha os campos obrigatórios");
                    
                    return false;
                }
                
                if( confirm("Deseja realmente inserir uma nova venda?") ) {
                    showLoading();
                    $("#selProdutosInseridos option").prop("selected", true);
                    json = _configuracoesGerais.efetuarPost( "/vendas/salvarvenda", $("#frmNovo").serialize() );
                    json = $.parseJSON(json);

                    if(json.CONTROLE == "SUCESSO"){
                        $("#divInformacoes input").val("");
                        $("#tabelaVendas").DataTable().ajax.reload();
                        alert(json.MENSAGEM);
                    } else {
                        alert(json.MENSAGEM);
                    }
                }
            });
        },
        visualizarProdutosVenda: function(){
            $("#tabelaVendas").on("click", ".btnVisualizar", function(e){
                var idVenda = $(this).parent().parent().find("td:nth-child(2)").text();
                
                showLoading();
                $("#tabelaItens").DataTable({
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
                            { "width": "5%", "targets": 0 }
                    ],
                    ajax: {
                        url: "/api/vendas/getlistaprodutosvendas",
                        type: "POST",
                        beforeSend: function(){
                            showLoading();
                        },
                        data: function(e){
                            e.txtIdVenda = idVenda;
                            e.acao = "visualizar";
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
                
                $("#modalVisualizarItens").modal("show");
                
                e.stopPropagation();
                e.stopImmediatePropagation();
                return false;
            });
        },
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
            $("#tabelaVendas").DataTable({
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
                    url: "/api/vendas/getlistagemvendas",
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
            _autoLoading.autoLoadingProduto();
            _autoLoading.listagemVendedores();
            _clickButton.addProduto();
            _clickButton.addProdutoEdicao();
            _clickButton.editar();
            _clickButton.excluirProduto();
            _clickButton.salvar();
            _clickButton.visualizarProdutosVenda();
            _configuracoesGerais.somenteNumeros();
            _configuracoesGerais.showDataTables();
        }
    };
    return {
        init: init
    };
})();