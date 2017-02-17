<?php
  session_start();
  if (!isset($_SESSION['id'])) {
    header("Location: index.php");
  }
  if (isset($_SESSION['teamId'])) {
  $teamId = $_SESSION['teamId'];
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

  include('inc/header.php');
  include 'functions.php';
?>

  <script type="text/javascript">
</script>

  <div class="container">



    <div class="row">
      <div class="twelve columns" >
        <h4 style="position: relative;">
          Tapahtumat
        </h4>
      </div>
    </div>

    <div class="row">

        <form name="form" action="functions.php" method="GET">
          <?php listEvents('all');
          ?>
          </table>
          <span id="newrow"></span>
            </form>

    </div>
  <?php
    include ('inc/footer.php');
  ?>
