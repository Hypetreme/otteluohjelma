<?php
if(!isset($_GET['eventId'])) {
  include('inc/head.php');
  include ('pages/menu.php');

} else {
include('inc/head.php');
include('pages/players.php');
include('pages/info.php');
include('pages/sponsors.php');
include('pages/home.php');
include('inc/nav.php');
}
?>
