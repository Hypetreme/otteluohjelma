<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
header("Location: index.php");
}

include ('inc/header.php');
?>
<script>
if(window.location.href.indexOf("event1") > -1) {
       //alert("your url contains the name franky");
    }
</script>
<div class="container">
  <div class="row" id="guide">
    <div class="twelve columns" style="text-align: center;">

    <a href="#" style="text-decoration:none"><div id="section1" style="float:left;width: 60px; height: 60px; background: green; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
    <h3 style="color:white;padding-top:5px">1</h3>
  </div></a>

<a href="event2.php" style="text-decoration:none"><div id="section2" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<h3 style="color:white;padding-top:5px">2</h3>
</div></a>

<a href="event3.php" style="text-decoration:none"><div id="section3" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<h3 style="color:white;padding-top:5px">3</h3>
</div></a>

<a href="event_overview.php" style="text-decoration:none"><div id="section4" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<h3 style="color:white;padding-top:5px">4</h3>
</div></a>

</div>
</div>

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
