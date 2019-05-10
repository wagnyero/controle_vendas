@extends("layouts.layout")
@section("body")
<div class="card">
        <div class="card-header bg-info text-white font-weight-bold">
            <h5>Cadastro de Produtos</h5>
        </div>
        <div class="card-body formCabecalho">
            <form id="frmNovo" method="post" class="mb-3">
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
                                    <label>Departamento:</label>
                                    <input type="text" name="txtDepartamento" class="form-control form-control-sm campoObrigatorio" />
                                </div>
                                <div class="form-group col-sm-1">
                                    <label>Valor:</label>
                                    <input type="text" name="txtValor" class="form-control form-control-sm somenteNumeros campoObrigatorio" maxlength="11" />
                                </div>
                                <div class="form-group col-sm-3 mt-4 pt-1">
                                    <button id="btnSalvar" type="button" class="btn btn-sm btn-outline-primary">
                                        <i class="material-icons vertical-align-middle">note_add</i>Salvar Produto
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-sm-12 table-responsive-sm">
                    <table id="tabelaProdutos" class="table table-sm table-striped table-bordered table-hover nowrap w-100">
                        <thead>
                            <tr>
                                <th>Opções</th>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Valor (R$)</th>
                                <th>Departamento</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<!-- Modal Editar-->
    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Produtos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmEditar" method="post">
                        @csrf
                        <div class="col-sm-12">
                            <div class="form-row">
                                <div class="form-group col-sm-4">
                                    <label>Nome:</label>
                                    <input type="text" name="txtNomeEditar" id="txtNomeEditar" class="form-control form-control-sm campoObrigatorio" />
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>Departamento:</label>
                                    <input type="text" name="txtDepartamentoEditar" id="txtDepartamentoEditar" class="form-control form-control-sm campoObrigatorio" />
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>Valor:</label>
                                    <input type="text" name="txtValorEditar" id="txtValorEditar" class="form-control form-control-sm somenteNumeros campoObrigatorio" maxlength="11" />
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="hdnIdProduto" id="hdnIdProduto" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnAtualizar" type="button" class="btn btn-sm btn-outline-primary">
                        <i class="material-icons vertical-align-middle md-17">done_all</i> Atualizar  
                    </button>  
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM - Modal Editar-->

   <script src="{{ asset("/js/formNovoProduto.js") }}" type="text/javascript"></script>
    <script>
        FormNovoProduto.init();
    </script>
@endsection