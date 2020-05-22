<?php

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($mysqli->connect_errno) {
    $error = "Error connecting to MySQL: " . $mysqli->connect_error;
    view('error', compact('error'));
    exit;
}

$res = $mysqli->query('SHOW TABLES');
$tableData = array_map(function($item){
    return $item[0];
}, $res->fetch_all());
$tableNames = ['history_items', 'players', 'step_thing', 'steps', 'things', 'traps'];
foreach($tableNames as $name){
    if(!in_array($name, $tableData)){
        $error = "Database is not migrated";
        view('error', compact('error'));
        exit;
    }
}