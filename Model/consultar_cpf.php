<?php
session_start(); //inicia a sessão
// print_r($_SESSION);

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

//obter ano selecionado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conecte ao banco de dados
    include_once('../Controller/conexao.php');

    // Obtém o valor do botão clicado do formulário
    $ano = isset($_POST['ano']) ? $_POST['ano'] : null;
    $id_matricula = isset($_POST['id_matricula']) ? $_POST['id_matricula'] : null;
    $matricula = isset($_POST['matricula']) ? $_POST['matricula'] : null;

} else {
    // O formulário ainda não foi enviado
    echo "Por favor, envie o formulário.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include_once('../Controller/conexao.php');
    

    $query = "SELECT DISTINCT mes FROM variavel WHERE matricula = $id_matricula AND ano = $ano ORDER BY mes ASC";
    $resultado = mysqli_query($conexao, $query);
    
    // Obtém a quantidade de linhas retornadas
    $num_rows = mysqli_num_rows($resultado);

    // Exibe a quantidade de linhas
    echo "Meses Encontrados: " . $num_rows;
    // Check if there are any results
    if (mysqli_num_rows($resultado) > 0) {
        // Exiba os registros sem repetir o mês e o ano
        while ($linha = mysqli_fetch_assoc($resultado)) {
            $mes = htmlspecialchars($linha['mes']);

            // Add the opening tag for an HTML element, e.g., a button
            echo '<br><button class="meuBotao" data-id-matricula="' . $id_matricula . ' " data-numero-matricula="' . $matricula . ' " data-ano="' . $ano . '" " data-mes="' . $mes . '">Visualizar</button> 
            id-matricula="' . $id_matricula . '
            data-id-matricula="' . $matricula . '
            "<span> data-mes="' . $mes . ' </span>
            " data-ano="' . $ano . '
            "> <br>';
        }
    } else {
        // Nao obteve resultado
        echo '<br>Não encontrei Nada';
    }
    ?>


    <script>
        // Adicione um evento de clique a todos os botões com a classe "visualizar-icon"
        // Adicionando um evento de clique para cada botão com a classe "meuBotao"
        var botoes = document.querySelectorAll('.meuBotao');
        botoes.forEach(function (botao) {
            botao.addEventListener('click', function () {
                // Obtendo os valores dos data attributes
                var idMatricula = botao.getAttribute('data-id-matricula');
                var numeroMatricula = botao.getAttribute('data-numero-matricula');
                var mes = botao.getAttribute('data-mes');
                var ano = botao.getAttribute('data-ano');

                // Faz algo com os valores, por exemplo, exibe no console
                // alert("ID Matricula: " + idMatricula + "Num. Matricula: " + numeroMatricula);

                // Construa a URL da página de destino com os valores como parâmetros de consulta
                const url = 'pdf_visualizar.php?mes=' + encodeURIComponent(mes) + '&ano=' + encodeURIComponent(ano) + '&id_matricula=' + encodeURIComponent(idMatricula) + '&NumMatricula=' + encodeURIComponent(numeroMatricula);
                                
                // Redirecione o usuário para a página de destino
                window.location.href = url;
            });
        });
    </script>
</body>

</html>