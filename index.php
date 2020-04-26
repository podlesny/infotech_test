<?php

require_once 'bootstrap.php';

use App\Routing\Router;

$routes = [
    ['GET', '/', ['\App\Controllers\MainController', 'index']],
    ['GET', '/steps/[{id:\d+}]', ['\App\Controllers\MainController', 'viewStep']],
    ['GET', '/actions/{id:\d+}', ['\App\Controllers\MainController', 'takeAction']],
];

$router = new Router($routes);
$router->dispatch();