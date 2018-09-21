@extends('adminlte::page')

@section('title', 'Grupo Categorias')

@section('content_header')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="header-title m-t-0 m-b-20">Painel de Grupo Categorias</h4>
        </div>
    </div>
@stop

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <a href="{{ route('grupos.create') }}" class="btn btn-success">Novo</a>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>
        </div>
        <div class="box-body">

          {{ $table }}

        </div>
      </div>
    </div>

</div>

@stop
