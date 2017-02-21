<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
header("Location: index.php");
}
$_SESSION['editEvent'] = true;
$_SESSION['homeName'] = $_SESSION['teamName'];
if (!isset($_SESSION['editEvent'])) {
header("Location: profile.php");
}

include ('inc/header.php');
?>
<link rel="stylesheet" href="inc/widgets/datepicker/classic.css">
<link rel="stylesheet" href="inc/widgets/datepicker/classic.date.css">
<script src="js/jquery.js"></script>
<script src="js/main.js"></script>
<script src="inc/widgets/datepicker/picker.js"></script>
<script src="inc/widgets/datepicker/picker.date.js"></script>
<script>
datePicker();
</script>
<div class="container">
  <div class="twelve columns" style="text-align:center" id="guide">
  <div id="section1" style="background-color:#2bc9c9">
  <p class="guideHeader">Tapahtuman tiedot</p>
  <a href="#" style="text-decoration:none">
  <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_1</i>
  </a></div>
  <div class="line" style="background-color:gray"></div>

  <div id="section2" style="background-color:gray">
  <p class="guideHeader">Kotipelaajat</p>
  <a id="btnEvent2" href="#" style="text-decoration:none">
  <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_2</i>
  </a></div>
  <div class="line" style="background-color:gray"></div>

  <div id="section3" style="background-color:gray">
  <p class="guideHeader">Vieraspelaajat</p>
  <a id="btnEvent3" href="#" style="text-decoration:none">
  <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_3</i>
  </a></div>
  <div class="line" style="background-color:gray"></div>

  <div id="section4" style="background-color:gray">
  <p class="guideHeader">Ennakkoteksti</p>
  <a id="btnEvent4" href="#" style="text-decoration:none">
  <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_4</i>
  </a></div>
  <div class="line" style="background-color:gray"></div>

  <div id="section5" style="background-color:gray">
  <p class="guideHeader">Mainospaikat</p>
  <a id="btnEvent5" href="#" style="text-decoration:none">
  <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_5</i>
  </a></div>
  <div class="line" style="background-color:gray"></div>

  <div id="section6" style="background-color:gray">
  <p class="guideHeader">Yhteenveto</p>
  <a id="btnEvent6" href="#" style="text-decoration:none">
  <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_6</i>
  </a></div>
  </div>

<div class="row">
  <div class="twelve columns">
    <span id="msg" class="msgError"></span>
  </div>
</div>
  <div class="row" style="border: solid 1px #D1D1D1;padding:15px;margin-top:20px">
<form name="form" id="info" action="functions.php" method="POST">
    <div class="twelve columns">
      <label for="eventName">Tapahtuman nimi</label>
      <input type="text" name="eventName" id="eventName" value="<?php
      if (isset($_SESSION['eventName'])) {
      echo $_SESSION['eventName'];
    }
        ?>">
      <label for="eventPlace">Tapahtuman paikka</label>
      <input type="text" name="eventPlace" id="eventPlace" value="<?php
      if (isset($_SESSION['eventPlace'])) {
         echo $_SESSION['eventPlace']; }
        ?>">

      <label for="eventdate">Tapahtuman pvm</label>
      <input type="text" name="eventDate" id="eventDate" value="<?php
      if (isset($_SESSION['eventDate'])) {
         echo $_SESSION['eventDate']; }
        ?>"> </div>
  </div>
  <div class="row">
    <div class="twelve columns" style="text-align:center;position:absolute;padding-top:50px">
      <button type="button" value="Takaisin" onclick="window.location='profile.php'"/>Takaisin</button>
      <input class="button-primary" type="submit" name="setEventInfo" id="btnEvent2" value="Seuraava">
</form>
  </div>
  </div>

</div>
<script>
$('#btnEvent2, #btnEvent3, #btnEvent4, #btnEvent5, #btnEvent6').click(function(event){
    var selected = ($(this).attr("id"));
    event.preventDefault(); // stop the form from submitting
    var eventname = $('#eventName').val();
    var eventplace = $('#eventPlace').val();
    var eventdate = $('#eventDate').val();
    var finish = $.post("functions.php", { setEventInfo: "eventinfo", eventName : eventname, eventPlace : eventplace, eventDate : eventdate}, function(data) {
      if(data){
        console.log(data);
      }
      message(data,selected);

    });
});
</script>

  <?php include('inc/footer.php'); ?>
