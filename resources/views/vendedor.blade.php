@extends("layouts.layout")
@section("body")
<div class="card">
        <div class="card-header bg-info text-white font-weight-bold">
            <h5>Cadastro de Vendedores</h5>
        </div>
        <div class="card-body formCabecalho">
            <form id="frmNovoVendedor" method="post" class="mb-3">
                @csrf
                <div id="divInformacoes">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-row">
                                <div class="form-group col-sm-4">
                                    <label>Nome:</label>
                                    <input type="text" name="txtNome" class="form-control form-control-sm campoObrigatorio" />
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>CPF:</label>
                                    <input type="text" name="txtCpf" class="form-control form-control-sm somenteNumeros campoObrigatorio" maxlength="11" />
                                </div>
                                <div class="form-group col-sm-3 mt-4 pt-1">
                                    <button id="btnSalvarVendedor" type="button" class="btn btn-sm btn-outline-primary">
                                        <i class="material-icons vertical-align-middle">note_add</i>Novo Vendedor
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-sm-12 table-responsive-sm">
                    <table id="tabelaVendedores" class="table table-sm table-striped table-bordered table-hover nowrap w-100">
                        <thead>
                            <tr>
                                <th>Opções</th>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>CPF</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<!-- Modal Editar Vendedor-->
    <div class="modal fade" id="modalEditarVendedor" tabindex="-1" role="dialog" aria-labelledby="modalEditarVendedorLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Vendedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmEditarVendedor" method="post">
                        @csrf
                        <div class="col-sm-12">
                            <div class="form-row">
                                <div class="form-group col-sm-4">
                                    <label>Nome:</label>
                                    <input type="text" name="txtNomeEdicao" id="txtNomeEdicao" class="form-control form-control-sm campoObrigatorio" />
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>CPF:</label>
                                    <input type="text" name="txtCpfEdicao" id="txtCpfEdicao" class="form-control form-control-sm somenteNumeros campoObrigatorio" maxlength="11" />
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="hdnIdVendedor" id="hdnIdVendedor" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnAtualizarVendedor" type="button" class="btn btn-sm btn-outline-primary">
                        <i class="material-icons vertical-align-middle md-17">done_all</i> Atualizar  
                    </button>  
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM - Modal Editar Vendedor-->

   <script src="{{ asset("/js/formNovoVendedor.js") }}" type="text/javascript"></script>
    <script>
        FormNovoVendedor.init();
    </script>
@endsection