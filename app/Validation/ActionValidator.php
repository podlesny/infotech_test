<?php

namespace App\Validation;

class ActionValidator implements IValidator{

	protected $params;

	public function __construct($params){
		$this->params = $params;
	}

	public function validate(){
		$id = $this->params['id'];
		if(!\App\Action::where('id', '=', $id)->count()){
			$result = ['status' => 'error', 'error_code' => 422, 'error_message' => 'No action with given id'];
		}
		else{
			$result = ['status' => 'ok',];
		}
		return $result;
	}
}