<?php

class Schedule {
    private $db;
    private $table = 'jadwal_kuliah';

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllSchedule() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function editSchedule() {

    }
}
