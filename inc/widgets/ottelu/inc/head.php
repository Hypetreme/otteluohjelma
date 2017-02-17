
<!DOCTYPE html>
<html>
<head>
<script src="js/jquery.js"></script>
<script src="js/main.js"></script>
    <!-- Pelin nimi -->
    <?php
    $url = $_SERVER['REQUEST_URI'];
    $url = strrchr($url, '?');
    $url = strrchr($url, '=');
    $url = substr($url, 0, strrpos($url, '_'));
    $url = strchr($url, '_');
    $url = substr($url, 1);
    $url = urldecode($url);

    echo '<meta property="og:title" content="'. $url .' :: Otteluohjelma.fi" />'; ?>
    <title><?php echo $url .' :: Otteluohjelma.fi' ?></title>
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link href="css/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css" type="text/css">
    <link rel="stylesheet" href="css/skeleton.css" type="text/css">
    <script src="https://use.fontawesome.com/85920deb12.js"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <script src="js/quill.min.js"></script>

</head>
<!-- Riippuen lajin tyypistä -->
<body class="background jaakiekko">
  <div class="overlay">
  </div>
