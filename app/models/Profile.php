<?php

class Profile extends Auth {

    public function updateProfile($email, $nama, $password) {
        $user = $this->getUserByEmail($email);
        if ( $user === false ) { return false; }
        if ( !empty($nama) ) { $user['nama'] = $nama; }
        if ( !empty($password) ) { $user['password'] = $this->hashPassword($password); }
    
        $query = "UPDATE $this->table SET nama = :nama, password = :password WHERE email = :email";
        $stmt = $this->db->prepare($query);
    
        $stmt->bindParam(':nama', $user['nama']);
        $stmt->bindParam(':password', $user['password']);
        $stmt->bindParam(':email', $email);
    
        return $stmt->execute();
    }

    public function deleteProfile($email) {
        $user = $this->getUserByEmail($email);
        if ( $user === false ) { return false; }
    
        $query = "DELETE FROM $this->table WHERE email = :email";
        $stmt = $this->db->prepare($query);
    
        $stmt->bindParam(':email', $email);
    
        return $stmt->execute();
    }
}
