<?php

session_start();
include ("../../SQL/config/conexao.php");

$sessao = trim($_SESSION['fabrica']);

$tipo = $_GET['tipo'];

$sql = "select * from $tipo where fabrica = '$sessao'";
$res = pg_query($con, $sql);

$arquivo = fopen("meuarquivo-$tipo.csv", 'w');

if($tipo == "tipo_atendimento"){
    $linha = array( 'Código', 'Descrição', 'Ativo (t = ativo)' );
}
if($tipo == "produto"){
    $linha = array( 'Referência', 'Descrição', 'Ativo (t = ativo)' );
}
if($tipo == "defeito" or $tipo == "peca"){
    $linha = array( 'Referência', 'Descrição');
}


fputcsv($arquivo, $linha);

while ($linha2 = pg_fetch_array($res)) {
    if($tipo == 'produto' or $tipo == 'tipo_atendimento'){
        $linha_csv = array($linha2[1] ,$linha2[2], $linha2[4]);
    }

    if($tipo == 'defeito' or $tipo == 'peca'){
        $linha_csv = array($linha2[1] ,$linha2[2]);
    }

    fputcsv($arquivo, $linha_csv);
}


fclose($arquivo);

header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=meuarquivo-$tipo.csv");

readfile("meuarquivo-$tipo.csv");

unlink("meuarquivo-$tipo.csv");

?> 