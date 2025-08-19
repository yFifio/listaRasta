<?php
require_once('../database/Database.php');
require_once('../src/Task.php');

$db = Database::getInstance()->getConnection();
$taskManager = new Task($db);

$id = filter_input(INPUT_POST, 'id');
$description = trim(filter_input(INPUT_POST, 'description'));
$difficulty = filter_input(INPUT_POST, 'difficulty');

if ($id && $description && $difficulty) {
    $taskManager->updateTask($id, $description, $difficulty);
}

header('Location: ../index.php');
exit;