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

            <h6 class="m-t-0">Nova Conta</h6>

            <form role="form" action="{{ route('contas.store') }}" method="post">

              {{ csrf_field() }}

              @php

                  $tipos = \App\Models\Conta\Tipo::all();
                  $bancos = \App\Models\Banco::all();

              @endphp

              <div class="row">

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label" for="nome">Nome</label>
                        <div class="input-group">
                            <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome') }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label" for="conta_tipo_id">Tipo</label>
                        <div class="input-group">

                            <select id="conta_tipo_id" name="conta_tipo_id" class="form-control">
                              @foreach ($tipos as $key => $tipo)
                                  <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                              @endforeach
                            </select>

                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label" for="banco_id">Banco</label>
                        <div class="input-group">

                            <select id="banco_id" name="banco_id" class="form-control">
                                  <option value="">Sem vínculo</option>
                              @foreach ($bancos as $key => $banco)
                                  <option value="{{ $banco->id }}">{{ $banco->nome }}</option>
                              @endforeach
                            </select>

                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label" for="numero">Número</label>
                        <div class="input-group">
                            <input type="text" id="numero" name="numero" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label" for="agencia">Agência</label>
                        <div class="input-group">
                            <input type="text" id="agencia" name="agencia" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label" for="conta">Conta</label>
                        <div class="input-group">
                            <input type="text" id="conta" name="conta" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label" for="limite">Limite</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">R$ </span>
                            </div>
                            <input type="text" id="limite" name="limite" class="form-control money">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label" for="ativo">Ativo</label>
                        <div class="input-group">
                            <input type="checkbox" id="ativo" name="ativo" checked value="1">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button class="btn btn-success" type="submit">Salvar</button>
                </div>

            </div>

            </form>

        </div>
    </div>
</div>

@stop
