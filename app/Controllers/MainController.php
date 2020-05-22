<?php

namespace App\Controllers;

use App\Step;
use App\Action;
use App\HistoryItem;
use App\Player;
use App\StepProcessor;

// include __DIR__.'/../Views/helpers.php';

class MainController{

    public static function index(){
        session_unset();
        view('welcome', []);
    }

    /**
     * Start a game
     * @param array $params Combined array of GET parameters and route parameters
     */
    public static function start(array $params){
        $validator = new \App\Validation\StartValidator($params);
        $result = $validator->validate($params);
        if($result['status'] == 'error'){
            $error = $result['error_code'] . " " . $result['error_message'];
            view('error', compact('error'));
            exit;
        }
        $step = Step::where('begin', true)->first();
        $_SESSION['NAME'] = $params['username'];
        header("Location: /steps/{$step->id}");
    }

    /**
     * Restart a game
     */
    public static function restart(){
        $name = $_SESSION['NAME'];
        $walkthrough = $_SESSION['WALKTHROUGH'];
        if($name && $walkthrough){
            self::saveWalkthrough($name, $walkthrough);
        }
        header("Location: /");
    }

    /**
     * Show history
     */
    public static function showHistory(){
        $players = Player::with('historyItems')->get();
        view('history', compact('players'));
    }

    /**
     * Save walkthrough of current player
     * @param string $name Name of current player
     * @param array $walkthrough Array of steps and actions in current game
     */
    static function saveWalkthrough(string $name, array $walkthrough){
        $player = Player::create([
            'name' => $name,
        ]);
        foreach($walkthrough as $item){
            HistoryItem::create([
                'player_id' => $player->id,
                'step_id' => $item['step_id'],
                'action_id' => $item['action_id'],
            ]);
        }
    }

    /**
     * Show page for current step
     * @param array $params Combined array of GET parameters and route parameters
     */
    public static function viewStep(array $params){
        $validator = new \App\Validation\StepValidator($params);
        $result = $validator->validate($params);
        if($result['status'] == 'error'){
            $error = $result['error_code'] . " " . $result['error_message'];
            view('error', compact('error'));
            exit;
        }

        $id = intval($params['id']);
        $step = Step::find($id);
        $random = rand(0,100);
        $sp = new StepProcessor($step, $random);

        $pickedUpThingIds = array_key_exists('PICKED_UP_THING_IDS', $_SESSION) ? $_SESSION['PICKED_UP_THING_IDS'] : [];
        $foundThingIds = $step->foundThings->map(function($thing){return $thing->id;})->toArray();
        $text = $sp->getText($pickedUpThingIds);
        $actions = $sp->getActions($pickedUpThingIds);

        $pickedUpThingIds = array_merge($pickedUpThingIds, $foundThingIds);
        self::newStepSetSession($pickedUpThingIds);

        view('step', compact('id', 'text', 'actions'));
    }

    /**
     * Redirect user on given step
     * @param array $params Combined array of GET parameters and route parameters
     */
    public function redirect(array $params){
        ['fromId' => $fromId, 'toId' => $toId] = $params;
        self::redirectSetSession($fromId);
        header("Location: /steps/{$toId}");
    }

    /**
     * Set walkthrough in session for redirect
     * @param int $fromId
     */
    static function redirectSetSession(int $fromId){
        $walkthrough = $_SESSION['WALKTHROUGH'];
        $walkthrough[] = [
            'step_id' => $fromId,
            'action_id' => NULL
        ];
        $_SESSION['WALKTHROUGH'] = $walkthrough;
    }
    /**
     * Set picked up things in session
     * @param array $pickedUpThingIds
     */
    static function newStepSetSession(array $pickedUpThingIds){
        $_SESSION['PICKED_UP_THING_IDS'] = $pickedUpThingIds;
    }

    /**
     * Processes action that is chosen by user
     * @param array $params Combined array of GET parameters and route parameters
     */
    public static function takeAction(array $params){
        $validator = new \App\Validation\ActionValidator($params);
        $result = $validator->validate($params);
        if($result['status'] == 'error'){
            $error = $result['error_code'] . " " . $result['error_message'];
            view('error', compact('error'));
            exit;
        }

        $id = intval($params['id']);
        $action = Action::find($id);
        $step = $action->nextStep;

        self::newActionSetSession($action);

        header("Location: /steps/{$step->id}");
    }

    /**
     * Set walkthrough in session for new action
     * @param Action $action
     */
    static function newActionSetSession(Action $action){
        ['WALKTHROUGH' => $walkthrough] = $_SESSION;
        $walkthrough[] = [
            'step_id' => $action->prevStep->id,
            'action_id' => $action->id
        ];
        $_SESSION['WALKTHROUGH'] = $walkthrough;
    }

}