<?php

namespace App\Validation;

class StartValidator implements IValidator{

	protected $params;

	public function __construct($params){
		$this->params = $params;
	}

	public function validate(){
		if(!array_key_exists('username', $this->params)){
			$result = ['status' => 'error', 'error_code' => 422, 'error_message' => 'No name parameter'];
		}
		else{
			$result = ['status' => 'ok',];
		}
		return $result;
	}
}