<?php

namespace App\Controllers;

use App\Step;

include __DIR__.'/../Views/helpers.php';

class MainController{

	public static function index(){
		view('welcome');
	}

	public static function viewStep($params){
		//Validation
		if(array_key_exists('id', $params)){
			$id = intval($params['id']);
			$step = Step::find($id);
		}
		else{
			$step = Step::where('begin', true)->first();
		}
		
	}

	public static function takeAction(){

	}

}