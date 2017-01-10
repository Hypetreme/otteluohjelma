<?php
  session_start();
  include 'dbh.php';
  $teamid = $_SESSION['teamid'];
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
          <table class='u-full-width'>
          <thead>
              <tr>
                <th>Laji</th>
                <th>Nimi</th>
                <th>Tila</th>
              </tr>
            </thead>
          <?php listEvents(all);
            echo'<input type="hidden" id="ref" value="'.$i.'">';
          ?>
          
          </table>
          <span id="newrow"></span>
            </form>
      
    </div>
  <?php 
    include ('inc/footer.php');
  ?>