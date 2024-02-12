<?php
   session_start();

   // Verificar se as variáveis de sessão não estão definidas
   if (!isset($_SESSION['cpf_user']) || !isset($_SESSION['senha_user'])) {
       // Destruir as variáveis de sessão
       unset($_SESSION['cpf_user']);
       unset($_SESSION['senha_user']);
   
       // Redirecionar para a página de login
       header('Location: ../login.html');
       exit(); // Certifique-se de sair após o redirecionamento
   }
   // Verificar se o botão de logout foi clicado
    if (isset($_POST['logout'])) {
        // Encerrar a sessão
        session_destroy();

        // Redirecionar para a página de login (ou outra página desejada)
        header("Location: login.html");
        exit();
    }
    $logado = $_SESSION['cpf_user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>HOME</h1>
    <form method="post" action="">
        <input type="submit" name="logout" value="Logout">
    </form>

    <br>
    <form action="#" method="POST" id="opcoes">
                <label for="opcao">Matriucla Desejada:</label>
                <!-- <select id="opcao" name="op_matricula"> -->
                <?php
                     include_once('./Controller/conexao.php');

                    // Verifique se a conexão foi bem-sucedida
                    if (!$conexao) {
                        die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
                    }
                    

                    // Evitar SQL Injection usando prepared statements
                    $query = "SELECT matricula FROM funcionarios WHERE usuarios_cpf_user = ?";
                    $stmt = mysqli_prepare($conexao, $query);
                    mysqli_stmt_bind_param($stmt, "s", $logado);
                    mysqli_stmt_execute($stmt);
                    $resultado = mysqli_stmt_get_result($stmt);

                    // Tratamento de erros
                    if (!$resultado) {
                        echo 'error';
                        die("Erro na execução da consulta: " . mysqli_error($conexao));
                    }

                

                    // Gerar opções para o elemento select
                    while ($linha = mysqli_fetch_assoc($resultado)) {
                        echo "<h2 name='{$linha['matricula']}'>{$linha['matricula']}</h2>";
                    } 
                    // Verificar se o loop não produziu nenhum botão
                    if (mysqli_num_rows($resultado) === 0) {
                        echo "Não há dados disponíveis.";
                    }

                    // Feche a conexão com o banco de dados
                    mysqli_close($conexao);
                    ?> 
                 <!-- </select>
                <button type="submit" class="btnuser2" name="submit">Entrar</button> -->
                
</body>
</html>