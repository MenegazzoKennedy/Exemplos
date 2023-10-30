<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatustag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {         
        Schema::table('tags', function (Blueprint $table) {
            $table->integer('status')->default(1)->after('tag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('tags', 'status'))
        {
            Schema::table('tags', function (Blueprint $table)
            {
                $table->dropColumn('status');
            });
        }
    }
}
