<?php

require '../config/database.php';
require '../app/models/User.php';
require '../app/controllers/AuthController.php';

session_start();

$action = isset($_GET['action']) ? $_GET['action'] : 'default';

switch ($action) {
    case 'register':
        require_once '../app/views/auth/register.php';
        break;
    case 'register_process':
        require_once 'register_process.php';
        break;
    case 'login':
        require_once '../app/views/auth/login.php';
        break;
    case 'login_process':
        require_once 'login_process.php';
        break;
    case 'dashboard':
        if (isset($_SESSION['user'])) {
            require_once '../app/views/dashboard.php';
        } else {
            header("Location: index.php?action=login");
        }
        break;
    case 'logout':
        unset($_SESSION['user']);
        header("Location: index.php");
        break;
    // Tambahkan kasus routing lainnya di sini
    default:
        // Mengarahkan ke halaman default dengan pilihan untuk login atau register
        require_once '../app/views/auth/welcome.php';
}

?>
