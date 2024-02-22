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

    //Dados do Titulo do Contracheque
    $logado = $_SESSION['cpf_user'];
    $empresa = 'MUNICIPIO DE ITACOATIARA';
    $endereco = 'RUA DR LUZARDO FERREIRA DE MELO, 2225, CENTRO';
    $cidade_uf=  ' ITACOATIARA-AM';
    $cnpj = '04.241.980/0001-75';

    // Verifica se os parâmetros 'mes' e 'ano' estão presentes na URL
    if (isset($_GET['mes'], $_GET['ano'], $_GET['id_matricula'], $_GET['NumMatricula'])){
        // Obtém os valores de mês e ano da URL e realiza a sanitização
        $mes = htmlspecialchars($_GET['mes']);
        $ano = htmlspecialchars($_GET['ano']);
        $id_matricula = htmlspecialchars($_GET['id_matricula']);
        $matricula = htmlspecialchars($_GET['NumMatricula']);
        
    } else {
       // Caso os parâmetros não estejam presentes na URL
        header('HTTP/1.1  400 Bad Request');
        echo "Parâmetros de mês e ano não fornecidos na URL.";
        exit();
    }

    $style = '
      .container {
        margin: 1rem auto;
        border: 1px solid black;
        width: 95%;
      }

      h3 {
        text-align: center;
      }';

    //informações do PDF
    $pdf = "<!DOCTYPE html>";
    $pdf .= "<html lang='pt-br'>";
    $pdf .= "<head>";
    $pdf .= "<meta charset='UTF-8'/>";
    $pdf .= "<link rel='stylesheet' href='https://localhost/Projeto_SEC/Model/assets/css/pdf.css'>";
    $pdf .= "<title>Contracheque - $matricula</title>";
    $pdf .= "<style>$style</style>";
    $pdf .= "</head>";
    $pdf .= "<body>";
    $pdf .= "<div class='container'>
    <h2>Recibo de Pagamento de Salário</h2>
    <div class='info'>
      <div class='company-info'>
        <div><strong>Empresa:</strong> MUNICIPIO DE ITACOATIARA</div>
        <div>
          <strong>Endereço:</strong> RUA DR LUZARDO FERREIRA
        </div>
        <div><strong>Cidade/UF:</strong> ITACOATIARA-AM</div>
        <div><strong>CNPJ:</strong> 04.241.980/0001-75</div>
      </div>
      <div class='date-info'><h4>Mês/Ano: <br/> 01/2024</h4>
      </div>";

    // Obter o Nome do usuario
    $query = "SELECT nome_user FROM infor_user WHERE usuarios_cpf_user = '$logado' ";
    $resulta = mysqli_query($conexao, $query);
    while($dados = mysqli_fetch_assoc($resulta)){
        // var_dump($dados);
        extract($dados);
        $pdf .= "Nome: $nome_user";
        $fileName = "Ficha - $nome_user";
    }

    $pdf .= "</body>";
require '../dompdf/vendor/autoload.php';
// referencia o dompdf namespace
use Dompdf\Dompdf;

//Instanciar e Usar a Classe dompdf
$dompdf = new Dompdf(); 
$dompdf->loadHtml($pdf);

//Configuração do tamanho e orientação do papel
$dompdf->setPaper('A4','portrait');

//Renderizar conteudo
$dompdf->render();

// Diga ao navegador que o conteúdo é um PDF
header('Content-type: application/pdf');

//Gerar o pdf 
// $dompdf->stream($fileName);

// Saída do PDF para o navegador
echo $dompdf->output();