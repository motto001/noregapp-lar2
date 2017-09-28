<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkerdaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workerdays', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('worker_id')->unsigned();
            $table->integer('daytype_id')->unsigned();
            $table->date('datum');
            $table->string('managernote')->nullable();
            $table->string('usernote')->nullable();
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
        Schema::drop('workerdays');
    }
}
