<?php
    @$login = $_COOKIE['login'];
    @$login_data = explode(",", $login);
    if (isset($login)) {
        echo "<script>window.location.href = 'index.php'</script>";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imgs/favicon.png" type="image/x-icon"></head>
<body>
    <?php require "help_files/menu_inicial.php" ?>
    <div class="container">
        <div class="main_form">
            <h1>Login</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="form">
                <label for="login">Usuário</label> 
                <input type="text" name="login" id="login">
                <label for="senha">Senha</label> 
                <input type="password" name="senha" id="senha">
                <input type="text" name="perfil" id="perfilFinal" value="escolas" hidden>
                <div class="perfisArea">
                    <div class="perfilEscola">
                        <input type="radio" name="escola" value="escolas" id="perfil_escola" class="perfis" checked>
                        <label for="perfil_escola">Escola</label> 
                    </div>
                    <div class="perfilEmpresa">
                        <input type="radio" name="empresa" value="empresas" id="perfil_empresa" class="perfis">
                        <label for="perfil_empresa">Empresa</label> 
                    </div>
                </div>
                <input type="button" class="submitBtn" value="Entrar">
            </form>
            <div class="responseMsg"></div>
        </div>
    </div>
    <script src="js/main.js"></script>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require "help_files/db.php";

            $login = $_POST['login'];
            $senha = md5($_POST['senha']);
            $perfil = $_POST['perfil'];
            $tabela = 'usuarios_' . $perfil;
            $id_inst_name = substr($perfil, 0, -1) . '_id';
            $query_select = "SELECT * FROM " . $tabela . " WHERE login = '$login' AND senha = '$senha'";

            $select_result = mysqli_query($mysql, $query_select);
            $array_select = mysqli_fetch_array($select_result);

            if ($array_select === false || $array_select === null) {
                echo "<script>responseMsgField.innerHTML = 'Usuário ou Senha Incorretos!'</script>";
                die();
            } else {
                $id_inst = $array_select[$id_inst_name];
                $query_getInstData = "SELECT * FROM $perfil WHERE id = '$id_inst'";
                $getInstData_result = mysqli_query($mysql, $query_getInstData);
                $array_getInstData = mysqli_fetch_array($getInstData_result);
                
                @$email = $array_getInstData["email"];
                @$cnpj = $array_getInstData["cnpj"];
                @$senha_o = explode('.', explode('@', $email)[1])[0] . "_" . substr($cnpj, 10, 14);
                @$senha_o_md5 = md5($senha_o);
                if($perfil === 'empresas' && $array_select['senha'] === $senha_o_md5){
                    setcookie('al_s', true);
                    echo "<script>finishAction('Você deve alterar sua senha para continuar!<br><br>Você será redirecionado em ', 'atualizar_senha.php?user=$login&pass=$senha');</script>";
                    die();
                }

                setcookie('login', implode(",", [$array_select["nome"], $array_getInstData["nome"], $array_getInstData["id"], $perfil]));
                echo "<script>window.location.href='index.php'</script>";
                die();
            }
        }
    ?>
</body>
</html>