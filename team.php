<?php
  session_start();
  include ('dbh.php');
  if (!isset($_SESSION['id'])) {
    header("Location: index.php");
  }
  include ('functions.php');
  include ('inc/header.php');
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
    unset($_SESSION['adlinks']);
    unset($_SESSION['editEvent']);
?>



  <script>

  function openDialog() {
  vex.dialog.open({
      message: 'Lisää pelaaja',
      input: [
          '<span id="msg" class="msgError"></span>',
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
          message("savePlayerSuccess");
          } else {
          }
      }
  })
  $('.vex-first').on('click', function() {
    if ($('#firstName').val()!="" && $('#lastName').val()!="" && $('#number').val()!="") {
      var selected = ($(this).attr("id"));
      var visitor = $('#visitorName').val();
      var first = $('#firstName').val();
      var last = $('#lastName').val();
      var num = $('#number').val();
      var finish = $.post("functions.php", { savePlayer: "saveplayer", firstName : first, lastName : last, number : num}, function(data) {
        if(data){
          console.log(data);
        }

      });
    openDialog();
  }
  });
  $('.vex-last').on('click', function() {
    if ($('#firstName').val()!="" && $('#lastName').val()!="" && $('#number').val()!="") {
      var selected = ($(this).attr("id"));
      var visitor = $('#visitorName').val();
      var first = $('#firstName').val();
      var last = $('#lastName').val();
      var num = $('#number').val();
      var finish = $.post("functions.php", { savePlayer: "saveplayer", firstName : first, lastName : last, number : num}, function(data) {
        if(data){
          console.log(data);
        }
         message(data);
      });
  }
  });
}
    $content = "<div class='six columns'>";
    $content += "<h1>Lisää pelaaja</h1>";
    $content += "<label>Etunimi</label>";
    $content += "<input type='text'>";
    $content += "<label>Sukunimi</label>";
    $content += "<input type='text'>";
    $content += "</div>";
    $content += "<label>Pelinumero</label>";
    $content += "<input type='text'>";
    $content += "</div>";

    function addInput() {
      $("#newTr").fadeIn();
      //document.getElementById('newTr').style="display:table-row;height:61px";
      $("#iconAddPlayer").hide();
      //document.getElementById('iconAddPlayer').style="display:none";
      $("#savePlayer").fadeIn();
      //document.getElementById('btnSave').style="display:block";

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
    }

  </script>

  <div class="container">
    <span id="msg" class="msgError"></span>
    <form name="form" action="functions.php" method="POST">
    <div class="row">
      <div class="twelve columns">
         <h4>
          <span><?php echo $_SESSION['teamUid'];?></span>
        </h4>
          <button type="button" class="button-primary" id="iconAddPlayer" style="position:relative;left:-10px">Lisää</button>
          <?php
          if (isset($_SESSION['foundPlayers'])) {
          echo '<button class="button-primary" type="button" onclick="window.location.href=\'edit.php\'">Muokkaa</button>';
        }
          ?>
      </div>
      <div class="twelve columns">
          <table class='u-full-width'>

            <?php
              listPlayers();
            ?>
            <tr id="newTr" style="height:61px;display:none">
              <td><img style="width: 35px; vertical-align: middle;" src="images/default.png"></td>
              <td><span id="newrow"></span></td>
              <td></td>
            </tr>
          </table>
          </div>
          <div class="row">
            <div class="twelve columns" style="text-align:left">

              <!--<a href="#" id="iconAddPlayer" class="addPlayer">
                Lisää pelaaja
              </a>-->

            <input style="display:none"class="button-primary" name="savePlayer" type="submit" id="savePlayer" value="Tallenna">
            </div>

          </div>
  </form>
</div>
<script>
$('#iconAddPlayer').on('click', function() {
openDialog();

});
</script>

  <?php include('inc/footer.php'); ?>
