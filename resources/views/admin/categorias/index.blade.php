@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="header-title m-t-0 m-b-20">Painel de Categorias</h4>
        </div>
    </div>
@stop

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <a href="{{ route('categorias.create') }}" class="btn btn-success">Novo</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">

            <div class="row">
                <div class="col-md-12">
                  <div class="box box-default">
                    <div class="box-header with-border">
                      <h3 class="box-title"></h3>
                    </div>
                    <div class="box-body">

                      <div class="row">

                        <div class="table-responsive">
                          <table class="table table-hover mails m-0 table table-actions-bar">
                            <thead>
                            <tr>
                              <th>Nome</th>
                              <th style="width:150px">#</th>
                            </tr>
                            </thead>
                            <tbody>

                              @foreach($categorias as $categoria)

                                <tr>
                                  <td>{{ $categoria->nome }}</td>
                                  <td>
                                    @if(!empty($categoria->condominio_id))
                                    <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-icon btn-primary btn-sm"><i class="fa fa-edit"></i> </a>
                                    <button class="btn btn-icon btn-danger btn-sm btnRemoveItem" data-route="{{route('categorias.destroy',$categoria->id)}}"> <i class="fa fa-remove"></i> </button>
                                    @endif
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
</div>


@stop
