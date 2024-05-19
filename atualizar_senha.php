<?php
    @$al_s = $_COOKIE['al_s'];
    if (!isset($al_s)) {
        echo "<script>window.location.href = 'login.php'</script>";
        die();
    }
    if(isset($_GET['user']) && isset($_GET['pass'])){
        $usuario = $_GET['user'];
        $senha = $_GET['pass'];
    } else {
        $usuario = "";
        $senha = "";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização de Senha</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imgs/favicon.png" type="image/x-icon"></head>
<body>
    <?php
        @$login = $_COOKIE['login'];
        $file = isset($login) ? 'menu.php' : 'menu_inicial.php';
        require "help_files/$file" 
    ?>
    <div class="container">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
        ?>
                <div class="main_form">
                    <h1>Atualização de Senha</h1>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form">
                        <label for="usuario">Usuário</label>
                        <input type="text" name="usuario" id="usuario" value="<?php echo $usuario; ?>">
                        <label for="old_senha">Senha</label>
                        <input type="password" name="old_senha" id="old_senha" <?php echo $senha !== "" ? "value=$senha readonly" : null ?>>
                        <label for="nova_senha">Nova Senha</label>
                        <input type="password" name="nova_senha" id="nova_senha">
                        <input type="button" value="Atualizar" class="submitBtn">
                    </form>
        <?php
            }
        ?>
            <div class="responseMsg"></div>
        </div>
    </div>
    <script src="js/main.js"></script>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require 'help_files/db.php';
            date_default_timezone_set('America/Sao_Paulo');
            @$httpFile = basename($_SERVER['SCRIPT_FILENAME'], '');
            @$httpSearch = explode('?', $_SERVER['HTTP_REFERER'])[1];
            @$httpRequest = isset($httpSearch) === true ? "$httpFile?$httpSearch" : "$httpFile";

            $usuario = $_POST['usuario'];
            $senha = $_POST['old_senha'];
            $nova_senha = $_POST['nova_senha'];
            $senha_md5 = strlen($senha) <= 30 ? md5($senha) : $senha;
            $nova_senha_md5 = md5($nova_senha);
            
            @$usuario_empresa = mysqli_fetch_assoc(mysqli_query($mysql, "SELECT * FROM usuarios_empresas WHERE login = '$usuario' AND senha = '$senha_md5'"));
            @$id_empresa = $usuario_empresa['empresa_id'];
            @$dados_empresa = mysqli_fetch_assoc(mysqli_query($mysql, "SELECT * FROM empresas WHERE id = '$id_empresa'"));
            @$senha_o = explode('.', explode('@', $dados_empresa['email'])[1])[0] . "_" . substr($dados_empresa['cnpj'], 10, 14);
            @$senha_o_md5 = md5($senha_o);

            if(!isset($usuario_empresa)){
                echo "<script>finishAction('Usuário ou Senha Incorretos!<br><br>A página irá recarregar em ', '$httpRequest')</script>";
                die();
            } else if($senha_md5 === $nova_senha_md5){
                echo "<script>finishAction('A nova senha deve ser diferente da atual!<br><br>A página irá recarregar em ', '$httpRequest')</script>";
                die();
            } else if($senha_o_md5 === $nova_senha_md5){
                echo "<script>finishAction('A nova senha não pode ser igual a senha original!<br><br>A página irá recarregar em ', '$httpRequest')</script>";
                die();
            }

            $id_usuario = $usuario_empresa['id'];
            $query_editarUsuario = "UPDATE usuarios_empresas SET senha = '$nova_senha_md5' WHERE id = '$id_usuario'";
            $update_editarUsuario = mysqli_query($mysql, $query_editarUsuario);

            if ($update_editarUsuario){
                echo "<script>finishAction('Senha atualizada com Sucesso!<br><br>A página irá recarregar em ', 'index.php')</script>";
            } else {
                echo "<script>finishAction('Não foi possível realizar a alteração de senha!<br><br>A página irá recarregar em ', '$httpRequest')</script>";
            }
            unset($al_s);
            setcookie('al_s', '', -1);
        }
    ?>
</body>
</html>