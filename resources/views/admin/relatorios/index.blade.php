@extends('adminlte::page')

@section('title', 'Relatórios')

@section('content_header')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="header-title m-t-0 m-b-20">Relatórios</h4>
        </div>
    </div>
@stop

@section('content')

<div class="row">
  <div class="col-md-12">
      <div class="card-box">

          <form class="form-inline">

            <input type="hidden" name="generate" value="1"/>

            @php

                $date=new \DateTime('last day of this month');
                $first=new \DateTime('first day of this month');

                if(\Request::has('start') && \Request::has('end')) {
                  $first = \DateTime::createFromFormat('d/m/Y', \Request::get('start'));
                  $date = \DateTime::createFromFormat('d/m/Y', \Request::get('end'));
                }

            @endphp

            <select class="form-control input-lg" style="height:46px" name="relatorio">
                <option value="1">Fluxo de Caixa</option>
            </select>
            &nbsp;&nbsp;&nbsp;
            <select class="form-control input-lg" style="height:46px" name="conta">
              <option value="">Todas as Contas</option>
              @foreach($contas as $conta)
                <option value="{{$conta->id}}" {{ \Request::has('conta') && \Request::get('conta') == $conta->id ? 'selected' : '' }}>{{ $conta->tipo->nome }} {{ $conta->banco ? $conta->banco->nome : '' }}</option>
              @endforeach
            </select>

            <div class="span5 col-md-5" id="sandbox-container">
              <div class="input-daterange input-group" id="datepicker">
                  <input type="text" class="input-lg form-control" name="start" value="{{ $first->format('d/m/Y') }}"/>
                  <div class="input-group-append">
                      <span class="input-group-text">Até</span>
                  </div>
                  <input type="text" class="input-lg form-control" name="end" value="{{ $date->format('d/m/Y') }}"/>
                  <span class="input-group-append">
                      <button class="btn btn-icon btn-success btn-lg"> <i class="fa fa-search"></i></button>
                  </span>
              </div>
            </div>

          </form>

      </div>
  </div>
</div>
@if(!empty($resultado))
<div class="row">
  <div class="col-md-12">
      <div class="card-box">
          <div class="panel panel-default panel-fill">
              <div class="panel-heading">
                  <h3 class="panel-title">Resultado</h3>
              </div>
              <div class="panel-body table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>
                            <th><h3 class="text-primary">Fluxo de Caixa</h3></th>
                            @foreach($header as $k => $i)
                                <th>{{ $i }}</th>
                            @endforeach
                        </tr>

                    <thead>

                    <tbody>

                      @foreach($resultado as $key => $itens)

                          <tr>
                              <th colspan="{{ count(current($itens)) }}">{{ $key }}</th>
                          </tr>

                        @foreach($itens as $key2 => $item)

                            <tr>
                                <td><h6 class="text-custom">{{ $key2 }}</h6></td>
                                @foreach($item as $i)
                                    <td>@if($i != '0,00') <h6 class="text-success">{{ $i }}</h6> @else <p class="text-muted">{{ $i }}</p> @endif</td>
                                @endforeach
                            </tr>
                        @endforeach

                      @endforeach

                    <tbody>

                    <tfoot>
                      <tr>
                        <th><span class="text-custom"></span></th>
                        @foreach($footer as $k => $i)
                            <th>@if($i != '0,00') <h6 class="text-danger">{{ $i }}</h6>@else <p class="text-muted">{{ $i }}</p> @endif  </th>
                        @endforeach
                      </tr>

                      <tr>
                        <th><h6 class="text-primary">SALDO DIÁRIO</h6></th>
                        @foreach($saldoDiario as $k => $i)
                            <th>@if($i != '0,00') <h6 class="text-primary">{{ $i }}</h6>@else <p class="text-muted">{{ $i }}</p> @endif  </th>
                        @endforeach
                      </tr>
                    </tfoot>

                </table>

              </div>

          </div>
      </div>
  </div>
</div>
@endif

@stop

@section('adminlte_js')

  <script src="{{ asset('dashboard/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>

@stop
