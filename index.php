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
    <form name="form" action="functions.php" method="POST">
      <div class="twelve columns">
        <h4>
          Login
        </h4>
      </div>
      <div class="twelve columns">
        <label for="uid">
          Username:
        </label>
        <input type="text" id="uid" name="uid">
      </div>
      <div class="twelve columns">
        <label for="pwd">
          Password:
        </label>
        <input type="password" id="pwd" name="pwd">
      </div>
      <span id="error" style="font-weight:bold;font-size:20px;color:red">&nbsp;</span>
      <div class="twelve columns">
        <input class="button-primary" id="logIn" name="logIn" id="submit" type="submit" value="Login">
        <input class="button-primary" type="button" value="Register" onclick="window.location.href='register.php'">
      </div>
    </form>
  </div>
</div>
<script>

$('form').submit(function(event){
    var error = document.getElementById("error");
    event.preventDefault(); // stop the form from submitting
    var username = $('#uid').val();
    var pass = $('#pwd').val();
    var finish = $.post("functions.php", { logIn: 'login', pwd: pass, uid: username }, function(data) {
      if(data){
        console.log(data);
      }
        if (data == "pwdWrong"){
        error.innerHTML="Käyttäjätunnus tai salasana on väärin!";
      }else if (data == "notActivated"){
        error.innerHTML="Käyttäjätunnusta ei ole aktivoitu!";
      } else if (data == "success"){
        window.location.href = "profile.php";
        }

    });
});
</script>
<?php include ('inc/footer.php'); ?>
