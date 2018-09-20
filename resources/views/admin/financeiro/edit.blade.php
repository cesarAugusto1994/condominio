@extends('adminlte::page')

@section('title', 'Contas')

@section('content_header')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="header-title m-t-0 m-b-20">Editar Movimentação #{{ $movimento->id }}</h4>
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

        <form method="post" action="{{ route('movimentos.update',$movimento->id) }}" enctype="multipart/form-data">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              <input type="hidden" name="movimento_tipo_id" value="{{ $movimento->movimento_tipo_id }}"/>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Descrição:</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" value="{{ $movimento->descricao }}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Conta:</label>
                    <select class="form-control Select2 select2"  style="width: 100%" name="conta_id">
                      @foreach($contas as $conta)
                        <option value="{{$conta->id}}" {{ $movimento->conta_id == $conta->id ? 'selected' : '' }}>{{ $conta->tipo->nome }} - {{ $conta->banco ? $conta->banco->nome : '' }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Recebido de:</label>
                    <select class="form-control Select2 select2"  style="width: 100%" name="contato_id">
                      @foreach($contatos as $contato)
                        <option value="{{$contato->id}}">{{ $contato->nome }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Valor:</label>
                    <input type="text" class="form-control money" id="valor" required name="valor" value="{{ number_Format($movimento->valor,2) }}">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Data:</label>
                    <input type="text" class="form-control date" id="data" name="data" required value="{{ $movimento->data_pagamento->format('d/m/Y') }}">
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descricao" class="control-label">Categoria:</label>

                    <select class="form-control Select2 select2"  style="width: 100%" name="categoria_id">
                      <option value="">Selecione</option>
                      @foreach($categorias as $categoria)
                        <option value="{{$categoria->id}}" {{ $movimento->categoria_id == $categoria->id ? 'selected' : '' }}>{{ $categoria->nome }}</option>
                      @endforeach
                    </select>

                  </div>
                </div>
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
                    <label for="descricao" class="control-label">Pago:</label>
                    <select class="form-control Select2 select2" style="width: 100%" name="pago">
                        <option value="0" {{ $movimento->pago == 0 ? 'selected' : '' }}>Não</option>
                        <option value="1" {{ $movimento->pago == 1 ? 'selected' : '' }}>Sim</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
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

              <div class="form-group  m-b-0">

                <button type="submit" class="btn btn-success">Salvar</button>
                <button type="button" class="btn btn-default">Cancelar</button>

              </div>



        </form>

      </div>
    </div>
  </div>

</div>

@stop

@section('adminlte_js')

  <script src="{{ asset('dashboard/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>

  <script>
      $( '.btnOpenModaDespesas' ).click( function() {
        $( '#modalDespesas' ).modal();
      });
      $( '.btnOpenModaReceitas' ).click( function() {
        $( '#modalReceitas' ).modal();
      });

      $('#sandbox-container .input-daterange').datepicker({
          format: "dd/mm/yyyy",
          todayBtn: "linked",
          language: "pt-BR",
          todayHighlight: true
      });

      $('.date').datepicker({
          format: "dd/mm/yyyy",
          language: "pt-BR",
          todayBtn: "linked",
          calendarWeeks: true,
          autoclose: true,
          todayHighlight: true,
      });

      $('.pago_checkbox').change(function(){
        var self = $(this);

        $.ajax({
          headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
          url: self.data('route'),
          type: 'POST',
          dataType: 'json',

        }).done(function(data) {

          const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          if(data.code==404) {
            toast({
              type: 'warning',
              title: data.message
            })
          }else {
            toast({
              type: 'success',
              title: data.message
            })
          }

        });

      });

  </script>

@stop
