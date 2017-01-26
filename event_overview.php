<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
header("Location: index.php");
}
include ('inc/header.php');
include 'functions.php';
?>

<!-- Theme included stylesheets -->
<link href="//cdn.quilljs.com/1.2.0/quill.snow.css" rel="stylesheet">

  <div class="container">
  <?php if (!isset($_GET['eventId'])) {
    echo '<div class="row" id="guide">
      <div class="twelve columns" style="text-align: center;">

  <a href="event1.php" style="text-decoration:none"><div id="section1" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">1</h3>
  </div></a>

  <a href="event2.php" style="text-decoration:none"><div id="section2" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">2</h3>
  </div></a>

  <a href="event3.php" style="text-decoration:none"><div id="section3" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">3</h3>
  </div></a>

  <a href="event4.php" style="text-decoration:none"><div id="section4" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">4</h3>
  </div></a>

  <a href="event5.php" style="text-decoration:none"><div id="section5" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">5</h3>
  </div></a>

  <a href="#" style="text-decoration:none"><div id="section6" style="float:left;width: 60px; height: 60px; background: green; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">6</h3>
  </div></a>

  </div>
  </div>'; }
  ?>
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
    <div class="twelve columns" style="text-align: center;">
      <h4>
        <span>Ennakkoteksti</span>
      </h4>
      <span><?php if (isset($_SESSION['matchText'])) {
        echo '<div id="editor" class="twelve columns" style="min-height:200px">';
        echo '</div>';
      }
        ?></span>
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
      $url = "event5.php";
      $url2 = "event1.php";
        if (isset($_GET['c'])) {
       echo "<button class='button-primary' type='button' value='Takaisin' onclick='window.location=\"$url\"'/>";
       echo "Takaisin</button>";
       echo "<form style='display: inline;padding: 5px' action='functions.php' method='POST'>";
       echo "<button class='button-primary' type='submit' name='createEvent' id='btncreateEvent' value='Tallenna'>";
       echo "Tallenna</button>";
       echo "</form>";
     } else if (isset($_GET['eventId'])) {
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
  <!-- Main Quill library -->
  <script src="//cdn.quilljs.com/1.2.0/quill.js"></script>
  <script>
  var options = {
    modules: {
    toolbar: null
  },
    readOnly: true,
    scrollingContainer: true,
    theme: 'snow'
  };
  var editor = new Quill('#editor', options);
  <?php
  echo 'editor.setContents ('.$_SESSION['matchText'].');';
  echo '</script>';
  ?>
  <?php include('inc/footer.php'); ?>
