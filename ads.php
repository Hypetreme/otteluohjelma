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

  $adArray = array();

  for ($i = 0; $i <= 25; $i++)
{
    array_push($adArray, ${'ad' . $i} = "");
}
  $ownerId = $_SESSION['ownerId'];

  for ($i = 1; $i <= 25; $i++) {
  ${'fileName' . $i . 's'} = 'images/ads/s_'.$ownerId.'_ad'.$i.'.png';
  if (isset($_SESSION['teamId'])) {
  $teamId   =  $_SESSION['teamId'];
  $teamUid   =  $_SESSION['teamUid'];
  ${'fileName' . $i . 'j'} = 'images/ads/j_'.$teamUid.$teamId.'_ad'.$i.'.png';
}

}

for ($i = 1; $i <= 25; $i++) {
  if (file_exists(${'fileName' . $i . 's'})){
    ${'ad' . $i } = ${'fileName' . $i . 's'};
  } else if (isset($_SESSION['teamId']) && file_exists(${'fileName' . $i . 'j'})){
    ${'ad' . $i } = ${'fileName' . $i . 'j'};
  }

}
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="js/jquery.cropit.js"></script>
<link rel="stylesheet" type="text/css" href="css/cropit.css">
<span id="msg" class="msgError"></span>
  <div class="container">
    <div class="twelve columns" style="text-align:center">
      <h4>Mainospaikat</h4>
    </div>
    <div class="row"></div>
    <div class="row" style="border: solid 1px #D1D1D1;padding:15px;margin-top:20px">
    <div class="row"style="float:left;">
      <div class="six columns" style="text-align:center">
        <h5 style="margin-bottom:0" id="adHeader">&nbsp;</h5>
        <span id="upload" style="visibility:hidden;">

        <tbody>
        <tr>
          <div class="image-editor" id="crop" style="border: solid 1px #D1D1D1;padding:15px;margin-top:20px">
      <div style="display:inline-block">
            <div id="preview" class="cropit-image-preview"></div>
          </div>
            <input style="display:inline-block;padding-left:30px" type="file" class="cropit-image-input">
            <label for="zoom">Zoomaus</label>
            <input id="zoom" style="display:inline-block;" type="range" class="cropit-image-zoom-input">
            <?php
            listAdLinks();
            ?>
            <input type="hidden" id="image-data" name="image-data" class="hidden-image-data"/>
</div>
<div class="twelve columns" style="text-align:center;margin-top:20px">
            <button id="removeAd" class="button-remove" type="submit">Poista</button>
            <button id="submitAd" class="button-primary" type="submit">Tallenna</button>
          </div>
      </span>
    </div>
    <div class="six columns">
      <div id="phone">
      <div style="position:relative;top:50%;">
      <i id="back" class="material-icons">arrow_back</i>
      <i id="forward" class="material-icons">arrow_forward</i>
    </div>

      <div id="1and2" class="on" style="position:relative;display:initial;text-align:center">
      <div id="adSelector" class="overlay">
        <?php
        if (file_exists($fileName1s) && isset($_SESSION['teamId'])){
        echo '<div class="ad reserved" onclick="notify(this);" id="1"><img src="'.$ad1.'?'.time().'"></div>';
      } else {
        echo '<div class="ad free" onclick="addAd(this);" id="1">';
        if ($ad1 != "") {
        echo '<img src="'.$ad1.'?'.time().'">';
      } else {
        echo '<h4 style="line-height:3">Mainos 1</h4>';
      }
        echo '</div>';
      }
      echo '<div><h2 class="preview">Pelaajat</h2></div>';
      echo '<div><h3 class="preview">Kotijoukkue</h3></div>';
      echo '<div><h5 class="preview">Pelaaja Yksi</h5></div>';
      echo '<div><h5 class="preview">Pelaaja Kaksi</h5></div>';
      if (file_exists($fileName2s) && isset($_SESSION['teamId'])){
      echo '<div class="ad reserved" onclick="notify(this);" id="2"><img src="'.$ad2.'?'.time().'"></div>';
    } else {
      echo '<div class="ad free" onclick="addAd(this);" id="2">';
      if ($ad2 != "") {
      echo '<img src="'.$ad2.'?'.time().'">';
    } else {
      echo '<h4 style="line-height:3">Mainos 2</h4>';
    }
      echo '</div>';
    }
      echo '<div><h3 class="preview">Vierasjoukkue</h3></div>';
      echo '<div><h5 class="preview">Pelaaja Yksi</h5></div>';
      echo '<div><h5 class="preview">Pelaaja Kaksi</h5></div>';
        ?>
      </div>
      </div>

      <div id="popup" style="display:none;text-align:center">
      <div id="adSelector">
        <?php
        echo '<div><h3 class="preview">Tapahtuman nimi</h3></div>';
        echo '<div><h3 class="preview">Päivämäärä</h3></div>';
        echo '<div><h3 class="preview">Paikka</h3></div>';
        echo '<div id="popupWindow">';
        echo '<div style="color:black" id="close2">X</div>';
        if (file_exists($fileName5s) && isset($_SESSION['teamId'])){
        echo '<div class="ad reserved" onclick="notify(this);" id="5"><img src="'.$ad5.'?'.time().'"></div>';
      } else {
        echo '<div class="ad free" style="margin-top:10px" onclick="addAd(this);" id="5">';
        if ($ad5 != "") {
        echo '<img src="'.$ad5.'?'.time().'">';
      } else {
        echo '<h4 style="color:black;line-height:3">Mainos 5</h4>';
      }
      }
        ?>
      </div>
    <p id="popupTextPreview">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
      Nam vel enim aliquet.</p>
      </div>
      </div>
</div>
      <div id="sponsors" style="display:none;text-align:center;">
      <div id="adSelector" style="overflow-x:hidden;overflow-y:scroll;">
        <div><h3 class="preview">Kumppanit</h3></div>
        <?php
        $i = 1;
        foreach ($adArray as $value) {
        if($i > 5 && $i <= 25) {
        if (file_exists(${'fileName' . $i . 's'}) && isset($_SESSION['teamId'])){
        echo '<div class="ad reserved" onclick="notify(this);" id="'.$i.'"><img src="'.${'ad' . $i }.'?'.time().'"></div>';
      } else {
        echo '<div class="ad free" onclick="addAd(this);" id="'.$i.'">';
        if (${'ad' . $i } != "") {
        echo '<img src="'.${'ad' . $i }.'?'.time().'">';
      } else {
        echo '<h4 style="line-height:3">Kumppani '.($i-5).'</h4>';
      }
      echo '</div>';
      }
    }
      $i++;
    }
        ?>

      </div>
      </div>
  </div>
</div>
</div>

  <script>
document.getElementById('popupTextPreview').innerHTML = document.getElementById('popupText').value;
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
          }
    }
);
      $(".free").on("mouseenter focus", function(){
        if(!$(this).hasClass('active')){
        $(this).css({"border-color":"orange"});
        $(this).css({"border-style":"solid"});
        $(this).css({"border-width":"3px"});
      }
      });
      $(".free").on("mouseleave", function(){
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
        $('.free:not(#'+element.id+')').removeClass('active');
        if(!$('.free:not(#'+element.id+')').hasClass('reserved')){
        $('.free:not(#'+element.id+')').css({"border-color":"transparent"});
      }
        $(element).addClass('active')
        $(element).css({"border-color":"#2def30"});
        $(element).css({"border-width":"3px"});

        $('#preview').css("display","none");
        $('#preview').fadeIn();
    });
$("#adHeader").css({"color":"gray"});
document.getElementById('popupDiv').style="display:none";

if (element.id == 5) {
document.getElementById('adHeader').innerHTML="Popup-Mainos";
document.getElementById('popupDiv').style="display:initial";
}else if (element.id >= 6){
document.getElementById('adHeader').innerHTML="Kumppani "+(element.id-5);
}else {
document.getElementById('adHeader').innerHTML="Mainos "+element.id;
}
document.getElementById('upload').style="visibility:visible;";
document.getElementById('submitAd').value=element.id;
document.getElementById('removeAd').value=element.id;
document.getElementById('linkHeader').style="initial";
$('.link:not(#link'+element.id+')').css({"display":"none"});
document.getElementById('link'+element.id).style="display:inline-block;width:240px";

//Ladataan asetettu kuva esikatselua varten
$('#preview').css("background-image", "none");
$('#image-data').val("");
imageData = "";

if (typeof document.getElementById(element.id).children[0] != 'undefined') {
    url = document.getElementById(element.id).children[0].src;
    $('.image-editor').cropit('imageSrc', url);
}
}
function notify(element) {

if($(element).hasClass('reserved')){
$(element).css({"border-color":"red"});
$(element).css({"border-width":"3px"});
}
$("#adHeader").css({"color":"red"});
document.getElementById('adHeader').innerHTML="Seurasi on asettanut mainospaikan!";
document.getElementById('upload').style="visibility:hidden";
document.getElementById('submitAd').name="adUpload";
}

$('#submitAd').click(function(event){
      event.preventDefault();
      if ($('#image-data').val()!="") {
      $('#image-data').val($('.image-editor').cropit('export'));
    }
      imageData = $('#image-data').val();
      var ad = $('#submitAd').val();
      var popupText = $('#popupText').val();
      var length = $('.ad').length;
      for (i = 0; i < 25; i++) {
      eval("adlink" + i + " = $('#link'+(i+1)).val()");
    }
      var finish = $.post("functions.php", { submitAd: ad, imgData: imageData ,
link1: adlink0, link2: adlink1, link3: adlink2, link4: adlink3,
link5: adlink4, link6: adlink5, link7: adlink6, link8: adlink7,
link9: adlink8, link10: adlink9, link11: adlink10, link12: adlink11,
link13: adlink12, link14: adlink13, link15: adlink14, link16: adlink15,
link17: adlink16, link18: adlink17, link19: adlink18, link20: adlink19,
link21: adlink20, link22: adlink21, link23: adlink22, link24: adlink23, link25: adlink24, text: popupText
}, function(data) {
        if(data){
          console.log(data);
        }
        message(data);
      });
  });
  $('#removeAd').click(function(event){
        event.preventDefault();
        var ad = $('#removeAd').val();
        var finish = $.post("functions.php", { removeAd: ad, fileName: url }, function(data) {
          if(data){
            console.log(data);
          }
          message(data);
        });
    });
    $('#forward').click(function(event){
  if ($('#1and2').hasClass("on")) {
    $('#1and2').removeClass("on");
    $('#1and2').css("display","none");
    $('#sponsors').toggleClass("on");
    $('#sponsors').fadeIn();
} else if ($('#sponsors').hasClass("on")) {
    $('#sponsors').removeClass("on");
    $('#sponsors').css("display","none");
    $('#popup').toggleClass("on");
    $('#popup').fadeIn();
} else if ($('#popup').hasClass("on")) {
    $('#popup').removeClass("on");
    $('#popup').css("display","none");
    $('#1and2').toggleClass("on");
    $('#1and2').fadeIn();
}
});

$('#back').click(function(event){
  if ($('#1and2').hasClass("on")) {
    $('#1and2').removeClass("on");
    $('#1and2').css("display","none");
    $('#popup').toggleClass("on");
    $('#popup').fadeIn();
} else if ($('#sponsors').hasClass("on")) {
    $('#sponsors').removeClass("on");
    $('#sponsors').css("display","none");
    $('#1and2').toggleClass("on");
    $('#1and2').fadeIn();
} else if ($('#popup').hasClass("on")) {
    $('#popup').removeClass("on");
    $('#popup').css("display","none");
    $('#sponsors').toggleClass("on");
    $('#sponsors').fadeIn();
}
});
</script>

  <?php
    include ('inc/footer.php');
  ?>
