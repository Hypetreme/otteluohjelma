<?php
  session_start();
  include ('dbh.php');
  if (isset($_SESSION['teamId'])) {
  $teamId = $_SESSION['teamId'];
}
  if (!isset($_SESSION['id'])) {
    header("Location: index.php");
  }
  if (isset($_SESSION['eventId'])) {
    unset($_SESSION['homeName']);
    unset($_SESSION['visitorName']);
    unset($_SESSION['eventId']);
    unset($_SESSION['eventName']);
    unset($_SESSION['eventPlace']);
    unset($_SESSION['eventDate']);
    unset($_SESSION['home']);
    unset($_SESSION['visitors']);
    unset($_SESSION['saved']);
  }
  include ('functions.php');
  include ('inc/header.php');

  $ad1 = $ad2 = $ad3 = $ad4 = "";

  $ownerId = $_SESSION['ownerId'];
  $fileName1s = 'images/ads/s_'.$ownerId.'_ad1.png';
  $fileName2s = 'images/ads/s_'.$ownerId.'_ad2.png';
  $fileName3s = 'images/ads/s_'.$ownerId.'_ad3.png';
  $fileName4s = 'images/ads/s_'.$ownerId.'_ad4.png';

  if (isset($_SESSION['teamId'])) {
  $teamId   =  $_SESSION['teamId'];
  $teamUid   =  $_SESSION['teamUid'];
  $fileName1j = 'images/ads/j_'.$teamUid.$teamId.'_ad1.png';
  $fileName2j = 'images/ads/j_'.$teamUid.$teamId.'_ad2.png';
  $fileName3j = 'images/ads/j_'.$teamUid.$teamId.'_ad3.png';
  $fileName4j = 'images/ads/j_'.$teamUid.$teamId.'_ad4.png';
}
  if (file_exists($fileName1s)){
  $ad1 = 'images/ads/s_'.$ownerId.'_ad1.png';
} else if (isset($_SESSION['teamId']) && file_exists($fileName1j)){
  $ad1 = 'images/ads/j_'.$teamUid.$teamId.'_ad1.png';
}
if (file_exists($fileName2s)){
$ad2 = 'images/ads/s_'.$ownerId.'_ad2.png';
} else if (isset($_SESSION['teamId']) && file_exists($fileName2j)){
$ad2 = 'images/ads/j_'.$teamUid.$teamId.'_ad2.png';
}
if (file_exists($fileName3s)){
$ad3 = 'images/ads/s_'.$ownerId.'_ad3.png';
} else if (isset($_SESSION['teamId']) && file_exists($fileName3j)){
$ad3 = 'images/ads/j_'.$teamUid.$teamId.'_ad3.png';
}
if (file_exists($fileName4s)){
$ad4 = 'images/ads/s_'.$ownerId.'_ad4.png';
} else if (isset($_SESSION['teamId']) &&file_exists($fileName4j)){
$ad4 = 'images/ads/j_'.$teamUid.$teamId.'_ad4.png';
}
?>
<link rel="stylesheet" type="text/css" href="css/cropit.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="js/jquery.cropit.js"></script>

  <div class="container">
    <div style="margin-top:-120px" class="row">
      <div class="twelve columns" style="text-align:center">
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

        <!--<form action="functions.php" method="POST" enctype="multipart/form-data">
          <tbody>
            <tr>
              <td><input type="file" name="file" id="file"></td>
              <td><input id="submitAd" type="submit" value="Tallenna Mainos" name="adUpload"></td>
            </tr>
          </tbody>
        </form>-->
      </span>
    </div>
    </div>
    <div class="row">
      <div class="twelve columns" style="text-align:center">
        <h4 style="margin-bottom:0">
          Mainokset
        </h4>
      </div>

    </div>
    <div style="margin-left:auto ;margin-right:auto;width:375px;height:709px;background-image: url(images/phone.jpg);background-repeat:no-repeat;">
    <div class="row">
      <div class="twelve columns" style="text-align:center">
      <div id="adSelector" style="position: relative;margin-left: auto;margin-right: auto;width: 340px;height: 595px;border-style: solid;top: 61px;">
        <?php
        if ($_SESSION['type'] == '1' && file_exists($fileName1s)){
        echo '<div class="reserved" onclick="notify(this);" id="1" style="border-width:3px;border-color:red;border-style:solid;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad1.');">AD 1</div>';
      } else {
        echo '<div onclick="addAd(this);" id="1" style="border-width:1px;border-style:solid;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad1.');">AD 1</div>';
      }
      if ($_SESSION['type'] == '1' && file_exists($fileName2s)){
      echo '<div class="reserved" onclick="notify(this);" id="2" style="border-width:3px;border-color:red;border-style:solid;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad2.');">AD 2</div>';
    } else {
      echo '<div onclick="addAd(this);" id="2" style="border-width:1px;border-style:solid;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad2.');">AD 2</div>';
    }
    if ($_SESSION['type'] == '1' && file_exists($fileName3s)){
    echo '<div class="reserved" onclick="notify(this);" id="3" style="border-width:3px;border-color:red;position:absolute;bottom:9.5%;border-style:solid;width:100%;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad3.');">AD 3</div>';
  } else {
    echo '<div onclick="addAd(this);" id="3" style="border-width:1px;position:absolute;bottom:9.5%;border-style:solid;width:100%;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad3.');">AD 3</div>';
  }
  if ($_SESSION['type'] == '1' && file_exists($fileName4s)){
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

  <?php
    include ('inc/footer.php');
  ?>
