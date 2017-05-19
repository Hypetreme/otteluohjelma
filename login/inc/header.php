<!DOCTYPE html>
<html>
  <?php include('inc/head.php'); ?>
<body>
 <?php
    $url = $_SERVER['REQUEST_URI'];
    if (($url != "/otteluohjelma/login/login.php" && $url != "/login/login.php") && $url != "/otteluohjelma/login/error.php" && strpos($url,"verify.php") == false && $url != "/otteluohjelma/login/register.php" && $url != "/login/register.php") {
    echo "<header>";
    include('inc/nav.php');
    echo "</header>";
  }
?>
<div class="wrapper">
