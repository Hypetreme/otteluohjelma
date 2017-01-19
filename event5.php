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
<style>
.dropdown {
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
}
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
<input form="form" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" name ="setMatchText" value ="6">
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
  <div id="chosenAd1" style="height:100px" class="row">
    <div class="twelve columns" style="text-align: center;">
      </div>
      </div>

<form id="form" action="functions.php" method="POST">
  <div class="row">
    <div class="twelve columns" style="text-align: center;">
      <?php if (empty($ad1) && empty($ad2) && empty($ad3) && empty($ad4)) {
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
      echo '<div id="Kokoonpano1" class="dropdown" style="display: inline-block;">
        <button>Kokoonpano 1</button>
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
      echo '<div id="Kokoonpano 2" class="dropdown" style="display: inline-block;">
        <button>Kokoonpano 2</button>
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
     }
      ?>
</div>
    </div>

  <div class="row">
    <div class="twelve columns" style="text-align:center;position:absolute;padding-top:50px">
      <button class="button-primary" type="button" value="Takaisin" onclick="window.location='event4.php'"/>Takaisin</button>
      <input class="button-primary" type="submit" name="setAds" id="btnEvent5" value="Seuraava">
</form>
    </div>
  </div>

</div>


  <?php include('inc/footer.php'); ?>
