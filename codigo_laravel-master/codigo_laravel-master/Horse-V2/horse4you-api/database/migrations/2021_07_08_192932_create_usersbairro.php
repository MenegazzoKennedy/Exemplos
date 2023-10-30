<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersbairro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {         
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('estado_id')->unsigned()->index()->nullable()->after('site');
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete("NO ACTION");

            $table->unsignedBigInteger('cidade_id')->unsigned()->index()->nullable()->after('estado_id');
            $table->foreign('cidade_id')->references('id')->on('cidades')->onDelete("NO ACTION");

            $table->unsignedBigInteger('bairro_id')->unsigned()->index()->nullable()->after('cidade_id');
            $table->foreign('bairro_id')->references('id')->on('bairros')->onDelete("NO ACTION");

            $table->integer('numero')->nullable()->after('endereco');
            $table->string('cep')->nullable()->after('numero');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'estado_id', 'cidade_id', 'bairro_id'))
        {
            Schema::table('users', function (Blueprint $table)
            {
                $table->dropForeign(['estado_id']);
                $table->dropColumn('estado_id');
                $table->dropForeign(['cidade_id']);
                $table->dropColumn('cidade_id');
                $table->dropForeign(['bairro_id']);
                $table->dropColumn('bairro_id');
                $table->dropColumn('numero');
                $table->dropColumn('cep');
            });
        }
    }
}
