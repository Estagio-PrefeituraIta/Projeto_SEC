<?php

    ini_set('max_execution_time', 0);

    require 'conexao.php';

    $filename = 'C:\func_2005_2013.csv';

    $delimiter = ';'; // Delimitador de campo do arquivo CSV
    $header = null; // Cabeçalho do arquivo CSV
    $data = array(); // Array para armazenar os dados do arquivo CSV

    if (($handle = fopen($filename, 'r')) !== false) {
        //funçao para ler   
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            if (!$header) {
                $header = $row;
            } else {
                $data[] = array_combine($header, $row);
               
            }
        }
        fclose($handle);
    }

    // Exibe os dados do arquivo CSV
    print_r($data);
?>