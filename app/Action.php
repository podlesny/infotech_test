<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Action extends Eloquent{

    protected $guarded = ['id'];

    public $timestamps = false;

    public function nextStep(){
        return $this->belongsTo(Step::class, 'next_id', 'id');
    }

    public function requiredObjects(){
        return $this->hasMany(RequiredObject::class);
    }

    public function getRequiredObjects(){
        $objects = $this->requiredObjects;
        $arr = [];
        foreach($objects as $obj){
            if($obj->random){
                $rand = mt_rand(1,100);
                if($rand > 50){
                    $arr[] = $obj;
                }
            }
            else{
                $arr[] = $obj;
            }
        }
        return $arr;
    }

}