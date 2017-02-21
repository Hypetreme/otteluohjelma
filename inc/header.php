<!DOCTYPE html>
<html>
  <?php include('inc/head.php'); ?>
<body>
 <?php
    $url = "$_SERVER[REQUEST_URI]";
    if (($url != "/otteluohjelma/index.php" && $url != "/login/index.php") && $url != "/otteluohjelma/error.php" && strpos($url,"verify.php") == false && $url != "/otteluohjelma/register.php" && $url != "/login/register.php") {
    echo "<header>";
    include('inc/nav.php');
    echo "</header>";
  }
?>
<div class="wrapper">
