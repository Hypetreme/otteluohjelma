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
  $teamId   =  $_SESSION['teamId'];
  $teamUid   =  $_SESSION['teamUid'];
  $fileName1s = 'images/ads/s_'.$teamUid.$teamId.'_ad1.jpg';
  $fileName2s = 'images/ads/s_'.$teamUid.$teamId.'_ad2.jpg';
  $fileName3s = 'images/ads/s_'.$teamUid.$teamId.'_ad3.jpg';
  $fileName4s = 'images/ads/s_'.$teamUid.$teamId.'_ad4.jpg';

  $fileName1j = 'images/ads/j_'.$teamUid.$teamId.'_ad1.jpg';
  $fileName2j = 'images/ads/j_'.$teamUid.$teamId.'_ad2.jpg';
  $fileName3j = 'images/ads/j_'.$teamUid.$teamId.'_ad3.jpg';
  $fileName4j = 'images/ads/j_'.$teamUid.$teamId.'_ad4.jpg';

  if (file_exists($fileName1s)){
  $ad1 = 'images/ads/s_'.$teamUid.$teamId.'_ad1.jpg';
} else if (file_exists($fileName1j)){
  $ad1 = 'images/ads/j_'.$teamUid.$teamId.'_ad1.jpg';
}
if (file_exists($fileName2s)){
$ad2 = 'images/ads/s_'.$teamUid.$teamId.'_ad2.jpg';
} else if (file_exists($fileName2j)){
$ad2 = 'images/ads/j_'.$teamUid.$teamId.'_ad2.jpg';
}
if (file_exists($fileName3s)){
$ad3 = 'images/ads/s_'.$teamUid.$teamId.'_ad3.jpg';
} else if (file_exists($fileName3j)){
$ad3 = 'images/ads/j_'.$teamUid.$teamId.'_ad3.jpg';
}
if (file_exists($fileName4s)){
$ad4 = 'images/ads/s_'.$teamUid.$teamId.'_ad4.jpg';
} else if (file_exists($fileName4j)){
$ad4 = 'images/ads/j_'.$teamUid.$teamId.'_ad4.jpg';
}
?>

  <div class="container">
    <div style="margin-top:-120px" class="row">
      <div class="twelve columns" style="text-align:center">
        <h5 style="margin-bottom:0" id="adHeader">&nbsp;</h5>
        <span id="upload" style="visibility:hidden;">
        <table class="u-full-width">
        <form action="functions.php" method="POST" enctype="multipart/form-data">
          <tbody>
            <tr>
              <td><input type="file" name="file" id="file"></td>
              <td><input id="submitAd" type="submit" value="Tallenna Mainos" name="adUpload"></td>
            </tr>
          </tbody>
        </form>
        </table>
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
        echo '<div onclick="notify();" id="1" style="border-width:1px;border-style:solid;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad1.');">AD 1</div>';
      } else {
        echo '<div onclick="addAd(this);" id="1" style="border-width:1px;border-style:solid;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad1.');">AD 1</div>';
      }
      if ($_SESSION['type'] == '1' && file_exists($fileName2s)){
      echo '<div onclick="notify();" id="2" style="border-width:1px;border-style:solid;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad2.');">AD 2</div>';
    } else {
      echo '<div onclick="addAd(this);" id="2" style="border-width:1px;border-style:solid;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad2.');">AD 2</div>';
    }
    if ($_SESSION['type'] == '1' && file_exists($fileName3s)){
    echo '<div onclick="notify();" id="3" style="border-width:1px;position:absolute;bottom:9.5%;border-style:solid;width:100%;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad3.');">AD 3</div>';
  } else {
    echo '<div onclick="addAd(this);" id="3" style="border-width:1px;position:absolute;bottom:9.5%;border-style:solid;width:100%;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad3.');">AD 3</div>';
  }
  if ($_SESSION['type'] == '1' && file_exists($fileName4s)){
  echo '<div onclick="notify();" id="4" style="border-width:1px;position:absolute;bottom:0;border-style:solid;width:100%;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad4.');">AD 4</div>';
} else {
  echo '<div onclick="addAd(this);" id="4" style="border-width:1px;position:absolute;bottom:0;border-style:solid;width:100%;height:55px;background-color:white;background-repeat:no-repeat;background-size:100% 100%;background-image: url('.$ad4.');">AD 4</div>';
}
        ?>
      </div>
      </div>
    </div>
    </div>


  </div>

  <script>
  $("#1, #2, #3, #4").on("mouseenter focus", function(){
    if(!$(this).hasClass('active')){
    $(this).css({"border-color":"red"});
    $(this).css({"border-width":"3px"});
  }
  });
  $("#1, #2, #3, #4").on("mouseleave", function(){
     if(!$(this).hasClass('active')){
    $(this).css({"border-color":"black"});
    $(this).css({"border-width":"1px"});
  }
  });
  function addAd(element) {
    $(function(){
        $("#1").removeClass('active')
        $("#1").css({"background-color":"white"});
        $("#1").css({"border-color":"black"});
        $("#1").css({"border-width":"1px"});
        $("#2").removeClass('active')
        $("#2").css({"background-color":"white"});
        $("#2").css({"border-color":"black"});
        $("#2").css({"border-width":"1px"});
        $("#3").removeClass('active')
        $("#3").css({"background-color":"white"});
        $("#3").css({"border-color":"black"});
        $("#3").css({"border-width":"1px"});
        $("#4").removeClass('active')
        $("#4").css({"background-color":"white"});
        $("#4").css({"border-color":"black"});
        $("#4").css({"border-width":"1px"});
        $(element).addClass('active')
        $(element).css({"background-color":"white"});
        $(element).css({"border-color":"red"});
        $(element).css({"border-width":"3px"});
    });
$("#adHeader").css({"color":"black"});
document.getElementById('adHeader').innerHTML="Mainoskuva "+element.id;
document.getElementById('upload').style="visibility:visible;";
document.getElementById('submitAd').name="adUpload"+element.id;
var adValue = 1;
}
function notify() {
  $("#1").removeClass('active')
  $("#1").css({"background-color":"white"});
  $("#1").css({"border-color":"black"});
  $("#1").css({"border-width":"1px"});
  $("#2").removeClass('active')
  $("#2").css({"background-color":"white"});
  $("#2").css({"border-color":"black"});
  $("#2").css({"border-width":"1px"});
  $("#3").removeClass('active')
  $("#3").css({"background-color":"white"});
  $("#3").css({"border-color":"black"});
  $("#3").css({"border-width":"1px"});
  $("#4").removeClass('active')
  $("#4").css({"background-color":"white"});
  $("#4").css({"border-color":"black"});
  $("#4").css({"border-width":"1px"});

$("#adHeader").css({"color":"red"});
document.getElementById('adHeader').innerHTML="Seurasi on asettanut tämän mainospaikan!";
document.getElementById('upload').style="visibility:hidden";
document.getElementById('submitAd').name="adUpload";
}
  </script>

  <?php
    include ('inc/footer.php');
  ?>
