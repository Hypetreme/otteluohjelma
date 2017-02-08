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
    unset($_SESSION['ads']);
    unset($_SESSION['adlinks']);
    unset($_SESSION['editEvent']);
  include('inc/header.php');
  include('functions.php');
?>

  <script type="text/javascript">

    function addInput() {


      $("#newTr").fadeIn();
      //document.getElementById('newTr').style="width: 100%;";

      $("#iconAddTeam").hide();
      //document.getElementById('iconAddTeam').style="display:none;";

      $("#register").fadeIn();
      //document.getElementById('btnSave').style="display:block;";

      var num = document.getElementById('ref').value.match(/\d+/)[0];

      var uidField = document.createElement("input");
      uidField.type = "text";
      uidField.name = "uid";
      uidField.id = "uid";

     var fakeField = document.createElement("input");
     fakeField.style = "display:none";

     var fakeField2 = document.createElement("input");
     fakeField2.style = "display:none";
     fakeField2.type = "password";

      var emailField = document.createElement("input");
      emailField.type = "text";
      emailField.name = "email";
      emailField.id = "email";

      var pwdField = document.createElement("input");
      pwdField.type = "password";
      pwdField.name = "pwd";
      pwdField.id = "pwd";

      var pwdConfirmField = document.createElement("input");
      pwdConfirmField.type = "password";
      pwdConfirmField.name = "pwdConfirm";
      pwdConfirmField.id = "pwdConfirm";


      var colorField = document.createElement("select");
        var colorOption1 = document.createElement("option");
        colorOption1.value = "sininen";
        colorOption1.text = "Sininen";
        var colorOption2 = document.createElement("option");
        colorOption2.value = "punainen";
        colorOption2.text = "Punainen";
        var colorOption3 = document.createElement("option");
        colorOption3.value = "vihreä";
        colorOption3.text= "Vihreä";

      colorField.appendChild(colorOption1);
      colorField.appendChild(colorOption2);
      colorField.appendChild(colorOption3);


      var uidH = document.createElement("label");
      uidH.innerHTML = "Nimi";

      var emailH = document.createElement("label");
      emailH.innerHTML = "Sähköposti";

      var pwdH = document.createElement("label");
      pwdH.innerHTML = "Salasana";

      var pwdConfirmH = document.createElement("label");
      pwdConfirmH.innerHTML = "Salasana uudelleen";

      var color = document.createElement("label");
      color.innerHTML = "Valitse väri";

      document.getElementById('newrow').appendChild(uidH);
      document.getElementById('newrow').appendChild(uidField);
      document.getElementById('newrow').appendChild(emailH);
      document.getElementById('newrow').appendChild(emailField);
      document.getElementById('newrow').appendChild(pwdH);
      document.getElementById('newrow').appendChild(fakeField);
      document.getElementById('newrow').appendChild(fakeField2);
      document.getElementById('newrow').appendChild(pwdField);
      document.getElementById('newrow').appendChild(pwdConfirmH);
      document.getElementById('newrow').appendChild(pwdConfirmField);
      document.getElementById('newrow').appendChild(color);
      document.getElementById('newrow').appendChild(colorField);
    }
</script>

  <div class="container">

    <div class="row">
      <div class="twelve columns">
        <h4>
          Joukkueet
        </h4>
      </div>
    </div>

    <div class="row">
      <div class="twelve columns">
<form id="form" action="functions.php" method="POST">
  <span style="float:left" id="msg" class="msgError"></span>
          <table class='u-full-width'>

          <thead>
              <tr>
                <th>Laji</th>
                <th>Nimi</th>
                <th>Tila</th>
               <th></th>
                  </tr>
            </thead>
          <?php
            $count = listTeams();
            echo '<input type="hidden" id="ref" value="'.$count.'">';
          ?>

          <tr id="newTr" style="display: none;">
            <td><img style="width: 35px; height: 35px; vertical-align: middle;" src="images/default_team.png"></td>

            <td><span id="newrow"></span></td>
            <td></td>
          </tr>
          </table>
        </div>

        <div class="twelve columns">
          <a href="#" id="iconAddTeam" onclick="addInput()">
            <i style="position:relative;font-size:40px; left:-10px"class="material-icons">add box</i>
          </a>
          <input form="form" style="display:none" class="button-primary" name="register" type="submit" id="register" value="Tallenna">
          </form>
        </div>
    </div>

  </div>
  <script>
  $('form').submit(function(event){
      event.preventDefault(); // stop the form from submitting
      var username = $('#uid').val();
      var emailaddress = $('#email').val();
      var pass = $('#pwd').val();
      var passconfirm = $('#pwdConfirm').val();
      var finish = $.post("functions.php", { register: 'register', pwd: pass, uid: username, email: emailaddress, pwdConfirm: passconfirm }, function(data) {
        if(data){
          console.log(data);
        }
          message(data);
      });
  });
  </script>

  <?php
    include ('inc/footer.php');
  ?>
