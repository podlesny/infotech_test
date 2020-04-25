<?php

require_once 'bootstrap.php';

use App\Step;

$step = Step::first();

$actions = $step->actions;

var_dump(count($actions));
