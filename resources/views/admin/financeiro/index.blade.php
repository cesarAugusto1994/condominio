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
                  <a href="#home-b2" data-toggle="tab" aria-expanded="false" class="nav-link active">
                      Despesas <span class="badge badge-danger">{{ $movimentosDespesas->count() }}</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="#profile-b2" data-toggle="tab" aria-expanded="true" class="nav-link ">
                      Receitas <span class="badge badge-success">{{ $movimentosReceitas->count() }}</span>
                  </a>
              </li>
          </ul>
          <div class="tab-content">
              <div class="tab-pane active" id="home-b2">

                <button class="btn btn-lg btn-icon btn-danger btnOpenModaDespesas"><i class="fa fa-plus"></i> </button>

                <hr/>

                <div class="row">

                  <div class="col-md-12">

                    <div class="table-responsive">
                      <table class="table table-hover mails m-0 table table-actions-bar">
                        <thead>
                        <tr>
                          <th>Data</th>
                          <th>Descrição</th>
                          <th>Categoria</th>
                          <th>(R$) Valor</th>
                          <th>Conta</th>
                          <th style="width:200px">Pago à</th>
                          <th style="width:150px">Anexos</th>
                          <th>Pago</th>
                          <th style="width:150px">Opções</th>
                        </tr>
                        </thead>
                        <tbody>

                          @foreach($movimentosDespesas as $movimento)
                            <tr>
                              <td>{{ $movimento->data_pagamento->format('d/m/Y') }}</td>
                              <td>{{ $movimento->descricao }}</td>
                              <td>{{ $movimento->categoria->nome }}</td>
                              <td>{{ number_format($movimento->valor, 2, ',', '.') }}</td>
                              <td>{{ $movimento->conta->tipo->nome }}</td>
                              <td><a class="text-custom" href="{{route('contatos.edit',$movimento->contato->id)}}">{{ $movimento->contato->nome }}</a></td>
                              <td>
                                @foreach($movimento->documentos as $doc)
                                  <a target="_blank" href="{{ route('images',['link'=>$doc->path]) }}">{{ $doc->nome }}</a><br/>
                                @endforeach
                              </td>
                              <td>
                                <input class="pago_checkbox" data-route="{{route('movimento_pagar',$movimento->id)}}" id="checkbox2" data-movimento="{{$movimento->id}}" type="checkbox" data-plugin="switchery" data-switchery="true" data-size="small" data-color="#039cfd" value="{{$movimento->id}}" {{ $movimento->pago ? 'checked' : '' }}>
                              </td>
                              <td>
                                <a href="{{ route('movimentos.edit', $movimento->id) }}" class="btn btn-sm btn-icon btn-info"><i class="fa fa-edit"></i> </a>
                                <button class="btn btn-sm btn-icon btn-danger btnRemoveItem" data-route="{{route('movimentos.destroy',$movimento->id)}}"> <i class="fa fa-remove"></i> </button>
                              </td>
                            </tr>
                          @endforeach

                        </tbody>
                      </table>
                    </div>

                  </div>

                </div>

              </div>
              <div class="tab-pane" id="profile-b2">

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
                            <th>Categoria</th>
                            <th>(R$) Valor</th>
                            <th>Conta</th>
                            <th style="width:200px">Recebido de</th>
                            <th style="width:150px">Anexos</th>
                            <th>Pago</th>
                            <th style="width:150px">Opções</th>
                          </tr>
                          </thead>
                          <tbody>

                            @foreach($movimentosReceitas as $movimento)
                              <tr>
                                <td>{{ $movimento->data_pagamento->format('d/m/Y') }}</td>
                                <td>{{ $movimento->descricao }}</td>
                                <td>{{ $movimento->categoria->nome }}</td>
                                <td>{{ number_format($movimento->valor, 2, ',', '.') }}</td>
                                <td>{{ $movimento->conta->tipo->nome }}</td>
                                <td><a class="text-custom" href="{{route('contatos.edit',$movimento->contato->id)}}">{{ $movimento->contato->nome }}</a></td>
                                <td>
                                  @foreach($movimento->documentos as $doc)
                                    <a target="_blank" href="{{ route('images',['link'=>$doc->path]) }}">{{ $doc->nome }}</a><br/>
                                  @endforeach
                                </td>
                                <td>
                                  <input class="pago_checkbox" data-route="{{route('movimento_pagar',$movimento->id)}}" id="checkbox3" data-movimento="{{$movimento->id}}" type="checkbox" data-plugin="switchery" data-switchery="true" data-size="small" data-color="#039cfd" value="{{$movimento->id}}" {{ $movimento->pago ? 'checked' : '' }}>
                                </td>
                                <td>
                                  <a href="{{ route('movimentos.edit', $movimento->id) }}" class="btn btn-sm btn-icon btn-info"><i class="fa fa-edit"></i> </a>
                                  <button class="btn btn-sm btn-icon btn-danger btnRemoveItem" data-route="{{route('movimentos.destroy',$movimento->id)}}"> <i class="fa fa-remove"></i> </button>
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
                  <label for="descricao" class="control-label">Pago à:</label>

                  <div class="input-group">
                      <select class="form-control Select2 select2 contato-select" required name="contato_id">
                        @foreach($contatos as $contato)
                          <option value="{{$contato->id}}">{{ $contato->nome }}</option>
                        @endforeach
                      </select>
                      <span class="input-group-prepend">
                          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#contato-modal"><i class="fa fa-plus"></i></button>
                      </span>
                  </div>

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

                  <select class="form-control Select2 select2"  style="width: 100%" name="categoria_id" required>
                    <option value="">Selecione</option>
                    @foreach($grupos as $grupo)
                        <optgroup label="{{ $grupo->nome }}">
                        @foreach($grupo->categorias as $categoria)
                          <option value="{{$categoria->id}}">{{ $categoria->nome }}</option>
                        @endforeach
                        <optgroup>
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
                  <input type="file" class="form-control filestyle" data-size="md" data-buttontext="Selecione um comprovante" data-buttonname="btn-default" id="arquivo" name="arquivo">
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

                      <div class="input-group">
                          <select class="form-control Select2 select2 contato-select" required name="contato_id">
                            @foreach($contatos as $contato)
                              <option value="{{$contato->id}}">{{ $contato->nome }}</option>
                            @endforeach
                          </select>
                          <span class="input-group-prepend">
                              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#contato-modal"><i class="fa fa-plus"></i></button>
                          </span>
                      </div>

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

                    <select class="form-control Select2 select2"  style="width: 100%" name="categoria_id" required>
                      <option value="">Selecione</option>
                      @foreach($grupos as $grupo)
                          <optgroup label="{{ $grupo->nome }}">
                          @foreach($grupo->categorias as $categoria)
                            <option value="{{$categoria->id}}">{{ $categoria->nome }}</option>
                          @endforeach
                          <optgroup>
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

<div id="contato-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Proprietário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <form method="post" id="formContato" class="formSubmitAjax" data-parent-modal="#contato-modal" data-target-element=".contato-select" action="{{ route('contato_store_ajax') }}" role="form">
            <div class="modal-body">

                {{ csrf_field() }}

                <div class="row">

                  <div class="col-md-4">
                      <div class="form-group">
                          <label class="col-form-label" for="nome">Nome</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fa fa-user"></i></span>
                              </div>
                              <input type="text" id="nome" name="nome" class="form-control" required>
                          </div>
                      </div>
                  </div>

                  <div class="col-md-4">
                      <div class="form-group">
                          <label class="col-form-label" for="tipo">Tipo</label>
                          <div class="input-group">

                              <select id="tipo_pessoa" name="tipo_pessoa" class="form-control">
                                <option value="Pessoa Física">Pessoa Física</option>
                                <option value="Pessoa Jurídica">Pessoa Jurídica</option>
                              </select>

                          </div>
                      </div>
                  </div>

                  <div class="col-md-4">
                      <div class="form-group">
                          <label class="col-form-label" for="categoria">Categoria</label>
                          <div class="input-group">

                              <select id="categoria" name="categoria" class="form-control">
                                <option value="Cliente">Cliente</option>
                                <option value="Fornecedor">Fornecedor</option>
                                <option value="Funcionário">Funcionário</option>
                              </select>

                          </div>
                      </div>
                  </div>

                  <div class="col-md-3">
                      <div class="form-group">
                          <label class="col-form-label" for="cpf_cnpj">CPF / CNPJ</label>
                          <div class="input-group">
                              <input type="text" id="cpf_cnpj" name="cpf_cnpj" class="form-control">
                          </div>
                      </div>
                  </div>

                  <div class="col-md-3">
                      <div class="form-group">
                          <label class="col-form-label" for="email">Email</label>
                          <div class="input-group">
                              <input type="text" id="email" name="email" class="form-control">
                          </div>
                      </div>
                  </div>

                  <div class="col-md-3">
                      <div class="form-group">
                          <label class="col-form-label" for="telefone">Telefone</label>
                          <div class="input-group">
                              <input type="text" id="telefone" name="telefone" class="form-control">
                          </div>
                      </div>
                  </div>

                  <div class="col-md-3">
                      <div class="form-group">
                          <label class="col-form-label" for="celular">Celular</label>
                          <div class="input-group">
                              <input type="text" id="celular" name="celular" class="form-control">
                          </div>
                      </div>
                  </div>

                  <div class="col-md-5">
                      <div class="form-group">
                          <label class="col-form-label" for="endereco">Endereço</label>
                          <div class="input-group">
                              <input type="text" id="endereco" name="endereco" class="form-control">
                          </div>
                      </div>
                  </div>

                  <div class="col-md-1">
                      <div class="form-group">
                          <label class="col-form-label" for="numero">Numero</label>
                          <div class="input-group">
                              <input type="text" id="numero" name="numero" class="form-control">
                          </div>
                      </div>
                  </div>

                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="col-form-label" for="complemento">Complemento</label>
                          <div class="input-group">
                              <input type="text" id="complemento" name="complemento" class="form-control">
                          </div>
                      </div>
                  </div>

                  <div class="col-md-3">
                      <div class="form-group">
                          <label class="col-form-label" for="bairro">Bairro</label>
                          <div class="input-group">
                              <input type="text" id="bairro" name="bairro" class="form-control">
                          </div>
                      </div>
                  </div>

                  <div class="col-md-3">
                      <div class="form-group">
                          <label class="col-form-label" for="cep">Cep</label>
                          <div class="input-group">
                              <input type="text" id="cep" name="cep" class="form-control">
                          </div>
                      </div>
                  </div>

                  <div class="col-md-3">
                      <div class="form-group">
                          <label class="col-form-label" for="estado">Estado</label>
                          <div class="input-group">
                              <input type="text" id="estado" name="estado" class="form-control">
                          </div>
                      </div>
                  </div>

                  <div class="col-md-3">
                      <div class="form-group">
                          <label class="col-form-label" for="cidade">Cidade</label>
                          <div class="input-group">
                              <input type="text" id="cidade" name="cidade" class="form-control">
                          </div>
                      </div>
                  </div>

                  <div class="col-md-3">
                      <div class="form-group">
                          <label class="col-form-label" for="aniversario">Aniversario</label>
                          <div class="input-group">
                              <input type="text" id="aniversario" name="aniversario" class="form-control date">
                          </div>
                      </div>
                  </div>

                  <div class="col-md-9">
                      <div class="form-group">
                          <label class="col-form-label" for="descricao">Descricao</label>
                          <div class="input-group">
                              <textarea id="descricao" name="descricao" class="form-control"></textarea>
                          </div>
                      </div>
                  </div>

                  <div class="col-md-12">
                      <div class="form-group">
                          <label class="col-form-label" for="ativo">Ativo</label>
                          <div class="input-group">
                              <input type="checkbox" id="ativo" name="ativo" checked value="1">
                          </div>
                      </div>
                  </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success waves-effect waves-light">Salvar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<input type="hidden" id="route-informcoes" value="{{ route('informacoes_financeiras', request()->getQueryString()) }}"/>

@stop

@section('js')

  <script src="{{ asset('dashboard/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>

  <script>

  $(".formSubmitAjax").submit(function(e) {

    var self = $(this);
    var url = self.attr('action');
    var modal = self.data('parent-modal');
    var element = self.data('target-element');

    e.preventDefault();

    $.ajax(
      {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: url,
        data: self.serialize(),
        dataType: 'json',
        success: function(data) {

          $(modal).modal('hide');
          var id = data.data.id;
          var nome = data.data.nome;
          self.find(element).append('<option selected value="'+id+'">'+nome+'</option>');

          $(element).append('<option selected value="'+id+'">'+nome+'</option>');

          const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          toast({
            type: data.type,
            title: data.message
          });

        }
      });

  });

  $('.btnLogout').click(function() {

      swal({
        title: 'Finalizar Sessão?',
        text: "Esta sessão será finalizada!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
        if (result.value) {

          document.getElementById('logout-form').submit();

          swal({
            title: 'Até logo!',
            text: 'Sua sessão será finalizada.',
            type: 'success',
            showConfirmButton: false,
          })
        }
      });

    });

  </script>

@stop
