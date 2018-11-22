@extends('adminlte::page')

@section('title', 'Relatórios')

@section('content_header')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="header-title m-t-0 m-b-20">Orçamentos</h4>
        </div>
    </div>
@stop

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
          <p class="lead">Orçamento #{{ $orcamento->id }}</p>
        </div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
      <div class="card-box">

        <h6 class="m-t-0">Lista</h6>
        <div class="table-responsive">
          <table class="table mails m-0 table table-actions-bar">
              <thead>
              <tr>
                  <th>ID</th>
                  <th>Categoria</th>
                  <th>Saldo</th>
                  <th>Meta</th>
                  <th>Meses</th>
                  <th style="width:150px">#</th>
              </tr>
              </thead>

              <tbody>
                @forelse($orcamento->categorias as $categoria)

                  <tr>
                    <td>#{{ $categoria->id }}</td>
                    <td>{{ $categoria->categoria->nome }}</td>
                    <td>{{ number_format($categoria->saldo, 2, ',', '.') }}</td>
                    <td>{{ number_format($categoria->meta, 2, ',', '.') }}</td>
                    <td>
                        @foreach($categoria->meses as $mes)
                            <p>{{ $mes->mes }}: {{ number_format($mes->saldo, 2, ',', '.') }}</p>
                        @endforeach
                    </td>
                    <td>
                      <!--
                      <a class="btn btn-primary btn-sm" href="{{ route('orcamentos.edit', $orcamento->id) }}"><i class="fa fa-edit"></i></a>
                      <a class="btn btn-danger btn-sm btnRemoveItem" data-route="{{ route('orcamentos.destroy', $orcamento->id) }}"><i class="fa fa-trash"></i></a>
                    -->
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="11" class="text-center">Nenhum orçamento cadastrardo até o momento!</td>
                  </tr>
                @endforelse

              </tbody>
          </table>

        </div>

      </div>

  </div>
</div>

@stop

@section('adminlte_js')

  <script src="{{ asset('dashboard/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>

@stop
