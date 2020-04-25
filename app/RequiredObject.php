<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class RequiredObject extends Eloquent{

	protected $guarded = ['id'];

	public $timestamps = false;

}