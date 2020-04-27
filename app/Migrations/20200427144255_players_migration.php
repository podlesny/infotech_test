<?php

use \App\Migrations\Migration;

class PlayersMigration extends Migration
{
	public function up(){
		$this->schema->create('players', function(Illuminate\Database\Schema\Blueprint $table){
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
		});
	}

	public function down(){
		$this->schema->drop('history_items');
	}
}
