<?php

session_start();
include ('dbh.php');
include ('functions.php');

include ('inc/header.php');
?>
<link rel="stylesheet" href="inc/widgets/datepicker/classic.css">
<link rel="stylesheet" href="inc/widgets/datepicker/classic.date.css">
<script src="inc/widgets/datepicker/picker.js"></script>
<script src="inc/widgets/datepicker/picker.date.js"></script>
<script>
datePicker();
</script>
<div class="header-bg"></div>
<div class="container" style="padding-bottom:60px;">
  <div class="row">
    <div class="twelve columns">
      <div class="section-header">
      <h4>
        Tapahtuma
         </h4>
       </div>
    </div>
  </div>
  <div class="twelve columns" style="text-align:center;margin-top:35px;margin-bottom: 20px;">
  <div class="section1" style="background-color:#2bc9c9">
  <p class="guide-header">Tapahtuman tiedot</p>
  <a href="#" style="text-decoration:none">
  <i class="material-icons guide">filter_1</i>
  </a></div>
  <div class="line" style="background-color:gray"></div>

  <div class="section2" style="background-color:gray">
  <p class="guide-header">Kotipelaajat</p>
  <a id="btnEvent2" href="#" style="text-decoration:none">
  <i class="material-icons guide">filter_2</i>
  </a></div>
  <div class="line" style="background-color:gray"></div>

  <div class="section3" style="background-color:gray">
  <p class="guide-header">Vieraspelaajat</p>
  <a id="btnEvent3" href="#" style="text-decoration:none">
  <i class="material-icons guide">filter_3</i>
  </a></div>
  <div class="line" style="background-color:gray"></div>

  <div class="section4" style="background-color:gray">
  <p class="guide-header">Ennakkoteksti</p>
  <a id="btnEvent4" href="#" style="text-decoration:none">
  <i class="material-icons guide">filter_4</i>
  </a></div>
  <div class="line" style="background-color:gray"></div>

  <div class="section5" style="background-color:gray">
  <p class="guide-header">Mainospaikat</p>
  <a id="btnEvent5" href="#" style="text-decoration:none">
  <i class="material-icons guide">filter_5</i>
  </a></div>
  <div class="line" style="background-color:gray"></div>

  <div class="section6" style="background-color:gray">
  <p class="guide-header">    Kilpailu</p>
  <a id="btnEvent6" href="#" style="text-decoration:none">
  <i class="material-icons guide">filter_6</i>
  </a></div>
  <div class="line" style="background-color:gray"></div>

  <div class="section7" style="background-color:gray">
  <p class="guide-header">Yhteenveto</p>
  <a id="btnEvent7" href="#" style="text-decoration:none">
  <i class="material-icons guide">filter_7</i>
  </a></div>
  </div>

<div class="row">
  <div class="twelve columns">
    <span class="msg msg-fail" id="msg"></span>
  </div>
</div>
  <div class="shadow-box2">
<form id="form">
    <div class="twelve columns">
      <label for="eventName">Tapahtuman nimi</label>
      <input maxlength="30" type="text" id="eventName" value="<?php
      if (isset($_SESSION['event']['name'])) {
          echo $_SESSION['event']['name'];
      }
        ?>">
      <label for="eventPlace">Tapahtuman paikka</label>
      <input maxlength="30" type="text" id="eventPlace" value="<?php
      if (isset($_SESSION['event']['place'])) {
          echo $_SESSION['event']['place'];
      }
        ?>">

      <label for="eventdate">Tapahtuman pvm</label>
      <input maxlength="30" class="calendar" type="text" id="eventDate" value="<?php
      if (isset($_SESSION['event']['date'])) {
          echo $_SESSION['event']['date'];
      }
        ?>"> </div>
        </form>
  </div>
    </div>
    <div class="twelve columns event-buttons">
      <button type="button" value="Takaisin" onclick="window.location='index.php'"/>Takaisin</button>
      <input form="form" class="button-primary" type="submit" id="btnEvent2" value="Seuraava">
    </div>
<script>
$('#btnEvent2, #btnEvent3, #btnEvent4, #btnEvent5, #btnEvent6, #btnEvent7').click(function(event){
    var selected = ($(this).attr("id"));
    event.preventDefault();
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
