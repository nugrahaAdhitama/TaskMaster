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

    public function readProfile($email) {
        $user = new User($this->conn);
        return $user->getUserByEmail($email);
    }
    
    public function updateProfile($email, $nama, $password) {
        $user = new User($this->conn);
        $user_data = $user->getUserByEmail($email);
        if ($user_data === false) {
            return false;
        }
    
        if (!empty($nama)) {
            $user_data['nama'] = $nama;
        }
    
        if (!empty($password)) {
            $user_data['password'] = $user->hashPassword($password);
        }
    
        $query = "UPDATE users SET nama = :nama, password = :password WHERE email = :email";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':nama', $user_data['nama']);
        $stmt->bindParam(':password', $user_data['password']);
        $stmt->bindParam(':email', $email);
    
        return $stmt->execute();
    }
    
    public function deleteProfile($email) {
        $user = new User($this->conn);
        $user_data = $user->getUserByEmail($email);
        if ($user_data === false) {
            return false;
        }
    
        $query = "DELETE FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':email', $email);
    
        return $stmt->execute();
    }
    
}

?>
