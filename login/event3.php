<?php
session_start();
include ('dbh.php');
include ('functions.php');
include ('unset.php');
include ('inc/header.php');
?>

  <script>
  function openDialog() {
  vex.dialog.open({

    onSubmit: function(event) {
    event.preventDefault();
    event.stopPropagation();

  if ($('#firstName').val()!="" && $('#lastName').val()!="" && $('#number').val()!="") {
    if ($('.vex-first').hasClass("ok")) {
    var btn = "add"
  } else {
    var btn = "";
  }
    var selected = ($(this).attr("id"));
    var visitor = $('#visitorName').val();
    var first = $('#firstName').val();
    var last = $('#lastName').val();
    var num = $('#number').val();
    var visitorrole = $('#visitorrole').val();
    var finish = $.post("functions.php", { addVisitor: "visitors", firstName : first, lastName : last, number : num, role: visitorrole, button: btn}, function(data) {
      if(data){
        console.log(data);
        $("#visitors").load(location.href + " #visitors");
      }
       message(data);
       if (data == "event3More") {
          vex.closeAll();
          setTimeout(function(){
          openDialog();
           }, 500);
       }


    });
}
  },

      message: 'Lisää pelaaja',
      input: [
          '<label for="firstName">Etunimi</label>',
          '<input maxlength="30" id="firstName" type="text" required="" valid. oninput="setCustomValidity(\'\')" oninvalid="this.setCustomValidity(\'Syötä etunimi\')">',
          '<label for="firstName">Sukunimi</label>',
          '<input maxlength="30" id="lastName" type="text" required="" valid. oninput="setCustomValidity(\'\')" oninvalid="this.setCustomValidity(\'Syötä sukunimi\')">',
          '<label for="firstName">Pelinumero</label>',
          '<input imaxlength="3" id="number" type="text" required="" valid. oninput="setCustomValidity(\'\')" oninvalid="this.setCustomValidity(\'Syötä pelinumero\')">',
          '<label for="visitorrole">Pelipaikka</label>',
          '<input id="visitorrole" type="text">',
      ].join(''),
      buttons: [
          $.extend({}, vex.dialog.buttons.YES, { text: 'Lisää uusi'}),
          $.extend({}, vex.dialog.buttons.YES, { text: 'Valmis' }),
      ],
      callback: function (data) {
          if (!data) {
          message("event3Close");
          }
      }
  })
  $('.vex-first').click(function(event){
    $(this).addClass("ok");
    });
}
  </script>
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
    <div class="twelve columns" style="text-align:center;margin-top:35px;margin-bottom: 20px;">

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
    <div class="line" style="background-color:#2bc9c9"></div>

    <div class="section3" style="background-color:#2bc9c9">
    <p class="guide-header">Vieraspelaajat</p>
    <a href="#" style="text-decoration:none">
    <i class="material-icons guide">filter_3</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div class="section4" style="background-color:gray">
    <p class="guide-header">Ennakkoteksti</p>
    <a id="btnEvent4" href="#" style="text-decoration:none">
    <i class="material-icons guide">filter_4</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div class="section5" style="background-color:gray">
    <p class="guide-header">Mainospaikat</p>
    <a id="btnEvent5" href="#" style="text-decoration:none">
    <i class="material-icons guide">filter_5</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div class="section6" style="background-color:gray">
    <p class="guide-header">    Kilpailu</p>
    <a id="btnEvent6" href="#" style="text-decoration:none">
    <i class="material-icons guide">filter_6</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div class="section7" style="background-color:gray">
    <p class="guide-header">Yhteenveto</p>
    <a id="btnEvent7" href="#" style="text-decoration:none">
    <i class="material-icons guide">filter_7</i>
    </a></div>
    </div>

  <div class="row">
    <div class="twelve columns">
      <span class="msg msg-fail" id="msg"></span>
    </div>
  </div>
      <div class="shadow-box2">
      <div class="twelve columns" style="text-align: center">
        <div class="six columns">
        <form id="form">
       <label for="visitorName">Vierasjoukkueen nimi</label>
      <input maxlength="30" type="text" id="visitorName" value="<?php
      if (isset($_SESSION['event']['visitorName'])) {
          echo $_SESSION['event']['visitorName'];
      }
        ?>">
        </form>
</div>
<div class="six columns">
        <label for="visitorName">Vierasjoukkueen Logo</label>
          <form id="logoForm" action="functions.php" method="post" enctype="multipart/form-data">
          <table style="margin-top:23px" class="u-full-width">
            <tbody>
              <tr>
                <td>
                  <p style="font-size:14px;color:gray;margin:0">Kuvan maksimikoko 500kt</p>
                  <input style="max-width:375px"type="file" onchange="loadData()"></td>
              </tr>

                <div style="height:166px">
                <img alt="logo" src= <?php

                    if (isset($_SESSION['event']['visitorLogo'])) {
                        echo $_SESSION['event']['visitorLogo'] .'?'.time();
                    } else {
                      echo 'images/logos/seura.png';
                    }
                ?> style="max-width:370px;max-height:202px;vertical-align:-160px">
              </div>
                <input type="hidden" id="imgData">

            </tbody>
          </table>
          <input class="button-primary" type="submit" value="Tallenna logo" id="fileUpload" name="fileUpload">
          </form>
</div>
        <button type="button" class="button-primary" id="iconAddPlayer" style="float:left;position:relative;left:-10px">Lisää</button>
      </div>

      <div class="twelve columns">
          <table id="visitors" class='u-full-width'>
            <thead>
              <tr>
                <th>Avatar</th>
                <th>Nro</th>
                <th>Etunimi</th>
                <th>Sukunimi</th>
                <th>Pelipaikka</th>
              </tr>
            </thead>
          <?php
          listVisitorTeam();
          ?>
        </table>
      </div>
</div>
  </div>
  <div class="twelve columns event-buttons">
<button type="button" value="Takaisin" onclick="window.location='event2.php'"/>Takaisin</button>
<input form="form" class="button-primary" type="submit" id="btnEvent4" value="Seuraava">
  </div>
<script>
$('#btnEvent4, #btnEvent5, #btnEvent6, #btnEvent7').click(function(event){
    var selected = ($(this).attr("id"));
    event.preventDefault();
    var visitor = $('#visitorName').val();
    var finish = $.post("functions.php", { setVisitorTeam: "visitors", visitorName: visitor }, function(data) {
      if(data){
        console.log(data);
      }
      message(data,selected);

    });
});

$('#iconAddPlayer').on('click', function() {
openDialog();

});

$('#logoForm').submit(function(event){

      event.preventDefault();
      var logo = document.getElementById("imgData");
      var finish = $.post("functions.php", { fileUpload: 'visitor', imgData: logo.value }, function(data) {
        if(data){
          console.log(data);
        }
        message(data);
      });
  });
  function loadData() {
    var preview = document.querySelector('img');
    var file    = document.querySelector('input[type=file]').files[0];
    var logo = document.getElementById("imgData");
    var reader  = new FileReader();
  reader.addEventListener("load", function () {
preview.src = reader.result;
logo.value = reader.result;
}, false);
if (file) {
reader.readAsDataURL(file);
}
}
</script>
  <?php include('inc/footer.php'); ?>
