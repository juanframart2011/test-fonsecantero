<?php
require_once '../config/config.php';
require_once '../src/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User($pdo);
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($user->register($username, $password)) {
        
        echo '<div class="alert alert-success text-center" role="alert">Usuario registrado con éxito.<br><a href="login.php">Inicia sesión</a></div>';
    } else {
        
        echo '<div class="alert alert-danger text-center" role="alert">Error al registrar el usuario.</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Registro</h2>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="username">Nombre de Usuario</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
        </form>
        <div class="text-center mt-3">
            <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
    </div>
</body>
</html>