<?php
require_once('../database/Database.php');
require_once('../src/Task.php');

header('Content-Type: application/json');

$db = Database::getInstance()->getConnection();
$taskManager = new Task($db);

$id = filter_input(INPUT_POST, 'id');
$completed = filter_input(INPUT_POST, 'completed');

if ($id !== null && $completed !== null) {
    if ($taskManager->updateTaskProgress($id, $completed)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update progress']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
}
exit;