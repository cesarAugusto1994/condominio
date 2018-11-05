@extends('adminlte::page')

@section('title', 'Blocos')

@section('content_header')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="header-title m-t-0 m-b-20">Blocos</h4>
        </div>
    </div>
@stop

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <a href="{{ route('blocos.create') }}" class="btn btn-success">Novo</a>
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

                              @foreach($blocos as $bloco)

                                <tr>
                                  <td>{{ $bloco->nome }}</td>
                                  <td>
                                    <a href="{{ route('blocos.edit', $bloco->id) }}" class="btn btn-icon btn-primary btn-sm"><i class="fa fa-edit"></i> </a>
                                    <button class="btn btn-icon btn-danger btn-sm btnRemoveItem" data-route="{{route('blocos.destroy',$bloco->id)}}"> <i class="fa fa-remove"></i> </button>
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
