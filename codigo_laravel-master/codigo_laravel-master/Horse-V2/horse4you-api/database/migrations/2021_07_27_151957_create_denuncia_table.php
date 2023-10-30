<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenunciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denuncia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user_denunciante');
            $table->unsignedBigInteger('id_user_denunciado')->nullable();  
            $table->unsignedBigInteger('id_post')->nullable();        
            $table->unsignedBigInteger('id_comentario')->nullable();        
            $table->unsignedBigInteger('categoria')->nullable();
            $table->string('denuncia');   
            $table->string('descricao_categoria')->nullable();   
            $table->integer('status')->default(0);   
            $table->foreign('id_user_denunciante')->references('id')->on('users');
            $table->foreign('id_user_denunciado')->references('id')->on('users');
            $table->foreign('id_post')->references('id')->on('posts');            
            $table->foreign('id_comentario')->references('id')->on('comments');            
            $table->foreign('categoria')->references('id')->on('denuncia_tipo');            
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
        Schema::dropIfExists('denuncia');
    }
}
