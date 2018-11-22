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
          <a href="{{ route('orcamentos.create') }}" class="btn btn-success">Novo</a>
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
                  <th>Meses</th>
                  <th>Saldo</th>
                  <th>Meta</th>
                  <th style="width:150px">#</th>
              </tr>
              </thead>

              <tbody>
                @forelse($orcamentos as $orcamento)

                  <tr>
                    <td>#{{ $orcamento->id }}</td>
                    @php

                        $meses = [];
                        $categoria = $orcamento->categorias->first();

                        if($categoria->meses->isNotEmpty()) {

                          foreach($categoria->meses as $mes) {
                              $meses[] = $mes->mes;
                          }

                        }

                    @endphp

                    <td>
                      @foreach($meses as $mes)
                          <p>{{ $mes }}</p>
                      @endforeach
                    </td>

                    <td>{{ number_format($orcamento->categorias->sum('saldo'), 2, ',', '.') }}</td>
                    <td>{{ number_format($orcamento->categorias->sum('meta'), 2, ',', '.') }}</td>

                    <td>
                      <a class="btn btn-primary btn-sm" href="{{ route('orcamento_categorias', $orcamento->id) }}"><i class="fa fa-edit"></i></a>
                      <!--
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
      {{ $orcamentos->links() }}
  </div>
</div>

@stop

@section('adminlte_js')

  <script src="{{ asset('dashboard/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>

@stop
