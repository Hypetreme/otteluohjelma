<?php
session_start();
include ('dbh.php');
include ('functions.php');
include ('inc/header.php');
?>
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
    <div class="section1">
    <p class="guide-header">Tapahtuman tiedot</p>
    <a href="event1.php" style="text-decoration:none">
    <i class="material-icons guide">filter_1</i>
    </a></div>
    <div class="line"></div>

    <div class="section2">
    <p class="guide-header">Kotipelaajat</p>
    <a href="event2.php" style="text-decoration:none">
    <i class="material-icons guide">filter_2</i>
    </a></div>
    <div class="line"></div>

    <div class="section3">
    <p class="guide-header">Vieraspelaajat</p>
    <a href="event3.php" style="text-decoration:none">
    <i class="material-icons guide">filter_3</i>
    </a></div>
    <div class="line"></div>

    <div class="section4">
    <p class="guide-header">Ennakkoteksti</p>
    <a href="event4.php" style="text-decoration:none">
    <i class="material-icons guide">filter_4</i>
    </a></div>
    <div class="line"></div>

    <div class="section5">
    <p class="guide-header">Mainospaikat</p>
    <a href="event5.php" style="text-decoration:none">
    <i class="material-icons guide">filter_5</i>
    </a></div>
    <div class="line" style="background-color:#2bc9c9"></div>

    <div class="section6" style="background-color:#2bc9c9">
    <p class="guide-header">    Kilpailu</p>
    <a href="#" style="text-decoration:none">
    <i class="material-icons guide">filter_6</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div class="section7" style="background-color:gray">
    <p class="guide-header">Yhteenveto</p>
    <a class="btnEvent7" href="#" style="text-decoration:none">
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
      <label for="guess-name">Kilpailun otsikko</label>
      <input type="text" id="guess-name" maxlength="50" value="<?php if (isset($_SESSION['event']['guessName'])) {
        echo $_SESSION['event']['guessName'];
      }?>">
      <label for="eventPlace">Kilpailun tyyppi</label>

      <select id="guess-type">
        <option <?php if (!isset($_SESSION['event']['guessType'])) { echo ' selected'; } ?> value="0">Ei mitään</option>
        <option <?php if (isset($_SESSION['event']['guessType']) && $_SESSION['event']['guessType'] == 1) { echo ' selected'; } ?> value="1">Kotijoukkueen pelaajat</option>
        <option <?php if (isset($_SESSION['event']['guessType']) && $_SESSION['event']['guessType'] == 2) { echo ' selected'; } ?> value="2">Vierasjoukkueen pelaajat</option>
        <option <?php if (isset($_SESSION['event']['guessType']) && $_SESSION['event']['guessType'] == 3) { echo ' selected'; } ?> value="3">Kaikki pelaajat</option>
        <option <?php if (isset($_SESSION['event']['guessType']) && $_SESSION['event']['guessType'] == 4) { echo ' selected'; } ?> value="4">Kellonaika</option>
      </select>

       </div>
        </form>
  </div>
    </div>
    <div class="twelve columns event-buttons">
      <button type="button" value="Takaisin" onclick="window.location='event5.php'"/>Takaisin</button>
      <input form="form" class="button-primary btnEvent7" type="submit" value="Seuraava">
    </div>
<script>
$('.btnEvent7').click(function(event){
    event.preventDefault();
    var guessname = $('#guess-name').val();
    var guesstype = $('#guess-type').val();
    var finish = $.post("functions.php", { setEventGuess: "guess", guessName : guessname, guessType : guesstype }, function(data) {
      if(data){
        console.log(data);
      }
      message(data);

    });
});
</script>

  <?php include('inc/footer.php'); ?>
