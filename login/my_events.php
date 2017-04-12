<?php
  session_start();
  if (!isset($_SESSION['id'])) {
    header("Location: index.php");
  }
  if (isset($_SESSION['teamId'])) {
  $teamId = $_SESSION['teamId'];
}
  unset($_SESSION['event']);

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

        <form id="form" action="functions.php" method="GET">
          <?php listEvents('all');
          ?>
          </table>
          <span id="newrow"></span>
            </form>

    </div>
  <?php
    include ('inc/footer.php');
  ?>
