<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Step extends Eloquent{

    protected $guarded = ['id'];

    public $timestamps = false;

    public function actions(){
        return $this->hasMany(Action::class, 'prev_id');
    }

    public function requiredObjects(){
        return $this->hasMany(RequiredObject::class, 'required_step_id');
    }

    public function pass($pickedUpObjects){
        $objectIds = $this->requiredObjects->map(function($o){return $o->id;});
        $result = false;
        if(!$objectIds->count){
            $result = true;
        }
        else{
            foreach($pickedUpObjects as $id){
                if(array_search($id, $objectIds) !== false){
                    $result = true;
                    break;
                }
            }
        }
        return $result;
    }

}