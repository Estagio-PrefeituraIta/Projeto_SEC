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

//obter matricula
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conecte ao banco de dados
    include_once('../Controller/conexao.php');

    // Obtém o valor do botão clicado do formulário
    $matricula = isset($_POST['matricula']) ? $_POST['matricula'] : null;

    // Agora você pode usar a variável $matricula conforme necessário
    if ($matricula !== null) {
        // Faça algo com a matrícula 
        echo "Matrícula selecionada: " . htmlspecialchars($matricula) . '<br>';
    } else {
        // A matrícula não foi enviada ou é nula
        echo "Matrícula não encontrada.";
    }
} else {
    // O formulário ainda não foi enviado
    echo "Por favor, envie o formulário.";
}

//buscar ID referente ao Código da matricula
$query = "SELECT * FROM funcionarios WHERE matricula = '$matricula'";
$result = mysqli_query($conexao, $query);
while ($dados = mysqli_fetch_assoc($result)) {
    $id_matricula = $dados['id_matricula'];
}
echo "Id da matricula: ";
print_r($id_matricula);

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


    $query = "SELECT DISTINCT mes, ano FROM variavel WHERE matricula = $id_matricula ORDER BY ano DESC, mes ASC";
    $resultado = mysqli_query($conexao, $query);

    // Check if there are any results
    if (mysqli_num_rows($resultado) > 0) {
        // Exiba os registros sem repetir o mês e o ano
        while ($linha = mysqli_fetch_assoc($resultado)) {
            $mes = htmlspecialchars($linha['mes']);
            $ano = htmlspecialchars($linha['ano']);

            // Add the opening tag for an HTML element, e.g., a button
            echo ' id-matricula="' . $id_matricula . '
                " numero matricula="' . $matricula . '
                " data-mes="' . $mes . '
                " data-ano="' . $ano . '
                ">';
        }
    } else {
        // Nao obteve resultado
        echo '<br>Não encontrei Nada';
    }
    ?>
</body>

</html>