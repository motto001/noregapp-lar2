<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorktimetypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worktimetypes', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('szorzo');
            $table->integer('fixplusz');
            $table->string('color');
            $table->string('note');
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
        Schema::drop('worktimetypes');
    }
}
