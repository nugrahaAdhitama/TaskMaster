<?php

require '../config/database.php';
require '../app/models/User.php';
// require '../app/controllers/AuthController.php';

session_start();

$action = isset($_GET['action']) ? $_GET['action'] : 'home';

$_SESSION["CURRENT_PAGE"] = ucwords(str_replace('_', ' ', $action));
require_once '../app/views/{templates}/header.php';

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

    case 'profile':
        if (isset($_SESSION['user'])) {
            require_once '../app/views/auth/profile.php';
        } else {
            header("Location: index.php?action=profile");
        }
        break;

    case 'edit_profile':
        if (isset($_SESSION['user'])) {
            require_once '../app/views/auth/edit_profile.php';
        } else {
            header("Location: index.php?action=edit_profile");
        }
        break;

    case 'edit_profile_process':
        if (isset($_POST['submit']) && $_POST['submit'] == 'Save') {
            require_once '../app/controllers/AuthController.php';
            $authController = new AuthController($conn);
                
            $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
                
            $updated = $authController->updateProfile($_SESSION['user']['email'], $nama, $password);
            if ($updated) {
                // Update session data
                $_SESSION['user']['nama'] = $nama;
                header('Location: index.php?action=profile');
                exit;
            } else {
                // Jika gagal mengupdate profil, arahkan kembali ke halaman edit profile
                header('Location: index.php?action=edit_profile');
                exit;
            }
        } else {
            header('Location: index.php?action=edit_profile');
            exit;
        }
        break;

    case 'delete_account':
        require_once '../app/views/auth/delete_profile.php';
        break;

    case 'delete_account_process':
        if (isset($_POST['submit']) && $_POST['submit'] == 'yes') {
            require_once '../app/controllers/AuthController.php';
            $authController = new AuthController($conn);
            $deleted = $authController->deleteProfile($_SESSION['user']['email']);
            if ($deleted) {
                unset($_SESSION['user']);
                header('Location: index.php?action=login');
                exit;
            } else {
                // Jika gagal menghapus akun, arahkan kembali ke halaman profil
                header('Location: index.php?action=profile');
                exit;
            }
        } else {
            header('Location: index.php?action=profile');
            exit;
        }
        break;
        
    // Tambahkan kasus routing lainnya di sini
    case 'schedule':
        require_once '../app/views/schedule/index.php';
        break;

    default:
        // Mengarahkan ke halaman default dengan pilihan untuk login atau register
        require_once '../app/views/auth/welcome.php';
}

require_once '../app/views/{templates}/footer.php';

?>
