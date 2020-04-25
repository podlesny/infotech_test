<?php

require_once "vendor/autoload.php";
require_once 'config.php';

use Illuminate\Database\Capsule\Manager as Capsule;

session_start();
 
$capsule = new Capsule;

$capsule->addConnection([
	'driver'    => 'mysql',
    'host'      => DB_HOST,
    'port'      => DB_PORT,
    'database'  => DB_NAME,
    'username'  => DB_USER,
    'password'  => DB_PASSWORD,
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
]);
 
// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
 
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();