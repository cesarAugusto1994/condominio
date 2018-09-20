@extends('layouts.create')

@section('title', 'Contatos')

@section('content_header')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="header-title m-t-0 m-b-20">Painel de Contatos</h4>
        </div>
    </div>
@stop

@section('content_box')
    {!! form($form) !!}
@stop
