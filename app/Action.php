<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Action extends Eloquent{

    protected $guarded = ['id'];

    public $timestamps = false;

    public function nextStep(){
        return $this->belongsTo(Step::class, 'next_id', 'id');
    }

}