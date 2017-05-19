<?php
session_start();
include ('dbh.php');
include ('functions.php');
include ('unset.php');
include ('inc/header.php');
?>

<!-- Theme included stylesheets -->
<link href="css/quill.snow.css" rel="stylesheet">
<div class="cover" id="cover"></div>
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
  <?php if (!isset($_GET['eventId'])) {
    echo '<div class="twelve columns" style="text-align:center;margin-top:35px;margin-bottom: 20px;">

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
      <div class="line"></div>

      <div class="section6">
      <p class="guide-header">    Kilpailu</p>
      <a href="event6.php" style="text-decoration:none">
      <i class="material-icons guide">filter_6</i>
      </a></div>
      <div class="line" style="background-color:#2bc9c9"></div>

      <div class="section7" style="background-color:#2bc9c9">
      <p class="guide-header">Yhteenveto</p>
      <a href="#" style="text-decoration:none">
      <i class="material-icons guide">filter_7</i>
      </a></div>
    </div>';
}
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
      <div class="msg msg-fail" id="msg"></div>
      <div class="share" id="share">
      <div class="close" id="close">X</div>
      <div class="complete" id="complete">Valmista!</div>
      <div id="options" style="float:right;font-size:25px">
      <div id="shareText" style="padding-right:50px;float:right;">Jaa:</div>

      <div class="email" id="email" style="text-align:center">
      <a href="">
      <button class="email-btn" type="button "style="background-color:black;color:white;width:144px">
      <i style="font-size:20px;padding-right:5px;width:25px;" class="ion-email"></i>Sähköposti</button></a>
      </div>

      <!--Facebook-->
      <div id="facebook" style="text-align:center">
      <div data-href="" data-layout="button"
      data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank"
      href="">
      <button class="fb-btn" type="button "style="background-color:black;color:white;width:144px">
      <i style="font-size:20px;padding-right:5px;width:25px;" class="ion-social-facebook"></i>Facebook</button></a>
      </div>
      </div>
      <!--Twitter-->
      <div id="twitter" style="text-align:center">
      <a href="">
      <button class="twitter-btn" type="button" style="background-color:black;color:white;width:144px">
      <i style="font-size:20px;padding-right:5px;width:25px;" class="ion-social-twitter"></i>Twitter</button></a>
      </div>
      <!--Whatsapp-->
      <div id="whatsapp" style="text-align:center">
      <a href="whatsapp://send?text=Hello world">
      <button class="whatsapp-btn" type="button "style="background-color:black;color:white;width:144px">
      <i style="font-size:20px;padding-right:5px;width:25px;" class="ion-social-whatsapp"></i>Whatsapp</button></a>
      </div>

      <div id="link" style="text-align:center">
      <button id="linkBtn" class="link-btn" data-clipboard-text="copy" type="button" style="background-color:white;width:144px">Kopioi linkki</button>
      </div>
      </div>
      <div id="qrCode" style="padding-top:40px;width:150px"></div>
      <div id="saveQr" style="margin-top:48px"><button style="width:144px;">Tallenna QR</div>
        <a style="display:none" href="#" id="download"></a>
      </div>
    </div>
  </div>

    <div class="row">
    </div>

    <div class="shadow-box2">

      <div class="six columns">
        <h4 style="color:#6f6f67">
          <?php
           echo $_SESSION['event']['name'];
            ?>
        </h4>
        <h5 style="color:#6f6f67">
          <?php
            if (isset($_SESSION['event']['homeName'])) {
                echo $_SESSION['event']['homeName'];
            } else {
                echo $_SESSION['teamName'];
            }
            ?>
        </h5>
         <table class="u-full-width">
          <?php showHomeTeam();
          ?>
          </table>
      </div>

      <div class="six columns">
        <h4 style="color:#6f6f67">
          <?php
            echo $_SESSION['event']['date'];
            ?>
        </h4>
        <h5 style="color:#6f6f67">
          <?php if (isset($_SESSION['event']['visitorName'])) {
                echo $_SESSION['event']['visitorName'];
            } else {
                echo '<h4 style="color:gray">Lisää vierasjoukkueen nimi!</h4>';
            }
            ?>
        </h5>
          <table class="u-full-width">
          <?php
          showVisitorTeam();
          ?>
        </table>
      </div>
    <div class="twelve columns" style="text-align: center;">
      <h4 style="color:#6f6f67">
        Ennakkoteksti
      </h4>
      <?php if (isset($_SESSION['event']['matchText'])) {
              echo '<div id="editor" class="twelve columns" style="font-size:17px;border:none;min-height:200px">';
              echo '</div>';
          } else {
              echo '<h3 style="color:gray">Ei ennakkotekstiä</h3>';
          }
        ?>
    </div>
    </div>
    </div>
      <div class="twelve columns event-buttons">
       <?php
       if (isset($_GET['eventId'])) {
           $eventId = $_GET['eventId'];
       }
      $url = "event6.php";
      $url2 = "event1.php";
        if (isset($_GET['c'])) {
            echo "<button type='button' value='Takaisin' onclick='window.location=\"$url\"'/>";
            echo "Takaisin</button>";
            if ((isset($_SESSION['event']['saved']) || isset($_SESSION['event']['home'])) && $_SESSION['event']['visitorName'] && $_SESSION['event']['visitors']) {
                echo "<form style='display: inline;padding: 5px' action='functions.php' method='POST'>";
                echo "<button class='button-primary' type='submit' id='createEvent' value='Tallenna'>";
                echo "Tallenna</button>";
                echo "</form>";
            }
        } elseif (isset($_GET['eventId'])) {
            echo "<form style='display: inline;padding: 5px' action='functions.php?removeEvent=".$eventId."' method='POST'>";
            echo "<button class='remove-btn' type='submit' id='removeEvent' value='Poista'>";
            echo "Poista</button>";
            echo "</form>";
            echo "<button class='button-primary' type='button' value='Muokkaa' onclick='window.location=\"$url2\"'/>";
            echo "Muokkaa</button>";
        } ?>
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
 window.location.href = "index.php";
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
      event.preventDefault();
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
  if (isset($_SESSION['event']['matchText'])) {
      echo 'editor.setContents ('.$_SESSION['event']['matchText'].');';
  }
  echo '</script>';
  ?>
  <?php include('inc/footer.php'); ?>
