<?php

require 'config/Database.php';
require 'config/App.php';
require 'vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('APP_NAME', $_ENV["APP_NAME"]);
define('URI_PARAM', $_ENV["APP_URI_PARAM"]);
define('BASE_URI', $_ENV["APP_BASE_URI"]);

$db = new Database;
$app = new App($db->conn);
