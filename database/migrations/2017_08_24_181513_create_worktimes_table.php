<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorktimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        id,name(alap,túlóra,túlóra éjszakai,ledolg,csúsztatás),
        szorzó(elszámoláshoz),fixplus,color,note 
        */
        Schema::create('worktimes', function(Blueprint $table) {
           // $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('day_id')->unsigned();
            $table->foreign('day_id')->references('id')->on('days');
            $table->integer('type_id');//worktime type
            $table->foreign('type_id')->references('id')->on('types');

            $table->time('start');
            $table->time('end');
            $table->decimal('hour', 3, 1);
            
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
        Schema::drop('worktimes');
    }
}
