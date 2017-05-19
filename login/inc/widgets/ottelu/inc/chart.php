<?php
include('dbh.php');
$url = $_GET['eventId'];
$eventId = substr($url, 0, strpos($url, "_"));
$stmt = $conn->prepare("SELECT * from guess WHERE event_id = :eventid");
$stmt->bindParam(':eventid', $eventId);
$stmt->execute();
$sum = $stmt->rowCount();
$most = array();
$answered = false;
//1 vastaus per IP-osoite
$ip = $_SERVER['REMOTE_ADDR'];
while ($row = $stmt->fetch()) {
  if ($ip == $row['ip']) {
    $answered = true;
    break;
  }
}
// Poista alla oleva rivi salliaksesi vain 1 äänestys per käyttäjä
$answered = false;
//--

  $stmt = $conn->prepare("SELECT answer from guess WHERE event_id = :eventid GROUP BY answer");
  $stmt->bindParam(':eventid', $eventId);
  $stmt->execute();
  $i = 0;
  while ($row = $stmt->fetch()) {
      $stmt2 = $conn->prepare("SELECT answer from guess WHERE answer = :answer AND event_id = :eventid");
      $stmt2->bindParam(':eventid', $eventId);
      $stmt2->bindParam(':answer', $row['answer']);
      $stmt2->execute();
      $count = $stmt2->rowCount();
      $most['count'][$i] = $count;
      $most['player'][$i] = $row['answer'];
      $i++;
  }
// Vaaditaan vähintään 3 eri vastausta graafin näyttämiseen
if (@$most['player'][0] != "" && @$most['player'][1] != "" && @$most['player'][2] != "" && $guessType != 4) {
    array_multisort($most['count'], SORT_DESC, $most['player'], SORT_DESC);
// Asetetaan dataksi 5 äänestetyintä
for ($i=0;$i<5;$i++) {
    if (@$most['count'][$i] != "") {
        $choice = $most['player'][$i];
        $percentage = round($most['count'][$i]*100/$sum, 2, PHP_ROUND_HALF_ODD);
        $percentage = round($percentage, 2);
        $chart_array[$i]=array((string)$choice." ".$percentage. "%", $percentage, "");
    }
}

    $data=json_encode($chart_array);
    echo "<script>var draw = true;</script>";

    echo "<script>function drawRightY(draw) {
    var data = new google.visualization.DataTable();
    data.addColumn('string', '');
    data.addColumn('number', '');
    //data.addColumn({type:'string', role:'annotation'});
    data.addColumn({type:'string',role:'tooltip'});
    data.addRows($data);
    data.sort([{column: 1, desc: true}]);

    var options = {
      animation:{
    duration: 1500,
    easing: 'in',
    startup: true
  },
  tooltip: {
    textStyle:  {
    fontName: 'Raleway',
    fontSize: 14,
    bold: true},
  },
      height: '208',
      backgroundColor: 'transparent',
      chartArea: {  width: '100%', height: '100%' },
      legend: {position: 'none'},

        annotations: {
textStyle:  {
fontName: 'Raleway',
fontSize: 14,
bold: true},
alwaysOutside: true,
        },

vAxis: {
  textPosition: 'in',
  textStyle:  {fontName: 'Raleway',
    fontSize: 16,bold: false,
    color: 'white',
    auraColor: 'none',
    bold: true},
    gridlines: {
        color: 'transparent'
    }
},
        hAxis: {
          ticks: [0,1,50,100],
            minValue: 0,
            viewWindow: {
            min: 0,
            max: 100,
        },
        gridlines: {
        color: 'transparent'
    }
          },
        bars: 'horizontal',
        bar: {  groupWidth: '95%'},
    };
    var formatter = new google.visualization.NumberFormat({
    fractionDigits: 2,
    suffix: '%'
});
    formatter.format(data, 1);
    var material = new google.visualization.BarChart(document.getElementById('chart'));
    document.getElementById('chartHeader').innerHTML = '<h4 style=\'color:white\'>Vastatuimmat</h4>';
    material.draw(data,options);
  }</script>";
} else {
    echo "<script>var draw = false;</script>";
}
