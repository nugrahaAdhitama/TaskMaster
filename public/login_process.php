<?php

require_once '../config/database.php';
require_once '../app/controllers/AuthController.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController = new AuthController($conn);

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $authController->login($email, $password);

    if($user) {
        // Login berhasil, simpan user dalam session dan alihkan ke halaman utama
        session_start();
        $_SESSION['user'] = $user;
        header("Location: index.php?action=dashboard");
    } else {
        // Login gagal, tampilkan pesan kesalahan
        echo "Invalid email or password. Please try again.";
        header("Refresh: 2; URL=login.php");
    }
} else {
    // Jika request method bukan POST, alihkan ke halaman login
    header("Location: login.php");
}