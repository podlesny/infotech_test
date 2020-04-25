<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Action extends Eloquent{

	protected $guarded = ['id'];

	public $timestamps = false;

}