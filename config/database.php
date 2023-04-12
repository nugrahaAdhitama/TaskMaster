<?php

// Konfigurasi database
define('DB_HOST', 'localhost'); // Ganti dengan host database Anda
define('DB_USER', 'root'); // Ganti dengan username database Anda
define('DB_PASS', ''); // Ganti dengan password database Anda
define('DB_NAME', 'taskmaster'); // Ganti dengan nama database Anda

// Koneksi ke database
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Cek koneksi ke database
if ($db->connect_errno) {
    die("Gagal terhubung ke database: " . $db->connect_error);
}

?>
