<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorktimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worktimes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('worker_id');
            $table->string('year');
            $table->integer('mounth');
            $table->integer('day');
            $table->integer('hour');
            $table->string('type');
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
        Schema::drop('worktimes');
    }
}
