<?php
session_start();

require_once __DIR__ . '/../database/Database.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/Task.php';

try {
    $dbConnection = Database::getInstance()->getConnection();
} catch (Exception $e) {
    error_log("Erro de conexão no index.php: " . $e->getMessage());
    die("Ocorreu um problema ao conectar com o servidor. Tente novamente mais tarde.");
}

$auth = new Auth($dbConnection);
$auth->checkLogin();

$taskManager = new Task($dbConnection);

$action = $_POST['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'create') {
        $description = trim($_POST['description'] ?? '');
        $difficulty = $_POST['difficulty'] ?? 'normal';
        if (!empty($description)) {
            $taskManager->createTask($description, $difficulty);
        }
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? 0;
        if ($id > 0) {
            $taskManager->deleteTask($id);
        }
    } elseif ($action === 'toggle') {
        $id = $_POST['id'] ?? 0;
        $completed = isset($_POST['completed']) && $_POST['completed'] == '1' ? 1 : 0;
        if ($id > 0) {
            $taskManager->updateTaskProgress($id, $completed);
        }
    } elseif ($action === 'update') {
        $id = $_POST['id'] ?? 0;
        $description = trim($_POST['description'] ?? '');
        $difficulty = $_POST['difficulty'] ?? 'normal';
        if ($id > 0 && !empty($description)) {
            $taskManager->updateTask($id, $description, $difficulty);
        }
    }
    header('Location: index.php');
    exit;
}

$tasks = $taskManager->getAllTasks();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JahBless</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/style.css">
    <style>
        .hidden { display: none; }
    </style>
</head>
<body>

    <div id="to_do">
        <h1>Lista Rasta</h1>
        <p class="user-greeting">
            Missões de <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guerreiro'); ?>
        </p>

        <form class="to-do-form" method="POST" action="index.php">
            <input type="hidden" name="action" value="create">
            <input type="text" name="description" placeholder="Qual a missão de hoje?" required>
            <select name="difficulty">
                <option value="fácil">Fácil</option>
                <option value="normal" selected>Normal</option>
                <option value="dificil">Difícil</option>
            </select>
            <button type="submit" class="form-button" title="Adicionar Tarefa">
                <i class="fa-solid fa-plus"></i>
            </button>
        </form>

        <div id="tasks">
            <?php foreach ($tasks as $task): ?>
                <div class="task" data-task-id="<?php echo $task['id']; ?>">
                    <div class="task-view">
                        <form method="POST" action="index.php" style="display: contents;">
                            <input type="hidden" name="action" value="toggle">
                            <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                            <input type="hidden" name="completed" value="<?php echo $task['completed'] ? '0' : '1'; ?>">
                            <button type="submit" class="action-button progress" title="Marcar como <?php echo $task['completed'] ? 'não concluída' : 'concluída'; ?>">
                                <i class="fa-regular <?php echo $task['completed'] ? 'fa-square-check' : 'fa-square'; ?>"></i>
                            </button>
                        </form>
                        <span class="task-description <?php echo $task['completed'] ? 'done' : ''; ?>"><?php echo htmlspecialchars($task['description']); ?></span>
                        <span class="task-difficulty difficulty-<?php echo htmlspecialchars($task['difficulty']); ?>"><?php echo htmlspecialchars(ucfirst($task['difficulty'])); ?></span>
                        <div class="task-actions">
                            <button class="action-button edit-btn" title="Editar Tarefa"><i class="fa-solid fa-pencil"></i></button>
                            <form method="POST" action="index.php" style="display: contents;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                <button type="submit" class="action-button delete-button" title="Excluir Tarefa" onclick="return confirm('Tem certeza que quer apagar esta missão?');">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <form class="edit-task hidden" method="POST" action="index.php">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                        <input type="text" name="description" value="<?php echo htmlspecialchars($task['description']); ?>" required>
                        <select name="difficulty">
                            <option value="fácil" <?php echo $task['difficulty'] == 'fácil' ? 'selected' : ''; ?>>Fácil</option>
                            <option value="normal" <?php echo $task['difficulty'] == 'normal' ? 'selected' : ''; ?>>Normal</option>
                            <option value="dificil" <?php echo $task['difficulty'] == 'dificil' ? 'selected' : ''; ?>>Difícil</option>
                        </select>
                        <button type="submit" class="action-button confirm-button" title="Salvar"><i class="fa-solid fa-check"></i></button>
                        <button type="button" class="action-button cancel-button" title="Cancelar"><i class="fa-solid fa-xmark"></i></button>
                    </form>
                </div>
            <?php endforeach; ?>
            <?php if (empty($tasks)): ?>
                <p style="text-align: center; color: #9ca3af;">Nenhuma missão por enquanto. Adicione uma acima!</p>
            <?php endif; ?>
        </div>

        <a href="momento_jah.php" class="jah-moment-button">
            Momento com Jah
        </a>
    </div>

    <a href="logout.php" class="logout-button" title="Sair">
        <i class="fa-solid fa-right-from-bracket"></i> Sair
    </a>

    <script src="js/main.js"></script>
</body>
</html>