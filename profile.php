<?php
  session_start();
  include 'dbh.php';
  if (!$_SESSION['type'] == 0) {
  $teamId = $_SESSION['teamId'];
  $teamUid = $_SESSION['teamUid'];
}
  if (!isset($_SESSION['id'])) {
    header("Location: index.php");
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
  if (isset($_GET['back'])) {
    unset($_SESSION['teamId']);
    unset($_SESSION['teamUid']);
    unset($_SESSION['teamName']);
  }
  include ('functions.php');
  getTeamName();
  include('inc/header.php');
?>

  <div class="container">


    <div class="row">
      <div class="twelve columns">
        <h4>
          Etusivu
           </h4>
      </div>
    </div>

    <div class="row">
        <div class="six columns">
            <h5>
              Tulevat tapahtumat
            </h5>
            <table class="u-full-width">
              <thead>
                <tr>
                  <th>Tapahtuman nimi</th>
                  <?php if (!isset($_SESSION['teamId'])) {
                  echo '<th>Joukkue</th>';
                  } ?>
                  <th>Päivämäärä</th>
                </tr>
              </thead>
              <tbody>
                <?php listEvents('upcoming'); ?>
              </tbody>
          </table>
       </div>
    </div>

    <div class="row">
      <div class="six columns">
            <h5>
              Viimeisimmät tapahtumat
            </h5>
            <table class="u-full-width">
              <thead>
                <tr>
                  <th>Tapahtuman nimi</th>
                  <?php if (!isset($_SESSION['teamId'])) {
                  echo '<th>Joukkue</th>';
                  } ?>
                  <th>Päivämäärä</th>
                </tr>
              </thead>
              <tbody>
                <?php listEvents('past'); ?>
              </tbody>
          </table>
       </div>
    </div>

<?php if (isset($_SESSION['teamId'])) {
    echo '<form action="functions.php" method="POST">';
    echo '<input type="submit" name="fetchAds" value="Luo Tapahtuma">'; }
    echo '</form>';
?>
    <?php
      include ('inc/footer.php');
    ?>
