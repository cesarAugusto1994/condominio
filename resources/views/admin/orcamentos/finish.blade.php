@extends('adminlte::page')

@section('title', 'Relatórios')

@section('content_header')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="header-title m-t-0 m-b-20">Orçamentos</h4>
        </div>
    </div>
@stop

@section('content')

<form class="" method="post" action="{{route('orcamentos.store')}}">

  {{csrf_field()}}

<div class="row">
  <div class="col-md-12">
      <div class="card-box">
          <input type="hidden" name="generate" value="1"/>
          <div class="col-md-3" id="sandbox-container2">
            <div class="input-group" id="datepicker">
                <button class="btn btn-custom btn-lg">Salvar</button>
            </div>
          </div>
      </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
      <div class="card-box">

        <div class="table-responsive">
          <table class="table table-hover mails m-0 table table-actions-bar table-lg">
            <thead class="thead-light">
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>Tipo</th>
              <th>Saldo</th>
              <th>Meta Mensal</th>
              @foreach($meses as $mes)
                  <th>{{ $mes->format('F, Y') }}</th>
              @endforeach
            </tr>
            </thead>
            <tbody>
              @foreach($categorias as $categoria)
                <tr>
                  <td>#{{ $categoria->id }}</td>
                  <td>{{ $categoria->nome }}</td>
                  <td>{{ $categoria->grupo->nome }}</td>
                  <td><input type="text" name="saldo-{{$categoria->id}}" class="money form-control saldoInicial" data-input="mes" data-meta="meta-{{$categoria->id}}"/></td>
                  <td class="table-success"><input type="text" name="meta-{{$categoria->id}}" id="meta-{{$categoria->id}}" class="money form-control"/></td>
                  @foreach($meses as $mes)
                      <td class="table-info"><input type="text" name="mes-{{$categoria->id}}-{{ $mes->format('m/Y') }}"  class="money form-control mesTd mes-{{ $mes->format('my') }}"/></td>
                  @endforeach
                </tr>
              @endforeach

            </tbody>
          </table>
        </div>

      </div>
  </div>
</div>

<input type="hidden" id="meses-count" value="{{count($meses)}}"/>
<input type="hidden" name="meses" value="{{$mesesString}}"/>

</form>

@stop

@section('adminlte_js')

  <script src="{{ asset('dashboard/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>

  <script>

      $('.saldoInicial').change(function() {

        var self = $(this);
        var valor = self.val();
        var meses = $("#meses-count").val();
        var mesTd = self.parents('tr').find('.mesTd');
        var meta = self.data('meta');

        valor = parseFloat(valor.replace(".", "").replace(",", "."));

        var resultado = (valor/meses);

        resultado = parseFloat(resultado).toFixed(2).replace(".", ",");

        $('#'+meta).val(resultado);
        mesTd.val(resultado);

      })

  </script>

@stop
