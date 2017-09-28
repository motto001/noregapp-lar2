<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWroleunitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wroleunits', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('wrole_id')->unsigned();
            $table->time('start');
            $table->time('end');
            $table->integer('hour');
            $table->string('note');
            $table->integer('pub');
            $table->foreign('wrole_id')->references('id')->on('wroles');
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
        Schema::drop('wroleunits');
    }
}
