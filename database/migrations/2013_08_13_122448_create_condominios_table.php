<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCondominiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condominios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('endereco')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->string('cep')->nullable();
            $table->boolean('ativo')->default(true);
            $table->uuid('uuid');
            $table->timestamps();
        });

        Schema::create('apartamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('referencia');
            $table->integer('condominio_id')->unsigned();
            $table->foreign('condominio_id')->references('id')->on('condominios');
            $table->boolean('ativo')->default(true);
            $table->uuid('uuid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartamentos');
        Schema::dropIfExists('condominios');
    }
}
