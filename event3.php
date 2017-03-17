<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
}
if (!isset($_SESSION['editEvent'])) {
    header("Location: profile.php");
}
include('inc/header.php');
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
          '<input id="firstName" type="text" required="" valid. oninput="setCustomValidity(\'\')" oninvalid="this.setCustomValidity(\'Syötä etunimi\')">',
          '<label for="firstName">Sukunimi</label>',
          '<input id="lastName" type="text" required="" valid. oninput="setCustomValidity(\'\')" oninvalid="this.setCustomValidity(\'Syötä sukunimi\')">',
          '<label for="firstName">Pelinumero</label>',
          '<input id="number" type="text" required="" valid. oninput="setCustomValidity(\'\')" oninvalid="this.setCustomValidity(\'Syötä pelinumero\')">',
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
  <div class="container" style="padding-bottom:60px;">
    <div class="twelve columns" style="text-align:center" id="guide">

    <div id="section1">
    <p class="guide-header">Tapahtuman tiedot</p>
    <a href="event1.php" style="text-decoration:none">
    <i class="material-icons">filter_1</i>
    </a></div>
    <div class="line"></div>

    <div id="section2">
    <p class="guide-header">Kotipelaajat</p>
    <a href="event2.php" style="text-decoration:none">
    <i class="material-icons">filter_2</i>
    </a></div>
    <div class="line" style="background-color:#2bc9c9"></div>

    <div id="section3" style="background-color:#2bc9c9">
    <p class="guide-header">Vieraspelaajat</p>
    <a href="#" style="text-decoration:none">
    <i class="material-icons">filter_3</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div id="section4" style="background-color:gray">
    <p class="guide-header">Ennakkoteksti</p>
    <a id="btnEvent4" href="#" style="text-decoration:none">
    <i class="material-icons">filter_4</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div id="section5" style="background-color:gray">
    <p class="guide-header">Mainospaikat</p>
    <a id="btnEvent5" href="#" style="text-decoration:none">
    <i class="material-icons">filter_5</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div id="section6" style="background-color:gray">
    <p class="guide-header">    Kilpailu</p>
    <a id="btnEvent6" href="#" style="text-decoration:none">
    <i class="material-icons">filter_6</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div id="section7" style="background-color:gray">
    <p class="guide-header">Yhteenveto</p>
    <a id="btnEvent7" href="#" style="text-decoration:none">
    <i class="material-icons">filter_7</i>
    </a></div>
    </div>

  <div class="row">
    <div class="twelve columns">
      <span id="msg" class="msg-fail"></span>
    </div>
  </div>
    <div class="row" style="border: solid 1px #D1D1D1;padding:15px;margin-top:20px">
      <div class="twelve columns" style="text-align: center">
        <form id="form">
       <label for="visitorName">Vierasjoukkueen nimi</label>
      <input type="text" id="visitorName" value="<?php
      if (isset($_SESSION['visitorName'])) {
          echo $_SESSION['visitorName'];
      }
        ?>">
        </form>
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
  <div id="event-buttons" class="twelve columns">
<button type="button" value="Takaisin" onclick="window.location='event2.php'"/>Takaisin</button>
<input form="form" class="button-primary" type="submit" id="btnEvent4" value="Seuraava">
  </div>
<script>
$('#btnEvent4, #btnEvent5, #btnEvent6, #btnEvent7').click(function(event){
    var selected = ($(this).attr("id"));
    event.preventDefault();
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
