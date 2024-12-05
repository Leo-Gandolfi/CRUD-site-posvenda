<?php

include "../../SQL/config/conexao.php"; 
$dir = dirname(__FILE__);

$fabrica = 13;

$arquivo = $dir . "/pecas_black.csv";

$cadastros = file_get_contents($arquivo);

$cadastros_linha = explode("\n" , $cadastros);

foreach($cadastros_linha as $linha){
    $substring = explode(";" , $linha);
    $referencia = $substring[0];
    $descricao = $substring[1];
    
    $sql = "INSERT INTO peca(referencia, descricao, fabrica) VALUES ('$referencia', '$descricao', $fabrica)";
    $res = pg_query($con, $sql);

}