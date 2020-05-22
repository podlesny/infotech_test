<?php

use \App\Migrations\Migration;

class ThingsMigration extends Migration
{
    public function up(){
        $this->schema->create('things', function(Illuminate\Database\Schema\Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('exists_text')->nullable();
            $table->integer('found_step_id')->unsigned();
            $table->foreign('found_step_id')->references('id')->on('steps');
        });
    }

    public function down(){
        $this->schema->drop('things');
    }
}
