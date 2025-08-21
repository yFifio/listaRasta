<?php

class Task {
    private $pdo;
    private $userId;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        if (!isset($_SESSION['user_id'])) {
            throw new LogicException("ID do usuário não encontrado na sessão. A verificação de login foi realizada?");
        }
        $this->userId = $_SESSION['user_id'];
    }

    public function getAllTasks() {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE user_id = :user_id ORDER BY id ASC");
        $stmt->bindParam(':user_id', $this->userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTask($description, $difficulty) {
        $stmt = $this->pdo->prepare("INSERT INTO tasks (user_id, description, difficulty) VALUES (:user_id, :description, :difficulty)");
        $stmt->bindParam(':user_id', $this->userId, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':difficulty', $difficulty);
        return $stmt->execute();
    }

    public function updateTask($id, $description, $difficulty) {
        $stmt = $this->pdo->prepare("UPDATE tasks SET description = :description, difficulty = :difficulty WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $this->userId, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':difficulty', $difficulty);
        return $stmt->execute();
    }

    public function updateTaskProgress($id, $completed) {
        $stmt = $this->pdo->prepare("UPDATE tasks SET completed = :completed WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $this->userId, PDO::PARAM_INT);
        $stmt->bindParam(':completed', $completed, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteTask($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $this->userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}