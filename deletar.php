<?php
    @$login = $_COOKIE['login'];
    @$login_data = explode(",", $login);
    if (!isset($login)) {
        echo "<script>window.location.href = 'login.php'</script>";
    } else if ($login_data[3] !== 'escolas'){
        echo "<script>window.location.href = 'erro.php?msg_id=1'</script>";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exclusão de Dados</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imgs/favicon.png" type="image/x-icon">    <script>
        function getMonth(year, month, day, elementId, place='innerHTML'){
            const element = document.querySelector(`#${elementId}`)
            const o_monthStr = new Date(year, month, day).toLocaleString('pt-br', { month: 'long' })
            const monthStr = o_monthStr.slice(0, 1).toUpperCase() + o_monthStr.slice(1, o_monthStr.length)
            element[place] = monthStr
        }
    </script>
</head>
<body>
    <?php 
        require "help_files/menu.php";
        require "help_files/db.php";
        $id = $_GET['id'];
        $type = $_GET['type'];
    ?>
    
    <div class="container">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                if($type === 'emp') {
                    $query_select = "SELECT * FROM empresas WHERE id = '$id'";
                    $select_result = mysqli_query($mysql, $query_select);
                    $array_select = mysqli_fetch_all($select_result, MYSQLI_ASSOC);

                    $row = $array_select[0];
                    $o_nomeEmpresa = $row['nome'];
                    $o_nomeResponsavel = mysqli_fetch_array(mysqli_query($mysql, "SELECT nome FROM usuarios_empresas WHERE empresa_id = '$id'"))['nome'];
                    $o_cnpj = $row['cnpj'];
                    $o_telefone = $row['telefone'];
                    $o_email = $row['email'];
                    $o_cep = $row['cep'];
                    $o_logradouro = $row['logradouro'];
                    $o_num = $row['num'];
                    $o_bairro = $row['bairro'];
                    $o_complemento = $row['complemento'];
                    $o_cidade = $row['cidade'];
                    $o_estado = $row['estado'];
        ?>
                    <div class="main_form">
                        <h1>Exclusão de Dados</h1>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id . '&type=' . $type?>" method="post" class="form">
                            <h3>Dados Gerais<br></h3>
                            <label for="nomeEmpresa">Nome da Empresa</label>
                            <input type="text" name="nomeEmpresa" id="nomeEmpresa" value="<?php echo $o_nomeEmpresa ?>" readonly>
                            <label for="nomeResponsavel">Nome Responsável</label>
                            <input type="text" name="nomeResponsavel" id="nomeResponsavel" value="<?php echo $o_nomeResponsavel ?>" readonly>
                            <label for="cnpj">CNPJ</label>
                            <input type="text" name="cnpj" id="cnpj" value="<?php echo $o_cnpj ?>" readonly>
                            <label for="telefone">Telefone</label>
                            <input type="text" name="telefone" id="telefone" value="<?php echo $o_telefone ?>" readonly>
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" value="<?php echo $o_email ?>" readonly>
                            <h3>Endereço<br></h3>
                            <div class="campoEndereco" style="text-align: center; width: 185px">
                                <label for="cep">CEP</label>
                                <input type="text" name="cep" id="cep" value="<?php echo $o_cep ?>">
                            </div>
                            <div class="enderecoArea">
                                <div class="campoEndereco">
                                    <label for="logradouro">Logradouro</label>
                                    <input type="text" name="logradouro" id="logradouro" value="<?php echo $o_logradouro ?>" readonly>
                                </div>
                                <div class="campoEndereco">
                                    <label for="num">Número</label>
                                    <input type="text" name="num" id="num" value="<?php echo $o_num ?>" readonly>
                                </div>
                                <div class="campoEndereco">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" name="bairro" id="bairro" value="<?php echo $o_bairro ?>" readonly>
                                </div>
                                <div class="campoEndereco">
                                    <label for="complemento">Complemento</label>
                                    <input type="text" name="complemento" id="complemento" value="<?php echo $o_complemento ?>" readonly>
                                </div>
                                <div class="campoEndereco">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" name="cidade" id="cidade" value="<?php echo $o_cidade ?>" readonly>
                                </div>
                                <div class="campoEndereco">
                                    <label for="estado">Estado</label>
                                    <input type="text" name="estado" id="estado" value="<?php echo $o_estado ?>" readonly>
                                </div>                 
                            </div>
                            <div class="btns">
                                <input type="button" value="Voltar" class="goBack" onclick="window.history.back()">
                                <input type="button" value="Excluir" class="submitBtn">
                            </div>
                        </form>  
        <?php
                } else if($type === 'rel'){
                    $query_select = "SELECT * FROM relatorios WHERE id = '$id'";
                    $select_result = mysqli_query($mysql, $query_select);
                    $array_select = mysqli_fetch_all($select_result, MYSQLI_ASSOC);

                    $row = $array_select[0];
                    $o_mes = $row['mes'];
                    $o_ano = $row['ano'];
                    $o_empresa_id = $row['empresa_id'];
                    $o_dados_empresa = mysqli_fetch_array(mysqli_query($mysql, "SELECT * FROM empresas WHERE id = '$o_empresa_id'"));
                    $o_cnpj_empresa = $o_dados_empresa['cnpj'];
                    $local_arquivo = $row['local_arquivo'];
                    $arquivo = substr($local_arquivo, strrpos($local_arquivo, '/') + 1);
        ?>
                    <div class="main_form">
                        <h1>Exclusão de Dados</h1>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id . '&type=' . $type?>" method="post" class="form" enctype="multipart/form-data" >
                            <label for="cnpj">CNPJ</label>
                            <input type="text" name="cnpj" id="cnpj" value="<?php echo $o_cnpj_empresa ?>" readonly>
                            <label for="mes">Mês</label>
                            <input type="text" name="mes" id="mes_text" readonly>
                            <script>getMonth(<?php echo $o_ano ?>, <?php echo $o_mes-1 ?>, 1, 'mes_text', 'value')</script>
                            <label for="ano">Ano</label>
                            <input type="text" name="ano" id="ano_text" value="<?php echo $o_ano ?>">
                            <label for="relatorio">Arquivo <a href="<?php echo $local_arquivo ?>" download style="text-decoration: underline; margin: 2px 0;"><i class="fa-solid fa-download"></i></a></label>
                            <input type="text" value="<?php echo $arquivo ?>" readonly>
                            <div class="btns">
                                <input type="button" value="Voltar" class="goBack" onclick="window.history.back()">
                                <input type="button" value="Excluir" class="submitBtn">
                            </div>
                        </form>
        <?php
                }
            }
        ?>
                    <div class="responseMsg"></div>
                </div>
    </div>
    <script src="js/main.js"></script>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            date_default_timezone_set('America/Sao_Paulo');
            if($type === 'emp'){
                $query_deleteUser = "DELETE FROM usuarios_empresas WHERE empresa_id = '$id'";
                $deleteUser_action = mysqli_query($mysql, $query_deleteUser);

                if ($deleteUser_action){
                    $query_deleteRelatoriosEmpresa = "DELETE FROM relatorios WHERE empresa_id = '$id'";
                    $deleteRelatoriosEmpresa_action = mysqli_query($mysql, $query_deleteRelatoriosEmpresa);
                    if($deleteRelatoriosEmpresa_action){
                        $cnpj = mysqli_fetch_array(mysqli_query($mysql, "SELECT cnpj FROM empresas WHERE id = '$id'"))[0];
                        $query_deleteEmpresa = "DELETE FROM empresas WHERE id = '$id'";
                        $deleteEmpresa_action = mysqli_query($mysql, $query_deleteEmpresa);
                        if($deleteEmpresa_action){
                            $dir = str_replace('\\', '/', __DIR__) . '/' . 'relatorios/' . $cnpj;
                            foreach(scandir($dir) as $file){
                                @unlink("$dir/$file");
                            }
                            if(rmdir(str_replace('\\', '/', __DIR__) . '/' . 'relatorios/' . $cnpj)){
                                echo "<script>finishAction(`Exclusão Realizada com Sucesso!<br><br>Você será redirecionado para a lista de empresas em `, 'empresas.php')</script>";
                            } else {
                                echo "<script>finishAction('Não foi possível realizar a exclusão dessa empresa!<br><br>A página irá recarregar em ', window.location.pathname)</script>";
                            }
                        }
                        else {
                            echo "<script>finishAction('Não foi possível realizar a exclusão dessa empresa!<br><br>A página irá recarregar em ', window.location.pathname)</script>";
                        }
                    }
                    else {
                        echo "<script>finishAction('Não foi possível realizar a exclusão dessa empresa!<br><br>A página irá recarregar em ', window.location.pathname)</script>";
                    }
                } else {
                    echo "<script>finishAction('Não foi possível realizar a exclusão dessa empresa!<br><br>A página irá recarregar em ', window.location.pathname)</script>";
                }
            } else if($type === 'rel'){
                $local_arquivo = mysqli_fetch_array(mysqli_query($mysql, "SELECT local_arquivo FROM relatorios WHERE id = '$id'"))["local_arquivo"];
                $dir = str_replace('\\', '/', __DIR__) . '/' . explode("./", $local_arquivo)[1];

                if (unlink($dir)){
                    $query_deleteEmpresa = "DELETE FROM relatorios WHERE id = '$id'";
                    $deleteEmpresa_action = mysqli_query($mysql, $query_deleteEmpresa);
                    if($deleteEmpresa_action){
                        echo "<script>finishAction('Exclusão Realizada com Sucesso!<br><br>Você será redirecionado para a lista de relatórios em ', 'relatorios.php')</script>";
                    } else {
                        echo "<script>finishAction('Não foi possível realizar a exclusão desse relatório!<br><br>A página irá recarregar em ', window.location.pathname)</script>";
                    }
                } else {
                    echo "<script>finishAction('Não foi possível realizar a exclusão desse relatório!<br><br>A página irá recarregar em ', window.location.pathname)</script>";
                }
            }
        }
    ?>
</body>
</html>