<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bancos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('conta_tipos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('contas', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('banco_id')->nullable();
            $table->bigInteger('numero')->nullable();
            $table->integer('agencia')->nullable();
            $table->integer('conta')->nullable();

            $table->float('limite', 12,2)->nullable();

            $table->integer('conta_tipo_id')->unsigned();
            $table->foreign('conta_tipo_id')->references('id')->on('conta_tipos');

            $table->integer('condominio_id')->unsigned();
            $table->foreign('condominio_id')->references('id')->on('condominios');

            $table->boolean('ativo')->default(true);

            $table->uuid('uuid');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('movimento_tipos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('conta_movimentos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('descricao')->nullable();

            $table->integer('contato_id')->nullable();

            $table->integer('conta_id')->unsigned();
            $table->foreign('conta_id')->references('id')->on('contas');

            $table->integer('movimento_tipo_id')->unsigned();
            $table->foreign('movimento_tipo_id')->references('id')->on('movimento_tipos');

            $table->integer('condominio_id')->unsigned();
            $table->foreign('condominio_id')->references('id')->on('condominios');

            $table->integer('categoria_id')->nullable();

            $table->date('data_vencimento')->nullable();
            $table->date('data_pagamento')->nullable();

            $table->float('valor', 12,2)->default(0.00);

            $table->boolean('pago')->default(false);

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
        Schema::dropIfExists('contas');
        Schema::dropIfExists('conta_tipos');
        Schema::dropIfExists('bancos');
    }
}
