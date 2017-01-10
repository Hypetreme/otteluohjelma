<?php  
  include('inc/header.php'); 
?>

<!-- Tähän sitten se switchi -->

<div class="container">
  <div class="row">
    <div class="twelve columns">
      <h1>
        Otteluohjelma
      </h1>
    </div>
  </div>
  <div class="row">
    <form action="functions.php" method="POST">
      <div class="twelve columns">
        <h4>
          Login
        </h4>
      </div>
      <div class="twelve columns">
        <label for="uid">
          Username:
        </label>
        <input type="text" name="uid">
      </div>
      <div class="twelve columns">
        <label for="pwd">
          Password:      
        </label>
        <input type="password" name="pwd">
      </div>
      <div class="twelve columns">
        <input class="button-primary" name="logIn" type="submit" value="Login">
        <input class="button-primary" type="button" value="Register" onclick="window.location.href='register.php'">
      </div>
    </form>
  </div>
</div>

<?php include ('inc/footer.php'); ?>