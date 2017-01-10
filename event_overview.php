<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
header("Location: index.php");
}
include ('inc/header.php');
include 'functions.php';
?>

  <div class="container">
    <div class="row">
<br>
      <div class="twelve columns" style="text-align: center;">

      </div>
      </div>

    <div class="row">

      <div class="six columns">
        <h4>
          <span><?php
           echo $_SESSION['eventName'];
            ?></span>
        </h4>
        <h5>
          <span><?php
            echo $_SESSION['homeName'];
            ?></span>
        </h5>
         <table class="u-full-width">
          <?php showHome();
          ?>
          </table>
      </div>

      <div class="six columns">
        <h4>
          <span><?php
            echo $_SESSION['eventDate'];
            ?></span>
        </h4>
        <h5>
          <span><?php
            echo $_SESSION['visitorName'];
            ?></span>
        </h5>
          <table class="u-full-width">
          <?php
          showVisitors();
          ?>
        </table>

      </div>
    </div>

        <input type="hidden" name="eventName" value= "<?php echo $_SESSION['eventName'];?>">
        <input type="hidden" name="eventdate" value= "<?php echo $_SESSION['eventDate'];?>">
    </div>
    <div class="row">
      <div class="twelve columns" style="text-align:center;position:absolute;padding-top:50px">
       <?php
      if (isset($_GET['eventId'])) {
      $eventId = $_GET['eventId'];
    }
      $url = "event3.php";
      $url2 = "event1.php";
        if (isset($_GET['c'])) {
       echo "<button class='button-primary' type='button' value='Takaisin' onclick='window.location=\"$url\"'/>";
       echo "Takaisin</button>";
       echo "<form style='display: inline;padding: 5px' action='functions.php' method='POST'>";
       echo "<button class='button-primary' type='submit' name='createEvent' id='btncreateEvent' value='Tallenna'>";
       echo "Tallenna</button>";
       echo "</form>";
        } else {
       echo "<form style='display: inline;padding: 5px' action='functions.php?removeEvent=".$eventId."' method='POST'>";
       echo "<button style='border-color:gray;background-color:gray;' class='button-primary' name='removeEvent' type='submit' id='btnremoveEvent' value='Poista'>";
       echo "Poista</button>";
       echo "</form>";
       echo "<button class='button-primary' type='button' value='Muokkaa' onclick='window.location=\"$url2\"'/>";
       echo "Muokkaa</button>";

} ?>

      </div>
    </div>

  </div>
  <?php include('inc/footer.php'); ?>
