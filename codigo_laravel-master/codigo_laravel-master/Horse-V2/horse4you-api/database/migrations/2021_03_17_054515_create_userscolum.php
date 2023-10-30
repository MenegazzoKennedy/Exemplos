<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersColum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('users', function (Blueprint $table)
        {
            $table->string('nick')->nullable()->after('email');
            $table->string('descricao')->nullable()->after('nick');
            $table->string('site')->nullable()->after('descricao');
            $table->string('endereco')->nullable()->after('site');
            $table->string('telefone')->nullable()->after('endereco');
            $table->string('genero')->nullable()->after('telefone');
            $table->date('aniversario')->nullable()->after('genero');
            $table->string('avatar')->nullable()->after('aniversario');
            $table->integer('privado')->default('0')->after('avatar');
            $table->integer('status')->default('0')->after('privado');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        if (Schema::hasColumn('users', 'nick', 'descricao', 'site', 'endereco', 'telefone', 'genero', 'aniversario', 'avatar', 'privado', 'status'))
        {
            Schema::table('users', function (Blueprint $table)
            {
                $table->dropColumn('nick');
                $table->dropColumn('descricao');
                $table->dropColumn('site');
                $table->dropColumn('endereco');
                $table->dropColumn('telefone');
                $table->dropColumn('genero');
                $table->dropColumn('aniversario');
                $table->dropColumn('avatar');
                $table->dropColumn('privado');
                $table->dropColumn('status');
            });
        }

    }
}
