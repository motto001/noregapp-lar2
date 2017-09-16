<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDayTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        /*
        napok tipusának beállítása (szabadság ,ünnepnap,stb)
        id,name,szorzo,fixplusz,color,note
        */

        Schema::create('day_types', function(Blueprint $table) {
        // $table->engine = 'InnoDB';id,name,szorzo,fixplusz,color,note
        $table->increments('id');
      
         $table->string('name');
         $table->decimal('szorzo', 4, 2)->default(1);
         $table->integer('fixplusz')->nullable();
         $table->string('color')->nullable();
         $table->string('note')->nullable();
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
