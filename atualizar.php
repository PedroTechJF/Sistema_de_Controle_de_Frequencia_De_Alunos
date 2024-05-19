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
    <title>Atualização de Dados</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imgs/favicon.png" type="image/x-icon">
    <script>
        function getMonth(year, month, day, elementId){
            const element = document.querySelector(`#${elementId}`)
            const o_monthStr = new Date(year, month, day).toLocaleString('pt-br', { month: 'long' })
            const monthStr = o_monthStr.slice(0, 1).toUpperCase() + o_monthStr.slice(1, o_monthStr.length)
            element.innerHTML = monthStr
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
                    $o_nomeResponsavel = ucwords(strtolower(mysqli_fetch_array(mysqli_query($mysql, "SELECT nome FROM usuarios_empresas WHERE empresa_id = '$id'"))['nome']));
                    $o_cnpj = $row['cnpj'];
                    $o_telefone = $row['telefone'];
                    $o_email = strtolower($row['email']);
                    $o_cep = $row['cep'];
                    $o_logradouro = ucwords(strtolower($row['logradouro']));
                    $o_num = $row['num'];
                    $o_bairro = ucwords(strtolower($row['bairro']));
                    $o_complemento = ucwords(strtolower($row['complemento']));
                    $o_cidade = ucwords(strtolower($row['cidade']));
                    $o_estado = strtoupper($row['estado']);
        ?>
                    <div class="main_form">
                        <h1>Atualização de Dados</h1>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id . '&type=' . $type?>" method="post" class="form">
                            <h3>Dados Gerais<br></h3>
                            <label for="nomeEmpresa">Nome da Empresa</label>
                            <input type="text" name="nomeEmpresa" id="nomeEmpresa" value="<?php echo $o_nomeEmpresa ?>">
                            <label for="nomeResponsavel">Nome Responsável</label>
                            <input type="text" name="nomeResponsavel" id="nomeResponsavel" value="<?php echo $o_nomeResponsavel ?>">
                            <label for="cnpj">CNPJ</label>
                            <input type="text" name="cnpj" id="cnpj" value="<?php echo $o_cnpj ?>" readonly>
                            <label for="telefone">Telefone</label>
                            <input type="text" name="telefone" id="telefone" value="<?php echo $o_telefone ?>">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" value="<?php echo $o_email ?>">
                            <h3>Endereço<br></h3>
                            <div class="campoEndereco" style="text-align: center; width: 185px">
                                <label for="cep">CEP</label>
                                <input type="text" name="cep" id="cep" value="<?php echo $o_cep ?>">
                            </div>
                            <div class="enderecoArea">
                                <div class="campoEndereco">
                                    <label for="logradouro">Logradouro</label>
                                    <input type="text" name="logradouro" id="logradouro" value="<?php echo $o_logradouro ?>">
                                </div>
                                <div class="campoEndereco">
                                    <label for="num">Número</label>
                                    <input type="text" name="num" id="num" value="<?php echo $o_num ?>">
                                </div>
                                <div class="campoEndereco">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" name="bairro" id="bairro" value="<?php echo $o_bairro ?>">
                                </div>
                                <div class="campoEndereco">
                                    <label for="complemento">Complemento</label>
                                    <input type="text" name="complemento" id="complemento" value="<?php echo $o_complemento ?>">
                                </div>
                                <div class="campoEndereco">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" name="cidade" id="cidade" value="<?php echo $o_cidade ?>">
                                </div>
                                <div class="campoEndereco">
                                    <label for="estado">Estado</label>
                                    <input type="text" name="estado" id="estado" value="<?php echo $o_estado ?>">
                                </div>                 
                            </div>
                            <div class="btns">
                                <input type="button" value="Voltar" class="goBack" onclick="window.history.back()">
                                <input type="button" value="Atualizar" class="submitBtn">
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
                    $o_local_arquivo = $row['local_arquivo'];
                    $o_dados_empresa = mysqli_fetch_array(mysqli_query($mysql, "SELECT * FROM empresas WHERE id = '$o_empresa_id'"));
                    $o_cnpj_empresa = $o_dados_empresa['cnpj'];
        ?>
                    <div class="main_form">
                        <h1>Atualização de Dados</h1>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id . '&type=' . $type?>" method="post" class="form" enctype="multipart/form-data">
                            <label for="cnpj">CNPJ</label>
                            <input type="text" name="cnpj" id="cnpj" value="<?php echo $o_cnpj_empresa ?>">
                            <label for="mes">Mês</label>
                            <select name="mes" id="mes_select">
                                <optgroup label="Dado Original">
                                    <option id="o_mes" value="<?php echo $o_mes < 10 ? 0 . $o_mes : $o_mes ?>"><script>getMonth(<?php echo $o_ano ?>, <?php echo $o_mes-1 ?>, 1, "o_mes")</script></option>
                                </optgroup>
                                <optgroup label="Selecione um Mês">
                                    <option value="01">Janeiro</option>
                                    <option value="02">Fevereiro</option>
                                    <option value="03">Março</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Maio</option>
                                    <option value="06">Junho</option>
                                    <option value="07">Julho</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Setembro</option>
                                    <option value="10">Outubro</option>
                                    <option value="11">Novembro</option>
                                    <option value="12">Dezembro</option>
                                </optgroup>
                            </select>
                            <label for="ano">Ano</label>
                            <select name="ano" id="ano_select">
                                <optgroup label="Dado Original">
                                    <option value="<?php echo $o_ano ?>"><?php echo $o_ano ?></option>
                                </optgroup>
                                <optgroup label="Selecione um Ano">
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                </optgroup>
                            </select>
                            <label for="">Arquivo <a href="<?php echo $o_local_arquivo ?>" download style="text-decoration: underline; margin: 2px 0;"><i class="fa-solid fa-download"></i></a></label>
                            <label for="relatorio_up">Enviar Arquivo</label>
                            <input type="file" name="relatorio" id="relatorio_up" accept="application/pdf">
                            <div class="btns">
                                <input type="button" value="Voltar" class="goBack" onclick="window.history.back()">
                                <input type="button" value="Atualizar" class="submitBtn">
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
                $nomeEmpresa = strtoupper($_POST['nomeEmpresa']);
                $nomeResponsavel = ucwords(strtolower($_POST['nomeResponsavel']));
                $cnpj = $_POST['cnpj'];
                $email = strtoupper($_POST['email']);
                $telefone = $_POST['telefone'];
                
                $cep = $_POST['cep'];
                $logradouro = strtoupper($_POST['logradouro']);
                $num = $_POST['num'];
                $bairro = strtoupper($_POST['bairro']);
                $complemento = strtoupper($_POST['complemento']);
                $cidade = strtoupper($_POST['cidade']);
                $estado = strtoupper($_POST['estado']);

                $login = explode('@', $email)[0] . "_" . substr($cnpj, 0, 4);
                // $senha_o = explode('.', explode('@', $email)[1])[0] . "_" . substr($cnpj, 10, 14);
                // $senha = md5($senha_o);
    
                $query_updateEmpresa = "UPDATE empresas SET nome = \"$nomeEmpresa\", cnpj = \"$cnpj\", telefone = \"$telefone\", email = \"$email\", cep = \"$cep\", logradouro = \"$logradouro\", num = \"$num\", bairro = \"$bairro\", complemento = \"$complemento\", cidade = \"$cidade\", estado = \"$estado\" WHERE id = \"$id\"";
                $updateEmpresa_action = mysqli_query($mysql, $query_updateEmpresa);
    
                if ($updateEmpresa_action){
                    // echo "<script>finishAction('Atualização Realizada com Sucesso!<br><br><br><br>Você será redirecionado em ', 'empresas.php')</script>";

                    $query_updateUser = "UPDATE usuarios_empresas SET login = \"$login\", nome = \"$nomeResponsavel\" WHERE empresa_id = '$id'";
                    $updateUser_action = mysqli_query($mysql, $query_updateUser);

                    if($updateUser_action){
                        echo "<script>finishAction(`Atualização Realizada com Sucesso!<br><br>Usuário: $login<br><br><div class='btns'><input type='button' value='Listar Empresas' class='btnsChild' onclick='window.location.href = \"empresas.php\"'><input type='button' value='Enviar Relatório' class='btnsChild' onclick='window.location.href = \"enviar_relatorio.php?cnpj=$cnpj\"'></div>`, null, 0)</script>";
                    } else {
                        echo "<script>finishAction('Não foi possível realizar a atualização dos dados dessa empresa!<br><br>Você será redirecionado em ', 'empresas.php')</script>";
                    }
                } else {
                    echo "<script>finishAction('Não foi possível realizar a atualização dos dados dessa empresa!<br><br>Você será redirecionado em ', 'empresas.php')</script>";
                }
            } else if($type === 'rel'){
                $cnpj = $_POST['cnpj'];
                $mes = $_POST['mes'];
                $ano = $_POST['ano'];
                $relatorio = $_FILES['relatorio'];
                $data = date("Y-m-d");
                $local_arquivo_o = mysqli_fetch_array(mysqli_query($mysql, "SELECT local_arquivo FROM relatorios WHERE id = '$id'"))["local_arquivo"];

                $filename = 'frequencia-alunos_' . $mes . '-' . $ano . '.pdf';
                $local_arquivo = './relatorios/' . $cnpj . '/' . $filename;

                if(move_uploaded_file($relatorio["tmp_name"], $local_arquivo)){
                    $query_atualizarRelatorio = "UPDATE relatorios SET mes = \"$mes\", ano = \"$ano\", local_arquivo = \"$local_arquivo\", data_criacao = \"$data\" WHERE id = '$id'";
                    $atualizarRelatorio_action = mysqli_query($mysql, $query_atualizarRelatorio);
        
                    if ($atualizarRelatorio_action){
                        echo "<script>finishAction('Relatório Atualizado com Sucesso!<br><br>A página irá recarregar em ', 'relatorios.php')</script>";
                    } else {
                        echo "<script>finishAction('Não foi possível realizar a atualização desse relatório!<br><br>A página irá recarregar em ', 'relatorios.php')</script>";
                    }
                } else {
                    echo "<script>finishAction('Não foi possível realizar a atualização desse relatório!<br><br>A página irá recarregar em ', 'relatorios.php')</script>";
                }
            }
        }
    ?>
</body>
</html>