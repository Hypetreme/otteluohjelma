
<!DOCTYPE html>
<html>
<head>



    <?php
    include('dbh.php');

    $title = "Tapahtuma";
    if (isset($_GET['eventId'])) {
    $eventId = $_GET['eventId'];
    $json = @file_get_contents('../../../files/overview_'. $eventId . '.json');
    if ($json) {
    $json = json_decode($json, true);
    $title = $json['eventinfo'][0];
    $guessType = $json['guess'][1];
}


    echo '<meta property="og:title" content="'. $title .' :: Otteluohjelma.fi" />'; }?>
    <title><?php echo $title .' :: Otteluohjelma.fi' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta property="fb:app_id" content="184484190795"/>
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link href="css/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet"  href="../../../ionicons/css/ionicons.min.css" />
    <link rel="stylesheet" href="css/normalize.css" type="text/css">
    <link rel="stylesheet" href="css/skeleton.css" type="text/css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/chartist.min.css" type="text/css">
    <script src="js/jquery.js"></script>
    <script src="js/main.js"></script>
    <script src="js/quill.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


</head>
<!-- Riippuen lajin tyypistä -->

<body id="mainBody" class="background hockey">

  <div class="content-wrapper" id="contentWrapper">
  <div class="up">
