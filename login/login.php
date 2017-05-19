<?php
  include('inc/header.php');
  if (!isset($_SESSION)) {
  session_start();
}
  if (isset($_SESSION['id'])) {
      header("Location: index.php");
  }
?>

<!-- Tähän sitten se switchi -->

<div class="container">
  <span class="msg msg-fail" id="msg"></span>
  <div class="row" style="text-align:center">
    <div class="twelve columns">
      <h1>
        Otteluohjelma
      </h1>
    </div>
  </div>
  <div class="shadow-box-login">
    <form style="margin-bottom:0px;"id="form" action="functions.php" method="POST">
      <div class="twelve columns">
        <h4>
          Kirjaudu sisään
        </h4>
      </div>
      <div class="twelve columns">
        <label for="uid">
          Käyttäjänimi
        </label>
        <input class="styled" type="text" id="uid">
      </div>
      <div class="twelve columns">
        <label for="pwd">
          Salasana
        </label>
        <input type="password" id="pwd">
      </div>
      <div class="twelve columns">
        <input class="button-primary" id="logIn" id="submit" type="submit" value="Kirjaudu">
        <input class="button-primary" type="button" value="Rekisteröidy" onclick="window.location.href='register.php'">
      </div>
    </form>
  </div>


</div>
<script>
$('form').submit(function(event){
    event.preventDefault();
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
<?php include('inc/footer.php'); ?>
