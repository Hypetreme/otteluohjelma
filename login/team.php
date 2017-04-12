<?php
  session_start();
  include('dbh.php');
  if (!isset($_SESSION['id']) || !isset($_SESSION['teamId'])) {
      header("Location: index.php");
  }
  include('functions.php');
  include('inc/header.php');
  unset($_SESSION['event']);
?>



  <script>

  function openDialog() {
    vex.dialog.open({
    onSubmit: function(event) {
    event.preventDefault();
    event.stopPropagation();

    if ($('#firstName').val()!="" && $('#lastName').val()!="" && $('#number').val()!="") {
      if ($('.vex-first').hasClass("ok")) {
      var btn = "add";
    } else {
      var btn = "";
    }
      var selected = ($(this).attr("id"));
      var visitor = $('#visitorName').val();
      var first = $('#firstName').val();
      var last = $('#lastName').val();
      var num = $('#number').val();
      var finish = $.post("functions.php", { addPlayer: "addPlayer", firstName : first, lastName : last, number : num, button: btn }, function(data) {
        if(data){
          $("#players").load(location.href + " #players");
          $("#emptyHeader").css("display", "none");
          $("#edit").css("display", "initial");

          console.log(data);
        }
         message(data);
         if (data == "addPlayerMore") {
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
          message("addPlayerClose");
          }
      }
  })

$('.vex-first').click(function(event){
  $(this).addClass("ok");
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

  </script>

  <div class="container">
    <span class="msg msg-fail" id="msg"></span>
    <form id="form" action="functions.php" method="POST">
    <div class="row">
      <div class="twelve columns">
         <h4>
          <span><?php echo $_SESSION['teamUid'];?></span>
        </h4>
          <button type="button" class="button-primary" id="iconAddPlayer" style="position:relative;">Lisää</button>
          <?php

          echo '<button id="edit" style="display:none" class="button-primary" type="button" onclick="window.location.href=\'edit_team.php\'">Muokkaa</button>';

          ?>
      </div>
      <div class="twelve columns">
          <table id="players" class='u-full-width'>

            <?php
              listPlayers();
            ?>
          </table>
          </div>
          <div class="row">
            <div class="twelve columns" style="text-align:left">

            <input style="display:none"class="button-primary" type="submit" id="addPlayer" value="Tallenna">
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
