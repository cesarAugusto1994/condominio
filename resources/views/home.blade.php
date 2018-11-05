@extends('adminlte::page')

@section('title', 'Meu Condominio')

@section('content_header')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="header-title m-t-0 m-b-20">Painel Principal</h4>
        </div>
    </div>
@stop

@section('css')

  <style>

    .morris-hover.morris-default-style .morris-hover-point, .morris-hover.morris-default-style .morris-hover-row-label{
      color: grey;
    }

  </style>

@endsection

@section('content')

@php

  $first=new \DateTime('first day of this month');
  $last=new \DateTime('last day of this month');

  $user = \Auth::user();
  $condominio = $user->pessoa->condominio->id;

  $movimentosDespesas = \App\Models\Conta\Movimento::where('movimento_tipo_id', 2)
  ->where('data_pagamento','>=',$first)
  ->where('data_pagamento','<=',$last)
  ->where('condominio_id',$condominio)
  ->orderBy('data_pagamento')
  ->get();

  $movimentosReceitas = \App\Models\Conta\Movimento::where('movimento_tipo_id', 1)
  ->where('data_pagamento','>=',$first)
  ->where('data_pagamento','<=',$last)
  ->where('condominio_id',$condominio)
  ->orderBy('data_pagamento')
  ->get();

@endphp

<div class="row">
    <div class="col-md-4">
        <div class="card-box">
            <i class="fa fa-info-circle text-muted pull-right inform" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Valor total de Receitas"></i>
            <h6 class="m-t-0 text-dark">Receitas</h6>
            <h3 class="text-primary text-center m-b-30 m-t-30">R$ <span id="recebimento"></span></h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-box">
            <i class="fa fa-info-circle text-muted pull-right inform" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Valor total de Despesas"></i>
            <h6 class="m-t-0 text-dark">Despesas</h6>
            <h3 class="text-danger text-center m-b-30 m-t-30">R$ <span id="despesas"></span></h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-box">
            <i class="fa fa-info-circle text-muted pull-right inform" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Valor total"></i>
            <h6 class="m-t-0 text-dark">Total</h6>
            <h3 class="text-success text-center m-b-30 m-t-30">R$ <span id="total"></span></h3>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card-box">
            <h6 class="m-t-0">Analise Por Periodo</h6>
            <div class="text-center">
                <ul class="list-inline chart-detail-list">
                    <li class="list-inline-item">
                        <p class="font-normal"><i class="fa fa-circle m-r-10 text-primary"></i>Receitas</p>
                    </li>
                    <li class="list-inline-item">
                        <p class="font-normal"><i class="fa fa-circle m-r-10 text-danger"></i>Despesas</p>
                    </li>
                </ul>
            </div>
            <div id="dashboard-bar-stacked" style="height: 300px;"></div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card-box">
            <h6 class="m-t-0">Análise</h6>
            <div class="text-center">
                <ul class="list-inline chart-detail-list">
                    <li class="list-inline-item">
                        <p class="font-weight-bold"><i class="fa fa-circle m-r-10 text-primary"></i>Receitas</p>
                    </li>
                    <li class="list-inline-item">
                        <p class="font-weight-bold"><i class="fa fa-circle m-r-10 text-danger"></i>Despesas</p>
                    </li>
                </ul>
            </div>
            <div id="dashboard-line-chart" style="height: 300px;"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <h6 class="m-t-0">Últimas Movimentações</h6>
            <div class="table-responsive">
                <table class="table table-hover mails m-0 table table-actions-bar">
                    <thead>
                      <tr>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Valor</th>
                        <th>Conta</th>
                        <th style="width:200px">Contato</th>
                        <th style="width:150px">Anexos</th>
                        <th>pago</th>
                        <th style="width:150px">Opções</th>
                      </tr>
                    </thead>

                    <tbody>

                      @php

                        $user = \Auth::user();
                        $condominio = $user->pessoa->condominio->id;

                        $movimentos = \App\Models\Conta\Movimento::where('condominio_id',$condominio)
                        ->orderByDesc('id')
                        ->take(5)
                        ->get()

                      @endphp

                      @foreach($movimentos as $movimento)
                        <tr>
                          @if($movimento->tipo->id == 1)
                              <td><span class="badge badge-success">{{ $movimento->tipo->nome }}</span></td>
                          @else
                              <td><span class="badge badge-danger">{{ $movimento->tipo->nome }}</span></td>
                          @endif
                          <td>{{ $movimento->data_pagamento->format('d/m/Y') }}</td>
                          <td>{{ $movimento->descricao }}</td>
                          <td>{{ $movimento->categoria->nome }}</td>
                          <td>{{ number_format($movimento->valor, 2, ',', '.') }}</td>
                          <td>{{ $movimento->conta->tipo->nome }}</td>
                          <td><a class="text-custom" href="{{route('contatos.edit',$movimento->contato->id)}}">{{ $movimento->contato->nome }}</a></td>
                          <td>
                            @foreach($movimento->documentos as $doc)
                              <a target="_blank" href="{{ route('images',['link'=>$doc->path]) }}">{{ $doc->nome }}</a><br/>
                            @endforeach
                          </td>
                          <td>
                            <input class="pago_checkbox" data-route="{{route('movimento_pagar',$movimento->id)}}" id="checkbox3" data-size="small" data-movimento="{{$movimento->id}}" type="checkbox" data-plugin="switchery" data-switchery="true" data-color="#039cfd" value="{{$movimento->id}}" {{ $movimento->pago ? 'checked' : '' }}>
                          </td>
                          <td>
                            <a href="{{ route('movimentos.edit', $movimento->id) }}" class="btn btn-sm btn-icon btn-info"><i class="fa fa-edit"></i> </a>
                            <button class="btn btn-sm btn-icon btn-danger btnRemoveItem" data-route="{{route('movimentos.destroy',$movimento->id)}}"> <i class="fa fa-remove"></i> </button>
                          </td>
                        </tr>
                      @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="route-informcoes" value="{{ route('informacoes_financeiras', request()->getQueryString()) }}"/>

@stop

@section('js')
  <script src="{{ asset('dashboard/plugins/morris/morris.min.js') }}"></script>
  <script src="{{ asset('dashboard/plugins/raphael/raphael-min.js') }}"></script>
  <script src="{{ asset('dashboard/pages/jquery.dashboard.js') }}"></script>
@stop
