<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimeframesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeframes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('timeunit_id')->unsigned();
            $table->string('name');
            $table->date('start');
            $table->integer('hourmax')->nullable();
            $table->integer('hourmin')->nullable();
            $table->string('note')->nullable();
            $table->integer('pub');
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
        Schema::drop('timeframes');
    }
}
