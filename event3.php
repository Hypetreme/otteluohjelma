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
    var count = 1;

    function addInput() {
      $("#newTr").fadeIn();
      //document.getElementById('newTr').style="display:table-row;height:61px";
      $("#iconAddPlayer").hide();
      //document.getElementById('iconAddPlayer').style="display:none";
      $("#addVisitor").fadeIn();
      //document.getElementById('addVisitor').style="display:block";
      var num = document.getElementById('ref').value.match(/\d+/)[0];
      var finalNum = +num + count - 1;

      var etuField = document.createElement("input");
      etuField.type = "text";
      etuField.name = "firstName";
      etuField.id = "firstName";

      var sukuField = document.createElement("input");
      sukuField.type = "text";
      sukuField.name = "lastName";
      sukuField.id = "lastName";

      var nroField = document.createElement("input");
      nroField.type = "text";
      nroField.name = "number";
      nroField.id = "number";

      var etuH = document.createElement("label");
      etuH.innerHTML = "Etunimi";

      var sukuH = document.createElement("label");
      sukuH.innerHTML = "Sukunimi";

      var nroH = document.createElement("label");
      nroH.innerHTML = "Numero";

      //var headerCount = "Pelaaja " + finalNum;

      //var header = document.createElement("h4");
      //var headerText = document.createTextNode(headerCount);
      //header.appendChild(headerText);

      //var br = document.createElement("br");

      //document.getElementById('newrow').appendChild(header);
      document.getElementById('newrow').appendChild(etuH);
      document.getElementById('newrow').appendChild(etuField);
      document.getElementById('newrow').appendChild(sukuH);
      document.getElementById('newrow').appendChild(sukuField);
      document.getElementById('newrow').appendChild(nroH);
      document.getElementById('newrow').appendChild(nroField);
      //document.getElementById('newrow').appendChild(br);

      count += 1;
    }
  </script>
  <div class="container">
    <div class="row" id="guide">
      <div class="twelve columns" style="text-align: center;">

      <a href="event1.php" style="text-decoration:none"><div id="section1" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
      <h3 style="color:white;padding-top:5px">1</h3>
    </div></a>

  <a href="event2.php" style="text-decoration:none"><div id="section2" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">2</h3>
  </div></a>

  <a href="#" style="text-decoration:none"><div id="section3" style="float:left;width: 60px; height: 60px; background: green; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">3</h3>
  </div></a>

  <div id="section4" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <input form="form" id="btnEvent4" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" value ="4">
  </div>

  <div id="section5" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <input form="form" id="btnEvent5" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" value="5">
  </div>

  <div id="section6" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <input form="form" id="btnEvent6" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" value ="6">
  </div>

  </div>
  </div>
  <div class="row">
    <div class="twelve columns">
      <span id="msg" class="msgError"></span>
    </div>
  </div>
    <div class="row">
      <div class="twelve columns" style="text-align: center">
        <h4>
          <span>Lisää vierasjoukkueen tiedot</span>
        </h4>
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

    </div>
<?php
        echo'<input type="hidden" id="ref" value="'.$count.'">';
  ?>
  <tr id="newTr" style="height:61px;display:none">
    <td><img style="width: 35px; vertical-align: middle;" src="images/default.png"></td>

    <td><span id="newrow"></span></td>
    <td></td>
  </tr>
  </table>

  <div class="row">
    <div class="twelve columns" style="text-align:left">
  <input style="display:none"class="button-primary" name="addVisitor" type="submit" id="addVisitor" value="Tallenna">
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
