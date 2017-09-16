<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDayChTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_ch', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('worker_id')->unsigned();
            $table->foreign('worker_id')->references('id')->on('workers');
            $table->integer('day_id')->unsigned();
            $table->foreign('day_id')->references('id')->on('day_types');
            $table->date('datum');
            $table->integer('pub')->default(1);
            $table->string('workernote')->nullable();
            $table->string('mangernote')->nullable();
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
        Schema::drop('day_ch');
    }
}
