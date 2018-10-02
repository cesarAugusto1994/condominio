@extends('layouts.create')

@section('title', 'Contatos')

@section('content_header')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="header-title m-t-0 m-b-20">Painel de Contatos</h4>
        </div>
    </div>
@stop

@section('content_box')

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">

            <h6 class="m-t-0">Novo Contato</h6>

            <form role="form" action="{{ route('contatos.store') }}" method="post">

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

                <div class="col-md-12">
                    <button class="btn btn-success" type="submit">Salvar</button>
                </div>

            </div>

            </form>

        </div>
    </div>
</div>

@stop
