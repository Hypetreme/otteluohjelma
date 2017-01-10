<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
header("Location: index.php");
}

include ('inc/header.php');
?>
<div class="container">
  <div class="row">
    <div class="twelve columns" style="text-align: center;">
      <h4>
        <span>Tapahtuman tiedot</span>
      </h4>
    </div>
<form name="form" action="functions.php" method="POST">
  </div>

  <div class="row">
    <div class="twelve columns">
      <label for="eventName">Tapahtuman nimi:</label>
      <input type="text" name="eventName" value="<?php
      if (isset($_SESSION['eventName'])) {
      echo $_SESSION['eventName'];
    }
        ?>">
      <label for="eventPlace">Tapahtuman paikka:</label>
      <input type="text" name="eventPlace" value="<?php
      if (isset($_SESSION['eventPlace'])) {
         echo $_SESSION['eventPlace']; }
        ?>">
      <label for="eventdate">Tapahtuman pvm:</label>
      <input type="text" name="eventDate" value="<?php
      if (isset($_SESSION['eventDate'])) {
         echo $_SESSION['eventDate']; }
        ?>">
    </div>
  </div>

  <div class="row">
    <div class="twelve columns" style="text-align:center;position:absolute;padding-top:50px">
      <button class="button-primary" type="button" value="Takaisin" onclick="window.location='my_events.php'"/>Takaisin</button>
      <input class="button-primary" type="submit" name="setEventInfo" id="btnEvent1" value="Seuraava">
</form>
    </div>
  </div>

</div>


  <?php include('inc/footer.php'); ?>
