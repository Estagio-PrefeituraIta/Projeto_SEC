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

    $empresa = 'Municipio de Itacoatiara';
    $endereco = 'Rua Dr Luzardo Ferreira de Melo, 2225, Centro';
    $cidade_uf=  'Itacoatiara - AM';
    $cnpj = '04.241.980/0001-75';

    // Verifica se os parâmetros 'mes' e 'ano' estão presentes na URL
    if (isset($_GET['mes'], $_GET['ano'], $_GET['id_matricula'], $_GET['NumMatricula'])){
        // Obtém os valores de mês e ano da URL e realiza a sanitização
        $mes = htmlspecialchars($_GET['mes']);
        $ano = htmlspecialchars($_GET['ano']);
        $id_matricula = htmlspecialchars($_GET['id_matricula']);
        $matricula = htmlspecialchars($_GET['NumMatricula']);

        // Exibe os valores na página
        //  echo "Mês: " . $mes . "<br>";
        //  echo "Ano: " . $ano . "<br>";
        //  echo "id_matricula: " . $id_matricula . "<br>";
        //  echo "matricula: " . $matricula;
    } else {
       // Caso os parâmetros não estejam presentes na URL
        header('HTTP/1.1  400 Bad Request');
        echo "Parâmetros de mês e ano não fornecidos na URL.";
        exit();
    }

    // Obter o Nome do usuario
    $query = "SELECT nome_user FROM infor_user WHERE usuarios_cpf_user = '$logado' ";
    $resulta = mysqli_query($conexao, $query);
    while($dados = mysqli_fetch_assoc($resulta)){
        $usuario = $dados['nome_user'];
    }

    // Obter o lotação do usuario e cargo
    $query = "SELECT lotacao , cargo FROM funcionarios WHERE  matricula = '$matricula' ";
    $resulta = mysqli_query($conexao, $query);
    while($dados = mysqli_fetch_assoc($resulta)){
        $lotacao = $dados['lotacao'];
        $cargo = $dados['cargo'];

        // echo "<br> Locatção: $lotacao";
        // echo "<br> Cargo: $cargo <br>";
    }

     // Obter os dados da tabela variável (dados do contracheque) 
    //  Se você obtiver resultados duplicados (com meses iguais)
     $query = "SELECT *, matricula, mes, ano, MAX(mes) as mes
     FROM variavel
     WHERE matricula = '$id_matricula' AND mes = '$mes' AND ano = '$ano'
     GROUP BY matricula, mes, ano";
     $result = mysqli_query($conexao, $query);

    //      
     while ($dados = mysqli_fetch_assoc($result)) {
        $mes = ($dados["mes"]);
        $provento = $dados['provento'];
        $referencia = $dados['referencia'];
        $valor = $dados['valor'];
        $admissao = $dados['data_cadastro'];
        // echo "<br> Mes: $mes";
        // echo "<br> Provento: $provento";
        // echo "<br>Referencia: $referencia";
        // echo "<br>Valor: $valor <hr>";
    } 

    echo "


    <body>
    <div class='container'>
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
        <div class='info'>
        <p>Mês/Ano:$mes/$ano</p>
    </div>
    <h1 class='title'>Recibo de Pagamento de Salário</h1>
<table class='table'>
        <tr>
             <th>Matrícula</th>
            <td>$matricula</td>
            <th>Nome</th>
            <td>$usuario</td>
        </tr>

    <tr>
        <th>PIS/PASEP</th>
        <td>$matricula</td>
        <th>Admissão</th>
        <td>$admissao</td>
    </tr>

    <tr>
        <th>Lotação</th>
        <td>$lotacao</td>
        <th>Cargo</th>
        <td>$cargo</td>
    </tr>

    <tr>
        <th>Banco</th>
        <td>-</td>
        <th>Agência</th>
        <td>-</td>
    </tr>

    <tr>
        <th>Conta</th>
        <td>-</td>
    </tr>
</table'>

<table class='table'>
  <thead>
    <tr>
        <th>Codigo</th>
        
        <th>Descrição</th>
        
        <th>Referência</th>
        
        <th>Ventimentos</th>
        
        <th>Descontos</th>
    
    </tr>
    </thead>
    <tbody>
    <td>-</td>
    <td>VENCIMENTO</td>
    <td>$referencia</td>
    <td>-</td>
    <td>-</td>
    </tbody>
 </table'>


 

 </body>
    ";

    // Obter os dados da tabela variável (dados do contracheque) 
    //  Se você obtiver resultados duplicados (com meses iguais)
    $query = "SELECT *, matricula, mes, ano, MAX(mes) as mes
    FROM variavel
    WHERE matricula = '$id_matricula' AND mes = '$mes' AND ano = '$ano'
    GROUP BY matricula, mes, ano";
    $result = mysqli_query($conexao, $query);

   //      
    while ($dados = mysqli_fetch_assoc($result)) {
       $mes = ($dados["mes"]);
       $provento = $dados['provento'];
       $referencia = $dados['referencia'];
       $valor = $dados['valor'];
       $admissao = $dados['data_cadastro'];
       // echo "<br> Mes: $mes";
       // echo "<br> Provento: $provento";
       // echo "<br>Referencia: $referencia";
       // echo "<br>Valor: $valor <hr>";
       echo "
       <table></table'>";
   } 

    //Fazer Verificação Mensal
    $query = "SELECT DISTINCT mes FROM variavel WHERE matricula = $id_matricula AND ano = $ano ORDER BY mes ASC";
    $resultado = mysqli_query($conexao, $query);

    // Obtém a quantidade de linhas retornadas
    // $num_rows = mysqli_num_rows($resultado);
    // echo "<br>Meses de $ano Encontrados: " . $num_rows; 

    $url = 'pdfteste.php?mes=' . urlencode($mes) . '&ano=' . urlencode($ano) . '&id_matricula=' . urlencode($id_matricula) . '&NumMatricula=' . urlencode($matricula);
    
    echo"
    <div class='assinatura'>
    ______________________________________________
        <p>Assinatura do Empregado</p>
      </div>
    
    
    <br><a  href='$url' target='_blank'>Visualizar em PDF</a>";
    
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="http://localhost/Projeto_SEC/Model/assets/css/pdf.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Pagamento de Salário</title>

    <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 14px;
      margin: 0;
      padding: 20px;
    }

    .container {
      width: 750px;
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

    .info {
      text-align: right;
      font-weight: bold;
    }
    .infoCidade {
      text-align: left;
    }

    .title {
      font-size: 16px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 5px;
    }

    th {
      text-align: left;
    }
  
    .tableTitle{
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
.titulo{
  border: 1px solid #ccc;
      padding: 5px;
}
    .total {
      font-weight: bold;
    }

    .assinatura {
      text-align: center;
      margin-top: 70px;
    }

    </style>
</head>
</html>