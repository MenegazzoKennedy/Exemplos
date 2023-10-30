<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('corretor_id_preferido')->nullable();
            $table->string('cpf')->nullable();
            $table->date('nascimento')->nullable();
            $table->integer('genero')->nullable();
            $table->string('senha')->nullable();
            $table->string('url_foto')->nullable();
            $table->string('telefone')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('corretor_genero')->nullable();
            $table->string('termos_servico')->nullable();
            $table->foreign('corretor_id_preferido')->references('id')->on('corretores');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('clientes');
    }
}
