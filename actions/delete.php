<?php
require_once('../database/Database.php');
require_once('../src/Task.php');

$db = Database::getInstance()->getConnection();
$taskManager = new Task($db);

$id = filter_input(INPUT_GET, 'id');

if ($id) {
    $taskManager->deleteTask($id);
}

header('Location: ../index.php');
exit;