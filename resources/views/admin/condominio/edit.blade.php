@extends('adminlte::page')

@section('title', 'Condomínio')

@section('content_header')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="header-title m-t-0 m-b-20">Informações do seu Condomínio</h4>
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

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">

                  @php
                      $user = \Auth::user();
                      $condominio = $user->pessoa->condominio;
                  @endphp

                  <form method="post" action="{{ route('condominio.update', $condominio->id) }}">

                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label" for="nome">Nome</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-building"></i></span>
                                    </div>
                                    <input type="text" id="nome" name="nome" value="{{ $condominio->nome }}" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label" for="endereco">Endereço</label>
                                <div class="input-group">
                                    <input type="text" id="endereco" name="endereco" value="{{ $condominio->endereco }}" required class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label" for="cidade">Cidade</label>
                                <div class="input-group">
                                    <input type="text" id="cidade" name="cidade" value="{{ $condominio->cidade }}" required class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="col-form-label" for="estado">Estado</label>
                                <div class="input-group">
                                    <input type="text" id="estado" name="estado" value="{{ $condominio->estado }}" required class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label" for="cep">Cep</label>
                                <div class="input-group">
                                    <input type="text" id="cep" name="cep" value="{{ $condominio->cep }}" required class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-success">Salvar</button>
                        </div>

                    </div>

                  </form>

                </div>
            </div>
        </div>

      </div>
    </div>
  </div>

</div>



@stop
