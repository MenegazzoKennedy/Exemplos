<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBairroCorretorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bairro_corretor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('corretor_id');
            $table->unsignedBigInteger('bairro_id');
            $table->foreign('corretor_id')->references('id')->on('corretores');
            $table->foreign('bairro_id')->references('id')->on('bairros');
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
        Schema::dropIfExists('bairro_corretor');
    }
}
