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

// Verifica se os parâmetros 'mes' e 'ano' estão presentes na URL
if (isset($_GET['ano'], $_GET['id_matricula'], $_GET['NumMatricula'])) {
    // Obtém os valores de mês e ano da URL e realiza a sanitização
    $ano = htmlspecialchars($_GET['ano']);
    $id_matricula = htmlspecialchars($_GET['id_matricula']);
    $matricula = htmlspecialchars($_GET['NumMatricula']);

    // Adicionar a frase "Relatório Geral" centralizada acima da tabela com os meses
    echo "<div class='center'><h2>Relatório Geral -  Ficha Financeira</h2></div>";

    // Exibir a imagem no topo
    echo "<div class='center'>
            <img class='logo' src='../logo.png' alt='Logo da empresa'>
          </div><br>";

    // Exibe os valores na página
    echo "<table border='1'>
            <tr>
                <th colspan='2'>Informações</th>
            </tr>
            <tr>
                <td><b>Ano:</b></td>
                <td>$ano</td>
            </tr>
            <tr>
                <td><b>ID Matrícula:</b></td>
                <td>$id_matricula</td>
            </tr>
            <tr>
                <td><b>Matrícula:</b></td>
                <td>$matricula</td>
            </tr>";

} else {
    // Caso os parâmetros não estejam presentes na URL
    header('HTTP/1.1 400 Bad Request');
    echo "Parâmetro de ano não fornecidos na URL.";
    exit();
}

// Obter o Nome do usuario
$query = "SELECT nome_user FROM infor_user WHERE usuarios_cpf_user = '$logado' ";
$resulta = mysqli_query($conexao, $query);
while ($dados = mysqli_fetch_assoc($resulta)) {
    $usuario = $dados['nome_user'];
    echo "<tr>
            <td colspan='2'><b>Nome:</b> $usuario</td>
        </tr>";
}

// Obter o lotação do usuario e cargo
$query = "SELECT lotacao , cargo FROM funcionarios WHERE  matricula = '$matricula' ";
$resulta = mysqli_query($conexao, $query);
while ($dados = mysqli_fetch_assoc($resulta)) {
    $lotacao = $dados['lotacao'];
    $cargo = $dados['cargo'];

    echo "<tr>
            <td colspan='2'><b>Localização:</b> $lotacao</td>
        </tr>
        <tr>
            <td colspan='2'><b>Cargo:</b> $cargo</td>
        </tr>
        </table><br>";

    // Obter os dados da tabela variável de todos os meses do ano
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
        echo '<table border="1">
                <tr>
                    <th>Mês</th>
                    <th>Provento</th>
                    <th>Referência</th>
                    <th>Valor</th>
                </tr>';

        while ($linha = mysqli_fetch_assoc($result)) {
            $mes = htmlspecialchars($linha["mes"]);
            $provento = htmlspecialchars($linha['provento']);
            $referencia = $linha['referencia'];
            $valor = $linha['valor'];

            echo "<tr>
                    <td>$mes</td>
                    <td>$provento</td>
                    <td>$referencia</td>
                    <td>$valor</td>
                </tr>";
        }

        echo '</table>';
    } else {
        // Nao obteve resultado
        echo '<br>Não encontrei Nada';
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Financeira</title>
    <style>
        body {
      font-family: Arial, sans-serif;
      font-size: 14px;
      margin: 0;
      padding: 20px;
    }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .logo {
            display: block;
            margin: auto;
            width: 100px;
        }
    </style>
</head>

<body>
</body>

</html>
