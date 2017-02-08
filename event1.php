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
  <div class="row" id="guide">
    <div class="twelve columns" style="text-align: center;">
    <a href="#" style="text-decoration:none"><div id="section1" style="float:left;width: 60px; height: 60px; background: green; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
    <h3 style="color:white;padding-top:5px">1</h3>
  </div></a>

<div id="section2" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<input form="info" id="btnEvent2" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" value ="2">
</div>

<div id="section3" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<input form="info" id="btnEvent3" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" value="3">
</div>

<div id="section4" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<input form="info" id="btnEvent4" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" value="4">
</div>

<div id="section5" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<input form="info" id="btnEvent5" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" value="5">
</div>

<div id="section6" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<input form="info" id="btnEvent6" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" value="6">
</div>

</div>
</div>
<div class="row">
  <div class="twelve columns">
    <span id="msg" class="msgError"></span>
  </div>
</div>
  <div class="row">
    <div class="twelve columns" style="text-align: center;">
      <h4>
        <span>Tapahtuman tiedot</span>
      </h4>
    </div>

  </div>
<form name="form" id="info" action="functions.php" method="POST">
  <div class="row">
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
$('#btnEvent1, #btnEvent2, #btnEvent3, #btnEvent4, #btnEvent5, #btnEvent6').click(function(event){
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
