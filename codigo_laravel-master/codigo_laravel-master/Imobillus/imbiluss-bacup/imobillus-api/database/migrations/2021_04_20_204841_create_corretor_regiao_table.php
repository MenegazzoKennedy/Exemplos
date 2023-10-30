<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorretorRegiaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corretor_regiao', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('corretor_id');
            $table->unsignedBigInteger('regiao_id');
            $table->foreign('corretor_id')->references('id')->on('corretores');
            $table->foreign('regiao_id')->references('id')->on('regioes');
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
        Schema::dropIfExists('corretor_regiao');
    }
}
