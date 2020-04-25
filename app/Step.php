<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Step extends Eloquent{

	protected $guarded = ['id'];

	public $timestamps = false;

}