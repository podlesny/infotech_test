<?php
require 'config.php';
return [
  'paths' => [
    'migrations' => './src/Migrations'
  ],
  'migration_base_class' => '\App\Migrations\Migration',
  'environments' => [
    'default_migration_table' => 'phinxlog',
    'default_database' => 'dev',
    'dev' => [
      'adapter' => 'mysql',
      'host' => DB_HOST,
      'name' => DB_NAME,
      'user' => DB_USER,
      'pass' => DB_PASSWORD,
      'port' => DB_PORT
    ]
  ]
];