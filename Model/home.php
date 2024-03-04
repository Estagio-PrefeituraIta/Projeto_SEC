<?php
session_start();

// Verificar se as variáveis de sessão não estão definidas
if (!isset($_SESSION['cpf_user']) || !isset($_SESSION['senha_user'])) {
    // Destruir as variáveis de sessão
    unset($_SESSION['cpf_user']);
    unset($_SESSION['senha_user']);

    // Redirecionar para a página de login
    header('Location: ../login.html');
    exit(); // Certifique-se de sair após o redirecionamento
}
// Verificar se o botão de logout foi clicado
if (isset($_POST['logout'])) {
    echo '<script>
            // Exibir o alerta com opções
            var confirmLogout = confirm("Deseja Sair?");

            // Verificar a escolha do usuário
            if (confirmLogout) {
                // Se confirmado, encerra a sessão e redireciona
                alert("Sessão encerrada!");
                // Encerrar a sessão
                `session_destroy();`

                // Redirecionar para a página de login (ou outra página desejada)
                window.location.href = "../login.html";
            } else {
                // Se não confirmado, continua
                alert("Sessão não encerrada");
            }
          </script>';
}
$logado = $_SESSION['cpf_user'];
// print_r($logado);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

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
    <nav class="navbar navbar-expand-sm navbar-dark"  style="background-color: #036B5A;">
    <div class="container">
    <!-- Adiciona a marca da barra de navegação -->
    <a class="navbar-brand" href="./home.php"><img src="./assets/img/Logo-Prefeitura-de-Itacoatiara-1-removebg-preview.png" width="150" alt=""></a>

    <!-- Adiciona um botão de menu hamburguer para dispositivos móveis -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

        <!-- Itens de navegação -->
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link active" href="./home.php"><i class="fas fa-home"></i> Home</a></li>
            <li class="nav-item"><a class="nav-link" href="../View/sobre.html"><i class="fas fa-info"></i> Sobre</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    
                    <form class="dropdown-item"  method="post" action="">
                        <input class="btn btn-outline-danger" type="submit" name="logout" value="Logout">
                    </form>
                      
                </div>
            </li>
        </ul>
        </div>
    </div>
</nav>


    <?php
    include_once('../Controller/conexao.php');

    // Verifique se a conexão foi bem-sucedida
    if (!$conexao) {
        die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
    }


    // Evitar SQL Injection usando prepared statements
    $query = "SELECT id_matricula , matricula FROM funcionarios WHERE usuarios_cpf_user = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "s", $logado);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    // Tratamento de erros
    if (!$resultado) {
        echo 'error';
        die("Erro na execução da consulta: " . mysqli_error($conexao));
    }

    // Obtém a quantidade de linhas retornadas
    $num_rows = mysqli_num_rows($resultado);

    // Exibe a quantidade de linhas
    echo "<h5 class='text-center p-2'>Mátriculas Encontradas: <span class='badge badge-dark'>$num_rows</span></h5>";
    
    //construir a div com a matriculas
    echo "<section class='container mt-4 flex-grow-1'>";
    echo "<div class='row'>";

    // Buscar Matriculas e Ano 
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $idmatricula = $linha['id_matricula'];
        $matricula = $linha['matricula'];
        // Consulta SQL para buscar os anos para uma matrícula específica
        $consultaAnos = "SELECT DISTINCT ano FROM variavel WHERE matricula = $idmatricula";
        $resultadoAnos = mysqli_query($conexao, $consultaAnos);

        // Verificar se a consulta foi bem-sucedida
        if ($resultadoAnos) {

            // Verificar se há dados retornados
            if (mysqli_num_rows($resultadoAnos) > 0) {
                // campo de entrada oculto passando o id da matricula
                echo"<div class='col-md-4 mb-3'> 
                <div class='card'>
                  <div class='card-body'>
                    <h5 class='card-title'>Mátricula: $matricula</h5>
                    
                    <form method='POST' action='../Model/consultar_cpf.php'>
                    <input type='hidden' name='id_matricula' value='$idmatricula'>
                    <input type='hidden' name='matricula' value='$matricula'>
                    <div class='form-group'>
                    <label for='ano'>Ano:</label>
                    <select class='form-control' name='ano' id='ano'>

                  ";
                
                // Loop para exibir os botões com os anos
                while ($linhaAno = mysqli_fetch_assoc($resultadoAnos)) {
                    $ano = $linhaAno['ano'];
                    echo "<option value='$ano'>$ano</option>";
                }

                echo "</select> </div>
                 <div class='form-group'>
                 <button type='submit' class='btn btn-info'>Consultar</button>
                 </div>
                 </form>
                 </div>       
                 </div>
                 </div>";

                // Liberar resultado da consulta de anos
                mysqli_free_result($resultadoAnos);
            } else {
                    echo "<div class='col-md-4 mb-3'> 
                    <div class='card'>
                      <div class='card-body'>
                        <h5 class='card-title'>Mátricula: $matricula</h5>
                        <div class='alert alert-secondary ' role='alert'>
                        Não há anos disponíveis para esta matrícula.
                        </div>
                      </div>
                    </div>
                  </div>";
            //     echo "<div class='alert alert-secondary' role='alert'>
            //     Mátricula: $matricula Não há anos disponíveis para esta matrícula.
            //   </div>";
            }
        } else {
            // Tratar erro na consulta de anos, se necessário
            echo "Erro na consulta de anos: " . mysqli_error($suaConexao);
        }
    }
    // Verificar se o loop não produziu nenhum botão
    if (mysqli_num_rows($resultado) === 0) {
        echo "<div class='alert alert-secondary w-100' role='alert'>
                Não há dados disponíveis.
              </div>";
    }   

    // Feche a conexão com o banco de dados
    mysqli_close($conexao);
    ?>

</section>

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

    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    
</body>

</html>