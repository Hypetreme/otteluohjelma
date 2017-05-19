<?php
session_start();
include ('dbh.php');
include ('unset.php');
include ('inc/header.php');
include ('functions.php');
?>

  <script type="text/javascript">
  function openDialog() {
  vex.dialog.open({

    onSubmit: function(event) {
    event.preventDefault();
    event.stopPropagation();

  if ($('#uid').val()!="" && $('#teamname').val()!="" && $('#email').val()!="" && $('#pwd').val()!="" && $('#pwdConfirm').val()!="") {
    if ($('.vex-first').hasClass("ok")) {
    var btn = "add"
  } else {
    var btn = "";
  }
    var username = $('#uid').val();
    var teamname = $('#teamname').val();
    var emailaddress = $('#email').val();
    var pass = $('#pwd').val();
    var passconfirm = $('#pwdConfirm').val();
    var finish = $.post("functions.php", { register: 'register', pwd: pass, uid: username, name: teamname, email: emailaddress, pwdConfirm: passconfirm, button: btn }, function(data) {
      if(data){
        console.log(data);
        $("#teams").load(location.href + " #teams");
        $("#emptyHeader").css("display", "none");
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
          '<label for="teamname">Joukkueen nimi</label>',
          '<input id="teamname" type="text" required="" valid. oninput="setCustomValidity(\'\')" oninvalid="this.setCustomValidity(\'Syötä joukkueen nimi\')">',
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
<div class="header-bg"></div>
  <div class="container">
  <span class="msg msg-fail" id="msg"></span>
    <div class="row">
      <div class="twelve columns">
        <div class="section-header">
        <h4>
          Joukkueet
        </h4>
      </div>
        <button type="button" class="button-primary" id="iconAddPlayer" style="position:relative;">Lisää</button>
      </div>
    </div>

    <div class="shadow-box2">
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
        event.preventDefault();
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
