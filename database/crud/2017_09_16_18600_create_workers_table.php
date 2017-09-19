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
    {
        /* 
        kapcsolatok:user_id, satus_id,workrole_id,unit_id,frameunit_id,(unit_id)frame start,cassa_id(költséghely),workertype_id,
        mezők: őrabér,havibér,beosztás, (személyes adatok)
       */
            Schema::create('workers', function(Blueprint $table) {
            // $table->engine = 'InnoDB';     
            $table->softDeletes();
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users') ; //->onDelete('cascade')->onUpdate('cascade');
            $table->integer('workrole_id')->unsigned(); //elszamalasi egység:napi,heti,havi,idokeret
            $table->foreign('workrole_id')->references('id')->on('workroles');   
            $table->integer('unit_id')->unsigned(); //elszamalasi egység:napi,heti,havi
            $table->foreign('unit_id')->references('id')->on('timeunits');
            $table->integer('frame_id')->unsigned()->nullable(); //idokeret ()
            $table->foreign('frame_id')->references('id')->on('timeunits');
            $table->date('framestart')->nullable(); 
            $table->integer('status_id')->unsigned(); //alkalmi ,diák, stb
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->integer('worker_type_id')->unsigned()->nullable(); //fizikai szeelemi
        //$table-foreign('worker_type_id')->references('id')->on('worker_types');
        $table->integer('salary');
        $table->string('position')->nullable();
            $table->string('foto')->nullable();
            $table->string('fullname');
            $table->string('cim');
            $table->string('tel')->nullable();
            $table->date('birth');
            $table->string('ado')->nullable();
            $table->string('tb')->nullable();
            $table->date('start');
            $table->date('end')->nullable();  
                  
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
