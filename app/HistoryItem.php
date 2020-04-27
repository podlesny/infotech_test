<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class HistoryItem extends Eloquent{

    protected $guarded = ['id'];

	public $timestamps = false;
	
	public function step(){
		return $this->belongsTo(Step::class);
	}

	public function action(){
		return $this->belongsTo(Action::class);
	}

	public function player(){
		return $this->belongsTo(Player::class);
	}

	public function getText(){
		$actionText = $this->action_id !== NULL ? $this->action->text : _RETURN;
		return "Шаг: {$this->step->text}<br/>Действие: {$actionText}";
	}

}