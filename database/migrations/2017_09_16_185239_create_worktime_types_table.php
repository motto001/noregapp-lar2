<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorktimeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        worktime_type
id,name(alap,túlóra,túlóra éjszakai,ledolg,csúsztatás),
szorzó(elszámoláshoz),fixplus,color,note 
        */

        Schema::create('worktime_types', function(Blueprint $table) {
            // $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');//worktime type
            $table->integer('fixplusz')->default(1); 
            $table->decimal('szorzo', 4, 2)->default(1);  
            $table->integer('pub')->default(0); 
            $table->string('note');
            $table->string('color');//worktime type
         }); //
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
