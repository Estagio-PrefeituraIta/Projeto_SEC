<?php

ini_set('max_execution_time', 0);

require 'conexao.php';

$filename = 'C:\func_2005_2013.csv';

$delimiter = ';'; // Delimitador de campo do arquivo CSV
$header = null; // Cabeçalho do arquivo CSV
$data = array(); // Array para armazenar os dados do arquivo CSV
$limit = 5; // Limite de linhas a serem lidas

if (($handle = fopen($filename, 'r')) !== false) {
    $rowCount = 0; // Inicializa o contador de linhas
    // Loop para ler e inserir os dados
    while ($rowCount < $limit && ($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
        // Verifica se os dados já existem na tabela
        $verificarExistencia = $conexao->query("SELECT * FROM usuarios WHERE cpf_user = '{$row[1]}'");

        if ($verificarExistencia->num_rows == 0) {
            // Se os dados não existem, proceda com a inserção
            $sql = "INSERT INTO usuarios (nome, cpf_user) VALUES (?, ?)";

            // Prepara a declaração SQL
            $stmt = $conexao->prepare($sql);
            
            // Associa os parâmetros
            $stmt->bind_param('ss', $row[0], $row[1]);
            $insercaoSucesso = $stmt->execute();

            // Verifica a inserção
            if ($insercaoSucesso) {
                echo 'Inserção bem-sucedida para a linha ' . $rowCount . '<br>';
            } else {
                echo 'Falha na inserção para a linha ' . $rowCount . ': ' . $stmt->error . '<br>';
            }

            $stmt->close();
        } else {
            // Se os dados já existem, exiba uma mensagem
            echo 'Dados já existentes para a linha ' . $rowCount . '<br>';
        }

        // Armazena os dados em $data
        $data[] = $row;
        $rowCount++;
    }
    fclose($handle);
    // Mostrando o conteúdo de $data
    echo '<pre>';
    print_r($data);
    echo '</pre>';
} else {
    echo 'Não foi possível abrir o arquivo CSV.';
}
?>