<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserGeolocalicaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) { 
            $table->float('latitude', 10, 5)->nullable();   
            $table->float('longitude', 10, 5)->nullable();   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users','latitude') && Schema::hasColumn('users','longitude'))
        {
            Schema::table('users', function (Blueprint $table) { 
                $table->dropColumn('latitude');   
                $table->dropColumn('longitude');   
            });
        }
    }
}
