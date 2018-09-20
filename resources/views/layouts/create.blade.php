@extends('adminlte::page')

@section('title', 'Contato')

@section('content_header')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="header-title m-t-0 m-b-20">@yield('title_box')</h4>
        </div>
    </div>
@stop

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">@yield('title_box') </h3>
      </div>
      <div class="box-body">

        @yield('content_box')

      </div>
    </div>
  </div>
</div>

@stop
