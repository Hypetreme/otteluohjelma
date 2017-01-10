<?php  
  include('inc/header.php'); 
?>

<div class="container">
  <div class="row">
    <div class="twelve columns">
      <h1>
        Rekisteröidy
      </h1>
    </div>
  </div>
  <div class="row">
    <form action="functions.php" method="POST">
      <div class="twelve columns">
        <h4>
          Register
        </h4>
      </div>
      <div class="twelve columns">
        <label for="uid">
          Username:
        </label>
        <input type="text" name="uid">
      </div>
      <div class="twelve columns">
        <label for="email">
          Email:      
        </label>
        <input type="text" name="email">
      </div>
      <div class="twelve columns">
        <label for="pwd">
          Password:      
        </label>
        <input type="password" name="pwd">
      </div>
      <div class="twelve columns">
        <input class="button-primary" name="register" type="submit" value="Register">
      </div>
    </form>
  </div>
</div>

<?php include ('inc/footer.php'); ?>