<?php

echo "<h1>Teste de Conexão com o Banco de Dados</h1>";

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../database/Database.php';

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();

    $dbName = $pdo->query('select database()')->fetchColumn();
    echo "<p style='color: green; font-weight: bold;'>Conexão com o banco de dados '{$dbName}' estabelecida com sucesso!</p>";

} catch (PDOException $e) {
    echo "<p style='color: red; font-weight: bold;'>FALHA na conexão com o banco de dados.</p>";
    echo "<p><strong>Erro:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<hr>";
    echo "<h3>O que verificar:</h3>";
    echo "<ul>";
    echo "<li>O servidor Apache e o MySQL estão rodando no XAMPP?</li>";
    echo "<li>As credenciais no arquivo <strong>database/Database.php</strong> estão corretas? (hostname, database, username, password, port)</li>";
    echo "<li>O banco de dados 'to_do' realmente existe no seu MySQL (via phpMyAdmin)?</li>";
    echo "</ul>";
}