<?php
  session_start();
  include ('dbh.php');
  if (isset($_SESSION['teamId'])) {
  $teamId = $_SESSION['teamId'];
}
  if (!isset($_SESSION['id'])) {
    header("Location: index.php");
  }
  if (isset($_SESSION['event']['id'])) {
    unset($_SESSION['event']['homeName']);
    unset($_SESSION['event']['visitorName']);
    unset($_SESSION['event']['id']);
    unset($_SESSION['event']['name']);
    unset($_SESSION['event']['place']);
    unset($_SESSION['event']['date']);
    unset($_SESSION['event']['home']);
    unset($_SESSION['event']['visitors']);
    unset($_SESSION['event']['saved']);
  }
  include ('functions.php');
  include ('inc/header.php');
?>

  <div class="container">
    <span class="msg msg-fail" id="msg"></span>
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
<td><input type="password" id="pwd"></td></tr>
            </tr>
          </body>
        </table>
      <ul class="navbar-list">
      <li class="navbar-item"><input class="button-primary" type="submit" id="setUser" value="Tallenna">
      <?php
       if ($_SESSION['type'] == 0 && isset($_SESSION['teamId'])) {
      echo '<li class="navbar-item"><button class="remove-btn" type="submit" id="removeTeam">Poista joukkue</button>';
      } ?>

      </form>
    </ul>
      </div>
    </div>
    <script>
    $('#setUser').click(function(event){
        event.preventDefault();
        var teamname = $('#name').val();
        var pass = $('#pwd').val();
        var serie = $('#serie').val();
        var finish = $.post("functions.php", { setUser: 'edit', pwd: pass, name: teamname, teamSerie: serie }, function(data) {
          if(data){
            console.log(data);
          }
          message(data);

        });
    });
    $('#removeTeam').click(function(event){
        event.preventDefault();
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
