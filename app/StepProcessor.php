<?php

namespace App;

class StepProcessor{

    private $step;
    private $random;

    function __construct(Step $step, int $random){
        $this->step = $step;
        $this->random = $random;
    }

    /**
     * @param array $pickedUpThingIds Picked up things on current step
     * @return string Text for current step
     */
    public function getText(array $pickedUpThingIds){
        $foundThings = $this->step->foundThings;

        $requiredThings = $this->step->requiredThings;
        if(!$foundThings->count() && !$requiredThings->count() && !$this->fallIntoTrap($this->random)){
            $text = $this->step->text;
        }
        else{
            if($foundThings->count()){
                $text = $this->step->text;
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
                    $text = $text ? $text . ' ' . $this->step->text : $this->step->text;
                }
                else{
                    $text = $requiredThings->first()->pivot->fail_text;
                }
            }
            if($this->fallIntoTrap($this->random)){
                $text = $this->step->trap->fail_text;
            }
        }
        return $text;
    }

    /**
     * @param array $pickedUpThingIds Picked up things on current step
     * @return array
     * Function that returns data for action buttons
     * Array structure:
     * text - text for button
     * restart - if current step leads to restart (optional)
     * redirect - if current step leads to redirect (optional)
     * redirect_step_id - step to redirect (optional)
     * prev_id - id of previous step (optional)
     * next_id - id of next step (optional)
     */
    public function getActions(array $pickedUpThingIds){
        $foundThingIds = $this->step->foundThings->map(function($thing){return $thing->id;})->toArray();
        $thingIds = array_merge($pickedUpThingIds, $foundThingIds);
        if(!$this->step->actions->count()){
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
                $thing = $this->step->requiredThings->first();
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
            else if($this->fallIntoTrap($this->random)){
                $actions = [
                    [
                        'text' => _RESTART,
                        'restart' => true,
                    ]
                ];
            }
            else{
                $actions = $this->step->actions;
            }
        }
        
        return $actions;
    }

    /**
     * Function that checks for required things in current step
     * @param array $pickedUpThingIds Picked up things on all steps
     * @return bool Result if user passes this step
     */
    public function checkThings(array $pickedUpThings){
        $thingIds = $this->step->requiredThings->map(function($o){return $o->id;})->toArray();
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

    /**
     * Function that determines if user falls into trap on current step based on random number
     * @return bool Result if user falls into trap
     */
    public function fallIntoTrap(){
        $result = false;
        $trap = $this->step->trap;
        if($trap && $this->random < _PROBABILITY){
            $result = true;
        }
        return $result;
    }

}