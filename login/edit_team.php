<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
}
include('inc/header.php');
include 'functions.php';
?>
<body>
  <div class="row">
    <div class="twelve columns">
      <span class="msg msg-fail" id="msg"></span>
    </div>
  </div>
<div class="container">
    <div class="row">

      <div class="twelve columns">
         <h4>
           <form id="form" action="functions.php" method="POST">
          <span><p style="display: inline;">Muokkaa</p></span>
        </h4>
  </div>
      <div class="twelve columns">

        <span id="datarow">

        <?php
        editPlayers();
          ?>
        </span>
      <button type="button" value="Takaisin" onclick="window.location='team.php?teamId=<?php echo $_SESSION['teamId']?>'"/>Takaisin</button>
      <input class="button-primary" name="setPlayers" type="submit" id="btnUpdate" value="Tallenna muutokset">
        </form>
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
    var playerids = $('.ids').serializeArray();
    var finish = $.post("functions.php", { setPlayers: 'players', numbers: nums, firstNames: firstnames, lastNames: lastnames, ids: playerids }, function(data) {
      if(data){
        console.log(data);
      }
      message(data);

    });
});
</script>
