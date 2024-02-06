<?php
    $dbHost = 'localhost:3309';
    $dbUserName = 'root';
    $dbPassword = '';   
    $dbName = "test";

    $conexao = new mysqli($dbHost, $dbUserName, $dbPassword, $dbName);

    
    if($conexao->connect_errno)
    {
        echo "Erro!";//caso haja erro
    } else {
        echo "Conexão Bem Sucedida!";//caso conexão seja efetuada
    }
?>