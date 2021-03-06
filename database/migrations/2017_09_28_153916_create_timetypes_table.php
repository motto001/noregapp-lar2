<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimetypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetypes', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('szorzo',4,2)->default(1)->nullable();
            $table->integer('fixplusz')->default(0)->nullable();
            $table->string('color')->nullable();
            $table->string('note')->nullable();
           // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('timetypes');
    }
}
