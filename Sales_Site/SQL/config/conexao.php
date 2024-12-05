<?php

$con = pg_connect("host=teste port=1111 dbname=teste user=postgres password=teste");

if (!$con) {
    echo "Erro ao conectar no banco de dados.";
}


