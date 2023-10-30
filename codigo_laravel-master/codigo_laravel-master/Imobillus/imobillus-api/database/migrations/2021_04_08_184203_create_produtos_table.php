<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('logradouro')->nullable();
            $table->string('numero')->nullable();
            $table->string('descricao')->nullable();
            $table->string('valor')->nullable();
            $table->string('slug')->nullable();
            $table->string('bairro')->nullable();
            $table->boolean('destaque')->nullable();
            $table->integer('tipo')->nullable();
            $table->integer('fonte')->nullable();
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
        Schema::dropIfExists('produtos');
    }
}
