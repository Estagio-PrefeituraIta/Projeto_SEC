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

// Dados do Título do Contracheque
$logado = $_SESSION['cpf_user'];
$empresa = 'MUNICIPIO DE ITACOATIARA';
$endereco = 'RUA DR LUZARDO FERREIRA DE MELO, 2225, CENTRO';
$cidade_uf = 'ITACOATIARA-AM';
$cnpj = '04.241.980/0001-75';

// Verifica se os parâmetros 'mes' e 'ano' estão presentes na URL
if (isset($_GET['mes'], $_GET['ano'], $_GET['id_matricula'], $_GET['NumMatricula'])) {
    // Obtém os valores de mês e ano da URL e realiza a sanitização
    $mes = htmlspecialchars($_GET['mes']);
    $ano = htmlspecialchars($_GET['ano']);
    $id_matricula = htmlspecialchars($_GET['id_matricula']);
    $matricula = htmlspecialchars($_GET['NumMatricula']);
} else {
    // Caso os parâmetros não estejam presentes na URL
    header('HTTP/1.1 400 Bad Request');
    echo "Parâmetros de mês e ano não fornecidos na URL.";
    exit();
}

$style = '

@page {
  size: A4;
  margin: 1cm;
}

body {
  font-family: Arial, sans-serif;
  font-size: 16px;
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
  height: auto;
  background-image: url("../images/logo.png");
  background-repeat: no-repeat;
  background-position: center;
}

.info {
  text-align: left;
  font-weight: bold;
}
.infoCidade {
  text-align: left;
}

.title {
  font-size: 18px; /* Aumento do tamanho da fonte */
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

.tableTitle {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

table.table tr td {
  font-size: 15px; /* Aumento do tamanho da fonte */
}

.info p {
  white-space: nowrap; /* Evita corte em "Mês/Ano" */
}
table.table tbody tr {
  line-height: 1.5; /* Redução do espaçamento entre linhas */
}

.titulo {
  border: 1px solid #ccc;
  padding: 5px;
}

.total {
  font-weight: bold;
}

.assinatura {
  text-align: center;
  margin-top: 70px;
}';

// Informações do PDF
$pdf = "<!DOCTYPE html>";
$pdf .= "<html lang='pt-br'>";
$pdf .= "<head>";
$pdf .= "<meta charset='UTF-8'/>";
$pdf .= "<link rel='stylesheet' href='https://localhost/Projeto_SEC/Model/assets/css/pdf.css'>";
$pdf .= "<title>Contracheque - $matricula</title>";
$pdf .= "<style>$style</style>";
$pdf .= "</head>";
$pdf .= "<body>";
// Obter o Nome do usuário
$query = "SELECT nome_user FROM infor_user WHERE usuarios_cpf_user = '$logado' ";
$resulta = mysqli_query($conexao, $query);
while ($dados = mysqli_fetch_assoc($resulta)) {
    extract($dados);
    $fileName = "Ficha - $nome_user";
}
$pdf .= "<div class='container'>
  <div class='header'>
       <img class='logo'>
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
          <td>$nome_user</td>
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
  </table>

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
      <tr>
        <td>-</td>
        <td>VENCIMENTO</td>
        <td>$referencia</td>
        <td>-</td>
        <td>-</td>
      </tr>
      </tbody>
  </table>

  <div class='assinatura'>
   ______________________________________________
   <p>Assinatura do Empregado</p>
 </div>
</div>";



$pdf .= "</body>";
require '../dompdf/vendor/autoload.php';

// referencia o dompdf namespace
use Dompdf\Dompdf;

// Instanciar e Usar a Classe dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($pdf);

// Configuração do tamanho e orientação do papel
$dompdf->setPaper('A4', 'portrait');

// Renderizar conteúdo
$dompdf->render();

// Diga ao navegador que o conteúdo é um PDF
header('Content-type: application/pdf');

//Gerar o pdf 
// $dompdf->stream($fileName);

// Saída do PDF para o navegador
echo $dompdf->output();