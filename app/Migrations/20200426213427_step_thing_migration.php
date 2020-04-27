<?php

use \App\Migrations\Migration;

class StepThingMigration extends Migration
{
	public function up(){
		$this->schema->create('step_thing', function(Illuminate\Database\Schema\Blueprint $table){
			$table->integer('step_id')->unsigned();
			$table->integer('thing_id')->unsigned();
			$table->string('pass_text')->nullable();
			$table->string('fail_text');
			$table->boolean('death')->default(false);
			$table->integer('redirect_step_id')->unsigned()->nullable();
		});
	}

	public function down(){
		$this->schema->drop('step_thing');
	}
}
