<?php

require_once 'bootstrap.php';

use App\Controllers\MainController;

$routes = [
    ['GET', '/', ['MainController', 'index']],
    ['GET', '/steps/{id:\d+}', ['MainController', 'viewStep']],
    ['GET', '/actions/{id:\d+}', ['MainController', 'takeAction']],
];

$router = new Router($routes);
$router->dispatch();