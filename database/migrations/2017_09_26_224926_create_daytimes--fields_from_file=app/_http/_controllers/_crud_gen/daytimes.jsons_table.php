<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDaytimes--fieldsFromFile=app/Http/Controllers/CrudGen/daytimes.jsonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daytimes--fields_from_file=app/_http/_controllers/_crud_gen/daytimes.jsons', function(Blueprint $table) {
            $table->increments('id');
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
        Schema::drop('daytimes--fields_from_file=app/_http/_controllers/_crud_gen/daytimes.jsons');
    }
}
