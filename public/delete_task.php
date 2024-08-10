<?php
require_once '../config/config.php';
require_once '../src/Task.php';

$task = new Task($pdo);
if(!empty($_GET['id'])) {
    $task->deleteTask($_GET['id']);
}
header('Location: dashboard.php');
exit;