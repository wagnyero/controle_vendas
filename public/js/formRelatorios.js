var FormRelatorios  = (function(){
    "use strict";
    
    var init = function(){
        _load.geral();
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
            $("#tabelaRelatorios").DataTable({
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
                    url: "/api/vendas/relatoriotopvendas",
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
        }
    },
    _load = {
        geral: function(){
            _configuracoesGerais.showDataTables();
        }
    };
    return {
        init: init
    };
})();