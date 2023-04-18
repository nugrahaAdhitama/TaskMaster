<?php

/**
 * Loads native core files.
 */
require_once __DIR__ . '/app/autoload.php';

/**
 * Loads third-party library files.
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Imports core files.
 */
use App\Core\App;
use App\Core\Database;

/**
 * Initialization
 */
session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
file_exists('.env') ? $dotenv->load() : exit('ERROR: Missing `.env` file!');

$database = new Database($_ENV["DB_HOST"]??'', $_ENV["DB_NAME"]??'', $_ENV["DB_USER"]??'', $_ENV["DB_PASS"]??'');
$app = new App($database->connection);
