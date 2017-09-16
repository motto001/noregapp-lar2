<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /*
        worker_id(nemkötelezö),datum,type_id
        */
        Schema::create('days', function(Blueprint $table) {
           // $table->engine = 'InnoDB';
           $table->increments('id');
            $table->integer('worker_id')->unsigned()->nullable();
            $table->foreign('worker_id')->references('id')->on('workers');
            $table->integer('type_id');
            $table->foreign('type_id')->references('id')->on('day_types');
            $table->date('datum');
            $table->unique(['worker_id', 'datum']);
            $table->integer('pub')->default(0); 
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('days');
    }
}
