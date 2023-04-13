<?php

require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($nama, $email, $password) {
        $user = new User($this->conn);
    
        if ($user->isEmailRegistered($email)) {
            return false;
        }
    
        return $user->register($nama, $email, $password);
    }

    public function isEmailRegistered($email) {
        $user = new User($this->conn);
        return $user->getUserByEmail($email) !== false;
    }
    
    

    public function login($email, $password) {
        $user = new User($this->conn);
        return $user->login($email, $password);
    }
}

?>
