<?php

class Auth {

    protected $table = 'users';

    public function __construct(private $db) {}

    public function register($nama, $email, $password) {
        $uuid = $this->generateUUID();
        $hashedPassword = $this->hashPassword($password);

        $query = "INSERT INTO $this->table (id, nama, email, password) VALUES (:id, :nama, :email, :password)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $uuid);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        return ( $stmt->execute() ? true : false );
    }

    public function read($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($query);
    
        $stmt->bindParam(':id', $id);

        return ( $stmt->execute() ? $stmt->fetch(PDO::FETCH_ASSOC) : false );
    }
    
    public function update($id, $data) {
        $query = "UPDATE $this->table SET nama = :nama, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($query);
    
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $data['nama']);
        $stmt->bindParam(':email', $data['email']);

        return ( $stmt->execute() ? true : false );
    }
    
    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($query);
    
        $stmt->bindParam(':id', $id);

        return ( $stmt->execute() ? true : false );
    }    

    public function generateUUID() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public function hashPassword($password) {
        $front_salt = $_ENV["FRONT_SALT"];
        $back_salt  = $_ENV["BACK_SALT"];
        $salted_password = $front_salt . $password . $back_salt;
        return hash('sha256', $salted_password);
    }

    public function login($email, $password) {
        $hashedPassword = $this->hashPassword($password);

        $query = "SELECT * FROM $this->table WHERE email = :email AND password = :password";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        $stmt->execute();

        return ( $stmt->rowCount() > 0 ? $stmt->fetch(PDO::FETCH_ASSOC) : false );
    }

    public function isEmailRegistered($email) {
        $query = "SELECT COUNT(*) FROM $this->table WHERE email = :email";
        $stmt = $this->db->prepare($query);
    
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        $count = $stmt->fetchColumn();
        return $count == 1;
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM $this->table WHERE email = :email";
        $stmt = $this->db->prepare($query);
    
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
