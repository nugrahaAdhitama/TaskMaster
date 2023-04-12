<?php

require '../config/database.php';
require '../app/models/User.php';
require '../app/controllers/AuthController.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'default';

switch ($action) {
    case 'register':
        require_once '../app/views/auth/register.php';
        break;
    case 'register_process':
        require_once 'register_process.php';
        break;
    // Tambahkan kasus routing lainnya di sini
    default:
        // Mengarahkan ke halaman register sebagai halaman default
        require_once '../app/views/auth/register.php';
}

?>
