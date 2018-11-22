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
  <div class="col-md-12">
      <div class="card-box">

          <form class="form-inline" method="get" action="{{route('orcamento_create_finish')}}">

              <input type="hidden" name="gerar" value="1"/>

              <div class="col-md-4" id="sandbox-container2">
                <div class="input-group" id="datepicker">
                    <input type="text" class="input-lg form-control input-date-month" name="meses" placeholder="Informe o mês ou meses para o calculode orçamento" required/>
                </div>
              </div>

              <button class="btn btn-custom btn-lg">Próximo</button>

          </form>

      </div>
  </div>
</div>

@stop
