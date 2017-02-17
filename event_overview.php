<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
header("Location: index.php");
}
if (isset($_GET['eventId'])) {
$_SESSION['editEvent'] = true;
}
if (!isset($_SESSION['editEvent'])) {
header("Location: profile.php");
}
include ('inc/header.php');
include 'functions.php';
?>

<!-- Theme included stylesheets -->
<link href="css/quill.snow.css" rel="stylesheet">
<div id="cover"></div>
  <div class="container">
  <?php if (!isset($_GET['eventId'])) {
    echo '<div class="row" id="guide">
      <div class="twelve columns" style="text-align: center;">

  <a href="event1.php" style="text-decoration:none"><div id="section1" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">1</h3>
  </div></a>

  <a href="event2.php" style="text-decoration:none"><div id="section2" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">2</h3>
  </div></a>

  <a href="event3.php" style="text-decoration:none"><div id="section3" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">3</h3>
  </div></a>

  <a href="event4.php" style="text-decoration:none"><div id="section4" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">4</h3>
  </div></a>

  <a href="event5.php" style="text-decoration:none"><div id="section5" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">5</h3>
  </div></a>

  <a href="#" style="text-decoration:none"><div id="section6" style="float:left;width: 60px; height: 60px; background: green; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">6</h3>
  </div></a>

  </div>
  </div>'; }
  ?>

  <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fi_FI/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));</script>
  <div class="row">
    <div class="twelve columns">
      <div id="msg" class="msgError"></div>
      <div id="share">
      <div id="close">X</div>
      <div id="title">Valmista!</div>
      <div id="options" style="float:right;font-size:25px">
      <div id="shareText" style="padding-right:50px;float:right;">Jaa:</div>

      <div id="email" style="text-align:center">
      <a href="">
      <button id="emailBtn" type="button "style="background-color:black;color:white;width:144px">
      <i style="font-size:20px;padding-right:5px;width:25px;" class="ion-email"></i>Sähköposti</button></a>
      </div>

      <!--Facebook-->
      <div id="facebook" style="text-align:center">
      <div data-href="" data-layout="button"
      data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank"
      href="">
      <button id="fbBtn" type="button "style="background-color:black;color:white;width:144px">
      <i style="font-size:20px;padding-right:5px;width:25px;" class="ion-social-facebook"></i>Facebook</button></a>
      </div>
      </div>
      <!--Twitter-->
      <div id="twitter" style="text-align:center">
      <a href="">
      <button id="twitterBtn" type="button "style="background-color:black;color:white;width:144px">
      <i style="font-size:20px;padding-right:5px;width:25px;" class="ion-social-twitter"></i>Twitter</button></a>
      </div>
      <!--Whatsapp-->
      <div id="whatsapp" style="text-align:center">
      <a href="whatsapp://send?text=Hello world">
      <button id="whatsappBtn" type="button "style="background-color:black;color:white;width:144px">
      <i style="font-size:20px;padding-right:5px;width:25px;" class="ion-social-whatsapp"></i>Whatsapp</button></a>
      </div>

      <div id="link" style="text-align:center">
      <button id="linkBtn" data-clipboard-text="copy" type="button" style="background-color:white;width:144px">Kopioi linkki</button>
      </div>
      </div>
      <div id="qrCode" style="padding-top:40px;width:150px"></div>
      <div id="saveQr" style="margin-top:48px"><button style="width:144px;">Tallenna QR</div>
        <a style="display:none" href="#" id="download"></a>
      </div>
    </div>
  </div>

    <div class="row">
<br>
      <div class="twelve columns" style="text-align: center;">

      </div>
      </div>

    <div class="row">

      <div class="six columns">
        <h4>
          <span><?php
           echo $_SESSION['eventName'];
            ?></span>
        </h4>
        <h5>
          <span><?php
            if (isset($_SESSION['homeName'])) {
            echo $_SESSION['homeName'];
          } else {
            echo $_SESSION['teamName'];
          }
            ?></span>
        </h5>
         <table class="u-full-width">
          <?php showHome();
          ?>
          </table>
      </div>

      <div class="six columns">
        <h4>
          <span><?php
            echo $_SESSION['eventDate'];
            ?></span>
        </h4>
        <h5>
          <span><?php if (isset($_SESSION['visitorName'])) {
            echo $_SESSION['visitorName'];
          } else {
            echo '<h4 style="color:gray">Lisää vierasjoukkueen nimi!</h4>';
          }
            ?></span>
        </h5>
          <table class="u-full-width">
          <?php
          showVisitors();
          ?>
        </table>
      </div>
    <div class="twelve columns" style="text-align: center;">
      <h4>
        <span>Ennakkoteksti</span>
      </h4>
      <span><?php if (isset($_SESSION['matchText'])) {
        echo '<div id="editor" class="twelve columns" style="font-size:17px;border:none;min-height:200px">';
        echo '</div>';
      } else {
        echo '<h3 style="color:gray">Ei ennakkotekstiä</h3>';
      }
        ?></span>
    </div>
    </div>
    </div>
    <div class="row">
      <div class="twelve columns" style="text-align:center;position:absolute;padding-top:50px">
       <?php
       if (isset($_GET['eventId'])) {
      $eventId = $_GET['eventId'];
    }
      $url = "event5.php";
      $url2 = "event1.php";
        if (isset($_GET['c'])) {
       echo "<button type='button' value='Takaisin' onclick='window.location=\"$url\"'/>";
       echo "Takaisin</button>";
       if ((isset($_SESSION['saved']) || isset($_SESSION['home'])) && $_SESSION['visitorName'] && $_SESSION['visitors']) {
       echo "<form style='display: inline;padding: 5px' action='functions.php' method='POST'>";
       echo "<button class='button-primary' type='submit' name='createEvent' id='createEvent' value='Tallenna'>";
       echo "Tallenna</button>";
       echo "</form>"; }
     } else if (isset($_GET['eventId'])) {
       echo "<form style='display: inline;padding: 5px' action='functions.php?removeEvent=".$eventId."' method='POST'>";
       echo "<button style='border-color:gray;background-color:red;' class='button-primary' name='removeEvent' type='submit' id='btnremoveEvent' value='Poista'>";
       echo "Poista</button>";
       echo "</form>";
       echo "<button class='button-primary' type='button' value='Muokkaa' onclick='window.location=\"$url2\"'/>";
       echo "Muokkaa</button>";

} ?>
      </div>
    </div>

  </div>
  <script>
  function downloadCanvas(link, canvasId, filename) {
    link.href = document.getElementById(canvasId).children[0].toDataURL();
    link.download = filename;
}
  document.getElementById('download').addEventListener('click', function() {
      downloadCanvas(this, 'qrCode', 'QR.png');
  }, false);

  $('#saveQr').click(function(event){
    console.log('asdsa');
     $("#download")[0].click();
  });

  $('#close').click(function(event){
  $("#cover").fadeOut();
  $("#share").fadeOut();
  setTimeout(function () {
 window.location.href = "profile.php";
}, 1000);

  });
  $('#linkBtn').click(function(event){
  var clipboard;
  if(clipboard = new Clipboard('#linkBtn')) {
  message('copySuccess');
  clipboard.destroy;
} else {
  message('copyFail');
  clipboard.destroy;
}
  });

  $('#createEvent').click(function(event){
      event.preventDefault(); // stop the form from submitting
      var finish = $.post("functions.php", { createEvent: "createEvent"}, function(data) {
        if(data){
          console.log(data);
          var eventId = data.substring(data.indexOf('=')+1);
          data = data.substring(0, data.indexOf('='));
        }
        message(data,eventId);

      });
  });
  </script>
  <!-- Main Quill library -->
  <script src="js/quill.min.js"></script>
  <script>
  var options = {
    modules: {
    toolbar: null
  },
    readOnly: true,
    scrollingContainer: true,
    theme: 'snow'
  };
  var editor = new Quill('#editor', options);
  <?php
  if (isset($_SESSION['matchText'])) {
  echo 'editor.setContents ('.$_SESSION['matchText'].');';
}
  echo '</script>';
  ?>
  <?php include('inc/footer.php'); ?>
