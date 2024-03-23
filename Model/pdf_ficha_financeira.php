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

$empresa = 'Municipio de Itacoatiara';
$endereco = 'Rua Dr Luzardo Ferreira de Melo, 2225, Centro';
$cidade_uf=  'Itacoatiara - AM';
$cnpj = '04.241.980/0001-75';

$codigo1 = '1';
$codigo2 = '103';
$codigo3 = '111';


$jan = '1.302,00'; $fev = '1.302,00'; $mar = '1.302,00';
$abr = '1.302,00' ;$mai = '1.302,00'; $jun= '1.302,00';
$jul = '1.302,00'; $ago = '1.302,00'; $set = '1.302,00';
$out = '1.302,00'; $nov = '1.302,00'; $dez = '1.302,00';

$logado = $_SESSION['cpf_user'];

// Verifica se os parâmetros 'mes' e 'ano' estão presentes na URL
if (isset($_GET['ano'], $_GET['id_matricula'], $_GET['NumMatricula'])) {

    // Obtém os valores de mês e ano da URL e realiza a sanitização
    $ano = htmlspecialchars($_GET['ano']);
    $id_matricula = htmlspecialchars($_GET['id_matricula']);
    $matricula = htmlspecialchars($_GET['NumMatricula']);

    // Adicionar a frase "Relatório Geral" centralizada acima da tabela com os meses

    // Exibir a imagem no topo
    echo "
  
    <div class='container'>
    <div class='center'>
    <h2>Relatório Geral - Ficha Financeira</h2>
    </div>
    <div class='header'>
     <img class='logo' src='../logo.png' alt='Logo da empresa'>

     <table class='tableTitle'>
            <tr>
            <th class='titulo'>Empresa:</th>
            <td class='titulo'>$empresa</td>
            </tr>
            <tr>
             <th class='titulo'>Endereço:</th>
                  <td class='titulo'>$endereco</td>
             </tr>
             <tr>
                <th class='titulo'>Cidade:</th>
                <td class='titulo'>$cidade_uf</td>
            </tr>

            <tr>
                <th class='titulo'>CNPJ:</th>
                <td class='titulo'>$cnpj</td>
            </tr>

        </table>
    </div>
</div>

";

    // Exibe os valores na página

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

}

// Obter o CPF do usuario
$query = "SELECT usuarios_cpf_user FROM infor_user WHERE usuarios_cpf_user = '$logado' ";
$resulta = mysqli_query($conexao, $query);

while ($dados = mysqli_fetch_assoc($resulta)) {
    $cpf_usuario = $dados['usuarios_cpf_user'];

}

// Obter o lotação do usuario e cargo
$query = "SELECT lotacao , cargo FROM funcionarios WHERE  matricula = '$matricula' ";
$resulta = mysqli_query($conexao, $query);
while ($dados = mysqli_fetch_assoc($resulta)) {
    $lotacao = $dados['lotacao'];
    $cargo = $dados['cargo'];

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
        

        while ($linha = mysqli_fetch_assoc($result)) {
            $mes = htmlspecialchars($linha["mes"]);
            $provento = htmlspecialchars($linha['provento']);
            $referencia = $linha['referencia'];
            $valor = $linha['valor'];


        }
    } else {
        // Nao obteve resultado
        echo '<br>Não encontrei Nada';
    }
    echo '
    <br>
    <table class="tableTitle">
                <tr>
                    <th>Nome do Trabalhador</th>
                    <th>Matricula</th>
                    <th>Cargo atual</th>
                    <th>Admissão</th>
                    <th>P.I.S</th>
                    <th>CPF</th>
                    <th>Horas Semana</th>
                    <th>Demissão</th>
                </tr>';
                echo "<tr>
                <td>$usuario</td>
                <td>$matricula</td>
                <td>$cargo</td>
                <td>$ano</td>
                <td>---</td>
                <td>$cpf_usuario</td>
                <td>12/12/12</td>
                <td>-</td>
            </tr>
        </table>";


        echo '
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Descrição</th>
                    <th></th>
                    <th>Janeiro</th>
                    <th>Fevereiro</th>
                    <th>Março</th>
                    <th>Abril</th>
                    <th>Maio</th>
                    <th>Junho</th>
                    <th>Julho</th>
                    <th>Agosto</th>
                    <th>Setembro</th>
                    <th>Outubro</th>
                    <th>Novembro</th>
                    <th>Dezembro</th>
                    <th>13º Salário</th>
                    <th>Total</th>        
                </tr>
            </thead>';
            //listagem dos meses da ficha financeira
                echo"
                <tbody>
                    <tr>
                        <td>$codigo1</td>
                        <td>Vencimentos</td>
                        <td>P</td>
                        <td>$jan</td>
                        <td>$fev</td>
                        <td>$mar</td>
                        <td>$abr</td>
                        <td>$mai</td>
                        <td>$jun</td>
                        <td>$jul</td>
                        <td>$ago</td>
                        <td>$set</td>
                        <td>$out</td>
                        <td>$nov</td>
                        <td>$dez</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>

                    <tr>
                        <td>$codigo2</td>
                        <td>G.T.I</td>
                        <td>P</td>
                        <td>$jan</td>
                        <td>$fev</td>
                        <td>$mar</td>
                        <td>$abr</td>
                        <td>$mai</td>
                        <td>$jun</td>
                        <td>$jul</td>
                        <td>$ago</td>
                        <td>$set</td>
                        <td>$out</td>
                        <td>$nov</td>
                        <td>$dez</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>

                    <tr>
                    <td>$codigo3</td>
                    <td>Produtividade</td>
                    <td>P</td>
                    <td>$jan</td>
                    <td>$fev</td>
                    <td>$mar</td>
                    <td>$abr</td>
                    <td>$mai</td>
                    <td>$jun</td>
                    <td>$jul</td>
                    <td>$ago</td>
                    <td>$set</td>
                    <td>$out</td>
                    <td>$nov</td>
                    <td>$dez</td>
                    <td>-</td>
                    <td>-</td>
                </tr>

                </tbody>
            </table>";

}





?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Financeira</title>
    <style>


.container {
      width: relative;
      margin: 0 auto;
      border: 1px solid #ccc;
      padding: 20px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .logo {
      width: 100px;
    }
        body {
      font-family: Arial, sans-serif;
      font-size: 10px;
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
