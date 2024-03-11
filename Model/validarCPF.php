<?php
session_start();

//Verifica se clicou no botão e se o cpf não está vazio
if (isset($_POST['submit']) && !empty($_POST['cpf_user'])) {

    //estabele conexão com banco de Dados
    include_once('../Controller/conexao.php');

    //define a variavel local
    $cpf_user = $_POST['cpf_user'];

    //Query no Banco de Dados
    $sql = "SELECT * FROM infor_user  WHERE usuarios_cpf_user = '$cpf_user' ";
    $resulta = $conexao->query($sql);

    //Verifica se o CPF tiver tabela info_user 
    if (mysqli_num_rows($resulta) < 1) {

        include_once('../Controller/conexao.php');
        $sql = "SELECT * FROM usuarios  WHERE cpf_user = '$cpf_user'";
        $result = $conexao->query($sql);

        if (mysqli_num_rows($result) < 1) {
            //Caso não esteja nos dados da prefeitura
            echo "<script>alert(`nao tem vinculo com a prefeitura nao posso cadastrar`)</script>";

        } else {
            echo "<script>alert(`tem vinculo com a prefeitura posso cadastrar`)</script>";

            //pegando o CPF dele e mando como parametro para a URL cadastro
            $parametro1 =$cpf_user;
            $parametroCriptografado = base64_encode($parametro1);
            $url = '../cadastro.html?parametro=' . urlencode($parametroCriptografado);
            header('Location: ' . $url);
            // header('Location: ../cadastro.html');
        }

    } else {
        //Se o CPF tiver tabela info_user 
        echo "<script>
                alert('Você já possui um cadastro.');
                window.location.href = '../login.html';
             </script>";
        exit(); // Make sure to exit after sending the Location header
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- BootStrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
    <title>Validar CPF</title>
</head>

<body>
    <form action="validarCPF.php" method="POST" class="right-content">
        <div class="input-group">
            <label for="cpf">Digite seu CPF:</label>
            <input type="text" id="cpf_user" name="cpf_user" pattern="\d{11}"
                placeholder="Digite apenas o número Ex:12345678901" required>
        </div>
        <a href="cadastro.html">
            <button type="submit" id="login-button" name="submit">Entrar</button>
        </a>
    </form>
    <a href="../login.html">Faça Login</a>

</body>

</html>