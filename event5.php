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

$fileName1s = 'images/ads/s_'.$ownerId.'_ad1.jpg';
$fileName2s = 'images/ads/s_'.$ownerId.'_ad2.jpg';
$fileName3s = 'images/ads/s_'.$ownerId.'_ad3.jpg';
$fileName4s = 'images/ads/s_'.$ownerId.'_ad4.jpg';

$fileName1j = 'images/ads/j_'.$teamUid.$teamId.'_ad1.jpg';
$fileName2j = 'images/ads/j_'.$teamUid.$teamId.'_ad2.jpg';
$fileName3j = 'images/ads/j_'.$teamUid.$teamId.'_ad3.jpg';
$fileName4j = 'images/ads/j_'.$teamUid.$teamId.'_ad4.jpg';

$fileName1e = 'images/ads/e_'.$teamUid.$teamId.'_ad1.jpg';
$fileName2e = 'images/ads/e_'.$teamUid.$teamId.'_ad2.jpg';
$fileName3e = 'images/ads/e_'.$teamUid.$teamId.'_ad3.jpg';
$fileName4e = 'images/ads/e_'.$teamUid.$teamId.'_ad4.jpg';

if (file_exists($fileName1e)){
$ad1 = 'images/ads/e_'.$teamUid.$teamId.'_ad1.jpg';
} else if (file_exists($fileName1s)){
$ad1 = 'images/ads/s_'.$ownerId.'_ad1.jpg';
} else if (isset($_SESSION['teamId']) && file_exists($fileName1j)){
$ad1 = 'images/ads/j_'.$teamUid.$teamId.'_ad1.jpg';
}
if (file_exists($fileName2e)){
$ad2 = 'images/ads/e_'.$teamUid.$teamId.'_ad2.jpg';
} else if (file_exists($fileName2s)){
$ad2 = 'images/ads/s_'.$ownerId.'_ad2.jpg';
} else if (isset($_SESSION['teamId']) && file_exists($fileName2j)){
$ad2 = 'images/ads/j_'.$teamUid.$teamId.'_ad2.jpg';
}
if (file_exists($fileName3e)){
$ad3 = 'images/ads/e_'.$teamUid.$teamId.'_ad3.jpg';
} else if (file_exists($fileName3s)){
$ad3 = 'images/ads/s_'.$ownerId.'_ad3.jpg';
} else if (isset($_SESSION['teamId']) && file_exists($fileName3j)){
$ad3 = 'images/ads/j_'.$teamUid.$teamId.'_ad3.jpg';
}
if (file_exists($fileName4e)){
$ad4 = 'images/ads/e_'.$teamUid.$teamId.'_ad4.jpg';
} else if (file_exists($fileName4s)){
$ad4 = 'images/ads/s_'.$ownerId.'_ad4.jpg';
} else if (isset($_SESSION['teamId']) && file_exists($fileName4j)){
$ad4 = 'images/ads/j_'.$teamUid.$teamId.'_ad4.jpg';
}
?>
<style>
/*.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    padding: 12px 16px;
    z-index: 1;
}

.dropdown:hover .dropdown-content {
    display: block;
}*/
</style>
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
      <?php /*if (empty($ad1) && empty($ad2) && empty($ad3) && empty($ad4)) {
        echo '<h4 style="color:gray">Sinulla ei ole mainoksia asetettuna.</h4>';
      } else {
    echo '<div id="Etusivu1" class="dropdown" style="display: inline-block;">
        <button>Etusivu 1</button>
        <div class="dropdown-content">';
        if (!empty($ad1)){
            echo '<div id="1" style="height:100px;background-size:100% 100%;background-image: url('.$ad1.');"></div>';
          } if (!empty($ad2)){
            echo '<div id="2" style="height:100px;background-size:100% 100%;background-image: url('.$ad2.');"></div>';
          } if (!empty($ad3)){
            echo '<div id="3" style="height:100px;background-size:100% 100%;background-image: url('.$ad3.');"></div>';
          } if (!empty($ad4)){
            echo '<div id="4" style="height:100px;background-size:100% 100%;background-image: url('.$ad4.');"></div>';
          }
        echo '</div></div>';
      echo '<div id="Etusivu2" class="dropdown" style="display: inline-block;">
        <button>Etusivu 2</button>
        <div class="dropdown-content">';
        if (!empty($ad1)){
            echo '<div id="1" style="height:100px;background-size:100% 100%;background-image: url('.$ad1.');"></div>';
          } if (!empty($ad2)){
            echo '<div id="2" style="height:100px;background-size:100% 100%;background-image: url('.$ad2.');"></div>';
          } if (!empty($ad3)){
            echo '<div id="3" style="height:100px;background-size:100% 100%;background-image: url('.$ad3.');"></div>';
          } if (!empty($ad4)){
            echo '<div id="4" style="height:100px;background-size:100% 100%;background-image: url('.$ad4.');"></div>';
          }
       echo '</div></div>';
      echo '<div class="row">';
      echo '<div style="background-image: url('.$ad1.');background-repeat:no-repeat;background-size:100% 100%;text-align:center;border-style:solid;width:20%;height:100px;display:inline-block;"></div>';
      echo '<div style="background-image: url('.$ad2.');background-repeat:no-repeat;background-size:100% 100%;text-align:center;border-style:solid;width:20%;height:100px;display:inline-block;"></div>';
      echo '</div>';
      echo '<div id="Kokoonpano1" class="dropdown" style="display: inline-block;">';
        echo '<div class="button">Kokoonpano 1</div>
        <div class="dropdown-content">';
        if (!empty($ad1)){
            echo '<div id="1" style="height:100px;background-size:100% 100%;background-image: url('.$ad1.');"></div>';
          } if (!empty($ad2)){
            echo '<div id="2" style="height:100px;background-size:100% 100%;background-image: url('.$ad2.');"></div>';
          } if (!empty($ad3)){
            echo '<div id="3" style="height:100px;background-size:100% 100%;background-image: url('.$ad3.');"></div>';
          } if (!empty($ad4)){
            echo '<div id="4" style="height:100px;background-size:100% 100%;background-image: url('.$ad4.');"></div>';
          }
        echo '</div></div>';
      echo '<div id="Kokoonpano 2" class="dropdown" style="display: inline-block;">';
        echo '<div class="button">Kokoonpano 2</div>
        <div class="dropdown-content">';
        if (!empty($ad1)){
            echo '<div id="1" style="height:100px;background-size:100% 100%;background-image: url('.$ad1.');"></div>';
          } if (!empty($ad2)){
            echo '<div id="2" style="height:100px;background-size:100% 100%;background-image: url('.$ad2.');"></div>';
          } if (!empty($ad3)){
            echo '<div id="3" style="height:100px;background-size:100% 100%;background-image: url('.$ad3.');"></div>';
          } if (!empty($ad4)){
            echo '<div id="4" style="height:100px;background-size:100% 100%;background-image: url('.$ad4.');"></div>';
          }
       echo '</div></div>';
     }*/
      ?>
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
