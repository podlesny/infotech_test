<?php

require_once 'bootstrap.php';

require_once 'constants.php';

require_once 'check-database.php';


use App\Routing\Router;

$routes = [
    ['GET', '/', ['\App\Controllers\MainController', 'index']],
    ['POST', '/start', ['\App\Controllers\MainController', 'start']],
    ['GET', '/restart', ['\App\Controllers\MainController', 'restart']],
    ['GET', '/history', ['\App\Controllers\MainController', 'showHistory']],
    ['GET', '/steps/{id:\d+}', ['\App\Controllers\MainController', 'viewStep']],
    ['GET', '/redirect/{fromId:\d+}/{toId:\d+}', ['\App\Controllers\MainController', 'redirect']],
    ['GET', '/actions/{id:\d+}', ['\App\Controllers\MainController', 'takeAction']],
];

$router = new Router($routes);
$router->dispatch();