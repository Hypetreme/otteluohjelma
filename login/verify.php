<?php
  include('inc/header.php');
  include ('functions.php');
?>

<div class="container">
  <div class="row">
    <div class="twelve columns" style="text-align:center">
      <h4>
        <?php verifyAccount();?>
      </h4>
    <button type="button" value="Takaisin" onclick="window.location='login.php'"/>Etusivulle</button>
    </div>
  </div>
</div>

<?php include ('inc/footer.php'); ?>
