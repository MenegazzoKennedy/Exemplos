<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documentos', function (Blueprint $table) {

            $table->unsignedBigInteger('negociacao_id')->unsigned()->index()->nullable()->after('id');
            $table->foreign('negociacao_id')->references('id')->on('negociacao')->onDelete("NO ACTION");

            $table->string('tipo')->nullable()->after('descricao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('documentos', 'tipo', 'negociacao_id'))
        {
            Schema::table('documentos', function (Blueprint $table)
            {
                $table->dropForeign(['negociacao_id']);
                $table->dropColumn('negociacao_id');
                $table->dropColumn('tipo');
            });
        }
        
    }
}
