<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreferidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id_user');
            $table->unsignedBigInteger('produto_id');
            $table->foreign('cliente_id_user')->references('id')->on('users');
            $table->foreign('produto_id')->references('id')->on('produtos');
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
        Schema::dropIfExists('preferidos');
    }
}
