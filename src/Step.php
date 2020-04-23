<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Step extends Eloquent{

	protected $guarded = ['id'];

	public function nextSteps(){
		return $this->hasMany('App\Step', 'parent_id');
	}

}