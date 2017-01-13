<?php
  session_start();
  include 'dbh.php';
  if (!$_SESSION['type'] == 0) {
  $teamId = $_SESSION['teamId'];
  $teamName = $_SESSION['teamName'];
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
  getTeamName();
  include('inc/header.php');
?>

  <div class="container">


    <div class="row">
      <div class="twelve columns">
        <h4>
          Profiili
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
                  <th>Päivämäärä</th>
                </tr>
              </thead>
              <tbody>
                <?php listEvents('upcoming'); ?>
              </tbody>
          </table>
       </div>
       <div class="six columns">
        <h5>Avatar</h5>
        <!-- tähän -->
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
                  <th>Päivämäärä</th>
                </tr>
              </thead>
              <tbody>
                <?php listEvents('past'); ?>
              </tbody>
          </table>
       </div>
    </div>

    <form action="functions.php" method="POST">
      <input name="newEvent" type="submit" value="Luo Tapahtuma">
    </form>
    <?php
      include ('inc/footer.php');
    ?>
