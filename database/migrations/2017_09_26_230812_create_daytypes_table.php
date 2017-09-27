<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDaytypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daytypes', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('szorzo')->nullable();
            $table->integer('fixplusz')->nullable();
            $table->string('color')->nullable();
            $table->string('note')->nullable();
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
        Schema::drop('daytypes');
    }
}