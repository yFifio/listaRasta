<?php
session_start();
require_once('../database/Database.php');
require_once('../src/Auth.php');

$db = Database::getInstance()->getConnection();
$auth = new Auth($db);

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';

    if ($auth->login($user, $pass)) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Usuário ou senha inválidos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lista Rasta</title>
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
    <form method="POST" action="login.php">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p style="color: #ef4444; margin-bottom: 15px;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <input type="text" name="username" placeholder="Usuário" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit">Entrar</button>
        <p>Não tem uma conta? <a href="register.php">Cadastre-se</a></p>
    </form>
</body>
</html>