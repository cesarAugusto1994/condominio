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

            <select class="form-control input-lg" style="height:46px" name="relatorio" id="relatorio" required>
                <option value="">Selecione</option>
                <option value="1" {{ \Request::has('relatorio') && \Request::get('relatorio') == '1' ? 'selected' : '' }}>Fluxo de Caixa</option>
                <option value="2" {{ \Request::has('relatorio') && \Request::get('relatorio') == '2' ? 'selected' : '' }}>Controle Orçamentário</option>
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
                      <button type="submit" class="btn btn-icon btn-success btn-lg"> <i class="fa fa-search"></i></button>
                  </span>
              </div>
            </div>

            <div class="col-md-4" id="sandbox-container2">
              <div class="input-group" id="datepicker">
                  <input type="text" id="meses-picker" class="input-lg form-control input-date-month" name="meses" placeholder="Informe o mês ou meses para o calculode orçamento" required/>
                  <span class="input-group-append">
                      <button type="submit" class="btn btn-icon btn-success btn-lg"> <i class="fa fa-search"></i></button>
                  </span>
              </div>
            </div>

          </form>

      </div>
  </div>
</div>
@if(!empty($resultado) && \Request::get('relatorio') == 1)
    <div class="row">

      <div class="col-md-6">
          <div class="card-box">
              <h6 class="m-t-0 text-dark">Saldo Mẽs Anterior</h6>
              <h3 class="text-primary text-center m-b-30 m-t-30">R$ <span>{{ $movimentoAnterior }}</span></h3>
          </div>
      </div>

      <div class="col-md-6">
          <div class="card-box">
              <h6 class="m-t-0 text-dark">Saldo Atual</h6>
              <h3 class="text-custom text-center m-b-30 m-t-30">R$ <span>{{ $saldoAtual }}</span></h3>
          </div>
      </div>

      <div class="col-md-12">
          <div class="card-box table-responsive">

              <table class="table table-condensed table-hover">

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
                            <th colspan="{{ count(current($itens))+1 }}">{{ $key }}</th>
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
@elseif(!empty($resultado) && \Request::has('relatorio') == 2)

<div class="row">
    <div class="col-md-12">
        <div class="card-box table-responsive">

          <table class="table table-condensed table-hover">

              <thead>

                  <tr>
                      @foreach($header as $k => $i)
                          <th>{{ $i }}</th>
                      @endforeach
                  </tr>

              <thead>

              <tbody>

                @foreach($resultado as $key => $itens)

                    <tr>
                        <th colspan="{{ count(current($itens),1) }}">{{ $key }}</th>
                    </tr>

                  @foreach($itens as $key2 => $item)

                      <tr>
                          <td><h6 class="text-custom">{{ $key2 }}</h6></td>
                          @foreach($item as $i)
                              <td>
                                @if($i['meta'] < '0')
                                    <h6 class="text-danger">{{ number_format($i['meta'], 2, ',', '.') }}</h6>
                                @elseif($i['meta'] > '0')
                                    <h6 class="text-success">{{ number_format($i['meta'], 2, ',', '.') }}</h6>
                                @else
                                    <p class="text-muted">{{ number_format($i['meta'], 2, ',', '.') }}</p>
                                @endif
                               </td>
                               <td>
                                 @if($i['saldo'] < '0')
                                     <h6 class="text-danger">{{ number_format($i['saldo'], 2, ',', '.') }}</h6>
                                 @elseif($i['meta'] > '0')
                                     <h6 class="text-success">{{ number_format($i['saldo'], 2, ',', '.') }}</h6>
                                 @else
                                     <p class="text-muted">{{ number_format($i['saldo'], 2, ',', '.') }}</p>
                                 @endif
                                </td>
                                <td>
                                  @if($i['realizado'] < '0')
                                      <h6 class="text-danger">{{ number_format($i['realizado'], 2, ',', '.') }}</h6>
                                  @elseif($i['meta'] > '0')
                                      <h6 class="text-success">{{ number_format($i['realizado'], 2, ',', '.') }}</h6>
                                  @else
                                      <p class="text-muted">{{ number_format($i['realizado'], 2, ',', '.') }}</p>
                                  @endif
                                 </td>
                          @endforeach
                      </tr>
                  @endforeach

                @endforeach

              <tbody>



          </table>

        </div>
    </div>
</div>

@endif

@stop

@section('js')

  <script>

    $(document).ready(function() {

      var selectRelatorio = $("#relatorio");

      $("#sandbox-container").hide();
      $("#sandbox-container2").hide();

      if(selectRelatorio.val() == 1) {
          $("#sandbox-container").show();
          $("#sandbox-container2").hide();

          $("#meses-picker").removeAttr('required');

      } else {
        $("#sandbox-container").hide();
        $("#sandbox-container2").show();
      }

      selectRelatorio.change(function() {

        var self = $(this);
        var valor = self.val();

        if(valor == 1) {
            $("#sandbox-container").show();
            $("#sandbox-container2").hide();

            $("#meses-picker").removeAttr('required');

        } else {
          $("#sandbox-container").hide();
          $("#sandbox-container2").show();
        }

      });

    });

  </script>

@stop
