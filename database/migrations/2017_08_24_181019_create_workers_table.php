<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { //kapcsolatok:user_id, satus_id,workrole_id,timeframe_id,cassa_id(költséghely),workertype_id,
       // mezők: őrabér,havibér,timframe_start,(személyes adatok)
       
            Schema::create('workers', function(Blueprint $table) {
            // $table->engine = 'InnoDB';     
            $table->softDeletes();
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users') ; //->onDelete('cascade')->onUpdate('cascade');
            $table->integer('timeunit_id')->unsigned(); //elszamalasi egység:napi,heti,havi,idokeret
            $table->foreign('timeunit_id')->references('id')->on('timeunits');
            $table->integer('status_id')->unsigned(); //alkalmi ,diák, stb
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->integer('workertype_id')->unsigned(); //fizikai szeelemi
       // $table-foreign('workertype_id')->references('id')->on('workertypes');
            $table->string('foto');
            $table->string('fullname');
            $table->string('cim');
            $table->string('tel')->nullable();
            $table->date('birth');
            $table->string('ado')->nullable();
            $table->string('tb')->nullable();
            $table->date('start');
            $table->date('end')->nullable();
            $table->date('timeframestart')->nullable(); //idökeret kezdete 
            
            $table->decimal('hour', 3, 1)->nullable();
            
            $table->string('position')->nullable(); 
            
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
        Schema::drop('workers');
    }
}
