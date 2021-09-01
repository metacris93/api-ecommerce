<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            //$table->bigInteger('user_id');
            $table->id();
            $table->float('score');
            $table->morphs('rateable');
            $table->morphs('qualifier');
            $table->index(['rateable_id', 'rateable_type', 'qualifier_id', 'qualifier_type'], 'rates_history_index');
            //$table->unsignedSmallInteger('value');
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
        Schema::table('ratings', function (Blueprint $table)
        {
            $table->dropIndex('rates_history_index');
        });
        Schema::dropIfExists('ratings');
    }
}
