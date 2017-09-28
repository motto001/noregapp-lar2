<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workertimes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('day_id')->unsigned();
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
        Schema::drop('workertimes');
    }
}
