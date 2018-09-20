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
    <div class="col-sm-12">
        <div class="card-box">
            <a href="{{ route('contas.create') }}" class="btn btn-success">Novo</a>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-12">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>
        </div>
        <div class="box-body">

          <div class="row">

            @foreach($contas as $conta)

            @php

                $card = 'bg-aqua';
                $icon = 'credit-card';

                if($conta->tipo->id == 2) {

                  $card = 'bg-green';
                  $icon = 'bank';

                } elseif($conta->tipo->id == 3) {

                  $card = 'bg-red';
                  $icon = 'key';

                }

                $restante = $conta->movimentos->sum('valor');
                $limite = $conta->limite;

                $restanteFormatado = number_format($restante, 2, ',', '.');
                $limiteFormatado = number_format($limite, 2, ',', '.');

                $gasto = 0.00;

                if(!$restante) {
                  //$restante = 1;
                }

                if(!$limite) {
                  $limite = 1;
                }

                $resultado = $limite - $restante;

                if($restante || $limite>0) {
                  $gasto = number_format(($resultado/$limite) * 100, 2);
                }


            @endphp

            <div class="col-md-4">
                <div class="card-box pb-0">

                    <a href="{{ route('contas.show', $conta->uuid) }}" class="mx-auto text-center text-dark" style="display: block;">
                        <div class="h5 m-b-0"><strong>{{ $conta->tipo->nome }}</strong> {{ $conta->banco ? $conta->banco->nome : '' }}</div>
                    </a>
                    <div class="bg-custom pull-in-card p-20 widget-box-two mb-0 m-t-30 list-inline text-center row">
                        <div class="col-12">
                            <h5 class="text-white m-0 font-600">Limite</h5>
                            <p class="text-white mb-0">{{ $restanteFormatado }} / {{ $limiteFormatado }}</p>
                        </div>
                        <a href="{{ route('contas.edit', $conta->uuid) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Editar</a>
                        <a class="btn btn-sm btn-danger btnRemoveItem" data-route="{{route('contas.destroy',$conta->id)}}"><i class="fa fa-remove"></i> Remover</a>
                    </div>
                </div>

            </div>


            @endforeach

          </div>

        </div>
      </div>
    </div>

</div>



@stop
