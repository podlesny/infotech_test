<?php

use \App\Migrations\Migration;

class ActionsMigration extends Migration
{
    public function up(){
        $this->schema->create('actions', function(Illuminate\Database\Schema\Blueprint $table){
            $table->increments('id');
            $table->string('text');
            $table->integer('prev_id')->unsigned()->nullable();
            $table->integer('next_id')->unsigned()->nullable();
            $table->foreign('prev_id')->references('id')->on('steps');
            $table->foreign('next_id')->references('id')->on('steps');
        });
    }

    public function down(){
        $this->schema->drop('actions');
    }
}
