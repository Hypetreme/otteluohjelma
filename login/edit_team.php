<?php
session_start();
include ('dbh.php');

include ('inc/header.php');
include ('functions.php');
?>
<body>
  <div class="row">
    <div class="twelve columns">
      <span class="msg msg-fail" id="msg"></span>
    </div>
  </div>
  <div class="header-bg"></div>
<div class="container">
    <div class="row">

      <div class="twelve columns">
        <div class="section-header">
         <h4>
        Muokkaa
        </h4>
      </div>
        <button type="button" value="Takaisin" onclick="window.location='team.php?teamId=<?php echo $_SESSION['teamId']?>'"/>Takaisin</button>
        <input class="button-primary" name="setPlayers" type="submit" id="btnUpdate" value="Tallenna muutokset">
  </div>
    <div class="shadow-box">
      <div class="twelve columns">
        <?php
        editPlayers();
          ?>
</div>
      </div>
      </div>
   </div>
<?php include('inc/footer.php'); ?>

<script>
$('#btnUpdate').click(function(event){
    event.preventDefault();
    var nums = $('.numbers').serializeArray();
    var firstnames = $('.firstnames').serializeArray();
    var lastnames = $('.lastnames').serializeArray();
    var playerroles = $('.playerroles').serializeArray();
    var playerids = $('.ids').serializeArray();
    var finish = $.post("functions.php", { setPlayers: 'players', numbers: nums, firstNames: firstnames, lastNames: lastnames, roles: playerroles, ids: playerids }, function(data) {
      if(data){
        console.log(data);
      }
      message(data);

    });
});
</script>
