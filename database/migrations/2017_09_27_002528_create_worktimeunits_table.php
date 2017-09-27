<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorktimeunitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worktimeunits', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('worktimetype_id')->unsigned();
            $table->time('start');
            $table->time('end');
            $table->integer('hour');
            $table->string('note');
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
        Schema::drop('worktimeunits');
    }
}
