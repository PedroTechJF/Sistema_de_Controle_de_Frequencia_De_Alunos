<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Controle de Frequência de Alunos</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imgs/favicon.png" type="image/x-icon"></head>
<body>
    <?php require "help_files/menu_inicial.php" ?>
    
    <div class="container" style="user-select: none!important;">
        <img src="imgs/logo.png" alt="" width="450px">
        <?php
            if (isset($_COOKIE['login'])) {
                echo "<h1>Bem Vindo, " . explode(",", $_COOKIE['login'])[0] . "!</h1>";
            } else {
                echo "<h1>Sistema de Controle de Frequência de Alunos</h1>";
            };
        ?>
    </div>
</body>
</html>