<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkroleCyclTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        a workrole munkarendjei. pl.: workrole_id:1,ciklus_num:1, start:06.00 end 14.30 hour:8,type_id:1
                              workrole_id:1,ciklus_num:2, start:14.00 end 16.30 hour:2,type_id:5
                              workrole_id:1,ciklus_num:2, start:77.00 end 22.30 hour:8,type_id:3
        */
        Schema::create('workrole_cycl', function(Blueprint $table) {
            // $table->engine = 'InnoDB';
             $table->increments('id');
             $table->integer('workrole_id')->unsigned();
             $table->foreign('workrole_id')->references('id')->on('workroles');
             $table->integer('worktime_type_id');
             $table->foreign('worktime_type_id')->references('id')->on('worktime_types');
             $table->time('start');
             $table->time('endt');
             $table->decimal('hour', 3, 1);
            // $table->decimal('szorzo', 4, 2)->default(1);
            // $table->integer('fixplusz')->nullable();
             $table->integer('pub')->default(0); 
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
        //
    }
}
