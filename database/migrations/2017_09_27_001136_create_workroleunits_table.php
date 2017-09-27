<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkroleunitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workroleunits', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('workrole_id')->unsigned();
            $table->integer('timeunit_id')->unsigned();
            $table->integer('worktime_id')->unsigned();
            $table->foreign('workrole_id')->references('id')->on('workroles');
            $table->foreign('timeunit_id')->references('id')->on('timeunits');
            $table->foreign('worktime_id')->references('id')->on('worktimes');
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
        Schema::drop('workroleunits');
    }
}
