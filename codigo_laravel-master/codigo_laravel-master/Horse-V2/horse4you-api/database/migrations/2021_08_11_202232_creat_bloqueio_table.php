<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatBloqueioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bloqueios', function (Blueprint $table) {
            $table->unsignedBigInteger('user_bloqueante');
            $table->foreign('user_bloqueante')->references('id')->on('users');
            $table->unsignedBigInteger('user_bloqueado');
            $table->foreign('user_bloqueado')->references('id')->on('users');
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
        Schema::dropIfExists('bloqueios');
    }
}
