<?php
  session_start();
  include ('dbh.php');
  if (isset($_SESSION['teamId'])) {
  $teamId = $_SESSION['teamId'];
}
  if (!isset($_SESSION['id'])) {
    header("Location: index.php");
  }
  unset($_SESSION['homeName']);
  unset($_SESSION['visitorName']);
  unset($_SESSION['eventId']);
  unset($_SESSION['eventName']);
  unset($_SESSION['eventPlace']);
  unset($_SESSION['eventDate']);
  unset($_SESSION['home']);
  unset($_SESSION['visitors']);
  unset($_SESSION['saved']);
  unset($_SESSION['matchText']);
  unset($_SESSION['plainMatchText']);
  unset($_SESSION['ads']);
  //unset($_SESSION['adlinks']);
  unset($_SESSION['editEvent']);
  include ('functions.php');
  include ('inc/header.php');

  $ad1 = $ad2 = $ad3 = $ad4 = 'images/default_ad.png';

  $ownerId = $_SESSION['ownerId'];

  // Seuran asettamat mainokset
  $fileName1s = 'images/ads/s_'.$ownerId.'_ad1.png';
  $fileName2s = 'images/ads/s_'.$ownerId.'_ad2.png';
  $fileName3s = 'images/ads/s_'.$ownerId.'_ad3.png';
  $fileName4s = 'images/ads/s_'.$ownerId.'_ad4.png';

  // Joukkueen asettamat mainokset
  if (isset($_SESSION['teamId'])) {
  $teamId   =  $_SESSION['teamId'];
  $teamUid   =  $_SESSION['teamUid'];
  $fileName1j = 'images/ads/j_'.$teamUid.$teamId.'_ad1.png';
  $fileName2j = 'images/ads/j_'.$teamUid.$teamId.'_ad2.png';
  $fileName3j = 'images/ads/j_'.$teamUid.$teamId.'_ad3.png';
  $fileName4j = 'images/ads/j_'.$teamUid.$teamId.'_ad4.png';
}
  if (file_exists($fileName1s)){
  $ad1 = $fileName1s;
} else if (isset($_SESSION['teamId']) && file_exists($fileName1j)){
  $ad1 = $fileName1j;
}
if (file_exists($fileName2s)){
$ad2 = $fileName2s;
} else if (isset($_SESSION['teamId']) && file_exists($fileName2j)){
$ad2 = $fileName2j;
}
if (file_exists($fileName3s)){
$ad3 = $fileName3s;
} else if (isset($_SESSION['teamId']) && file_exists($fileName3j)){
$ad3 = $fileName3j;
}
if (file_exists($fileName4s)){
$ad4 = $fileName4s;
} else if (isset($_SESSION['teamId']) &&file_exists($fileName4j)){
$ad4 = $fileName4j;
}
?>
<link rel="stylesheet" type="text/css" href="css/cropit.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="js/jquery.cropit.js"></script>
<span id="msg" class="msgError"></span>
  <div class="container">
    <div class="row">
      <div class="twelve columns" style="text-align:center">
        <h4>Mainospaikat</h4>
      </div>

    </div>
    <div style="float:left;" class="row">
      <div class="six columns" style="text-align:center">
        <h5 style="margin-bottom:0" id="adHeader">&nbsp;</h5>
        <span id="upload" style="visibility:hidden;">

        <form method="POST" enctype="multipart/form-data">
        <tbody>
        <tr>
          <div class="image-editor" id="crop">
      <div style="display:inline-block">
            <div id="preview" class="cropit-image-preview"><div class="error-msg"></div></div>
          </div>
            <input style="display:inline-block" type="file" class="cropit-image-input">
            <label for="zoom">Zoomaus</label>
            <input id="zoom" style="display:inline-block;" type="range" class="cropit-image-zoom-input">
            <?php
            listAdLinks();
            ?>
            <input type="hidden" id="image-data" name="image-data" class="hidden-image-data" />
            <button id="submitAd" class="button-primary" type="submit">Tallenna</button>
    </form>
    </div>
      </span>
    </div>
    <div style="float:left;margin-left:auto ;margin-right:auto;width:360px;height:680px;background-image: url(images/phone.jpg);background-repeat:no-repeat;">
      <div class="six columns" style="text-align:center">
      <div id="adSelector" style="position: relative;margin-left: auto;margin-right: auto;width: 360px;height: 680px;solid;top: 59px;">
        <?php
        if (file_exists($fileName1s) && isset($_SESSION['teamId'])){
        echo '<div class="reserved" onclick="notify(this);" id="1" style="margin-left:auto;margin-right:auto;text-align:center;border-width:3px;border-style:solid;border-color:red;width:218px;height:71px;"><img style="height:65px;width:212px" src="'.$ad1.'"></div>';
      } else {
        echo '<div onclick="addAd(this);" id="1" style="margin-left:auto;margin-right:auto;text-align:center;border-width:3px;border-style:solid;border-color:transparent;width:218px;height:71px;"><img style="height:65px;width:212px" src="'.$ad1.'"></div>';
      }
      echo '<div style="color:white"><h2>Pelaajat</h2></div>';
      echo '<div style="color:white"><h3>Kotijoukkue</h3></div>';
      echo '<div style="color:white"><h5>Pelaaja Yksi</h5></div>';
      echo '<div style="color:white"><h5>Pelaaja Kaksi</h5></div>';
      if (file_exists($fileName2s) && isset($_SESSION['teamId'])){
      echo '<div class="reserved" onclick="notify(this);" id="2" style="margin-left:auto;margin-right:auto;text-align:center;border-width:3px;border-style:solid;border-color:red;width:218px;height:71px;"><img style="height:65px;width:212px" src="'.$ad2.'"></div>';
    } else {
      echo '<div onclick="addAd(this);" id="2" style="margin-left:auto;margin-right:auto;text-align:center;border-width:3px;border-style:solid;border-color:transparent;width:218px;height:71px;"><img style="height:65px;width:212px" src="'.$ad2.'"></div>';
    }
      echo '<div style="color:white"><h3>Vierasjoukkue</h3></div>';
      echo '<div style="color:white"><h5>Pelaaja Yksi</h5></div>';
      echo '<div style="color:white"><h5>Pelaaja Kaksi</h5></div>';
        ?>
      </div>
      </div>
    </div>
    </div>

  </div>

  <script>
var imageData = "";
var url = "";
$('.image-editor').cropit(
    {
      onImageError: function() {
            $('#preview').css("background-image", "none");
            imageData = "";
            message('imgError');

        },
        onImageLoaded: function() {
              $('#image-data').val("");
              $('#image-data').val($('.image-editor').cropit('export'));
              imageData = $('#image-data').val();
          }
    }
);

      $("#1, #2, #3, #4").on("mouseenter focus", function(){
        if(!$(this).hasClass('active')){
        $(this).css({"border-color":"orange"});
        $(this).css({"border-style":"solid"});
        $(this).css({"border-width":"3px"});
      }
      });
      $("#1, #2, #3, #4").on("mouseleave", function(){
         if(!$(this).hasClass('active')){
        $(this).css({"border-color":"transparent"});
        $(this).css({"border-width":"3px"});
      }
      if($(this).hasClass('reserved')){
      $(this).css({"border-color":"red"});
      $(this).css({"border-width":"3px"});
      }
      });

  function addAd(element) {
    $(function(){
        $("#1").removeClass('active')
        if(!$("#1").hasClass('reserved')){
        $("#1").css({"border-color":"transparent"});
      }
        $("#2").removeClass('active')
        if(!$("#2").hasClass('reserved')){
        $("#2").css({"border-color":"transparent"});
        }
        $("#3").removeClass('active')
        if(!$("#3").hasClass('reserved')){
        $("#3").css({"border-color":"transparent"});
        }
        $("#4").removeClass('active')
        if(!$("#4").hasClass('reserved')){
        $("#4").css({"border-color":"transparent"});
        }
        $(element).addClass('active')
        $(element).css({"border-color":"#2def30"});
        $(element).css({"border-width":"3px"});
    });
$("#adHeader").css({"color":"black"});
document.getElementById('adHeader').innerHTML="Mainoskuva "+element.id;
document.getElementById('upload').style="visibility:visible;";
document.getElementById('submitAd').value=element.id;
document.getElementById('linkHeader').style="initial";
document.getElementById('link1').style="display:none;";
document.getElementById('link2').style="display:none";
document.getElementById('link3').style="display:none";
document.getElementById('link4').style="display:none";
if (element.id == 1) {
document.getElementById('link1').style="display:inline-block;width:180px";
} else if (element.id == 2) {
document.getElementById('link2').style="display:inline-block;width:180px";
}
url = document.getElementById(element.id).children[0].src;

//Ladataan asetettu kuva esikatselua varten
$('#preview').css("background-image", "none");
$('#image-data').val("");
imageData = "";

if (url != 'http://localhost/otteluohjelma/images/default_ad.png' && url != 'www.otteluohjelma.fi/login/images/default_ad.png' && url != 'otteluohjelma.fi/login/images/default_ad.png') {
$('.image-editor').cropit('imageSrc', url);
}
}
function notify(element) {
$("#1").removeClass('active')
if(!$("#1").hasClass('reserved')){
$("#1").css({"border-color":"transparent"});
}
$("#2").removeClass('active')
if(!$("#2").hasClass('reserved')){
$("#2").css({"border-color":"transparent"});
}
$("#3").removeClass('active')
if(!$("#3").hasClass('reserved')){
$("#3").css({"border-color":"transparent"});
}
$("#4").removeClass('active')
if(!$("#4").hasClass('reserved')){
$("#4").css({"border-color":"transparent"});
}
if($(element).hasClass('reserved')){
$(element).css({"border-color":"red"});
$(element).css({"border-width":"3px"});
}
$("#adHeader").css({"color":"red"});
document.getElementById('adHeader').innerHTML="Seurasi on asettanut mainospaikan!";
document.getElementById('upload').style="visibility:hidden";
document.getElementById('submitAd').name="adUpload";
}

$('form').submit(function(event){
      event.preventDefault(); // stop the form from submitting

      var ad = $('#submitAd').val();
      var adlink1 = $('#link1').val();
      var adlink2 = $('#link2').val();
      var adlink3 = $('#link3').val();
      var adlink4 = $('#link4').val();
      var finish = $.post("functions.php", { submitAd: ad, imgData: imageData , link1: adlink1, link2: adlink2, link3: adlink3, link4: adlink4 }, function(data) {
        if(data){
          console.log(data);
        }
        message(data);
      });
  });
</script>

  <?php
    include ('inc/footer.php');
  ?>
