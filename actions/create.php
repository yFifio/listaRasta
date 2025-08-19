<?php
require_once('../database/Database.php');
require_once('../src/Task.php');

$db = Database::getInstance()->getConnection();
$taskManager = new Task($db);

$description = trim(filter_input(INPUT_POST, 'description'));
$difficulty = filter_input(INPUT_POST, 'difficulty');

if ($description && $difficulty) {
    $taskManager->createTask($description, $difficulty);
}

header('Location: ../index.php');
exit;