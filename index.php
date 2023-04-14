<?php
require 'config/database.php';
require 'config/App.php';

define('APP_NAME', 'Taskmaster');
define('URI_PARAM', 'URI');
define('BASE_URI', '/taskmaster/');

session_start();

$app = new App($conn);
