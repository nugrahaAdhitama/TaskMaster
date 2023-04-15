<?php

class Schedule {
    private $db;
    private $table = 'schedules';

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllSchedules() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findScheduleByID(string $id) {
        $query = "SELECT * FROM $this->table WHERE id = $id";
        $stmt = $this->db->prepare($query);
        return ( $stmt->execute() ? true : false );
    }

    public function getScheduleByID(string $id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return ( $stmt->rowCount() > 0 ? $stmt->fetch(PDO::FETCH_ASSOC) : false );
    }

    public function getScheduleByUserID(string $user_id) {
        $query = "SELECT * FROM $this->table WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getScheduleByOwner(string $id, string $user_id) {
        $query = "SELECT * FROM $this->table WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return ( $stmt->rowCount() > 0 ? $stmt->fetch(PDO::FETCH_ASSOC) : false );
    }

    public function addNewSchedule(array $columns, array $data) {
        $params = ':' . implode(', :', $columns);
        $column = implode(', ', $columns);
    
        $uuid = $this->generateUUID();
        $query = "INSERT INTO $this->table (id, user_id, $column) VALUES (:id, :user_id, $params)";
        $stmt = $this->db->prepare($query);
    
        $stmt->bindParam(':id', $uuid);
        $stmt->bindParam(':user_id', $_SESSION["user"]["id"]);
    
        foreach ($columns as $index => $column) {
            $stmt->bindParam(':' . $column, $data[$index]);
        }
    
        return ($stmt->execute() ? true : false);
    }
        

    public function editSchedule(string $id, string $user_id, array $columns, array $data) {
        $placeholders = implode(', ', array_map(function($col) { return "$col = :$col"; }, $columns));
    
        $query = "UPDATE $this->table SET $placeholders WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':userid', $user_id);
    
        foreach ($columns as $index => $column) {
            $stmt->bindParam(':' . $column, $data[$index]);
        }
    
        return $stmt->execute();
    }

    public function deleteScheduleByID(string $id) {
        $schedule = $this->findScheduleByID($id);
        if ( $schedule === false ) { return false; }
    
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($query);
    
        $stmt->bindParam(':id', $id);
    
        return $stmt->execute();
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
}