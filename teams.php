<?php
  session_start();
  include 'dbh.php';
unset($_SESSION['teamId']);
unset($_SESSION['teamName']);
  if (!isset($_SESSION['id'])) {
    header("Location: index.php");
  }
  if (($_SESSION['type']!=0)) {
      $teamId = $_SESSION['teamId'];
    header("Location: team.php?teamId=$teamId");
  }

  include('inc/header.php');
  include('functions.php');
?>

  <script type="text/javascript">

    function addInput() {
      document.getElementById('newTr').style="width: 100%;";
      document.getElementById('iconAddTeam').style="display:none;";
      document.getElementById('btnSave').style="display:block;";
      var num = document.getElementById('ref').value.match(/\d+/)[0];

      var uidField = document.createElement("input");
      uidField.type = "text";
      uidField.name = "uid";
      uidField.id = "uid";

      var emailField = document.createElement("input");
      emailField.type = "text";
      emailField.name = "email";
      emailField.id = "email";

      var pwdField = document.createElement("input");
      pwdField.type = "password";
      pwdField.name = "pwd";
      pwdField.id = "pwd";

      var uidH = document.createElement("label");
      uidH.innerHTML = "Nimi:";

      var emailH = document.createElement("label");
      emailH.innerHTML = "Sähköposti:";

      var pwdH = document.createElement("label");
      pwdH.innerHTML = "Salasana:";

      document.getElementById('newrow').appendChild(uidH);
      document.getElementById('newrow').appendChild(uidField);
      document.getElementById('newrow').appendChild(emailH);
      document.getElementById('newrow').appendChild(emailField);
      document.getElementById('newrow').appendChild(pwdH);
      document.getElementById('newrow').appendChild(pwdField);
    }
</script>

  <div class="container">

    <div class="row">
      <div class="twelve columns">
        <h1 style="text-transform: uppercase;">
          Joukkueet
        </h1>
      </div>
    </div>

    <div class="row">
      <div class="twelve columns">

        <form name="form" action="functions.php" method="POST">
          <table class='u-full-width'>
          <thead>
              <tr>
                <th>Laji</th>
                <th>Nimi</th>
                <th>Tila</th>
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
          <a href="#" id="iconAddTeam"  onclick="addInput()">
            <i style="position:relative;font-size:40px; left:-10px"class="material-icons">add box</i>
          </a>
          <input style="display:none"class="button-primary" name="register" type="submit" id="btnSave" value="Tallenna">
        </div>

      </form>
    </div>

  </div>


  <?php
    include ('inc/footer.php');
  ?>
