<?php

require_once 'bootstrap.php';

use App\Step;
use App\Trap;


$step = Step::find(8);

var_dump($step->trap->fail_text);