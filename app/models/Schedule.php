<?php

class Schedule {
    private $db;
    private $table = 'schedules';

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllSchedule() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllCourses() {
        $query = "SELECT course FROM $this->table";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function addNewSchedule(mixed $columns, mixed $data) {
        $params = ':'.implode(', :', $columns);
        $column = implode(', ', $columns);

        $uuid = $this->generateUUID();
        $query = "INSERT INTO $this->table (id, user_id, $column) VALUES (:id, :user_id, $params)";
        $stmt = $this->db->prepare($query);

        $params = explode(', ', $params);
        $stmt->bindParam(':id', $uuid);
        $stmt->bindParam(':user_id', $_SESSION["user"]["id"]);
        foreach ( $data as $index => $value ) { $stmt->bindParam($params[$index], $value); }

        return ( $stmt->execute() ? true : false );
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
