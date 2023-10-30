<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostimgtipo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {         
        Schema::table('post_images', function (Blueprint $table) {
            $table->string('tipo')->default('imagem')->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('post_images', 'tipo'))
        {
            Schema::table('post_images', function (Blueprint $table)
            {
                $table->dropColumn('tipo');
            });
        }
    }
}
