@extends("layouts.layout")
@section("body")
<div class="card">
    <div class="card-header bg-info text-white font-weight-bold">
        <h5>Relatório de Top Vendas</h5>
    </div>
    <div class="row">
        <div class="col-sm-12 table-responsive-sm">
            <table id="tabelaRelatorios" class="table table-sm table-striped table-bordered table-hover nowrap w-100">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome Vendedor</th>
                        <th>Valor (R$)</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="{{ asset("/js/formRelatorios.js") }}" type="text/javascript"></script>
<script>
    FormRelatorios.init();
</script>
@endsection