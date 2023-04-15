<?php

class Schedule {
    private $db;
    private $table = 'schedules';

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllSchedules() {
        $query = "SELECT s.id, u.nama, s.course, s.started_at, s.ended_at, s.day, s.room, s.notes FROM $this->table s INNER JOIN users u ON s.user_id=u.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
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
        

    public function editSchedule() {

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