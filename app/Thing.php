<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Thing extends Eloquent{

    protected $guarded = ['id'];

	public $timestamps = false;
	
	public function steps(){
		return $this->belongsToMany(Step::class);
	}

}