<?php
  session_start();
  include 'dbh.php';
if (!isset($_SESSION['id'])) {
header("Location: index.php");
  }
if (($_SESSION['type']==0)) {
unset($_SESSION['teamId']);
unset($_SESSION['teamUid']);
unset($_SESSION['teamName']);
} else {
$teamId = $_SESSION['teamId'];
header("Location: profile.php");
exit();
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
    unset($_SESSION['guessName']);
    unset($_SESSION['guessType']);
    unset($_SESSION['popupText']);
    unset($_SESSION['ads']);
    unset($_SESSION['adlinks']);
    unset($_SESSION['editEvent']);
    unset($_SESSION['old']);
  include('inc/header.php');
  include('functions.php');
?>

  <script type="text/javascript">
  function openDialog() {
  vex.dialog.open({

    onSubmit: function(event) {
    event.preventDefault();
    event.stopPropagation();

  if ($('#uid').val()!="" && $('#email').val()!="" && $('#pwd').val()!="" && $('#pwdConfirm').val()!="") {
    if ($('.vex-first').hasClass("ok")) {
    var btn = "add"
  } else {
    var btn = "";
  }
    var username = $('#uid').val();
    var emailaddress = $('#email').val();
    var pass = $('#pwd').val();
    var passconfirm = $('#pwdConfirm').val();
    var finish = $.post("functions.php", { register: 'register', pwd: pass, uid: username, email: emailaddress, pwdConfirm: passconfirm, button: btn }, function(data) {
      if(data){
        console.log(data);
        $("#teams").load(location.href + " #teams");
      }
       message(data);
       if (data == "teamMore") {
          vex.closeAll();
          setTimeout(function(){
          openDialog();
           }, 500);
       }


    });
}
  },
      message: 'Lisää joukkue',
      input: [
          '<label for="uid">Käyttäjänimi</label>',
          '<input id="uid" type="text" required="" valid. oninput="setCustomValidity(\'\')" oninvalid="this.setCustomValidity(\'Syötä käyttäjänimi\')">',
          '<label for="email">Sähköposti</label>',
          '<input id="email" type="text" required="" valid. oninput="setCustomValidity(\'\')" oninvalid="this.setCustomValidity(\'Syötä sähköpostiosoite\')">',
          '<input id="fake1" style="display:none">',
          '<input id="fake2" style="display:none" type="password">',
          '<label for="pwd">Salasana</label>',
          '<input id="pwd" type="password" required="" valid. oninput="setCustomValidity(\'\')" oninvalid="this.setCustomValidity(\'Syötä salasana\')">',
          '<label for="pwd">Salasana uudelleen</label>',
          '<input id="pwdConfirm" type="password" required="" valid. oninput="setCustomValidity(\'\')" oninvalid="this.setCustomValidity(\'Syötä salasana uudelleen\')">',
      ].join(''),
      buttons: [
          $.extend({}, vex.dialog.buttons.YES, { text: 'Lisää uusi'}),
          $.extend({}, vex.dialog.buttons.YES, { text: 'Valmis' }),
      ],
      callback: function (data) {
          if (!data) {
          message("teamClose");
          }
      }
  })
  $('.vex-first').click(function(event){
    $(this).addClass("ok");
    });

}
</script>

  <div class="container">
  <span id="msg" class="msg-fail"></span>
    <div class="row">
      <div class="twelve columns">
        <h4>
          Joukkueet
        </h4>
        <button type="button" class="button-primary" id="iconAddPlayer" style="position:relative;">Lisää</button>
      </div>
    </div>

    <div class="row">
      <div class="twelve columns">
<form id="form" action="functions.php" method="POST">
          <table id="teams" class='u-full-width'>


          <?php
            listTeams();
          ?>
          </table>
        </div>

        <div class="twelve columns">
          <input form="form" style="display:none" class="button-primary" name="register" type="submit" id="register" value="Tallenna">
          </form>
        </div>
    </div>

  </div>
  <script>
  $('a[name=activation').click(function(event){
        event.preventDefault(); // stop the form from submitting
        var id = $(this).attr('id');
        var finish = $.post("functions.php", { sendActivation: 'send', activationId: id }, function(data) {
          if(data){
            $("#teams").load(location.href + " #teams");
            $("#emptyHeader").css("display", "none");
            
            console.log(data);
          }
          message(data);
        });
    });

  $('#iconAddPlayer').on('click', function() {
  openDialog();

  });
  </script>

  <?php
    include ('inc/footer.php');
  ?>
