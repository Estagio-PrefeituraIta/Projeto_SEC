<?php
    session_start();
    
    //Verifica se clicou no botão e se o cpf não está vazio
    if(isset($_POST['submit']) && !empty($_POST['cpf_user'])){

        //estabele conexão com banco de Dados
        include_once('../Controller/conexao.php');

        //define a variavel local
        $cpf_user = $_POST['cpf_user'];

        //Query no Banco de Dados
        $sql = "SELECT * FROM infor_user  WHERE usuarios_cpf_user = '$cpf_user' ";
        $resulta = $conexao->query($sql);

        //Verifica se o CPF tiver tabela info_user 
        if(mysqli_num_rows($resulta)<1){

            include_once('../Controller/conexao.php');
            $sql = "SELECT * FROM usuarios  WHERE cpf_user = '$cpf_user'";
            $result = $conexao->query($sql);

            if(mysqli_num_rows($result)<1){
                //Caso não esteja nos dados da prefeitura
                echo "<script>alert(`nao ta no usuarios nao posso cadastrar`)</script>";
                
            } else {
                
                include_once('../Controller/conexao.php');
                $_SESSION['cpf_user'] = $cpf_user;//cria a variavel da sessão

                $cpf = $_SESSION['cpf_user'];
                $nome = $_POST['nome_user'];
                $email = $_POST['email_user'];
                $telefone = $_POST['telefone_user'];
                $senha = $_POST['senha_user'];

                $result = mysqli_query($conexao, "INSERT INTO infor_user(usuarios_cpf_user,nome_user,telefone_user,email_user,senha_user) 
                VALUES ('$cpf','$nome','$telefone','$email','$senha')");

                // Verifica se foi possivel
                if (!$result) {
                    // Redirecionar para a tela de login
                    header("Location: ../cadastro.html");
                    exit; // Certifique-se de que o script pare de ser executado após o redirecionamento
                }else{
                    echo "<script>alert(`$nome cadastrado no sistema`)</script>";
                    header("Location: ../login.html");
                }
            }

        }else{
            //Se o CPF tiver tabela info_user 
            header("Location: ../login.html");
            exit(); // Make sure to exit after sending the Location header
        }
    }

?>
