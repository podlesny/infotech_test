<?php

use \App\Migrations\Migration;

class HistoryItemsMigration extends Migration
{
	public function up(){
		$this->schema->create('history_items', function(Illuminate\Database\Schema\Blueprint $table){
			$table->increments('id');
			$table->integer('player_id')->unsigned();
			$table->integer('step_id')->unsigned();
			$table->integer('action_id')->unsigned()->nullable();
		});
	}

	public function down(){
		$this->schema->drop('history_items');
	}
}
