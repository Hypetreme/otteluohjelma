<?php
  session_start();
  include 'dbh.php';
  $teamid = $_SESSION['teamId'];
  if (!isset($_SESSION['id'])) {
    header("Location: index.php");
  }
if (isset($_SESSION['eventId'])) {
unset($_SESSION['homeName']);
unset($_SESSION['visitorName']);
unset($_SESSION['eventId']);
unset($_SESSION['eventName']);
unset($_SESSION['eventPlace']);
unset($_SESSION['eventDate']);
unset($_SESSION['home']);
unset($_SESSION['visitors']);
}
include 'functions.php';
include('inc/header.php');
?>

  <script type="text/javascript">
</script>

  <div class="container">



    <div class="row">
      <div class="twelve columns" >
        <h4 style="position: relative;">
          Asetukset
        </h4>
      </div>
      <ul class="navbar-list"> <?php
$url = "";
if (isset($_SESSION['teamId'])) {
$team = 'team.php?teamId='.$_SESSION['teamId'];
$url = 'location.href="'.$team.'"';
}
$loc = 'my_events.php';
$url2 = 'location.href="'.$loc.'"';
      if (isset($_SESSION['teamId'])) {
       echo '<li class="navbar-item"><button style="background-color:blue;color:white" onclick='.$url.'>Kokoonpano</button></li>';
       echo '<li class="navbar-item"><button style="background-color:blue;color:white" onclick='.$url2.'>Tapahtumasi</button></li>'; } ?>
      </ul>
    </div>

    <div class="row">

          <table class='six columns' style='width:70px'>
          <thead>
            <h5 style="position: relative;">
          Käyttäjätiedot
        </h5>
            </thead>
          <tr>
          <?php userData(); ?>
            </tr>

          </table>

    </div>
    <div class="row">

          <table class='six columns' style='width:70px'>
          <thead>
          <h5 style="position: relative;">
          -
        </h5>
            </thead>
          <?php
          ?>

          </table>

    </div>
  <?php
    include ('inc/footer.php');
  ?>
