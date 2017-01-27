<?php
if(!isset($_GET['eventId'])) {
  include('inc/head.php');
  include ('pages/menu.php');

} else {
include('inc/head.php');
include('pages/players.php');
include('pages/favourites.php');
include('pages/stats.php');
include('pages/share.php');
include('pages/home.php');
include('inc/nav.php');
}
?>
