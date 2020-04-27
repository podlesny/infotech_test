<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Action extends Eloquent{

    protected $guarded = ['id'];

    public $timestamps = false;
    
    public function prevStep(){
        return $this->belongsTo(Step::class, 'prev_id');
    }

    public function nextStep(){
        return $this->belongsTo(Step::class, 'next_id');
    }

}