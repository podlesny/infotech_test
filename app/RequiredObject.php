<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class RequiredObject extends Eloquent{

    protected $guarded = ['id'];

    public $timestamps = false;

    public function redirectStep(){
        return $this->belongsTo(Step::class, 'redirect_step_id', 'id');
    }

    public function redirectStr(){
        return $this->death ? 'Начать заново' : 'Вернуться';
    }

}