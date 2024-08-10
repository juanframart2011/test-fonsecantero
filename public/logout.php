<?php
require_once '../src/User.php';
$user = new User($pdo);
$user->logout();
header('Location: login.php');
exit