<?php
//Conexão com o banco de dados
$mysqli = new mysqli('localhost', 'coden218_clima', '123@123@', 'coden218_clima');
if ($mysqli->connect_error) {
    die('Erro de conexão: (' . $mysqli->connect_errno . ')');
}
date_default_timezone_set('America/Sao_Paulo');
?>