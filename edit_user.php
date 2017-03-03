<?php
  session_start();
  include ('dbh.php');
  if (isset($_SESSION['teamId'])) {
  $teamId = $_SESSION['teamId'];
}
  if (!isset($_SESSION['id'])) {
    header("Location: index.php");
  }
  if (isset($_SESSION['eventId'])) {
    unset($_SESSION['homeName']);
    unset($_SESSION['visitorName']);
    unset($_SESSION['eventId']);
    unset($_SESSION['eventName']);
    unset($_SESSION['eventPlace']);
    unset($_SESSION['eventDate']);
    unset($_SESSION['home']);
    unset($_SESSION['visitors']);
    unset($_SESSION['saved']);
  }
  include ('functions.php');
  include ('inc/header.php');
?>

  <div class="container">
    <span id="msg" class="msgError"></span>
    <div class="row">
      <div class="twelve columns">
        <h4>
          Muokkaa käyttäjätietoja
        </h4>
      </div>

      <div class="six columns">
        <table class="u-full-width">
        <form action="functions.php" method="POST">
          <tbody>
            <tr>
              <?php userData('edit'); ?>

<tr>
<td class="bold">Vahvista salasana</td>
<td><input type="password" id="pwd" name="pwd" ></td></tr>
            </tr>
          </body>
        </table>
      <ul class="navbar-list">
      <li class="navbar-item"><input class="button-primary" type="submit" name="editUser" id="editUser" value="Tallenna">
      <?php
       if ($_SESSION['type'] == 0 && isset($_SESSION['teamId'])) {
      echo '<li class="navbar-item"><input style="background-color:red;color:white"type="submit" id="removeTeam" name="removeTeam" value="Poista joukkue">';
      } ?>

      </form>
    </ul>
      </div>
    </div>
    <script>
    $('#editUser').click(function(event){
        event.preventDefault(); // stop the form from submitting
        var teamname = $('#name').val();
        var pass = $('#pwd').val();
        var serie = $('#serie').val();
        var finish = $.post("functions.php", { editUser: 'edit', pwd: pass, name: teamname, teamSerie: serie }, function(data) {
          if(data){
            console.log(data);
          }
          message(data);

        });
    });
    $('#removeTeam').click(function(event){
        event.preventDefault(); // stop the form from submitting
        var teamname = $('#name').val();
        var pass = $('#pwd').val();
        var finish = $.post("functions.php", { removeTeam: 'remove', pwd: pass }, function(data) {
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
