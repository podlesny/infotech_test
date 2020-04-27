<?php

namespace App\Controllers;

use App\Step;
use App\Action;

include __DIR__.'/../Views/helpers.php';

class MainController{

	public static function index(){
		view('welcome', []);
	}

	public static function start(){
		$step = Step::where('begin', true)->first();
		header("Location: /steps/{$step->id}");
	}

	public static function restart(){
		session_unset();
		header("Location: /");
	}

	public static function viewStep($params){
		$validator = new \App\Validation\StepValidator($params);
		$result = $validator->validate($params);
		if($result['status'] == 'error'){
			echo json_encode($result);
			return;
		}

		$id = intval($params['id']);
		$step = Step::find($id);

		$random = rand(0,100);
		$pickedUpThingIds = array_key_exists('PICKED_UP_THING_IDS', $_SESSION) ? $_SESSION['PICKED_UP_THING_IDS'] : [];
		$foundThingIds = $step->foundThings->map(function($thing){return $thing->id;})->toArray();
		$text = $step->getText($pickedUpThingIds, $random);
		$actions = $step->getActions($pickedUpThingIds, $random);

		$pickedUpThingIds = array_merge($pickedUpThingIds, $foundThingIds);
		self::newStepSetSession($pickedUpThingIds);

		view('step', compact('id', 'text', 'actions'));
	}

	public function redirect($params){
		['fromId' => $fromId, 'toId' => $toId] = $params;
		self::redirectSetSession($fromId);
		header("Location: /steps/{$toId}");
	}

	static function redirectSetSession($fromId){
		['WALKTHROUGH' => $walkthrough] = $_SESSION;
		$walkthrough[] = [
			'step_id' => $fromId,
			'action_id' => -1
		];
		$_SESSION['WALKTHROUGH'] = $walkthrough;
	}

	static function newStepSetSession($pickedUpThingIds){
		$_SESSION['PICKED_UP_THING_IDS'] = $pickedUpThingIds;
	}

	public static function takeAction($params){
		$validator = new \App\Validation\ActionValidator($params);
		$result = $validator->validate($params);
		if($result['status'] == 'error'){
			echo json_encode($result);
			return;
		}

		$id = intval($params['id']);
		$action = Action::find($id);
		$step = $action->nextStep;

		self::newActionSetSession($action);

		header("Location: /steps/{$step->id}");
	}

	static function newActionSetSession($action){
		['WALKTHROUGH' => $walkthrough] = $_SESSION;
		$walkthrough[] = [
			'step_id' => $action->id,
			'action_id' => $action->prev_step->id
		];
		$_SESSION['WALKTHROUGH'] = $walkthrough;
	}

}