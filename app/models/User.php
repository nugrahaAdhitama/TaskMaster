<?php

class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($nama, $email, $password) {
        $uuid = $this->generateUUID();
        $hashedPassword = $this->hashPassword($password);

        $query = "INSERT INTO users (id, nama, email, password) VALUES (:id, :nama, :email, :password)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $uuid);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function read($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':id', $id);
    
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
    
    public function update($id, $data) {
        $query = "UPDATE users SET nama = :nama, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $data['nama']);
        $stmt->bindParam(':email', $data['email']);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function delete($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':id', $id);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }    

    private function generateUUID() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public function hashPassword($password) {
        $front_salt = "s3FE2Geoxo9+(L3F";
        $back_salt = "QN3+*5nHkP=RtU=D";
        $salted_password = $front_salt . $password . $back_salt;
        return hash('sha256', $salted_password);
    }

    public function login($email, $password) {
        $hashedPassword = $this->hashPassword($password);

        $query = "SELECT * FROM users WHERE email = :email AND password = :password";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } else {
            return false;
        }
    }

    public function isEmailRegistered($email) {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    
}

?>
