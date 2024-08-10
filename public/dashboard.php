<?php
require_once '../config/config.php';
require_once '../src/User.php';
require_once '../src/Task.php';

$user = new User($pdo);
if (!$user->isAuthenticated()) {
    header('Location: login.php');
    exit();
}

$task = new Task($pdo);
$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $task->createTask($userId, $_POST['title'], $_POST['description']);

        echo '<div class="alert alert-success text-center" role="alert">Tarea Registrada</div>';
    }
}

$tasks = $task->getTasks($userId);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">

        <div class="row">
            <div class="col-md-4">
                <a href="logout.php" class="btn btn-secondary mb-4">Cerrar Sesión</a>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">
                
                <h2 class="text-center">Crear Tarea</h2>
                <form action="dashboard.php" method="POST" class="mb-4">
                    <div class="form-group">
                        <label for="title">Título</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <input type="hidden" name="create" value="1">
                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Crear Tarea</button>
                </form>
            </div>
            <div class="col-md-6">
                
                <h2 class="text-center">Tus Tareas</h2>
                <!-- Aquí va la lista de tareas -->
                <ul class="list-group">
                    <?php
                    foreach ($tasks as $task): ?>
                        <li class="list-group-item">
                            <h5><?php echo htmlspecialchars($task['title']); ?></h5>
                            <p><?php echo htmlspecialchars($task['description']); ?></p>
                            <small>Estado: 
                            <?php
                            if($task['status'] == 'pending'){
                                echo '<span class="badge badge-primary">Pending</span>';
                            }
                            elseif($task['status'] == 'in_progress'){
                                echo '<span class="badge badge-secondary">In Progress</span>';
                            }
                            elseif($task['status'] == 'completed'){
                                echo '<span class="badge badge-success">Completed</span>';
                            }
                            elseif($task['status'] == 'danger'){
                                echo '<span class="badge badge-danger">Danger</span>';
                            }
                            elseif($task['status'] == 'warning'){
                                echo '<span class="badge badge-warning">Warning</span>';
                            }
                            ?></small>                       
                            <div class="mt-2">
                                <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="delete_task.php?id=<?php echo $task['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                            </div>
                        </li>
                    <?php
                    endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>