<?php
session_start();
include('dbh.php');
include('unset.php');
include('inc/header.php');
include('functions.php');

  $adArray = array();
  $offerArray = array();

  for ($i = 1; $i <= 25; $i++) {
      array_push($adArray, ${'ad' . $i} = "");
  }
for ($i = 1; $i <= 10; $i++) {
    array_push($offerArray, ${'offer' . $i} = "");
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

for ($i = 1; $i <= 10; $i++) {
    ${'offerFileName' . $i . 's'} = 'images/ads/s_'.$ownerId.'_offer'.$i.'.png';
    if (isset($_SESSION['teamId'])) {
        $teamId   =  $_SESSION['teamId'];
        $teamUid   =  $_SESSION['teamUid'];
        ${'offerFileName' . $i . 'j'} = 'images/ads/j_'.$teamUid.$teamId.'_offer'.$i.'.png';
    }
}
// Mainoskuvien asetus
for ($i = 1; $i <= 25; $i++) {
    if (file_exists(${'fileName' . $i . 's'})) {
        ${'ad' . $i } = ${'fileName' . $i . 's'};
    } elseif (isset($_SESSION['teamId']) && file_exists(${'fileName' . $i . 'j'})) {
        ${'ad' . $i } = ${'fileName' . $i . 'j'};
    }
}
// Tarjousten asetus
for ($i = 1; $i <= 10; $i++) {
    if (file_exists(${'offerFileName' . $i . 's'})) {
        ${'offer' . $i } = ${'offerFileName' . $i . 's'};
    } elseif (isset($_SESSION['teamId']) && file_exists(${'offerFileName' . $i . 'j'})) {
        ${'offer' . $i } = ${'offerFileName' . $i . 'j'};
    }
}
?>

<script src="js/jquery.cropit.js"></script>
<link rel="stylesheet" type="text/css" href="css/cropit.css">
<span class="msg msg-fail" id="msg"></span>
<div class="header-bg"></div>
  <div class="container">
    <div class="row" style="text-align:left">
    <div class="twelve columns">
      <div class="section-header">
      <h4>Mainospaikat</h4>
    </div>
      <?php
        $url = "";
        if (isset($_SESSION['teamId'])) {
            $team = 'team.php?teamId='.$_SESSION['teamId'];
            $url = 'location.href="'.$team.'"';
        }
          $url2 = 'location.href="my_events.php"';
          $url3 = 'location.href="guess.php"';
          $url4 = 'location.href="ads.php"';
        echo '<div>';
        if (isset($_SESSION['teamId'])) {
            echo '<button class="button-primary" onclick='.$url.'>Kokoonpano</button>';
        }
          echo '<button class="button-primary" onclick='.$url2.'>Tapahtumasi</button>';
          if (isset($_SESSION['teamId'])) {
              echo '<button class="button-primary" onclick='.$url3.'>Kilpailut</button>';
          }
          echo '<button class="button-primary" onclick='.$url4.'>Aseta Mainospaikat</button>';
          echo '</div>';

      ?>
    </div>
    </div>
    <div class="shadow-box2" style="padding:15px;margin-bottom:0px">
      <div class="six columns" style="text-align:center;">
        <h5 style="margin-bottom:0" class="ad-header" id="adHeader">&nbsp;</h5>
        <span id="upload" style="visibility:hidden;">
        <tbody>
        <tr>

          <div class="image-editor" id="crop" style="padding:15px;margin-top:20px">
            <div class="shadow-box">
      <div style="display:inline-block">
            <div id="preview" class="cropit-image-preview"></div>
          </div>
            <input style="padding-left:30px;max-width:300px" type="file" class="cropit-image-input">
            <div id="zoom" style="display:none">
            <label for="zoom">Zoomaus</label>
            <p class="zoom-minus">-</p><input style="display:inline-block;" type="range" class="cropit-image-zoom-input">
            <p class="zoom-plus">+</p>
            </div>
            <form id="form">

            <?php
            listAdLinks();
            ?>
            <input type="hidden" id="image-data" name="image-data" class="hidden-image-data"/>
            </form>

</div>
</div>

<div class="image-editor" id="crop-offer" style="padding:15px;margin-top:20px;display:none">
<div class="shadow-box">
<div style="display:inline-block">
  <div id="preview-offer" class="cropit-image-preview offer-view"></div>
</div>
  <input style="padding-left:30px;max-width:300px" type="file" class="cropit-image-input">
  <div id="zoom-offer" style="display:none">
  <label for="zoom">Zoomaus</label>
  <p class="zoom-minus">-</p><input style="display:inline-block;" type="range" class="cropit-image-zoom-input">
  <p class="zoom-plus">+</p>
  </div>
  <form id="form">
    <?php
    listOffer();
    ?>

  <input type="hidden" id="image-data-offer" name="image-data-offer" class="hidden-image-data"/>
  </form>

</div>
</div>
<div class="twelve columns" style="text-align:center;margin-top:20px">
            <button id="removeAd" class="remove-btn" type="submit">Poista</button>
            <button form="form" id="set" class="button-primary" type="submit">Tallenna</button>
          </div>
      </span>
    </div>
    <div class="six columns">
      <div class="phone">
      <div style="position:relative;top:50%;">
      <i id="back" class="material-icons back">arrow_back</i>
      <i id="forward" class="material-icons forward">arrow_forward</i>
    </div>

      <div id="1and2" class="on" style="position:relative;display:initial;text-align:center">
      <div class="ad-selector overlay">
        <?php
        echo '<div><h2 class="preview">Pelaajat</h2></div>';
        if (file_exists($fileName1s) && isset($_SESSION['teamId'])) {
            echo '<div class="ad reserved" onclick="notify(this);" id="1"><img alt="mainos 1" src="'.$ad1.'?'.time().'"></div>';
        } else {
            echo '<div class="ad free" onclick="addAd(this);" id="1">';
            if ($ad1 != "") {
                echo '<img alt="mainos 1" src="'.$ad1.'?'.time().'">';
            } else {
                echo '<h4 style="line-height:3">Mainos 1</h4>';
            }
            echo '</div>';
        }
      echo '<div class="team-preview">
      <img src="images/logos/'.$uid.$teamId.'.png">
      <h3 class="preview">'.$_SESSION['teamName'].'</h3>
      </div>';
      echo '<div class="players-preview">
      <h5>01 Pelaaja Yksi</h5>';
      echo '<h5>02 Pelaaja Kaksi</h5></div>';
      if (file_exists($fileName2s) && isset($_SESSION['teamId'])) {
          echo '<div class="ad reserved" onclick="notify(this);" id="2"><img alt="mainos 2" src="'.$ad2.'?'.time().'"></div>';
      } else {
          echo '<div class="ad free" onclick="addAd(this);" id="2">';
          if ($ad2 != "") {
              echo '<img alt="mainos 2" src="'.$ad2.'?'.time().'">';
          } else {
              echo '<h4 style="line-height:3">Mainos 2</h4>';
          }
          echo '</div>';
      }
      echo '<div class="team-preview"><h3 class="preview">Vierasjoukkue</h3></div>';
      echo '<div><h5 class="preview">Pelaaja Yksi</h5></div>';
      echo '<div><h5 class="preview">Pelaaja Kaksi</h5></div>';
        ?>
      </div>
      </div>

      <div id="popup" style="display:none;text-align:center">
      <div class="ad-selector">
        <?php
        echo '<div style="height:50px"></div>';
        echo '<div style="height:60px">';
        echo '<div style="width:40%;float:left"><h3 class="preview-name">Koti</h3></div>';
        echo '<div style="width:20%;float:left"><h3 class="preview-name">VS</h3></div>';
        echo '<div style="width:40%;float:right"><h3 class="preview-name">Vieras</h3></div>';
        echo '</div>';
        echo '<div><h3 class="preview">Päivämäärä</h3></div>';
        echo '<div><h3 class="preview">Paikka</h3></div>';
        echo '<div class="popup-window">';
        echo '<div class="close-line">';
        echo '<div class="close2">X</div></div>';
        if (file_exists($fileName5s) && isset($_SESSION['teamId'])) {
            echo '<div class="ad reserved" style="margin-top:10px" onclick="notify(this);" id="5"><img alt="mainos 5" src="'.$ad5.'?'.time().'"></div>';
        } else {
            echo '<div class="ad free" style="margin-top:10px" onclick="addAd(this);" id="5">';
            if ($ad5 != "") {
                echo '<img alt="mainos 5" src="'.$ad5.'?'.time().'"></div>';
            } else {
                echo '<h4 style="color:black;line-height:3">Mainos 5</h4></div>';
            }
        }
        ?>
        <p class="popup-text-preview" id="popupTextPreview"></p>
      </div>
      </div>
      </div>

      <div id="sponsors" style="display:none;text-align:center;">
      <div class="ad-selector scroll">
        <div><h2 class="preview">Kumppanit</h2></div>
        <?php
        $i = 1;
        foreach ($adArray as $value) {
            if ($i > 5 && $i <= 25) {
                if (file_exists(${'fileName' . $i . 's'}) && isset($_SESSION['teamId'])) {
                    echo '<div class="ad reserved" onclick="notify(this);" id="'.$i.'"><img alt="'.'mainos' . $i .'" src="'.${'ad' . $i }.'?'.time().'"></div>';
                } else {
                    echo '<div class="ad free" onclick="addAd(this);" id="'.$i.'">';
                    if (${'ad' . $i } != "") {
                        echo '<img alt="mainos ' . $i .'" src="'.${'ad' . $i }.'?'.time().'">';
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

      <div id="offer" style="display:none;text-align:center;">
      <div class="ad-selector scroll">
        <div><h2 class="preview">Tarjoukset</h2></div>

        <?php
        $i = 1;
foreach ($offerArray as $value) {
    if (file_exists(${'offerFileName' . $i . 's'}) && isset($_SESSION['teamId'])) {
        echo '<div class="reserved offer" onclick="notify(this);" id="offer'.$i.'">';
        echo '<p id="offerText'.$i.'" class="offer-text-preview"></p>';
    } else {
        echo '<div class="free offer" onclick="addAd(this);" id="offer'.$i.'">';
        echo '<p id="offerText'.$i.'" class="offer-text-preview"></p>';
    }
    echo '<div class="offer-image" id="offerImage" style="float:left;">';
    if (${'offer' . $i } != "") {
        echo '<img src="'.${'offer' . $i }.'?'.time().'">';
    }
    echo'</div>
          <div style="float:right;width:50%">
          <p id="offerPrice'.$i.'" class="offer-price-preview"></p></div>
        </div>';
    $i++;
}
?>
      </div>
      </div>
  </div>
</div>
</div>

  <script>
if (document.getElementById('popupText').value != "") {
document.getElementById('popupTextPreview').innerHTML = document.getElementById('popupText').value;
} else {
document.getElementById('popupTextPreview').innerHTML = "Mainosteksti";
}
for (var i = 1; i <= 10; i++) {
if (document.getElementById('offerInput'+i).value != "") {
document.getElementById('offerText'+i).innerHTML = document.getElementById('offerInput'+i).value;
} else {
document.getElementById('offerText'+i).innerHTML = "Otsikko";
}
if (document.getElementById('priceInput'+i).value != "") {
document.getElementById('offerPrice'+i).innerHTML = document.getElementById('priceInput'+i).value;
} else {
document.getElementById('offerPrice'+i).innerHTML = "0,00€";
}
}
var imageData = "";
var url = "";
// Oletuskroppaaja
$('#crop').cropit(
    {
      minZoom: 'fit',
      fitWidth: 'true',
      smallImage: 'stretch',
      onImageError: function() {
            $('#preview').css("background-image", "none");
            imageData = "";
            message('imgError');
        },
        onImageLoaded: function() {
          $('#preview').css('background-size', 'none');

              $('#image-data').val("");
              $('#image-data').val($('#crop').cropit('export'));
          },
          onZoomDisabled: function() {
                $('#zoom').css("display", "none");

            },
            onZoomEnabled: function() {
              $('#zoom').css("display", "initial");

              }
    }
);
// Tarjouskroppaaja
$('#crop-offer').cropit(
    {
      minZoom: 'fit',
      fitWidth: 'true',
      smallImage: 'stretch',
      onImageError: function() {
            $('#preview-offer').css("background-image", "none");
            imageData = "";
            message('imgError');
        },
        onImageLoaded: function() {
          $('#preview-offer').css('background-size', 'none');
              $('#image-data-offer').val("");
              $('#image-data-offer').val($('#crop-offer').cropit('export'));
          },
          onZoomDisabled: function() {
                $('#zoom-offer').css("display", "none");
            },
            onZoomEnabled: function() {
                  $('#zoom-offer').css("display", "initial");
              }
    }
);

      $(".free").on("mouseenter focus", function(){
        if(!$(this).hasClass('active')){
        $(this).css({"border-color":"orange"});
        $(this).css({"border-style":"solid"});
        $(this).css({"border-width":"4px"});
      }
      });
      $(".free").on("mouseleave", function(){
        if ($(this).hasClass('offer') && !$(this).hasClass('active')) {
          $(this).css({"border-style":"dashed"});
          $(this).css({"border-color":"#999999"});
          $(this).css({"border-width":"4px"});
        }
        else if(!$(this).hasClass('active')){
        $(this).css({"border-style":"none"});
        $(this).css({"border-color":"transparent"});
        $(this).css({"border-width":"4px"});
      }
      if($(this).hasClass('reserved')){
      $(this).css({"border-color":"red"});
      $(this).css({"border-width":"4px"});
      }
      });

      function addAd(element) {
      // Mainospaikan valinta
      if(!$(element).hasClass('active')){
      $('#zoom').css("display", "none");
      $('#zoom-offer').css("display", "none");
      $(function(){
          $('.free:not(#'+element.id+')').removeClass('active');
          if(!$('.free:not(#'+element.id+')').hasClass('reserved')){
          $('.free:not(#'+element.id+')').css({"border-style":"none"});
          $('.free:not(#'+element.id+')').css({"border-color":"transparent"});
          $('.offer').css({"border-style":"dashed"});
          $('.offer').css({"border-color":"#999999"});
          $('.offer').css({"border-width":"4px"});
      }
          $(element).addClass('active')
          $(element).css({"border-style":"solid"});
          $(element).css({"border-color":"#2def30"});
          $(element).css({"border-width":"4px"});

          $('#preview').css("display","none");
          $('#preview').fadeIn();
          $('#preview-offer').css("display","none");
          $('#preview-offer').fadeIn();
    });

          $('#offer-box').css("display","none");
          $('#popupDiv').css("display","none");
          $('#crop-offer').css("display","none");
          $('#crop').css("display","block");

if ($(element).hasClass('offer')) {
var number = element.id.replace('offer', '')
document.getElementById('adHeader').innerHTML="Tarjous "+number;
$('#crop').css("display","none");
$('#crop-offer').css("display","inline-block");
$('#offer-box').css("display","inline-block");
$('.offer-text:not('+element.id+')').css({"display":"none"});
$('.offer-price:not('+element.id+')').css({"display":"none"});
$('#offerInput'+number).css("display","inline-block");
$('#offerInput'+number).css("width","240px");
$('#priceInput'+number).css("display","inline-block");
$('#priceInput'+number).css("width","240px");
}
else if (element.id == 5) {
document.getElementById('adHeader').innerHTML="Popup-Mainos";
$('#popupDiv').css("display","initial");
} else if (element.id >= 6){
document.getElementById('adHeader').innerHTML="Kumppani "+(element.id-5);
}else {
document.getElementById('adHeader').innerHTML="Mainos "+element.id;
}
$('#upload').css("visibility","visible");
document.getElementById('set').value=element.id;
document.getElementById('removeAd').value=element.id;
document.getElementById('linkHeader').style="initial";
$('.link:not(#link'+element.id+')').css({"display":"none"});
$('#link'+element.id).css("display","inline-block");
$('#link'+element.id).css("width","240px");

//Ladataan asetettu kuva esikatselua varten
$('#preview').css("background-image", "none");
$('#preview-offer').css("background-image", "none");
$('#image-data').val("");
$('#image-data-offer').val("");
imageData = "";
if (typeof document.getElementById(element.id).children[0] != 'undefined' && !$(element).hasClass("offer")) {
    url = document.getElementById(element.id).children[0].src;
    $('#crop').cropit('imageSrc', url);
} else if (typeof document.getElementById(element.id).children[1].children[0] != 'undefined' && $(element).hasClass("offer")){

  url = document.getElementById(element.id).children[1].children[0].src;
  $('#crop-offer').cropit('imageSrc', url);
}
}
}
function notify(element) {
message('adReserved');
if($(element).hasClass('reserved')){
$(element).css({"border-color":"red"});
$(element).css({"border-width":"4px"});
}

document.getElementById('adHeader').innerHTML="";
document.getElementById('upload').style="visibility:hidden";
document.getElementById('set').name="adUpload";
}

$('#set').click(function(event){
      event.preventDefault();
      if ($('#image-data').val()!="") {
      $('#image-data').val($('#crop').cropit('export'));
    }
    if ($('#image-data-offer').val()!="") {
    $('#image-data-offer').val($('#crop-offer').cropit('export'));
  }
if ($('#crop-offer').css("display") != "none") {
      imageData = $('#image-data-offer').val();
      var type = "offer";
} else {
      var type = "ad";
      imageData = $('#image-data').val();
    }
      var set = $('#set').val();
      var popupText = $('#popupText').val();

      var length = $('.ad').length;
      for (i = 0; i < 25; i++) {
      eval("adlink" + i + " = $('#link'+(i+1)).val()");
    }
    for (i = 1; i <= 10; i++) {
    eval("offername" + i + " = $('#offerInput'+(i)).val()");
    eval("offerprice" + i + " = $('#priceInput'+(i)).val()");
  }
      var finish = $.post("functions.php", { fileUpload: type, number: set, imgData: imageData ,
link1: adlink0, link2: adlink1, link3: adlink2, link4: adlink3,
link5: adlink4, link6: adlink5, link7: adlink6, link8: adlink7,
link9: adlink8, link10: adlink9, link11: adlink10, link12: adlink11,
link13: adlink12, link14: adlink13, link15: adlink14, link16: adlink15,
link17: adlink16, link18: adlink17, link19: adlink18, link20: adlink19,
link21: adlink20, link22: adlink21, link23: adlink22, link24: adlink23, link25: adlink24, text: popupText,
offer1: offername1, offer2: offername2, offer3: offername3, offer4: offername4, offer5: offername5,
offer6: offername6, offer7: offername7, offer8: offername8, offer9: offername9, offer10: offername10,
price1: offerprice1, price2: offerprice2, price3: offerprice3, price4: offerprice4, price5: offerprice5,
price6: offerprice6, price7: offerprice7, price8: offerprice8, price9: offerprice9, price10: offerprice10
}, function(data) {
        if(data){
          console.log(data);
        }
        message(data);
      });
  });
  $('#removeAd').click(function(event){
        event.preventDefault();
        var set = $('#removeAd').val();
        var finish = $.post("functions.php", { removeAd: set, fileName: url }, function(data) {
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
    $('#offer').toggleClass("on");
    $('#offer').fadeIn();
} else if ($('#offer').hasClass("on")) {
    $('#offer').removeClass("on");
    $('#offer').css("display","none");
    $('#1and2').toggleClass("on");
    $('#1and2').fadeIn();
}
});

$('#back').click(function(event){
  if ($('#1and2').hasClass("on")) {
    $('#1and2').removeClass("on");
    $('#1and2').css("display","none");
    $('#offer').toggleClass("on");
    $('#offer').fadeIn();
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
} else if ($('#offer').hasClass("on")) {
    $('#offer').removeClass("on");
    $('#offer').css("display","none");
    $('#popup').toggleClass("on");
    $('#popup').fadeIn();
}
});
</script>

  <?php
    include('inc/footer.php');
  ?>
