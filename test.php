<?php

require_once 'bootstrap.php';

use App\Step;

$step = Step::find(9);

$ro = $step->requiredObjects;

var_dump($ro);