<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Step extends Eloquent{

    protected $guarded = ['id'];

    public $timestamps = false;

    public function actions(){
        return $this->hasMany(Action::class, 'prev_id');
    }
    
    public function trap(){
        return $this->hasOne(Trap::class);
    }

    public function requiredThings(){
        return $this->belongsToMany(Thing::class)->withPivot('pass_text', 'fail_text', 'death', 'redirect_step_id');
    }
    
    public function foundThings(){
        return $this->hasMany(Thing::class, 'found_step_id');
    }
    
    public function getText($pickedUpThingIds, $random){
        $foundThings = $this->foundThings;

        $requiredThings = $this->requiredThings;
        if(!$foundThings->count() && !$requiredThings->count() && !$this->fallIntoTrap($random)){
            $text = $this->text;
        }
        else{
            if($foundThings->count()){
                $text = $this->text;
                $foundThingsText = '';
                foreach($foundThings as $thing){
                    if(in_array($thing->id, $pickedUpThingIds)){
                        $foundThingsText .= $thing->exists_text . ' ';
                    }
                }
                if($foundThingsText){
                    $text = $foundThingsText;
                }
            }
            if($requiredThings->count()){
                $foundThingIds = $foundThings->map(function($thing){return $thing->id;})->toArray();
                $thingIds = array_merge($pickedUpThingIds, $foundThingIds);
                if(($id = $this->checkThings($thingIds)) !== false){
                    $text = $requiredThings
                    ->filter(function($thing) use ($id) {return $thing->id === $id;})
                    ->first()
                    ->pivot->pass_text;
                    $text = $text ? $text . ' ' . $this->text : $this->text;
                }
                else{
                    $text = $requiredThings->first()->pivot->fail_text;
                }
            }
            if($this->fallIntoTrap($random)){
                $text = $this->trap->fail_text;
            }
        }
        return $text;
    }

    public function getActions($pickedUpThingIds, $random){
        $foundThingIds = $this->foundThings->map(function($thing){return $thing->id;})->toArray();
        $thingIds = array_merge($pickedUpThingIds, $foundThingIds);
        if(!$this->actions->count()){
            $begin = \App\Step::where('begin', true)->first();
            $actions = [
                [
                    'text' => _RESTART,
                    'restart' => true
                ]
            ];
        }
        else{
            if(!$this->checkThings($thingIds)){
                $thing = $this->requiredThings->first();
                if($thing->pivot->death){
                    $actions = [
                        [
                            'text' => _RESTART,
                            'restart' => true,
                        ]
                    ];
                }
                else{
                    $actions = [
                        [
                            'text' => _RETURN,
                            'redirect' => true,
                            'redirect_step_id' => $thing->pivot->redirect_step_id
                        ]
                    ];
                }
            }
            else if($this->fallIntoTrap($random)){
                $actions = [
                    [
                        'text' => _RESTART,
                        'restart' => true,
                    ]
                ];
            }
            else{
                $actions = $this->actions;
            }
        }
        
        return $actions;
    }

    public function checkThings($pickedUpThings){
        $thingIds = $this->requiredThings->map(function($o){return $o->id;})->toArray();
        $result = false;
        if(!count($thingIds)){
            $result = true;
        }
        else{
            foreach($pickedUpThings as $id){
                if(array_search($id, $thingIds) !== false){
                    $result = $id;
                    break;
                }
            }
        }
        return $result;
    }
    
    public function fallIntoTrap($random){
        $result = false;
        $trap = $this->trap;
        if($trap && $random < _PROBABILITY){
            $result = true;
        }
        return $result;
    }

}