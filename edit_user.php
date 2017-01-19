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
<td class="bold">Vahvista salasana:</td>
              <td><input type="password" name="pwd" ></td></tr>
            </tr>
          </body>
        </table>
      <ul class="navbar-list">
      <li class="navbar-item"><input type="submit" name="saveUser" value="Tallenna">
      <?php
       if (isset($_SESSION['teamId'])) {
      echo '<li class="navbar-item"><input style="background-color:gray;color:white"type="submit" name="removeTeam" value="Poista joukkue">';
      } ?>

      </form>
    </ul>
      </div>
    </div>


  <?php
    include ('inc/footer.php');
  ?>
