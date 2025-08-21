<?php
require_once('../database/Database.php');
require_once('../src/Auth.php');

$db = Database::getInstance()->getConnection();
$auth = new Auth($db);
$auth->checkLogin();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" type="image/png" href="assets/favicon.png">
    <title>Momento com Jah</title>
</head>
<body>
    <div id="jah_moment">
        <a href="index.php" class="end-meditation-button">
            Encerrar meditação com Jah
        </a>

        <h1 class="jah-banner">
            Relaxe com Jah
        </h1>

        <div id="music-player">

            <audio id="audio-player" src="assets/musicaRasta.mp3"></audio>
            <div class="player-controls">
                <button id="play-pause-btn" class="control-button">
                    <i class="fa-solid fa-play"></i>
                </button>
                <div class="progress-container">
                    <div class="progress-bar"></div>
                </div>
                <div class="time-display">
                    <span id="current-time">0:00</span> / <span id="total-time">0:00</span>
                </div>
            </div>
        </div>
    </div>

    <a href="logout.php" class="logout-button" title="Sair">
        <i class="fa-solid fa-right-from-bracket"></i> Sair
    </a>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/script.js"></script>
</body>
</html>