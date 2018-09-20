@extends('adminlte::page')

@section('title', 'Contas')

@section('content_header')
    <h1>Painel de Contas</h1>
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

      $resultado = $limite - $restante;

      if($restante || $limite) {
        $gasto = number_format(($resultado/$limite) * 100, 2);
      }


  @endphp

    <div class="col-md-3">
      <!-- Widget: user widget style 1 -->
      <div class="box box-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header {{ $card }}">
          <h3 class="widget-user-username">{{ $conta->tipo->nome }} </h3>
          <h5 class="widget-user-desc">{{ $conta->banco ? $conta->banco->nome : '' }}</h5>
        </div>
        <div class="box-footer">
          <div class="row">
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header">{{ $limiteFormatado }}</h5>
                <span class="description-text">Limite</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header">{{ $restanteFormatado }}</h5>
                <span class="description-text">Saldo</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4">
              <div class="description-block">
                <h5 class="description-header">{{ $gasto }}%</h5>
                <span class="description-text">Percentual</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.widget-user -->
    </div>

    <div class="col-md-5">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class=""><a href="#tab_1" data-toggle="tab" aria-expanded="false">Despesas</a></li>
          <li class="active"><a href="#tab_2" data-toggle="tab" aria-expanded="true">Receitas</a></li>

          <div class="modal modal-danger fade " id="modalDespesas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="exampleModalLabel">Nova Despesa</h4>
                </div>
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
                              <option value="1">1</option>
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
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="descricao" class="control-label">Anexar documento:</label>
                          <input type="file" class="form-control" id="descricao" name="descricao">
                        </div>
                      </div>
                    </div>

                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Send message</button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal modal-success fade " id="modalReceitas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="exampleModalLabel">Nova Receita</h4>
                </div>
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
                              <option value="1">1</option>
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
                      <div class="col-md-3">
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
                  <button type="button" class="btn btn-success">Salvar</button>
                </div>
              </div>
            </div>
          </div>

        </ul>
        <div class="tab-content">
          <div class="tab-pane" id="tab_1">

            <div class="row">

              <div class="col-md-12">

                <button type="button" class="btn btn-danger btn-sm pull-right btnOpenModaDespesas"><i class="fa fa-plus"></i> Nova Despesa</a></button>

              </div>

              <hr/>

              <div class="col-md-12">

                <div class="table-responsive">
                  <table class="table no-margin table-striped table-bordered">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Tipo</th>
                      <th>Valor</th>
                      <th>Status</th>
                      <th>Opções</th>
                    </tr>
                    </thead>
                    <tbody>

                      @foreach($conta->movimentos as $movimento)
                        <tr>
                          <td><a href="#">#{{ $movimento->id }}</a></td>
                          <td>{{ $movimento->tipo->nome }}</td>
                          <td>{{ number_format($movimento->valor, 2, ',', '.') }}</td>
                          <td>
                            @if($movimento->status == 'Pendente')
                            <span class="label label-default">{{ $movimento->status }}</span>
                            @elseif($movimento->status == 'Pago')
                            <span class="label label-success">{{ $movimento->status }}</span>
                            @elseif($movimento->status == 'Cancelado')
                            <span class="label label-danger">{{ $movimento->status }}</span>
                            @endif
                          </td>
                          <td>
                            <div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
                          </td>
                        </tr>
                      @endforeach

                    </tbody>
                  </table>
                </div>

              </div>

            </div>

          </div>
          <div class="tab-pane active" id="tab_2">

            <div class="row">

                <div class="col-md-12">

                  <button type="button" class="btn btn-success btn-sm pull-right btnOpenModaReceitas"><i class="fa fa-plus"></i> Nova Receita</a></button>

                </div>

                <hr/>

                <div class="col-md-12">

                  <div class="table-responsive">
                  <table class="table no-margin table-striped table-bordered">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Tipo</th>
                      <th>Valor</th>
                      <th>Status</th>
                      <th>Opções</th>
                    </tr>
                    </thead>
                    <tbody>

                      @foreach($conta->movimentos as $movimento)
                        <tr>
                          <td><a href="#">#{{ $movimento->id }}</a></td>
                          <td>{{ $movimento->tipo->nome }}</td>
                          <td>{{ number_format($movimento->valor, 2, ',', '.') }}</td>
                          <td>
                            @if($movimento->status == 'Pendente')
                            <span class="label label-default">{{ $movimento->status }}</span>
                            @elseif($movimento->status == 'Pago')
                            <span class="label label-success">{{ $movimento->status }}</span>
                            @elseif($movimento->status == 'Cancelado')
                            <span class="label label-danger">{{ $movimento->status }}</span>
                            @endif
                          </td>
                          <td>
                            <div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
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

    <div class="col-md-4">

      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Calendário</h3>
        </div>
        <div class="box-body">

            <div class="calendar"></div>

        </div>
      </div>

    </div>

</div>



@stop

@section('adminlte_js')

  <script>

      let $calendar = $('.calendar');

      $calendar.fullCalendar({

        iews: {
          listDay: {
            buttonText: 'list day',
            titleFormat: "dddd, DD MMMM YYYY",
            columnFormat: "",
            timeFormat: "HH:mm"
          },

          listWeek: {
            buttonText: 'list week',
            columnFormat: "ddd D",
            timeFormat: "HH:mm"
          },

          listMonth: {
            buttonText: 'list month',
            titleFormat: "MMMM YYYY",
            timeFormat: "HH:mm"
          },

          month: {
            buttonText: 'month',
            titleFormat: 'MMMM YYYY',
            columnFormat: "ddd",
            timeFormat: "HH:mm"
          },

          agendaWeek: {
            buttonText: 'agendaWeek',
            columnFormat: "ddd D",
            timeFormat: "HH:mm"
          },

          agendaDay: {
            buttonText: 'agendaDay',
            titleFormat: 'dddd, DD MMMM YYYY',
            columnFormat: "",
            timeFormat: "HH:mm"
          },
        },
        lang: 'pt-br',
        defaultView: 'month',
        eventBorderColor: "#de1f1f",
        eventColor: "#AC1E23",
        slotLabelFormat: 'HH:mm',
        eventLimitText: 'consultas',
        minTime: '06:00:00',
        maxTime: '22:00:00',
        header: {
            left: 'prev,next,today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },

        navLinks: true,
        selectable: true,
        selectHelper: true,

      });

  </script>

  <script>
      $( '.btnOpenModaDespesas' ).click( function() {
        $( '#modalDespesas' ).modal();
      });
      $( '.btnOpenModaReceitas' ).click( function() {
        $( '#modalReceitas' ).modal();
      });
  </script>

@stop
