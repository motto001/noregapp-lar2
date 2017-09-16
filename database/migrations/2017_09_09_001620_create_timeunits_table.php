<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimeunitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      /*  time_units: //timeframe is használja
      name, unit(nap,hónap),hosz, óraszám,elszamtip(pernap,permunkanap,perframe)note,
        */
        Schema::create('timeunits', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('unit');//hónap,nap,hét
            $table->integer('hossz')->default(1);//hány unit alkotja az elszámolási egységet
            $table->integer('oraszam')->default(0);//hány órának kellmeglennie
            $table->string('elszamtip');//pernap,permunkanap,perunit
            $table->text('note')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('timeunits');
    }
}
