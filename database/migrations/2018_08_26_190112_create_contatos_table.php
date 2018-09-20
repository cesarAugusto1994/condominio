<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contatos', function (Blueprint $table) {
          $table->increments('id');

          $table->string('nome');

          $table->enum('tipo_pessoa', ['Pessoa Jurídica', 'Pessoa Física'])->default('Pessoa Física');
          $table->enum('categoria', ['Cliente', 'Fornecedor', 'Funcionário'])->default('Cliente');

          $table->integer('condominio_id')->unsigned();
          $table->foreign('condominio_id')->references('id')->on('condominios');

          $table->string('cpf_cnpj')->nullable();
          $table->string('email')->nullable();

          $table->string('telefone')->nullable();
          $table->string('celular')->nullable();

          $table->string('endereco')->nullable();
          $table->string('numero')->nullable();
          $table->string('complemento')->nullable();
          $table->string('bairro')->nullable();
          $table->string('cep')->nullable();
          $table->string('estado')->nullable();
          $table->string('cidade')->nullable();
          $table->string('aniversario')->nullable();
          $table->text('descricao')->nullable();

          $table->boolean('ativo')->default(true);
          $table->uuid('uuid');
          $table->timestamps();
          $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contatos');
    }
}
