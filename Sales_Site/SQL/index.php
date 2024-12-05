<?php

include "config/conexao.php";

if($con){
    echo "conectado";
}


// $sql_insert = "INSERT INTO tabela () values ()";
$sql_insert = "INSERT INTO usuario (nome, email, senha) values ('leonardo', 'teste@teste', '321')";
$res_insert = pg_query($con, $sql_insert);

