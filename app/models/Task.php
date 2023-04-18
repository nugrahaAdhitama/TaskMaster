<?php

class Task {
    
    private $table = 'tugas';

    public function __construct(private $db) {}

    public function getAllTasks() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findTaskByID(string $id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return ($stmt->execute() ? true : false);
    }

    public function getTaskByID(string $id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return ($stmt->rowCount() > 0 ? $stmt->fetch(PDO::FETCH_ASSOC) : false);
    }

    public function getTaskByUserID(string $user_id) {
        $query = "SELECT * FROM $this->table WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTaskByOwner(string $id, string $user_id) {
        $query = "SELECT * FROM $this->table WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return ( $stmt->rowCount() > 0 ? $stmt->fetch(PDO::FETCH_ASSOC) : false );
    }

    public function addNewTask(array $columns, array $data) {
        $uuid = $this->generateUUID();
        while ($this->db->query("SELECT COUNT(*) FROM $this->table WHERE id ='$uuid'")->fetchColumn()) {
            $uuid = $this->generateUUID();
        }

        $params = ':' . implode(', :', $columns);
        $column = implode(', ', $columns);
        $query = "INSERT INTO $this->table (id, user_id, $column) VALUES(:id, :user_id, $params)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $uuid);
        $stmt->bindParam(':user_id', $_SESSION["user"]["id"]);

        foreach ($columns as $column) {
            $stmt->bindParam(":$column", $data[$column]);
        }

        return $stmt->execute();
    }

    public function editTask(string $id, string $user_id, array $data) {
        $placeholders = implode(', ', array_map(function($col) { return "$col = :$col"; }, array_keys($data)));

        $query = "UPDATE $this->table SET $placeholders WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);

        foreach ($data as $param => $value) {
            $stmt->bindValue(":$param", $value);
        }

        return $stmt->execute();
    }

    public function deleteTaskByID(string $id) {
        $schedule = $this->findTaskByID($id);
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