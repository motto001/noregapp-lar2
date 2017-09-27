<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDaytypechangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daytypechanges', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('day_id')->unsigned();
            $table->integer('daytype_id')->unsigned();
            $table->integer('pub');
            $table->string('workernote')->nullable();
            $table->string('managernote')->nullable();
            $table->foreign('worker_id')->references('id')->on('workers');
            $table->foreign('daytype_id')->references('id')->on('daytypes');
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
        Schema::drop('daytypechanges');
    }
}
