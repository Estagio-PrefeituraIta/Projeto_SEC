<?php
    session_start();//startando variavel de sessão 

    // Verifica se o formulário foi enviado e se os campos não estão vazios.
    if(isset($_POST['submit']) && !empty($_POST['cpf_user'])&&!empty($_POST['senha_user'])){

        //acessa
        include_once('../Controller/conexao.php');

        $cpf_user = addslashes($_POST["cpf_user"]);
        $senha_user = addslashes($_POST["senha_user"]);

        $_SESSION['cpf_user'] = $cpf_user;//cria a variavel da sessão
        $_SESSION['senha_user'] = $senha_user;//cria a variavel da sessão

        $sql = "SELECT * FROM infor_user  WHERE usuarios_cpf_user = '$cpf_user' and senha_user = '$senha_user'";
        
        $result = $conexao->query($sql);

        if(mysqli_num_rows($result)<1)
        {
            // print_r('Não existe!');
            
            unset($_SESSION['cpf_user']);//destrui a variavel
            unset($_SESSION['senha_user']);//destrui a variavel
            header('Location: ../login.html');
            
        } else {
            // print_r('Existe');
            
            $_SESSION['cpf_user'] = $cpf_user;//cria a variavel da sessão
            $_SESSION['senha_user'] = $senha_user;//cria a variavel da sessão
            // header('Location: ../Model/home.php');
            echo "<script>
                alert(`Logado com Sucesso`);
                window.location.href = '../Model/home.php'
            </script>;";
            
        }
    }else{
        echo "<script>
            alert(`Verifique as credenciais`) 
            window.location.href = '../login.html'
        </script>;";
    }
?>