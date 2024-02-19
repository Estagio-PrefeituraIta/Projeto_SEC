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

    $empresa = 'MUNICIPIO DE ITACOATIARA';
    $endereco = 'RUA DR LUZARDO FERREIRA DE MELO, 2225, CENTRO';
    $cidade_uf=  ' ITACOATIARA-AM';
    $cnpj = '04.241.980/0001-75';

    echo "<h1>$empresa</h1>";
    echo "<p>$endereco</p>";
    echo "<p>$cidade_uf  -  $cnpj</p>";

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
         echo "matricula: " . $matricula;
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
        echo "<br>Nome: $usuario";
    }

    // print_r($usuario);

    // Obter o lotação do usuario e cargo
    $query = "SELECT lotacao , cargo FROM funcionarios WHERE  matricula = '$matricula' ";
    $resulta = mysqli_query($conexao, $query);
    while($dados = mysqli_fetch_assoc($resulta)){
        $lotacao = $dados['lotacao'];
        $cargo = $dados['cargo'];

        echo "<br> Locatção: $lotacao";
        echo "<br> Cargo: $cargo <br>";
    }
    // print_r($lotacao);
    // print_r($cargo);
    
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

        echo "<br> Mes: $mes";
        echo "<br> Provento: $provento";
        echo "<br>Referencia: $referencia";
        echo "<br>Valor: $valor <hr>";
    } 

    //Fazer Verificação Mensal
    $query = "SELECT DISTINCT mes FROM variavel WHERE matricula = $id_matricula AND ano = $ano ORDER BY mes ASC";
    $resultado = mysqli_query($conexao, $query);

    // Obtém a quantidade de linhas retornadas
    $num_rows = mysqli_num_rows($resultado);
    echo "<br>Meses de $ano Encontrados: " . $num_rows; 

    echo '<br><button id="meuBotao" data-id-matricula="' . $id_matricula . ' " data-numero-matricula="' . $matricula . ' " data-ano="' . $ano . '">Ficha Financeira</button> '
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<script>
        // Adicione um evento de clique a todos os botões com a classe "visualizar-icon"
        // Adicionando um evento de clique para cada botão com a classe "meuBotao"
        var botao = document.getElementById('meuBotao');
            botao.addEventListener('click', function () {
                // Obtendo os valores dos data attributes
                var idMatricula = botao.getAttribute('data-id-matricula');
                var numeroMatricula = botao.getAttribute('data-numero-matricula');
                var mes = botao.getAttribute('data-mes');
                var ano = botao.getAttribute('data-ano');

                // Faz algo com os valores, por exemplo, exibe no console
                alert("ID Matricula: " + idMatricula + "Num. Matricula: " + numeroMatricula);

                // // Construa a URL da página de destino com os valores como parâmetros de consulta
                const url = 'pdf_ficha_financeira.php?ano=' + encodeURIComponent(ano) + '&id_matricula=' + encodeURIComponent(idMatricula) + '&NumMatricula=' + encodeURIComponent(numeroMatricula);
                                
                // // Redirecione o usuário para a página de destino
                window.location.href = url;
            });
    </script>
</body>
</html>