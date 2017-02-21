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
include 'functions.php';
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
    var finish = $.post("functions.php", { addVisitor: "visitors", firstName : first, lastName : last, number : num, button: btn}, function(data) {
      if(data){
        console.log(data);
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
          '<input id="firstName" name="firstName" type="text" required="" valid. oninput="setCustomValidity(\'\')" oninvalid="this.setCustomValidity(\'Syötä etunimi\')">',
          '<label for="firstName">Sukunimi</label>',
          '<input id="lastName" name="lastName" type="text" required="" valid. oninput="setCustomValidity(\'\')" oninvalid="this.setCustomValidity(\'Syötä sukunimi\')">',
          '<label for="firstName">Pelinumero</label>',
          '<input id="number" name="number" type="text" required="" valid. oninput="setCustomValidity(\'\')" oninvalid="this.setCustomValidity(\'Syötä pelinumero\')">',
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
  <div class="container">
    <div class="twelve columns" style="text-align:center" id="guide">

    <div id="section1">
    <p class="guideHeader">Tapahtuman tiedot</p>
    <a href="event1.php" style="text-decoration:none">
    <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_1</i>
    </a></div>
    <div class="line"></div>

    <div id="section2">
    <p class="guideHeader">Kotipelaajat</p>
    <a href="event2.php" style="text-decoration:none">
    <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_2</i>
    </a></div>
    <div class="line" style="background-color:#2bc9c9"></div>

    <div id="section3" style="background-color:#2bc9c9">
    <p class="guideHeader">Vieraspelaajat</p>
    <a href="#" style="text-decoration:none">
    <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_3</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div id="section4" style="background-color:gray">
    <p class="guideHeader">Ennakkoteksti</p>
    <a id="btnEvent4" href="#" style="text-decoration:none">
    <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_4</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div id="section5" style="background-color:gray">
    <p class="guideHeader">Mainospaikat</p>
    <a id="btnEvent5" href="#" style="text-decoration:none">
    <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_5</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div id="section6" style="background-color:gray">
    <p class="guideHeader">Yhteenveto</p>
    <a id="btnEvent6" href="#" style="text-decoration:none">
    <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_6</i>
    </a></div>
    </div>

  <div class="row">
    <div class="twelve columns">
      <span id="msg" class="msgError"></span>
    </div>
  </div>
    <div class="row" style="border: solid 1px #D1D1D1;padding:15px;margin-top:20px">
      <div class="twelve columns" style="text-align: center">
        <form id="form" action="functions.php" method="POST">
       <label for="visitorName">Vierasjoukkueen nimi</label>
      <input type="text" id="visitorName" name="visitorName" value="<?php
      if (isset($_SESSION['visitorName'])) {
         echo $_SESSION['visitorName'];
       }
        ?>">
        </form>
        <button type="button" class="button-primary" id="iconAddPlayer" style="float:left;position:relative;left:-10px">Lisää</button>
      </div>

      <div class="twelve columns">
        <form name="players" action="functions.php" method="POST">
          <table class='u-full-width'>
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
          $count = listVisitors();
          ?>
        </table>
      </form>
      </div>
</div>

<div class="row">
      <div class="twelve columns" style='text-align:center;padding-top:50px'>
<button type="button" value="Takaisin" onclick="window.location='event2.php'"/>Takaisin</button>
<input form="form" class="button-primary" type="submit" id="btnEvent4" name="setVisitorTeam" value="Seuraava">
      </div>
    </div>
  </div>
<script>
$('#btnEvent4, #btnEvent5, #btnEvent6').click(function(event){
    var selected = ($(this).attr("id"));
    event.preventDefault(); // stop the form from submitting
    var visitor = $('#visitorName').val();
    var first = $('#firstName').val();
    var last = $('#lastName').val();
    var num = $('#number').val();
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
</script>
  <?php include('inc/footer.php'); ?>
