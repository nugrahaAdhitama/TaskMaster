<?php

require_once '../config/database.php';
require_once '../app/controllers/AuthController.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController = new AuthController($conn);

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $authController->login($email, $password);

    # exit(var_dump($user));

    if($user) {
        // Login berhasil, simpan user dalam session dan alihkan ke halaman utama
        session_start();
        $_SESSION['user'] = $user;
        header("Location: ?action=dashboard");
    } else {
        // Login gagal, tampilkan pesan kesalahan
        echo "Invalid email or password. Please try again.";
        header("Refresh: 2; URL=?action=login"); # minor [?action=]
    }
} else {
    // Jika request method bukan POST, alihkan ke halaman login
    header("Location: ?action=login");
}