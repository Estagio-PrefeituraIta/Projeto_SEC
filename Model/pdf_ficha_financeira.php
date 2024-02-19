<?php

    session_start();

    include_once('../Controller/conexao.php');

    if (!isset($_SESSION['cpf_user']) || !isset($_SESSION['senha_user'])) {
        // Destruir as variáveis de sessão
        unset($_SESSION['cpf_user']);
        unset($_SESSION['senha_user']);

        // Redirecionar para a página de login
        header('Location: ./login.html');
        exit(); // Certifique-se de sair após o redirecionamento
    }

    $logado = $_SESSION['cpf_user'];
    // print_r($logado);

    // Verifica se os parâmetros 'mes' e 'ano' estão presentes na URL
    if (isset($_GET['ano'], $_GET['id_matricula'], $_GET['NumMatricula'])){
        // Obtém os valores de mês e ano da URL e realiza a sanitização
        $ano = htmlspecialchars($_GET['ano']);
        $id_matricula = htmlspecialchars($_GET['id_matricula']);
        $matricula = htmlspecialchars($_GET['NumMatricula']);

        // Exibe os valores na página
         echo "Ano: " . $ano . "<br>";
         echo "id_matricula: " . $id_matricula . "<br>";
         echo "matricula: " . $matricula;
    } else {
       // Caso os parâmetros não estejam presentes na URL
        header('HTTP/1.1  400 Bad Request');
        echo "Parâmetro de ano não fornecidos na URL.";
        exit();
    }

    // Obter o Nome do usuario
    $query = "SELECT nome_user FROM infor_user WHERE usuarios_cpf_user = '$logado' ";
    $resulta = mysqli_query($conexao, $query);
    while($dados = mysqli_fetch_assoc($resulta)){
        $usuario = $dados['nome_user'];
        echo "<br>Nome: $usuario <br>";
    }

    // Obter o lotação do usuario e cargo
    $query = "SELECT lotacao , cargo FROM funcionarios WHERE  matricula = '$matricula' ";
    $resulta = mysqli_query($conexao, $query);
    while($dados = mysqli_fetch_assoc($resulta)){
        $lotacao = $dados['lotacao'];
        $cargo = $dados['cargo'];

        echo "<br> Locatção: $lotacao";
        echo "<br> Cargo: $cargo <br>";
    }

    // Obter os dados da tabela variável de todos os meses do ano
     //  Se você obtiver resultados duplicados (com meses iguais)
     $query = "SELECT *, matricula, mes, ano, MAX(mes) as mes
     FROM variavel
     WHERE matricula = '$id_matricula' AND ano = '$ano'
     GROUP BY matricula, mes, ano";
    $result = mysqli_query($conexao, $query);
    
    // Obtém a quantidade de linhas retornadas
    $num_rows = mysqli_num_rows($result);
   
    // Verificar se retornou dados
    if (mysqli_num_rows($result) > 0) {
        // Exiba os registros sem repetir o mês e o ano
        while ($linha = mysqli_fetch_assoc($result)) {
            $mes = htmlspecialchars($linha["mes"]);
            $provento = htmlspecialchars($linha['provento']);
            $referencia = $linha['referencia'];
            $valor = $linha['valor'];

            echo "<br>Mes: $mes <br>Provento: $provento <br>Referencia: $referencia <br>Valor: $valor <hr>";
        }
    } else {
        // Nao obteve resultado
        echo '<br>Não encontrei Nada';
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>