<?php

namespace App\Controllers;

use App\Step;
use App\Action;
use App\HistoryItem;
use App\Player;

include __DIR__.'/../Views/helpers.php';

class MainController{

	public static function index(){
		session_unset();
		view('welcome', []);
	}

	public static function start($params){
		$validator = new \App\Validation\StartValidator($params);
		$result = $validator->validate($params);
		if($result['status'] == 'error'){
			echo json_encode($result);
			return;
		}
		$step = Step::where('begin', true)->first();
		$_SESSION['NAME'] = $params['username'];
		header("Location: /steps/{$step->id}");
	}

	public static function restart(){
		$name = $_SESSION['NAME'];
		$walkthrough = $_SESSION['WALKTHROUGH'];
		if($name && $walkthrough){
			self::saveWalkthrough($name, $walkthrough);
		}
		header("Location: /");
	}

	public static function showHistory(){
		$players = Player::with('historyItems')->get();
		view('history', compact('players'));
	}

	static function saveWalkthrough($name, $walkthrough){
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
		$walkthrough = $_SESSION['WALKTHROUGH'];
		$walkthrough[] = [
			'step_id' => $fromId,
			'action_id' => NULL
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
			'step_id' => $action->prevStep->id,
			'action_id' => $action->id
		];
		$_SESSION['WALKTHROUGH'] = $walkthrough;
	}

}