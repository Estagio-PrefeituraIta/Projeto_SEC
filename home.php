<?php
    session_start();//inicia a sessão
    // print_r($_SESSION);
    
    if((!isset($_SESSION['cpf_user']) == true) and (!isset($_SESSION['senha_user']) == true)){
        unset($_SESSION['cpf_user']);//destrui a variavel
        unset($_SESSION['senha_user']);//destrui a variavel
        header('Location: ../login.html');
    }

    $logado = $_SESSION['cpf_user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>HOME</h1>
</body>
</html>