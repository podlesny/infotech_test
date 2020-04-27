<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Trap extends Eloquent{

    protected $guarded = ['id'];

	public $timestamps = false;
	
	public function steps(){
		return $this->hasOne(Step::class);
	}

}