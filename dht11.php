<?php
//Incluimos o código de conexão ao BD
include 'conn.php';
//Variável responsável por guardar o valor enviado pelo ESP8266
$temp = $_GET['temp'];
$umid = $_GET['umid'];
$lumi = $_GET['lumi'];
//Captura a Data e Hora do SERVIDOR (onde está hospedada sua página):
$hora = date('H:i:s');
$data = date('Y-m-d');
//Insere no Banco de Dados, usando Prepared Statements.
$sql = "INSERT INTO temp (data, hora, temperatura, umidade, luminosidade)  VALUES (?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ssddd', $data, $hora, $temp, $umid, $lumi);
$stmt->execute();
echo 'Dados gravados com sucesso!';
?>