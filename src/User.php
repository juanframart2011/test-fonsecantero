<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    #Metodo de registro de usuarios
    public function register($username, $password) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $hash]);
    }

    #Metodo de registro de login
    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
        return false;
    }

    #Metodo que valida si esta logueado el usuario regresa el id
    public function isAuthenticated() {
        session_start();
        return isset($_SESSION['user_id']);
    }

    #Metodo que destruye la session
    public function logout() {
        session_start();
        session_destroy();
    }
}