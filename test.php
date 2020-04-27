<?php

require_once 'bootstrap.php';

use App\Step;
use App\Trap;
use App\Action;



$action = Action::find(6);

var_dump($action->nextStep->text);