<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orcamento_mensal', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mes');
            $table->float('saldo', 12,2)->default('0.00');
            $table->float('gasto', 12,2)->default('0.00');
            $table->float('resultado', 12,2)->default('0.00');
            $table->integer('orcamento_id')->unsigned();
            $table->foreign('orcamento_id')->references('id')->on('orcamento_categorias');
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
        Schema::dropIfExists('orcamento_mensal');
    }
}
