<?php

require_once '../config/database.php';
require_once '../app/controllers/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController = new AuthController($conn);

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $authController->register($nama, $email, $password);

    if ($result) {
        // Registrasi berhasil, tampilkan pesan dan alihkan ke halaman login
        echo "Registration successful!";
        header("Refresh: 2; URL=login.php");
    } else {
        if ($authController->isEmailRegistered($email)) {
            // Email sudah terdaftar, tampilkan pesan kesalahan
            echo "Email already registered. Please try again with a different email.";
        } else {
            // Registrasi gagal, tampilkan pesan kesalahan
            echo "Registration failed. Please try again.";
        }
        header("Refresh: 2; URL=index.php?action=register");
    }
} else {
    // Jika request method bukan POST, alihkan ke halaman register
    header("Location: register.php");
}

?>
