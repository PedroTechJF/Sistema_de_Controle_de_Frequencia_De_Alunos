<?php
    if (basename(__FILE__, '') === basename($_SERVER['SCRIPT_FILENAME'], '')) {
        echo "<script>window.location.href = '../erro.php?msg_id=1'</script>";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imgs/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar nav_inicial">
        <div class="navbar_left navbar_section">
            <?php
                @$login = $_COOKIE['login'];
                $login_data = explode(",", $login);
                if (isset($login)) {
                    echo "<a href='index.php'>" . $login_data[1] . "</a>";
                    if($login_data[3] === "escolas"){
                        echo '<div class="pages">
                        <a href="cadastro_empresa.php" class="page">Cadastrar Empresa</a>
                        <a href="empresas.php" class="page">Listar Empresas</a>
                        <a href="enviar_relatorio.php" class="page">Enviar Relatórios</a>
                        <a href="relatorios.php" class="page">Listar Relatórios</a>
                        </div>
                        </div>
                        <div class="navbar_right navbar_section searchArea" id="searchDiv">
                        <a href="logout.php" class="btnLogin">Sair</a>
                        </form>
                        </div>';
                    } else {
                        echo '<div class="pages">
                        <a href="relatorios.php" class="page">Listar Relatórios</a>
                        </div>
                        </div>
                        <div class="navbar_right navbar_section">
                        <a href="logout.php" class="btnLogin">Sair</a>
                        </div>';
                    }
                } else {
                    echo "<a href='index.php'>Sistema de Controle de Frequência de Alunos</a></div>";
                };
            ?>
    </nav>
</body>
</html>