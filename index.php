<!DOCTYPE html>
<html lang="en">
<head>
  <title>Gráfico de Temperatura - ESP8266 + PHP + MYSQL (Versão 2)</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <meta http-equiv='refresh' content='60' URL=''>    
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <!-- JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!-- Google Chart -->  
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>

<?php

//Inclui a conexão com o BD
include 'conn.php';
//Faz o SELECT da tabela, usando Prepared Statements.
$sql = "SELECT data, hora, temperatura, umidade, luminosidade FROM temp";
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$stmt->bind_result($data, $hora, $temp, $umid, $lumi);
$stmt->store_result();
//Cria o array primário
$dados = array();
$dados2 = array();
//Laço dos dados
 while ($ln = $stmt->fetch()){
//Cria o array secundário, onde estarão os dados.
    $temp_hora = array();
$temp_hora[] = ((string) $hora);
    $temp_hora[] = ((float) $temp);


    $umid_hora = array();
$umid_hora[] = ((string) $hora);
    $umid_hora[] = ((float) $umid);

    $lumi_hora = array();
$lumi_hora[] = ((string) $hora);
    $lumi_hora[] = ((float) $lumi);


//Recebe no array principal, os dados.
    $dados[] = ($temp_hora);
    $dados2[] = ($umid_hora);
    $dados3[] = ($lumi_hora);
}
//Trasforma os dados em JSON
  $jsonTable = json_encode($dados);
  $jsonTableUmid = json_encode($dados2);
  $jsonTableLumi = json_encode($dados3);
//echo $jsonTable;
?>
<h3 align="center">ESP8266 + MYSQL + PHP + GOOGLE CHART - V2</h3>
<!-- Div do Gráfico -->
<div class="container" style="height: 300px; width: 100%" id="chart_div"></div>
<hr><br>
<div class="container" style="height: 300px; width: 100%" id="chart_div_umid"></div>
<hr><br>
<div class="container" style="height: 300px; width: 100%" id="chart_div_lumi"></div>
<br><br>
</body>
<script>
//Script do Google que define o TIPO do gráfico
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawBackgroundColor);
//Define o tipo de coluna e o nome
function drawBackgroundColor() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Horario');
      data.addColumn('number', 'Temperatura (ºC)');
    
      //Captura os dados em JSON e monta o gráfico, de acordo com os dados.
      data.addRows( <?php echo $jsonTable ?>);
//Opções do gráfico:  
      var options = {
        hAxis: {
          title: 'Hora'
        },
        vAxis: {
          title: 'Temperatura'
        },
        backgroundColor: '#f1f8e9'
      };
//Criação do Gráfico 
      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
</script>
<script>
//Script do Google que define o TIPO do gráfico
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBackgroundColor);
//Define o tipo de coluna e o nome
function drawBackgroundColor() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Horario');
      data.addColumn('number', 'Umidade (%)');
    
      //Captura os dados em JSON e monta o gráfico, de acordo com os dados.
      data.addRows( <?php echo $jsonTableUmid ?>);
//Opções do gráfico:  
      var options = {
        hAxis: {
          title: 'Hora'
        },
        vAxis: {
          title: 'Umidade'
        },
        backgroundColor: '#ededed'
      };
//Criação do Gráfico 
      var chart = new google.visualization.LineChart(document.getElementById('chart_div_umid'));
      chart.draw(data, options);
    }
</script>
<script>
//Script do Google que define o TIPO do gráfico
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBackgroundColor);
//Define o tipo de coluna e o nome
function drawBackgroundColor() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Horario');
      data.addColumn('number', 'Luminosidade (%)');
    
      //Captura os dados em JSON e monta o gráfico, de acordo com os dados.
      data.addRows( <?php echo $jsonTableLumi ?>);
//Opções do gráfico:  
      var options = {
        hAxis: {
          title: 'Hora'
        },
        vAxis: {
          title: 'Luminosidade'
        },
        backgroundColor: '#f1f8bb'
      };
//Criação do Gráfico 
      var chart = new google.visualization.LineChart(document.getElementById('chart_div_lumi'));
      chart.draw(data, options);
    }
</script>
</html>