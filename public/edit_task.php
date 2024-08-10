<?php
require_once '../config/config.php';
require_once '../src/User.php';
require_once '../src/Task.php';

$user = new User($pdo);
if (!$user->isAuthenticated()) {
    header('Location: login.php');
    exit();
}
if(empty($_GET['id'])){
    header('Location: dashboard.php');
    exit();
}

$task = new Task($pdo);
$userId = $_SESSION['user_id'];

$taskResult = $task->getTask($_GET['id']);
if( count( $taskResult ) == 0 ){

    header('Location: dashboard.php');
    exit();
}

$taskResult = $taskResult[0];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {

        $task->updateTask($_POST['task_id'], $_POST['title'], $_POST['description'], $_POST['status']);
        header('Location: dashboard.php');
    }
}
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
                
                <h2 class="text-center">Editar Tarea</h2>
                <form action="edit_task.php?id=<?php echo $_GET['id']; ?>" method="POST" class="mb-4">
                    <div class="form-group">
                        <label for="title">Título</label>
                        <input type="text" class="form-control" id="title" name="title" required value="<?= $taskResult["title"] ?>">
                    </div>
                    <input type="hidden" name="create" value="1">
                    <input type="hidden" name="task_id" value="<?= $_GET['id'] ?>">
                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required><?= $taskResult["description"] ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="status">Estado</label>
                        <select class="form-control" name="status">
                            <option <?= ($taskResult["status"] == '')?'selected' : '' ?> value="pending">Pending</option>
                            <option <?= ($taskResult["status"] == '')?'selected' : '' ?> value="in_progress">In Progress</option>
                            <option <?= ($taskResult["status"] == '')?'selected' : '' ?> value="completed">Done</option>
                            <option <?= ($taskResult["status"] == '')?'selected' : '' ?> value="danger">Danger</option>
                            <option <?= ($taskResult["status"] == '')?'selected' : '' ?> value="warning">Warning</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">Editar Tarea</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>