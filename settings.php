<?php
  session_start();
  include ('dbh.php');
  if (isset($_SESSION['teamId'])) {
  $teamid = $_SESSION['teamId'];
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
  }
  include ('functions.php');
  include ('inc/header.php');
?>

  <div class="container">
    <div class="row">
      <div class="twelve columns">
        <h4>
          Asetukset
        </h4>
      </div>
      <ul class="navbar-list">
        <?php
          $url = "";
          if (isset($_SESSION['teamId'])) {
            $team = 'team.php?teamId='.$_SESSION['teamId'];
            $url = 'location.href="'.$team.'"';
          }
          $loc = 'my_events.php';
          $url2 = 'location.href="'.$loc.'"';
          if (isset($_SESSION['teamId'])) {
            echo '<li class="navbar-item"><button onclick='.$url.'>Kokoonpano</button></li>';
            echo '<li class="navbar-item"><button onclick='.$url2.'>Tapahtumasi</button></li>';
          }
        ?>
      </ul>
    </div>

    <div class="row">
      <div class="six columns">
        <h5>Logo</h5>
        <table class="u-full-width">
        <form action="functions.php" method="post" enctype="multipart/form-data">
          <tbody>
            <tr>
              <td><input type="file" name="file" id="file"></td>
              <td><input type="submit" value="Tallenna logo" name="logoUpload"></td>
            </tr>
          </tbody>
        </form>
        </table>
      </div>
    </div>

    <div class="row">
      <div class="six columns">
        <h5>Käyttäjätiedot</h5>
        <table class="u-full-width">
          <tbody>
            <tr>
              <?php userData(); ?>
            </tr>
          </body>
        </table>
      </div>
    </div>


  <?php
    include ('inc/footer.php');
  ?>
