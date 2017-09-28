<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWroletimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wroletimes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('wroleunit_id')->unsigned();
            $table->integer('timetype_id')->unsigned();
            $table->time('start');
            $table->time('end')->nullable();
            $table->integer('hour');
            $table->string('managernote')->nullable();
            $table->string('workernote')->nullable();
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
        Schema::drop('wroletimes');
    }
}
