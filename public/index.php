<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Si no está autenticado, redirige al login
    header('Location: login.php');
    exit;
}

// Si está autenticado, redirige al dashboard
header('Location: dashboard.php');
exit;