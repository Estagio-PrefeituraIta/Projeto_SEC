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
    echo '<script>
            // Exibir o alerta com opções
            var confirmLogout = confirm("Deseja Sair?");

            // Verificar a escolha do usuário
            if (confirmLogout) {
                // Se confirmado, encerra a sessão e redireciona
                alert("Sessão encerrada!");
                // Encerrar a sessão
                `session_destroy();`

                // Redirecionar para a página de login (ou outra página desejada)
                window.location.href = "../login.html";
            } else {
                // Se não confirmado, continua
                alert("Sessão não encerrada");
            }
          </script>';
}
$logado = $_SESSION['cpf_user'];
// print_r($logado);
?>

<!DOCTYPE html>
<html lang="pt-br">

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

    <?php
    include_once('../Controller/conexao.php');

    // Verifique se a conexão foi bem-sucedida
    if (!$conexao) {
        die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
    }


    // Evitar SQL Injection usando prepared statements
    $query = "SELECT id_matricula , matricula FROM funcionarios WHERE usuarios_cpf_user = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "s", $logado);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    // Tratamento de erros
    if (!$resultado) {
        echo 'error';
        die("Erro na execução da consulta: " . mysqli_error($conexao));
    }

    // Obtém a quantidade de linhas retornadas
    $num_rows = mysqli_num_rows($resultado);

    // Exibe a quantidade de linhas
    echo "Matriculas Encontradas: " . $num_rows;

    // Buscar Matriculas e Ano 
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $idmatricula = $linha['id_matricula'];
        $matricula = $linha['matricula'];
        // Consulta SQL para buscar os anos para uma matrícula específica
        $consultaAnos = "SELECT DISTINCT ano FROM variavel WHERE matricula = $idmatricula";
        $resultadoAnos = mysqli_query($conexao, $consultaAnos);

        // Verificar se a consulta foi bem-sucedida
        if ($resultadoAnos) {
            echo "<h3>Nº Matrícula: {$linha['matricula']}</h3>";

            // Verificar se há dados retornados
            if (mysqli_num_rows($resultadoAnos) > 0) {
                // campo de entrada oculto passando o id da matricula
                echo "<form method='POST' action='../Model/consultar_cpf.php'>
                <input type='hidden' name='id_matricula' value='$idmatricula'>
                <input type='hidden' name='matricula' value='$matricula'>
                <select name='ano'>";

                // Loop para exibir os botões com os anos
                while ($linhaAno = mysqli_fetch_assoc($resultadoAnos)) {
                    $ano = $linhaAno['ano'];
                    echo "<option value='$ano'>$ano</option>";
                }

                echo "</select>
                <button type='submit' >Consultar</button></form>";

                // Liberar resultado da consulta de anos
                mysqli_free_result($resultadoAnos);
            } else {
                echo "Não há anos disponíveis para esta matrícula.";
            }
        } else {
            // Tratar erro na consulta de anos, se necessário
            echo "Erro na consulta de anos: " . mysqli_error($suaConexao);
        }

    }
    // Verificar se o loop não produziu nenhum botão
    if (mysqli_num_rows($resultado) === 0) {
        echo "Não há dados disponíveis.";
    }

    // Feche a conexão com o banco de dados
    mysqli_close($conexao);
    ?>
</body>
</html>