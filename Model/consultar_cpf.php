<?php
session_start(); //inicia a sessão
// print_r($_SESSION);

include_once('../Controller/conexao.php');

if (!isset($_SESSION['cpf_user']) || !isset($_SESSION['senha_user'])) {
    // Destruir as variáveis de sessão
    unset($_SESSION['cpf_user']);
    unset($_SESSION['senha_user']);

    // Redirecionar para a página de login
    header('Location: ../login.html');
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
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Mensal</title>
    <link rel="stylesheet" href="./Model/assets/css/reset.css">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body class="d-flex flex-column min-vh-100" style="min-width: 400px;">
    <!-- Navigation -->
    <nav
      class="navbar navbar-expand-sm navbar-dark"
      style="background-color: #036b5a"
    >
      <div class="container">
        <!-- Adiciona a marca da barra de navegação -->
        <a class="navbar-brand" href="../Model/home.php"
          ><img
            src="../Model/assets/img/Logo-Prefeitura-de-Itacoatiara-1-removebg-preview.png"
            width="150"
            alt=""
        /></a>

        <!-- Adiciona um botão de menu hamburguer para dispositivos móveis -->
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Itens de navegação -->
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="./home.php"
                ><i class="fas fa-home"></i> Home</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../View/sobre.php"
                ><i class="fas fa-info"></i> Sobre</a
              >
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="fas fa-sign-out-alt"></i> Sair
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <form class="dropdown-item" method="post">
                  <input
                    class="btn btn-outline-danger"
                    type="submit"
                    name="logout"
                    value="Logout"
                  />
                </form>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <?php
    include_once('../Controller/conexao.php');
    

    $query = "SELECT DISTINCT mes FROM variavel WHERE matricula = $id_matricula AND ano = $ano ORDER BY mes ASC";
    $resultado = mysqli_query($conexao, $query);
    
    // Obtém a quantidade de linhas retornadas
    $num_rows = mysqli_num_rows($resultado);

    // Exibe a quantidade de linhas
    echo "<h5 class='text-center p-2'>Meses Encontrados: <span class='badge badge-dark'>$num_rows</span></h5>";

    //exibe a tabela
    echo "<div class='container mt-3 table-responsive-sm flex-grow-1'>
        <table class='table table-hover'>
            <thead class='table-dark'>
                <tr>
                <th>Visualizar</th>
                <th>Mês</th>
                <th>Ano</th>
                </tr>
            </thead>
            <tbody>";

    // Check if there are any results
    if (mysqli_num_rows($resultado) > 0) {
        // Exiba os registros sem repetir o mês e o ano
        while ($linha = mysqli_fetch_assoc($resultado)) {
            $mes = htmlspecialchars($linha['mes']);

            echo '<tr>
            <td><button class="meuBotao btn-secondary" data-id-matricula="' . $id_matricula . ' " data-numero-matricula="' . $matricula . ' " data-ano="' . $ano . '" " data-mes="' . $mes . '"> <i class="fa fa-eye"></i></button></td>
            <td>'.$mes.'</td>
            <td>'.$ano.'</td>
          </tr>';

            // echo '<button class="meuBotao" data-id-matricula="' . $id_matricula . ' " data-numero-matricula="' . $matricula . ' " data-ano="' . $ano . '" " data-mes="' . $mes . '">Visualizar</button> 
            // id-matricula="' . $id_matricula . '
            // data-id-matricula="' . $matricula . '
            // "<span> data-mes="' . $mes . ' </span>
            // " data-ano="' . $ano . '
            // "> <br>';
        }

        echo '</tbody>';
        $url = 'pdf_ficha_financeira.php?mes=' . '&ano=' . urlencode($ano) . '&id_matricula=' . urlencode($id_matricula) . '&NumMatricula=' . urlencode($matricula);
        
        echo "<br><a style='color: red' href='$url'>Visualizar Ficha Financeira</a>";
    } else {
        // Nao obteve resultado
        echo "<div class='alert alert-secondary' role='alert'>
                Não encontrei Dados 
              </div>";
    }
    ?>
                
            </table>
        </div>

    <!-- Rodapé -->
    <footer class="text-white p-3 text-center"  style="background-color: #036b5a">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <!-- Ícone do Instagram -->
                    <a href="#" target="_blank" class="text-white mr-3" style="text-decoration: none;">
                        <i class="fab fa-instagram"></i>
                    </a>
                    
                    <a href="#" target="_blank" class="text-white mr-3" style="text-decoration: none;">
                        <i class="fab fa-facebook"></i>
                    </a>

                    <!-- Link para o site principal -->
                    <a href="https://prefeituradeitacoatiara.com.br/" target="_blank" class="text-white" style="text-decoration: none;">
                      Site Principal
                  </a>
                </div>
                <div class="col-md-6">
                    <!-- Outros elementos do rodapé -->
                    <div class="container">
                        &copy; 2024 SEC | Todos os direitos reservados
                    </div>  
                </div>
            </div>
        </div>
    </footer>

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

    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>