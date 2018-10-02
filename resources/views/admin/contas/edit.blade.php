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

            <h6 class="m-t-0">Editar Conta</h6>

            <form role="form" action="{{ route('contas.update', $conta->uuid) }}" method="post">

              {{ csrf_field() }}
              {{ method_field('PUT') }}

              @php

                  $tipos = \App\Models\Conta\Tipo::all();
                  $bancos = \App\Models\Banco::all();

              @endphp

              <div class="row">

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label" for="conta_tipo_id">Tipo</label>
                        <div class="input-group">

                            <select id="conta_tipo_id" name="conta_tipo_id" class="form-control">
                              @foreach ($tipos as $key => $tipo)
                                  <option value="{{ $tipo->id }}" {{ $conta->conta_tipo_id == $tipo->id ? 'selected' : '' }}>{{ $tipo->nome }}</option>
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
                                  <option value="{{ $banco->id }}" {{ $conta->banco_id == $banco->id ? 'selected' : '' }}>{{ $banco->nome }}</option>
                              @endforeach
                            </select>

                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label" for="numero">Número</label>
                        <div class="input-group">
                            <input type="text" id="numero" name="numero" class="form-control" value="{{ $conta->numero }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label" for="agencia">Agência</label>
                        <div class="input-group">
                            <input type="text" id="agencia" name="agencia" class="form-control" value="{{ $conta->agencia }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label" for="conta">Conta</label>
                        <div class="input-group">
                            <input type="text" id="conta" name="conta" class="form-control" value="{{ $conta->conta }}">
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
                            <input type="text" id="limite" name="limite" class="form-control money" value="{{ number_format($conta->limite, 2, '.', ',') }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label" for="ativo">Ativo</label>
                        <div class="input-group">
                            <input type="checkbox" id="ativo" name="ativo" value="1" {{ $conta->ativo ? 'checked' : '' }}>
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
