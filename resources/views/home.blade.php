@extends('adminlte::page')

@section('title', 'Meu Condominio')

@section('content_header')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="header-title m-t-0 m-b-20">Painel Principal</h4>
        </div>
    </div>
@stop

@section('content')

@stop

@section('js')
  <script src="{{ asset('dashboard/plugins/morris/morris.min.js') }}"></script>
  <script src="{{ asset('dashboard/plugins/raphael/raphael-min.js') }}"></script>
  <script src="{{ asset('dashboard/pages/jquery.dashboard.js') }}"></script>
@stop
