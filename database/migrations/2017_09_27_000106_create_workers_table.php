<?php

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
        Schema::create('workers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('workrole_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->integer(''workertype_id')->unsigned();
            $table->integer(''workgroup_id')->unsigned();
            $table->integer('salary');
            $table->string('salary_type');
            $table->string('position');
            $table->string('foto')->nullable();
            $table->string('fullname');
            $table->string('cim');
            $table->string('tel')->nullable();
            $table->date('birth');
            $table->string('ado')->nullable();
            $table->string('tb')->nullable();
            $table->date('start');
            $table->date('end')->nullable();
            $table->integer('pub');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('workrole_id')->references('id')->on('workroles');
            $table->foreign('status')->references('id')->on('statuses');
            $table->foreign('workertype_id')->references('id')->on('workertypes');
            $table->foreign('workergroup_id')->references('id')->on('workergroups');
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
