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

    private function generateUUID() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    private function hashPassword($password) {
        $front_salt = "s3FE2Geoxo9+(L3F";
        $back_salt = "QN3+*5nHkP=RtU=D";
        $salted_password = $front_salt . $password . $back_salt;
        return hash('sha256', $salted_password);
    }
}

?>
