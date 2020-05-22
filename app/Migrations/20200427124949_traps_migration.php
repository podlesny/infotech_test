<?php

use \App\Migrations\Migration;

class TrapsMigration extends Migration
{
    public function up(){
        $this->schema->create('traps', function(Illuminate\Database\Schema\Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('fail_text');
            $table->integer('step_id')->unsigned();
            $table->foreign('step_id')->references('id')->on('steps');
        });
    }

    public function down(){
        $this->schema->drop('traps');
    }
}
