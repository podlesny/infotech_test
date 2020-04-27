<?php

namespace App\Validation;

class StepValidator implements IValidator{

	protected $params;

	public function __construct($params){
		$this->params = $params;
	}

	public function validate(){
		$id = $this->params['id'];
		if(!\App\Step::where('id', '=', $id)->count()){
			$result = ['status' => 'error', 'error_code' => 422, 'error_message' => 'No step with given id'];
		}
		else{
			$result = ['status' => 'ok',];
		}
		return $result;
	}
}