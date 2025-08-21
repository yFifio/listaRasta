<?php
require_once('../src/Auth.php');
require_once('../database/Database.php');
$db = Database::getInstance()->getConnection();
$auth = new Auth($db);

$auth->logout();
header('Location: login.php');
exit;