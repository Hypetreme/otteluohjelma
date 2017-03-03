<?php
  include('inc/header.php');
  if (isset($_SESSION['id'])) {
    header("Location: profile.php");
  }
?>

<!-- Tähän sitten se switchi -->

<div class="container">
  <span id="msg" class="msgError"></span>
  <div class="row">
    <div class="twelve columns">
      <h1>
        Otteluohjelma
      </h1>
    </div>
  </div>
  <div class="row">
    <form name="form" action="functions.php" method="POST">
      <div class="twelve columns">
        <h4>
          Kirjaudu sisään
        </h4>
      </div>
      <div class="twelve columns">
        <label for="uid">
          Käyttäjänimi
        </label>
        <input class="styled" type="text" id="uid" name="uid">
      </div>
      <div class="twelve columns">
        <label for="pwd">
          Salasana
        </label>
        <input type="password" id="pwd" name="pwd">
      </div>
      <div class="twelve columns">
        <input class="button-primary" id="logIn" name="logIn" id="submit" type="submit" value="Login">
        <input class="button-primary" type="button" value="Register" onclick="window.location.href='register.php'">
      </div>
    </form>


  </div>

  <div class="row">
    <div class="twelve columns">
    </div>
  </div>


</div>
<script>
$('form').submit(function(event){
    event.preventDefault(); // stop the form from submitting
    var username = $('#uid').val();
    var pass = $('#pwd').val();
    var finish = $.post("functions.php", { logIn: 'login', pwd: pass, uid: username }, function(data) {
      if(data){
        console.log(data);
      }
      message(data);

    });
});
</script>
<?php include ('inc/footer.php'); ?>
