
<!DOCTYPE html>
<html>
<head>
<script src="js/jquery.js"></script>
<script src="js/main.js"></script>
    <!-- Pelin nimi -->
    <?php
    $eventId = $_GET['eventId'];
    $json = file_get_contents('../../../files/overview_'. $eventId . '.json');
    $json = json_decode($json, true);
    $title = $json['eventinfo'][0];

    echo '<meta property="og:title" content="'. $title .' :: Otteluohjelma.fi" />'; ?>
    <title><?php echo $title .' :: Otteluohjelma.fi' ?></title>
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0" />
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
    <script src="js/quill.min.js"></script>

</head>
<!-- Riippuen lajin tyypistä -->

<body id="mainBody" class="background jaakiekko">

  <div id="contentWrapper">
  <div id="up">
