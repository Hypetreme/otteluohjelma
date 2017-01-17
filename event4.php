<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
header("Location: index.php");
}

include ('inc/header.php');
?>
<div class="container">
  <div class="row" id="guide">
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

<a href="#" style="text-decoration:none"><div id="section4" style="float:left;width: 60px; height: 60px; background: green; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<h3 style="color:white;padding-top:5px">4</h3>
</div></a>

<div id="section5" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<input form="form" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" name ="setMatchText" value ="5">
</div>

</div>
</div>

  <div class="row">
    <div class="twelve columns" style="text-align: center;">
      <h4>
        <span>Ennakot</span>
      </h4>
    </div>

  </div>
<form id="form" action="functions.php" method="POST">
  <div class="row">
    <div class="twelve columns" style="text-align: center;">
      <textarea style="resize:vertical; max-width:400px; min-height:200px;max-height:400px; min-width:400px;"name="matchText"><?php
      if (isset($_SESSION['matchText'])) {
         echo $_SESSION['matchText']; }
        ?></textarea></div>
    </div>

  <div class="row">
    <div class="twelve columns" style="text-align:center;position:absolute;padding-top:50px">
      <button class="button-primary" type="button" value="Takaisin" onclick="window.location='event3.php'"/>Takaisin</button>
      <input class="button-primary" type="submit" name="setMatchText" id="btnEvent4" value="Seuraava">
</form>
    </div>
  </div>

</div>


  <?php include('inc/footer.php'); ?>
