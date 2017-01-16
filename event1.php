<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
header("Location: index.php");
}

include ('inc/header.php');
?>
<link rel="stylesheet" href="datepicker/classic.css">
<link rel="stylesheet" href="datepicker/classic.date.css">
<script src="js/jquery.js"></script>
<script src="datepicker/picker.js"></script>
<script src="datepicker/picker.date.js"></script>
<script>
$(document).ready(function() {
$("#eventDate").click(function () {
$("#eventDate").pickadate({
    today: 'Tänään',
    clear: '',
    close: '',
    monthsFull: ['Tammikuu', 'Helmikuu', 'Maaliskuu', 'Huhtikuu', 'Toukokuu', 'Kesäkuu', 'Heinäkuu', 'Elokuu', 'Syyskuu', 'Lokakuu', 'Marraskuu', 'Joulukuu'],
  weekdaysShort: ['Ma', 'Ti', 'Ke', 'To', 'Pe', 'La', 'Su'],
  format: 'dd.mm.yyyy',
  // An integer (positive/negative) sets it relative to today.
min: -1,
// `true` sets it to today. `false` removes any limits.
max: false
});
});
});
</script>

<div class="container">
  <div class="row" id="guide">
    <div class="twelve columns" style="text-align: center;">
    <a href="#" style="text-decoration:none"><div id="section1" style="float:left;width: 60px; height: 60px; background: green; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
    <h3 style="color:white;padding-top:5px">1</h3>
  </div></a>

<div id="section2" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<input form="info" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" name ="setEventInfo" value ="2">
</div>

<div id="section3" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<input form="info" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" name="setEventInfoGuide" value="3">
</div>

<div id="section4" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<input form="info" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" name="setEventInfoGuide2" value="4">
</div>

</div>
</div>

  <div class="row">
    <div class="twelve columns" style="text-align: center;">
      <h4>
        <span>Tapahtuman tiedot</span>
      </h4>
    </div>

  </div>
<form id="info" action="functions.php" method="POST">
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
      <input type="text" name="eventDate" id="eventDate" value="<?php
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
