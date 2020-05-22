<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Step extends Eloquent{

    protected $guarded = ['id'];

    public $timestamps = false;

    /**
     * @return Collection Actions after current step
     */
    public function actions(){
        return $this->hasMany(Action::class, 'prev_id');
    }
    
    /**
     * @return Trap Trap in current step
     */
    public function trap(){
        return $this->hasOne(Trap::class);
    }

    /**
     * @return Collection Required things for current step
     */
    public function requiredThings(){
        return $this->belongsToMany(Thing::class)->withPivot('pass_text', 'fail_text', 'death', 'redirect_step_id');
    }
    
    /**
     * @return Collection Found things in current step
     */
    public function foundThings(){
        return $this->hasMany(Thing::class, 'found_step_id');
    }

}