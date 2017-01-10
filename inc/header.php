<!DOCTYPE html>
<html>
  <?php include('inc/head.php'); ?>
<body>
 <?php
    $url = "$_SERVER[REQUEST_URI]";
    if ($url != "otteluohjelma/index.php" && $url != "/teams.php" && $url != "/error.php" && $url != "/register.php") {
    echo "<header>";
    include('inc/nav.php');
    echo "</header>";
  }
?>
<div class="wrapper">
  <form name="form" action="functions.php" method="POST">
    <input name="logOut" type="submit" value="Kirjaudu ulos">
  </form>
