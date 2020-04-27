<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Player extends Eloquent{

    protected $guarded = ['id'];

	public function historyItems(){
		return $this->hasMany(HistoryItem::class);
	}

}