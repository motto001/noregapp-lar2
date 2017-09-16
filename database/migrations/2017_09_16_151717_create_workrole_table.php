<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkroleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

       // munkarend pl:id:1  name:kétmúszak, unit:hét unitlong:1 (hány unit egy ciklus)
        Schema::create('workroles', function(Blueprint $table) {
            // $table->engine = 'InnoDB';
             $table->increments('id');
             $table->string('name');
             $table->string('unit')->default('week');//hónap,nap/hét
             $table->integer('unit_long')->default(1);//hány unitonként ismétlődik a workrole
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
        //
    }
}
