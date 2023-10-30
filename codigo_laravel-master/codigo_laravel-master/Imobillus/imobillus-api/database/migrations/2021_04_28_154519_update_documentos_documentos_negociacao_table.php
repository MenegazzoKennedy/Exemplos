<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDocumentosDocumentosNegociacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos_negociacao', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('documentos_id');
            $table->unsignedBigInteger('negociacao_id');
            $table->foreign('negociacao_id')->references('id')->on('negociacao');
            $table->foreign('documentos_id')->references('id')->on('documentos');
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
        Schema::dropIfExists('documentos_negociacao');
    }
}
