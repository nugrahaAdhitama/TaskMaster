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
        $query = "SELECT * FROM $this->table WHERE user_id = :user_id
              UNION
              SELECT tugas.* FROM $this->table
              JOIN kelompok_tugas ON tugas.id = kelompok_tugas.tugas_id
              WHERE kelompok_tugas.user_id = :user_id";
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

    public function getUserByEmailOrName(string $emailOrName) {
        $query = "SELECT * FROM users WHERE email = :emailOrName OR nama = :emailOrName";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':emailOrName', $emailOrName);
        $stmt->execute();
    
        return ($stmt->rowCount() > 0 ? $stmt->fetch(PDO::FETCH_ASSOC) : false);
    }
    
    public function inviteFriendToTask(string $task_id, string $friend_id) {
        $query = "INSERT INTO kelompok_tugas (tugas_id, user_id) VALUES (:task_id, :friend_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':task_id', $task_id);
        $stmt->bindParam(':friend_id', $friend_id);
    
        return $stmt->execute();
    }

    public function getTaskMembers(string $task_id) {
        $query = "SELECT users.* FROM users JOIN kelompok_tugas ON users.id = kelompok_tugas.user_id WHERE kelompok_tugas.tugas_id = :task_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':task_id', $task_id);
        $stmt->execute();
        return $stmt->fetchAll();
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