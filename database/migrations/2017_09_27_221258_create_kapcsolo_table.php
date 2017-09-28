<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKapcsoloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('workroleunit_daytype', function(Blueprint $table) {
          
            $table->integer('work
            roleunit_id')->unsigned();
            $table->integer('daytype_id')->unsigned();
       
        });  
         Schema::create('worker_timeframe', function(Blueprint $table) {
            
              $table->integer('timeframe_id')->unsigned();
              $table->integer('worker_id')->unsigned();
         
          });
          
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
