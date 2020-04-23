<?php

use App\Migrations\Migration;

class StepsMigration extends Migration
{
    public function up(){
		$this->schema->create('steps', function(Illuminate\Database\Schema\Blueprint $table){
			$table->increments('id');
			$table->string('text');
			$table->string('description');
			$table->integer('parent_id')->unsigned()->nullable();
			$table->integer('key_id')->unsigned()->nullable();
			$table->string('key_text')->nullable();
		});
	}

	public function down(){
		$this->schema->drop('steps');
	}
}
