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
include 'functions.php';
include('inc/header.php');
?>

  <script type="text/javascript">
</script>

  <div class="container">
      
    
    
    <div class="row">
      <div class="twelve columns" >
        <h4 style="position: relative;">
          Asetukset
        </h4>
      </div>
      <ul class="navbar-list">
       <li class="navbar-item"><button onclick="location.href='team.php?teamId=<?php echo $_SESSION['teamId']?>'">Kokoonpano</button></li>  
       <li class="navbar-item"><button onclick="location.href='my_events.php'">Tapahtumasi</button></li> 
      </ul> 
    </div>
    
    <div class="row">
      
          <table class='six columns' style='width:70px'>
          <thead>
            <h5 style="position: relative;">
          Käyttäjätiedot
        </h5>
            </thead>
          <tr>
          <?php userData(); ?> 
            </tr>
          
          </table>
      
    </div>
    <div class="row">
      
          <table class='six columns' style='width:70px'>
          <thead>
          <h5 style="position: relative;">
          -
        </h5>  
            </thead>
          <?php
          ?>
          
          </table>
      
    </div>
  <?php 
    include ('inc/footer.php');
  ?>