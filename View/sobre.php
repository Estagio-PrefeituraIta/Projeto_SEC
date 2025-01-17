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
  // V

  // Verificar se o botão de logout foi clicado
  if (isset($_POST['logout'])) {
    session_destroy();
  }

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sobre Nós</title>

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
              <a class="nav-link" href="../Model/home.php"
                ><i class="fas fa-home"></i> Home</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="../View/sobre.php"
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
                <form class="dropdown-item" method="post" action="">
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

    <!-- Conteúdo da página "Sobre Nós" -->
    <div class="container mt-4 flex-grow-1">
        <div class="row">
            <div class="col-md-6">
                <h1>Sobre Nós</h1>
                <p class="text-justify">Bem-vindo ao site SEC (Sistema de Emissão de Contra-Cheque) da Prefeitura de Itacoatiara. Aqui, estamos comprometidos em fornecer informações relevantes e serviços eficientes para nossos cidadãos.</p>
                

                <p>Nossa equipe está comprometida em...</p>
                
            </div>
            <div class="col-md-6 mb-4 mb-lg-0">
                <!-- Adicione uma imagem representativa da sua empresa -->
                <!-- <img src="../Model/assets/img/Background_logo.png" alt="Imagem Representativa" class="img-fluid"> -->
                <div class="embed-responsive embed-responsive-4by3">
                  <iframe class="embed-responsive-item" src="https://prefeituradeitacoatiara.com.br/"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo da página "Missão, Visão e Valores" -->
<div class="container my-4">

  <div class="row my-4">
      <!-- Missão -->
      <div class="col-lg-4 mb-4">
          <div class="card">
              <div class="card-body">
                  <h5 class="card-title border-bottom pb-2">Missão</h5>
                  <p class="card-text">Nossa missão é garantir o bem-estar e a qualidade de vida de todos os habitantes de nossa Cidade.</p>
              </div>
          </div>
      </div>

      <!-- Visão -->
      <div class="col-lg-4 mb-4">
          <div class="card">
              <div class="card-body">
                  <h5 class="card-title border-bottom pb-2" >Visão</h5>
                  <p class="card-text">Ser reconhecida como uma cidade referência em qualidade de vida, sustentabilidade e inovação.</p>
              </div>
          </div>
      </div>

      <!-- Valores -->
      <div class="col-lg-4 mb-4">
          <div class="card">
              <div class="card-body">
                  <h5 class="card-title border-bottom pb-2">Valores</h5>
                  <p class="card-text">Nosso trabalho é guiado por valores fundamentais, incluindo transparência, responsabilidade, eficiência e colaboração.</p>
              </div>
          </div>
      </div>
  </div>

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


    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>
