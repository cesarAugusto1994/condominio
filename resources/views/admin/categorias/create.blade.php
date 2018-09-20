@extends('adminlte::page')

@section('title', 'Contas')

@section('content_header')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="header-title m-t-0 m-b-20">Painel de Contas</h4>
        </div>
    </div>
@stop

@section('content')

<div class="row">

  <div class="col-md-12">
    <div class="box box-success">
      <div class="box-header with-border">
      </div>
      <div class="box-body">

        {!! form($form) !!}

      </div>
    </div>
  </div>

</div>



@stop
