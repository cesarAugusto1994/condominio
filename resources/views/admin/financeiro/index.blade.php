@extends('adminlte::page')

@section('title', 'Financeiro')

@section('content_header')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="header-title m-t-0 m-b-20">Painel Financeiro</h4>
        </div>
    </div>
@stop

@section('content')

<div class="row">
  <div class="col-md-12">
      <div class="card-box">

        <form class="form-inline">

          @php

              $date=new \DateTime('last day of this month');
              $first=new \DateTime('first day of this month');

              if(\Request::has('start') && \Request::has('end')) {
                $first = \DateTime::createFromFormat('d/m/Y', \Request::get('start'));
                $date = \DateTime::createFromFormat('d/m/Y', \Request::get('end'));
              }

          @endphp

          <select class="form-control input-lg" style="height:46px" name="conta">
            <option value="">Todas as Contas</option>
            @foreach($contas as $conta)
              <option value="{{$conta->id}}" {{ \Request::has('conta') && \Request::get('conta') == $conta->id ? 'selected' : '' }}>{{ $conta->tipo->nome }} {{ $conta->banco ? $conta->banco->nome : '' }}</option>
            @endforeach
          </select>

          <div class="span5 col-md-5" id="sandbox-container">
            <div class="input-daterange input-group" id="datepicker">
                <input type="text" class="input-lg form-control" name="start" value="{{ $first->format('d/m/Y') }}"/>
                <div class="input-group-append">
                    <span class="input-group-text">Até</span>
                </div>
                <input type="text" class="input-lg form-control" name="end" value="{{ $date->format('d/m/Y') }}"/>
                <span class="input-group-append">
                    <button class="btn btn-icon btn-success btn-lg"> <i class="fa fa-search"></i></button>
                </span>
            </div>
          </div>

        </form>

      </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
      <div class="card-box widget-inline">
          <div class="row">

              <div class="col-lg-3 col-sm-6">
                  <div class="widget-inline-box text-center">
                      <h3><i class="text-custom mdi mdi-coin"></i> <b id="recebimento"></b></h3>
                      <p class="text-muted">RECEBIMENTOS</p>
                  </div>
              </div>

              <div class="col-lg-3 col-sm-6">
                  <div class="widget-inline-box text-center">
                      <h3><i class="text-info mdi mdi-receipt"></i> <b id="despesas"></b></h3>
                      <p class="text-muted">DESPESAS</p>
                  </div>
              </div>

              <div class="col-lg-3 col-sm-6">
                  <div class="widget-inline-box text-center">
                      <h3><i class="text-primary mdi mdi-elevation-rise"></i> <b id="previsto"></b></h3>
                      <p class="text-muted">PREVISTO</p>
                  </div>
              </div>

              <div class="col-lg-3 col-sm-6">
                  <div class="widget-inline-box text-center b-0">
                      <h3><i class="text-danger mdi mdi-currency-usd"></i> <b id="total"></b></h3>
                      <p class="text-muted">SALDO TOTAL</p>
                  </div>
              </div>

          </div>
      </div>
  </div>
  </div>

<div class="row">

  <div class="col-md-12">
      <div class="card-box">

          <ul class="nav nav-tabs tabs-bordered nav-justified">
              <li class="nav-item">
                  <a href="#home-b2" data-toggle="tab" aria-expanded="false" class="nav-link">
                      Despesas <span class="badge badge-danger">{{ $movimentosDespesas->count() }}</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="#profile-b2" data-toggle="tab" aria-expanded="true" class="nav-link active">
                      Receitas <span class="badge badge-success">{{ $movimentosReceitas->count() }}</span>
                  </a>
              </li>
          </ul>
          <div class="tab-content">
              <div class="tab-pane" id="home-b2">

                <button class="btn btn-lg btn-icon btn-danger btnOpenModaDespesas"><i class="fa fa-plus"></i> </button>

                <hr/>

                <div class="row">

                  <div class="col-md-12">

                    <div class="table-responsive">
                      <table class="table table-hover mails m-0 table table-actions-bar table-bordered">
                        <thead>
                        <tr>
                          <th>Data</th>
                          <th>Descrição</th>
                          <th>Valor</th>
                          <th>Conta</th>
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
                              <td>{{ $movimento->conta->tipo->nome }}</td>
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

                <button class="btn btn-icon btn-lg btn-success btnOpenModaReceitas"><i class="fa fa-plus"></i> </button>

                <hr/>

                <div class="row">

                    <div class="col-md-12">

                      <div class="table-responsive">
                        <table class="table table-hover mails m-0 table table-actions-bar table-bordered">
                          <thead>
                          <tr>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Conta</th>
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
                                <td>{{ $movimento->conta->tipo->nome }}</td>
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
      <form method="post" action="{{ route('movimentos.store') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="hidden" name="movimento_tipo_id" value="2"/>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="descricao" class="control-label">Descrição:</label>
                  <input type="text" class="form-control" id="descricao" name="descricao">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="descricao" class="control-label">Conta:</label>
                  <select class="form-control select2"  style="width: 100%" name="conta_id">
                    @foreach($contas as $conta)
                      <option value="{{$conta->id}}">{{ $conta->tipo->nome }} {{ $conta->banco ? ' - ' . $conta->banco->nome : '' }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="descricao" class="control-label">Recebido de:</label>
                  <select class="form-control Select2 select2" required style="width: 100%" name="contato_id">
                    @foreach($contatos as $contato)
                      <option value="{{$contato->id}}">{{ $contato->nome }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="descricao" class="control-label">Valor:</label>
                  <input type="text" class="form-control money" id="valor" required name="valor">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="descricao" class="control-label">Data:</label>
                  <input type="text" class="form-control date" id="data" name="data" required value="{{ now()->format('d/m/Y') }}">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="descricao" class="control-label">Categoria:</label>

                  <select class="form-control Select2 select2"  style="width: 100%" name="categoria_id">
                    <option value="">Selecione</option>
                    @foreach($categorias as $categoria)
                      <option value="{{$categoria->id}}">{{ $categoria->nome }}</option>
                    @endforeach
                  </select>

                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label for="descricao" class="control-label">Pago:</label>
                  <select class="form-control Select2 select2" style="width: 100%" name="pago">
                      <option value="0">Não</option>
                      <option value="1">Sim</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="descricao" class="control-label">Pagamento:</label>

                  <select class="form-control Select2 select2"  style="width: 100%" name="pagamento">

                      <option value="1">Á Vista</option>
                      <option value="2">Criar Parcelas</option>
                      <option value="3">Repetir Transação</option>

                  </select>

                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="descricao" class="control-label">Competência:</label>
                  <input type="text" class="form-control date" id="descricao" name="competencia">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="descricao" class="control-label">Número do Documento:</label>
                  <input type="text" class="form-control" id="descricao" name="documento">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="descricao" class="control-label">Modo de Pagamento:</label>

                  <select class="form-control Select2 select2"  style="width: 100%" name="modo_pagamento">
                      <option value="">Selecione</option>
                      <option value="1">Dinheiro</option>
                      <option value="2">Cheque</option>
                      <option value="3">Boleto Bancário</option>
                      <option value="3">Cartão de Crédito</option>
                  </select>

                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="descricao" class="control-label">Anexar documento:</label>
                  <input type="file" class="form-control filestyle" data-size="md" data-buttontext="Selecione um comprovante" data-buttonname="btn-success" id="arquivo" name="arquivo">
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

      <form method="post" action="{{ route('movimentos.store') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="hidden" name="movimento_tipo_id" value="1"/>
          <div class="modal-body">

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Descrição:</label>
                    <input type="text" class="form-control" id="descricao" name="descricao">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Conta:</label>
                    <select class="form-control Select2 select2"  style="width: 100%" name="conta_id">
                      @foreach($contas as $conta)
                        <option value="{{$conta->id}}">{{ $conta->tipo->nome }} {{ $conta->banco ? ' - ' . $conta->banco->nome : '' }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Recebido de:</label>
                    <select class="form-control Select2 select2"  style="width: 100%" required name="contato_id">
                      @foreach($contatos as $contato)
                        <option value="{{$contato->id}}">{{ $contato->nome }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Valor:</label>
                    <input type="text" class="form-control money" id="valor" required name="valor">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Data:</label>
                    <input type="text" class="form-control date" id="data" name="data" required value="{{ now()->format('d/m/Y') }}">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Categoria:</label>

                    <select class="form-control Select2 select2"  style="width: 100%" name="categoria_id">
                      <option value="">Selecione</option>
                      @foreach($categorias as $categoria)
                        <option value="{{$categoria->id}}">{{ $categoria->nome }}</option>
                      @endforeach
                    </select>

                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Pago:</label>
                    <select class="form-control Select2 select2" style="width: 100%" name="pago">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Pagamento:</label>

                    <select class="form-control Select2 select2"  style="width: 100%" name="pagamento">

                        <option value="1">Á Vista</option>
                        <option value="2">Criar Parcelas</option>
                        <option value="3">Repetir Transação</option>

                    </select>

                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Competência:</label>
                    <input type="text" class="form-control date" id="descricao" name="competencia">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Número do Documento:</label>
                    <input type="text" class="form-control" id="descricao" name="documento">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Modo de Pagamento:</label>

                    <select class="form-control Select2 select2"  style="width: 100%" name="modo_pagamento">
                        <option value="">Selecione</option>
                        <option value="1">Dinheiro</option>
                        <option value="2">Cheque</option>
                        <option value="3">Boleto Bancário</option>
                        <option value="3">Cartão de Crédito</option>

                    </select>

                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="arquivo" class="control-label">Anexar documento:</label>
                    <input type="file" class="form-control filestyle" data-size="md" data-buttontext="Selecione um comprovante" data-buttonname="btn-default" id="arquivo2" name="arquivo">
                  </div>
                </div>
              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Salvar</button>
          </div>
      </form>
    </div>
  </div>
</div>

<input type="hidden" id="route-informcoes" value="{{ route('informacoes_financeiras', request()->getQueryString()) }}"/>

@stop

@section('adminlte_js')

  <script src="{{ asset('dashboard/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>

@stop
