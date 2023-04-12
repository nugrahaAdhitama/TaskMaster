<?php

require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($nama, $email, $password) {
        $user = new User($this->conn);
        return $user->register($nama, $email, $password);
    }

    // Anda akan menambahkan method login di sini nanti
}

?>
