<?php
  session_start();
  include 'dbh.php';
  if (!$_SESSION['type'] == 0) {
      $teamId = $_SESSION['teamId'];
      $teamUid = $_SESSION['teamUid'];
  }
  if (!isset($_SESSION['id'])) {
      header("Location: login.php");
  }
      unset($_SESSION['event']);
  if (isset($_GET['back'])) {
      unset($_SESSION['teamId']);
      unset($_SESSION['teamUid']);
      unset($_SESSION['teamName']);
  }
  include('functions.php');
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
    <?php if (isset($_SESSION['teamId'])) {
    echo '<form action="functions.php" method="POST">';
    echo '<input class="button-primary" type="submit" name="addEvent" value="Luo Tapahtuma">';
}
        echo '</form>';
    ?>
    <div class="row">
        <div class="six columns">
            <h5>
              Tulevat tapahtumat
            </h5>

                <?php listEvents('upcoming'); ?>
          </table>
       </div>
    </div>

    <div class="row">
      <div class="six columns">
            <h5>
              Viimeisimmät tapahtumat
            </h5>

                <?php listEvents('past'); ?>
          </table>
       </div>
    </div>
    <?php
      include('inc/footer.php');
    ?>
