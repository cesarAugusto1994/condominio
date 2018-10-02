@extends('adminlte::page')

@section('title', 'Grupos')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
          <a href="{{ route('contatos.create') }}" class="btn btn-success">Novo</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <h6 class="m-t-0">Lista</h6>
            <div class="table-responsive">
              <table class="table table-hover mails m-0 table table-actions-bar">
                  <thead>
                  <tr>
                      <th>Nome</th>
                      <th>Tipo</th>
                      <th>Categoria</th>
                      <th style="width:150px">#</th>
                  </tr>
                  </thead>

                  <tbody>
                    @forelse($contatos as $contato)
                      <tr>
                        <td>{{ $contato->nome }}</td>
                        <td>{{ $contato->tipo_pessoa }}</td>
                        <td>{{ $contato->categoria }}</td>

                        <td>
                          <a class="btn btn-primary btn-sm" href="{{ route('contatos.edit', $contato->id) }}"><i class="fa fa-edit"></i></a>
                          <a class="btn btn-danger btn-sm btnRemoveItem" data-route="{{ route('contatos.destroy', $contato->id) }}"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="11" class="text-center">Nenhum valor cadastrardo até o momento!</td>
                      </tr>
                    @endforelse

                    {{ $contatos->links() }}

                  </tbody>
              </table>
            </div>
        </div>
    </div>
</div>

@endsection
