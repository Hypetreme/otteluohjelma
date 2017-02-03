<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
header("Location: index.php");
}
if (!isset($_SESSION['editEvent'])) {
header("Location: profile.php");
}
include ('inc/header.php');
include ('functions.php');

$ad1 = $ad2 = $ad3 = $ad4 = 'images/default_ad.png';
$teamId = $teamUid = "";
if (isset($_SESSION['teamId'])) {
$teamId   =  $_SESSION['teamId'];
$teamUid   =  $_SESSION['teamUid'];
}

$ownerId = $_SESSION['ownerId'];

// Seuran asettamat mainokset
$fileName1s = 'images/ads/s_'.$ownerId.'_ad1.png';
$fileName2s = 'images/ads/s_'.$ownerId.'_ad2.png';
$fileName3s = 'images/ads/s_'.$ownerId.'_ad3.png';
$fileName4s = 'images/ads/s_'.$ownerId.'_ad4.png';

// Joukkueen asettamat mainokset
$fileName1j = 'images/ads/j_'.$teamUid.$teamId.'_ad1.png';
$fileName2j = 'images/ads/j_'.$teamUid.$teamId.'_ad2.png';
$fileName3j = 'images/ads/j_'.$teamUid.$teamId.'_ad3.png';
$fileName4j = 'images/ads/j_'.$teamUid.$teamId.'_ad4.png';

// Seuran asettamat mainokset tapahtumanluonnissa (väiaikaiset)
$fileName1es = 'images/ads/e_'.$ownerId.'_ad1.png';
$fileName2es = 'images/ads/e_'.$ownerId.'_ad2.png';
$fileName3es = 'images/ads/e_'.$ownerId.'_ad3.png';
$fileName4es = 'images/ads/e_'.$ownerId.'_ad4.png';

// Joukkueen asettamat mainokset tapahtumanluonnissa (väiaikaiset)
$fileName1ej = 'images/ads/e_'.$teamUid.$teamId.'_ad1.png';
$fileName2ej = 'images/ads/e_'.$teamUid.$teamId.'_ad2.png';
$fileName3ej = 'images/ads/e_'.$teamUid.$teamId.'_ad3.png';
$fileName4ej = 'images/ads/e_'.$teamUid.$teamId.'_ad4.png';

if (file_exists($fileName1es)){
$ad1 = $fileName1es;
} else if (file_exists($fileName1ej)){
$ad1 = $fileName1ej;
} else if (file_exists($fileName1s)){
$ad1 = $fileName1s;
} else if (isset($_SESSION['teamId']) && file_exists($fileName1j)){
$ad1 = $fileName1j;
}
if (file_exists($fileName2es)){
$ad2 = $fileName2es;
} else if (file_exists($fileName2ej)){
$ad2 = $fileName2ej;
} else if (file_exists($fileName2s)){
$ad2 = $fileName2s;
} else if (isset($_SESSION['teamId']) && file_exists($fileName2j)){
$ad2 = $fileName2j;
}
if (file_exists($fileName3es)){
$ad3 = $fileName3es;
} else if (file_exists($fileName3ej)){
$ad3 = $fileName3ej;
} else if (file_exists($fileName3s)){
$ad3 = $fileName1s;
} else if (isset($_SESSION['teamId']) && file_exists($fileName3j)){
$ad3 = $fileName3j;
}
if (file_exists($fileName4es)){
$ad4 = $fileName4es;
} else if (file_exists($fileName4ej)){
$ad4 = $fileName4ej;
} else if (file_exists($fileName4s)){
$ad4 = $fileName4s;
} else if (isset($_SESSION['teamId']) && file_exists($fileName4j)){
$ad4 = $fileName4j;
}
?>
<link rel="stylesheet" type="text/css" href="css/cropit.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="js/jquery.cropit.js"></script>

<div class="container">
  <div class="row" id="guide">
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

<a href="#" style="text-decoration:none"><div id="section5" style="float:left;width: 60px; height: 60px; background: green; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<h3 style="color:white;padding-top:5px">5</h3>
</div></a>

<a href="event_overview.php?c" style="text-decoration:none"><div id="section6" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<h3 style="color:white;padding-top:5px">6</h3>
</div></a>

</div>
</div>
  <span id="msg" class="msgError"></span>
  <div class="row">
    <div class="twelve columns" style="text-align: center;">
      <h4>
        <span>Mainospaikat</span>
      </h4>
    </div>

  </div>
  <div class="row" style="float:left">
    <div class="six columns" style="text-align: center;">
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

  <div style="float:left;margin-left:auto ;margin-right:auto;width:375px;height:709px;background-image: url(images/phone.jpg);background-repeat:no-repeat;">
    <div class="six columns" style="text-align:center">
      <div id="adSelector" style="position: relative;margin-left: auto;margin-right: auto;width: 360px;height: 680px;solid;top: 59px;">
        <?php
        if (file_exists($fileName1s) || file_exists($fileName1j)){
          echo '<div class="reserved" onclick="notify(this);" id="1" style="margin-left:auto;margin-right:auto;text-align:center;border-width:3px;border-style:solid;border-color:red;width:218px;height:71px;"><img style="height:65px;width:212px" src="'.$ad1.'"></div>';
        } else {
          echo '<div onclick="addAd(this);" id="1" style="margin-left:auto;margin-right:auto;text-align:center;border-width:3px;border-style:solid;border-color:transparent;width:218px;height:71px;"><img style="height:65px;width:212px" src="'.$ad1.'"></div>';
        }
      echo '<div style="color:white"><h2>Pelaajat</h2></div>';
      echo '<div style="color:white"><h3>Kotijoukkue</h3></div>';
      echo '<div style="color:white"><h5>Pelaaja Yksi</h5></div>';
      echo '<div style="color:white"><h5>Pelaaja Kaksi</h5></div>';
      if (file_exists($fileName2s) || file_exists($fileName2j)){
        echo '<div class="reserved" onclick="notify(this);" id="2" style="margin-left:auto;margin-right:auto;text-align:center;border-width:3px;border-style:solid;border-color:red;width:218px;height:71px;"><img style="height:65px;width:212px" src="'.$ad2.'"></div>';
      } else {
        echo '<div onclick="addAd(this);" id="2" style="margin-left:auto;margin-right:auto;text-align:center;border-width:3px;border-style:solid;border-color:transparent;width:218px;height:71px;"><img style="height:65px;width:212px" src="'.$ad2.'"></div>';
      }
      echo '<div style="color:white"><h3>Vierasjoukkue</h3></div>';
      echo '<div style="color:white"><h5>Pelaaja Yksi</h5></div>';
      echo '<div style="color:white"><h5>Pelaaja Kaksi</h5></div>';
  /*if (file_exists($fileName3s) || file_exists($fileName3j)){
  echo '<div class="reserved" onclick="notify(this);" id="3" style="border-width:3px;border-color:red;position:absolute;bottom:9.5%;border-style:solid;width:100%;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad3.');">AD 3</div>';
} else {
  echo '<div onclick="addAd(this);" id="3" style="border-width:3px;position:absolute;bottom:9.5%;border-style:solid;width:100%;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad3.');">AD 3</div>';
}
if (file_exists($fileName4s) || file_exists($fileName4j)){
echo '<div class="reserved" onclick="notify(this);" id="4" style="border-width:3px;border-color:red;position:absolute;bottom:0;border-style:solid;width:100%;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad4.');">AD 4</div>';
} else {
echo '<div onclick="addAd(this);" id="4" style="border-width:1px;position:absolute;bottom:0;border-style:solid;width:100%;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad4.');">AD 4</div>';
}*/
      ?>
    </div>
    </div>
  </div>
</div>
</div>

  <div class="row">
    <div class="twelve columns" style="text-align:center;position:absolute;padding-top:50px">
      <?php
       echo'<input type="hidden" id="ad1" name="ad1" value="'.$ad1.'">';
       echo'<input type="hidden" id="ad2" name="ad2" value="'.$ad2.'">';
       echo'<input type="hidden" id="ad3" name="ad3" value="'.$ad3.'">';
       echo'<input type="hidden" id="ad4" name="ad4" value="'.$ad4.'">';
      ?>
      <button class="button-primary" type="button" onclick="window.location='event4.php'"/>Takaisin</button>
      <button class="button-primary" type="button" id="btnEvent6" onclick="window.location='event_overview.php?c'"/>Seuraava</button>
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
document.getElementById('link1').style="display:none";
document.getElementById('link2').style="display:none";
document.getElementById('link3').style="display:none";
document.getElementById('link4').style="display:none";
if (element.id == 1) {
document.getElementById('link1').style="display:inline-block";
} else if (element.id == 2) {
document.getElementById('link2').style="display:inline-block";
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
document.getElementById('adHeader').innerHTML="Mainospaikka on jo asetettu!";
document.getElementById('upload').style="visibility:hidden";
document.getElementById('submitAd').name="adUpload";
}
$('#submitAd').click(function(event){
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

  <?php include('inc/footer.php'); ?>
