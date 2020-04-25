<?php

use \App\Migrations\Migration;

class RequiredObjectMigration extends Migration
{
	public function up(){
		$this->schema->create('required_objects', function(Illuminate\Database\Schema\Blueprint $table){
			$table->increments('id');
			$table->string('pass_text')->nullable();
			$table->string('fail_text');
			$table->string('exists_text')->nullable();
			$table->boolean('death')->default(false);
			$table->boolean('random')->default(false);
			$table->integer('action_id')->unsigned();
			$table->integer('required_step_id')->unsigned();
			$table->integer('redirect_step_id')->unsigned();
		});
	}

	public function down(){
		$this->schema->drop('required_objects');
	}
}
