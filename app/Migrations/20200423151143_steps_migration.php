<?php

use App\Migrations\Migration;

class StepsMigration extends Migration
{
    public function up(){
		$this->schema->create('steps', function(Illuminate\Database\Schema\Blueprint $table){
			$table->increments('id');
			$table->string('text');
		});
	}

	public function down(){
		$this->schema->drop('steps');
	}
}
