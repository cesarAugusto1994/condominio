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

      if($limite) {
        $resultado = $limite - $restante;
        $gasto = number_format(($resultado/$limite) * 100, 2);
      }

  @endphp

  <div class="col-md-3">
      <div class="card-box pb-0">
          <a href="javascript:;" class="mx-auto text-center text-dark" style="display: block;">

              <div class="h5 m-b-0"><strong>{{ $conta->tipo->nome }}</strong> - {{ $conta->banco ? $conta->banco->nome : '' }}</div>
          </a>
          <div class="bg-twitter pull-in-card p-20 widget-box-two mb-0 m-t-30 list-inline text-center row">
              <div class="col-4">
                  <h5 class="text-white m-0 font-600">{{ $limiteFormatado }}</h5>
                  <p class="text-white mb-0">Limite</p>
              </div>
              <div class="col-4">
                  <h5 class="text-white m-0 font-600">{{ $restanteFormatado }}</h5>
                  <p class="text-white mb-0">Saldo</p>
              </div>
              <div class="col-4">
                  <h5 class="text-white m-0 font-600">{{ $gasto }}%</h5>
                  <p class="text-white mb-0">Percentual</p>
              </div>
          </div>
      </div>

  </div>

  <div class="col-md-9">
      <div class="card-box">

          <ul class="nav nav-tabs tabs-bordered nav-justified">
              <li class="nav-item">
                  <a href="#home-b2" data-toggle="tab" aria-expanded="false" class="nav-link">
                      Despesas
                  </a>
              </li>
              <li class="nav-item">
                  <a href="#profile-b2" data-toggle="tab" aria-expanded="true" class="nav-link active">
                      Receitas
                  </a>
              </li>
          </ul>
          <div class="tab-content">
              <div class="tab-pane" id="home-b2">

                <!--
                <button class="btn btn-icon btn-danger btn-lg btnOpenModaDespesas"> <i class="fa fa-plus"></i></button>

                <hr/>
              -->
              
                <div class="row">

                  <div class="col-md-12">

                    <div class="table-responsive">
                      <table class="table table-hover mails m-0 table table-actions-bar table-bordered">
                        <thead>
                        <tr>
                          <th>Data</th>
                          <th>Descrição</th>
                          <th>Valor</th>
                          <th style="width:200px">Contato</th>
                          <th style="width:200px">Documentos</th>
                          <th>pago</th>
                          <th style="width:150px">Opções</th>
                        </tr>
                        </thead>
                        <tbody>

                          @foreach($movimentosDespesas as $movimento)
                            <tr>
                              <td>{{ $movimento->data_pagamento->format('d/m/Y') }}</td>
                              <td>{{ $movimento->descricao }}</td>
                              <td>{{ number_format($movimento->valor, 2, ',', '.') }}</td>
                              <td>{{ $movimento->contato->nome }}</td>
                              <td>
                                @foreach($movimento->documentos as $doc)
                                  <a target="_blank" href="{{ route('images',['link'=>$doc->path]) }}">{{ $doc->nome }}</a><br/>
                                @endforeach
                              </td>
                              <td>
                                <input class="pago_checkbox" data-route="{{route('movimento_pagar',$movimento->id)}}" id="checkbox3" data-movimento="{{$movimento->id}}" type="checkbox" data-plugin="switchery" data-switchery="true" data-color="#039cfd" value="{{$movimento->id}}" {{ $movimento->pago ? 'checked' : '' }}>
                              </td>
                              <td>
                                <a href="{{ route('movimentos.edit', $movimento->id) }}" class="btn btn-icon btn-info"><i class="fa fa-edit"></i> </a>
                                <button class="btn btn-icon btn-danger btnRemoveItem" data-route="{{route('movimentos.destroy',$movimento->id)}}"> <i class="fa fa-remove"></i> </button>
                              </td>
                            </tr>
                          @endforeach

                        </tbody>
                      </table>
                    </div>

                  </div>

                </div>

              </div>
              <div class="tab-pane active" id="profile-b2">

                <!--
                <button class="btn btn-icon btn-success btn-lg btnOpenModaReceitas"> <i class="fa fa-plus"></i></button>

                <hr/>
              -->

                <div class="row">

                    <div class="col-md-12">

                      <div class="table-responsive">
                        <table class="table table-hover mails m-0 table table-actions-bar table-bordered">
                          <thead>
                          <tr>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th style="width:200px">Contato</th>
                            <th style="width:200px">Documentos</th>
                            <th>Pago</th>
                            <th style="width:150px">Opções</th>
                          </tr>
                          </thead>
                          <tbody>

                            @foreach($movimentosReceitas as $movimento)
                              <tr>
                                <td>{{ $movimento->data_pagamento->format('d/m/Y') }}</td>
                                <td>{{ $movimento->descricao }}</td>
                                <td>{{ number_format($movimento->valor, 2, ',', '.') }}</td>
                                <td>{{ $movimento->contato->nome ?? '' }}</td>
                                <td>
                                  @foreach($movimento->documentos as $doc)
                                    <a target="_blank" href="{{ route('images',['link'=>$doc->path]) }}">{{ $doc->nome }}</a><br/>
                                  @endforeach
                                </td>
                                <td>
                                  <input class="pago_checkbox" data-route="{{route('movimento_pagar',$movimento->id)}}" id="checkbox3" data-movimento="{{$movimento->id}}" type="checkbox" data-plugin="switchery" data-switchery="true" data-color="#039cfd" value="{{$movimento->id}}" {{ $movimento->pago ? 'checked' : '' }}>
                                </td>
                                <td>
                                  <a href="{{ route('movimentos.edit', $movimento->id) }}" class="btn btn-icon btn-info"><i class="fa fa-edit"></i> </a>
                                  <button class="btn btn-icon btn-danger btnRemoveItem" data-route="{{route('movimentos.destroy',$movimento->id)}}"> <i class="fa fa-remove"></i> </button>
                                </td>
                              </tr>
                            @endforeach

                          </tbody>
                        </table>
                      </div>

                    </div>

                </div>

              </div>

          </div>
      </div>
  </div>

</div>

<div class="modal modal-danger fade " id="modalDespesas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Nova Despesa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form method="post" action="{{ route('movimentos.store') }}">
          {{ csrf_field() }}
          <input type="hidden" name="conta_id" value="{{ $conta->id }}"/>
          <input type="hidden" name="movimento_tipo_id" value="2"/>
          <div class="modal-body">
              <div class="row">
                <div class="col-md-9">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Descrição:</label>
                    <input type="text" class="form-control" id="descricao" name="descricao">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Pago à:</label>
                    <select class="form-control Select2 select2"  style="width: 100%" name="cliente">
                      @foreach($contatos as $contato)
                        <option value="{{$contato->id}}">{{ $contato->nome }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Valor:</label>
                    <input type="text" class="form-control" id="valor" name="valor">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Categoria:</label>
                    <input type="text" class="form-control" id="categoria" name="categoria">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Pagamento:</label>
                    <input type="text" class="form-control" id="pagamento" name="pagamento">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Pago:</label>
                    <select class="form-control Select2 select2"  style="width: 100%" name="cliente">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Competência:</label>
                    <input type="text" class="form-control" id="competencia" name="competencia">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Número do Documento:</label>
                    <input type="text" class="form-control" id="documento" name="documento">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Modo de Pagamento:</label>
                    <input type="text" class="form-control" id="pagamento" name="pagamento">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Anexar documento:</label>
                    <input type="file" class="form-control" id="anexo" name="anexo">
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Salvar</button>
          </div>
      </form>
    </div>
  </div>
</div>
<div class="modal modal-success fade " id="modalReceitas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Nova Receita</h5>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>

      <form method="post" action="{{ route('movimentos.store') }}">
          {{ csrf_field() }}
          <input type="hidden" name="conta_id" value="{{ $conta->id }}"/>
          <input type="hidden" name="movimento_tipo_id" value="1"/>
          <div class="modal-body">
            <form>
              <div class="row">
                <div class="col-md-9">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Descrição:</label>
                    <input type="text" class="form-control" id="descricao" name="descricao">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Recebido de:</label>
                    <select class="form-control Select2 select2"  style="width: 100%" name="cliente">
                      @foreach($contatos as $contato)
                        <option value="{{$contato->id}}">{{ $contato->nome }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Valor:</label>
                    <input type="text" class="form-control" id="descricao" name="descricao">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Categoria:</label>
                    <input type="text" class="form-control" id="descricao" name="descricao">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Pagamento:</label>
                    <input type="text" class="form-control" id="descricao" name="descricao">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Pago:</label>
                    <select class="form-control Select2 select2"  style="width: 100%" name="cliente">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Competência:</label>
                    <input type="text" class="form-control" id="descricao" name="descricao">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Número do Documento:</label>
                    <input type="text" class="form-control" id="descricao" name="descricao">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Modo de Pagamento:</label>
                    <input type="text" class="form-control" id="descricao" name="descricao">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Anexar documento:</label>
                    <input type="file" class="form-control" id="descricao" name="descricao">
                  </div>
                </div>
              </div>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Salvar</button>
          </div>
      </form>
    </div>
  </div>
</div>

@stop

@section('adminlte_js')

  <script>
      $( '.btnOpenModaDespesas' ).click( function() {
        $( '#modalDespesas' ).modal();
      });
      $( '.btnOpenModaReceitas' ).click( function() {
        $( '#modalReceitas' ).modal();
      });
  </script>

@stop
