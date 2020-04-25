<?php

require_once 'bootstrap.php';

use App\Controllers\MainController;

$router = new Router($routes);
$router->dispatch();