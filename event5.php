<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
header("Location: index.php");
}
include ('inc/header.php');
include ('functions.php');

$ad1 = $ad2 = $ad3 = $ad4 = "";
$teamId   =  $_SESSION['teamId'];
$teamUid   =  $_SESSION['teamUid'];
$ownerId = $_SESSION['ownerId'];

$fileName1s = 'images/ads/s_'.$ownerId.'_ad1.png';
$fileName2s = 'images/ads/s_'.$ownerId.'_ad2.png';
$fileName3s = 'images/ads/s_'.$ownerId.'_ad3.png';
$fileName4s = 'images/ads/s_'.$ownerId.'_ad4.png';

$fileName1j = 'images/ads/j_'.$teamUid.$teamId.'_ad1.png';
$fileName2j = 'images/ads/j_'.$teamUid.$teamId.'_ad2.png';
$fileName3j = 'images/ads/j_'.$teamUid.$teamId.'_ad3.png';
$fileName4j = 'images/ads/j_'.$teamUid.$teamId.'_ad4.png';

$fileName1e = 'images/ads/e_'.$teamUid.$teamId.'_ad1.png';
$fileName2e = 'images/ads/e_'.$teamUid.$teamId.'_ad2.png';
$fileName3e = 'images/ads/e_'.$teamUid.$teamId.'_ad3.png';
$fileName4e = 'images/ads/e_'.$teamUid.$teamId.'_ad4.png';

if (file_exists($fileName1e)){
$ad1 = 'images/ads/e_'.$teamUid.$teamId.'_ad1.png';
} else if (file_exists($fileName1s)){
$ad1 = 'images/ads/s_'.$ownerId.'_ad1.png';
} else if (isset($_SESSION['teamId']) && file_exists($fileName1j)){
$ad1 = 'images/ads/j_'.$teamUid.$teamId.'_ad1.png';
}
if (file_exists($fileName2e)){
$ad2 = 'images/ads/e_'.$teamUid.$teamId.'_ad2.png';
} else if (file_exists($fileName2s)){
$ad2 = 'images/ads/s_'.$ownerId.'_ad2.png';
} else if (isset($_SESSION['teamId']) && file_exists($fileName2j)){
$ad2 = 'images/ads/j_'.$teamUid.$teamId.'_ad2.png';
}
if (file_exists($fileName3e)){
$ad3 = 'images/ads/e_'.$teamUid.$teamId.'_ad3.png';
} else if (file_exists($fileName3s)){
$ad3 = 'images/ads/s_'.$ownerId.'_ad3.png';
} else if (isset($_SESSION['teamId']) && file_exists($fileName3j)){
$ad3 = 'images/ads/j_'.$teamUid.$teamId.'_ad3.png';
}
if (file_exists($fileName4e)){
$ad4 = 'images/ads/e_'.$teamUid.$teamId.'_ad4.png';
} else if (file_exists($fileName4s)){
$ad4 = 'images/ads/s_'.$ownerId.'_ad4.png';
} else if (isset($_SESSION['teamId']) && file_exists($fileName4j)){
$ad4 = 'images/ads/j_'.$teamUid.$teamId.'_ad4.png';
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

<div id="section6" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<input form="form" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" name ="setEventAds" value ="6">
</div>

</div>
</div>

  <div class="row">
    <div class="twelve columns" style="text-align: center;">
      <h4>
        <span>Mainospaikat</span>
      </h4>
    </div>

  </div>
  <div class="row">
    <div class="twelve columns" style="text-align: center;">
      <h5 style="margin-bottom:0" id="adHeader">&nbsp;</h5>
      <span id="upload" style="visibility:hidden;">

      <form method="POST" enctype="multipart/form-data">
      <tbody>
      <tr>
    <div class="image-editor" id="crop">
<div style="display:inline-block">
      <div class="cropit-image-preview"><div class="error-msg"></div></div>
    </div>
      <input style="display:inline-block" type="file" class="cropit-image-input">

    <div class="row" style="text-align:left">
      <input style="display:inline-block;margin-left:190px" type="range" class="cropit-image-zoom-input">
      <p style="display:inline-block" class="image-size-label">
        Zoomaus
      </p>
    </div>

      <input type="hidden" name="image-data" class="hidden-image-data" />
      <button id="submitAd" type="submit">Tallenna</button>
</div>
        </form>
    </span>
  </div>
  </div>

  <div style="margin-left:auto ;margin-right:auto;width:375px;height:709px;background-image: url(images/phone.jpg);background-repeat:no-repeat;">
  <div class="row">
    <div class="twelve columns" style="text-align:center">
    <div id="adSelector" style="position: relative;margin-left: auto;margin-right: auto;width: 340px;height: 595px;border-style: solid;top: 61px;">
      <?php
      if (file_exists($fileName1s) || file_exists($fileName1j)){
      echo '<div class="reserved" onclick="notify(this);" id="1" style="border-width:3px;border-color:red;border-style:solid;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad1.');">AD 1</div>';
    } else {
      echo '<div onclick="addAd(this);" id="1" style="border-width:1px;border-style:solid;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad1.');">AD 1</div>';
    }
    if (file_exists($fileName2s) || file_exists($fileName2j)){
    echo '<div class="reserved" onclick="notify(this);" id="2" style="border-width:3px;border-color:red;border-style:solid;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad2.');">AD 2</div>';
  } else {
    echo '<div onclick="addAd(this);" id="2" style="border-width:1px;border-style:solid;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad2.');">AD 2</div>';
  }
  if (file_exists($fileName3s) || file_exists($fileName3j)){
  echo '<div class="reserved" onclick="notify(this);" id="3" style="border-width:3px;border-color:red;position:absolute;bottom:9.5%;border-style:solid;width:100%;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad3.');">AD 3</div>';
} else {
  echo '<div onclick="addAd(this);" id="3" style="border-width:3px;border-color:red;position:absolute;bottom:9.5%;border-style:solid;width:100%;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad3.');">AD 3</div>';
}
if (file_exists($fileName4s) || file_exists($fileName4j)){
echo '<div class="reserved" onclick="notify(this);" id="4" style="border-width:1px;position:absolute;bottom:0;border-style:solid;width:100%;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad4.');">AD 4</div>';
} else {
echo '<div onclick="addAd(this);" id="4" style="border-width:1px;position:absolute;bottom:0;border-style:solid;width:100%;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad4.');">AD 4</div>';
}
      ?>
    </div>
    </div>
  </div>
  </div>
</div>

  <div class="row">
    <div class="twelve columns" style="text-align:center;position:absolute;padding-top:50px">

<form id="form" action="functions.php" method="POST">
      <?php echo'<input type="hidden" name="ad1" value="'.$ad1.'">';
       echo'<input type="hidden" name="ad2" value="'.$ad2.'">';
       echo'<input type="hidden" name="ad3" value="'.$ad3.'">';
       echo'<input type="hidden" name="ad4" value="'.$ad4.'">';
      ?>
      <button class="button-primary" type="button" value="Takaisin" onclick="window.location='event4.php'"/>Takaisin</button>
      <input class="button-primary" type="submit" name="setEventAds" id="btnEvent5" value="Seuraava">
</form>
    </div>
  </div>

</div>

<script>
$(function() {
  $(function() {
  $('.image-editor').cropit();

  $('form').submit(function() {
    // Move cropped image data to hidden input

    var imageData = $('.image-editor').cropit('export');
    $('.hidden-image-data').val(imageData);

    // Print HTTP request params
    var formValue = $(this).serialize();

$.ajax({
   type: 'post',
   data: formValue,
   url: 'functions.php',
   success: function(data){
   $('#result-data').text('New file in: images/'+data);
   $('#crop').show();
  }

});

    // Prevent the form from actually submitting
    //return false;
  });
});
});

$("#1, #2, #3, #4").on("mouseenter focus", function(){
  if(!$(this).hasClass('active')){
  $(this).css({"border-color":"orange"});
  $(this).css({"border-width":"3px"});
}
});
$("#1, #2, #3, #4").on("mouseleave", function(){
   if(!$(this).hasClass('active')){
  $(this).css({"border-color":"black"});
  $(this).css({"border-width":"1px"});
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
      $("#1").css({"background-color":"white"});
      $("#1").css({"border-color":"black"});
      $("#1").css({"border-width":"1px"});
    }
      $("#2").removeClass('active')
      if(!$("#2").hasClass('reserved')){
      $("#2").css({"background-color":"white"});
      $("#2").css({"border-color":"black"});
      $("#2").css({"border-width":"1px"});
      }
      $("#3").removeClass('active')
      if(!$("#3").hasClass('reserved')){
      $("#3").css({"background-color":"white"});
      $("#3").css({"border-color":"black"});
      $("#3").css({"border-width":"1px"});
      }
      $("#4").removeClass('active')
      if(!$("#4").hasClass('reserved')){
      $("#4").css({"background-color":"white"});
      $("#4").css({"border-color":"black"});
      $("#4").css({"border-width":"1px"});
      }
      $(element).addClass('active')
      $(element).css({"background-color":"white"});
      $(element).css({"border-color":"#2def30"});
      $(element).css({"border-width":"3px"});
  });
$("#adHeader").css({"color":"black"});
document.getElementById('adHeader').innerHTML="Mainoskuva "+element.id;
document.getElementById('upload').style="visibility:visible;";
document.getElementById('submitAd').name="adUpload"+element.id;
var adValue = 1;
}
function notify(element) {
$("#1").removeClass('active')
if(!$("#1").hasClass('reserved')){
$("#1").css({"background-color":"white"});
$("#1").css({"border-color":"black"});
$("#1").css({"border-width":"1px"});
}
$("#2").removeClass('active')
if(!$("#2").hasClass('reserved')){
$("#2").css({"background-color":"white"});
$("#2").css({"border-color":"black"});
$("#2").css({"border-width":"1px"});
}
$("#3").removeClass('active')
if(!$("#3").hasClass('reserved')){
$("#3").css({"background-color":"white"});
$("#3").css({"border-color":"black"});
$("#3").css({"border-width":"1px"});
}
$("#4").removeClass('active')
if(!$("#4").hasClass('reserved')){
$("#4").css({"background-color":"white"});
$("#4").css({"border-color":"black"});
$("#4").css({"border-width":"1px"});
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
</script>

  <?php include('inc/footer.php'); ?>
