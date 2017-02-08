<?php
  include('inc/header.php');
?>

<div class="container">
  <span id="msg" class="msgError"></span>
  <div class="row">
    <div class="twelve columns">
      <h1>
        Rekisteröidy
      </h1>
    </div>
  </div>
  <div class="row">
    <form action="functions.php" method="POST">
      <div class="six columns">
        <label for="uid">
          Käyttäjänimi
        </label>
        <input type="text" id="uid" name="uid">
      </div>

      <div class="six columns">
        <label for="email">
          Sähköposti
        </label>
        <input type="text" id="email" name="email">
        <input type="text" style="display:none">
      </div>
    </div>
    <div class="row">
      <div class="six columns">
        <label for="pwd">
          Salasana
        </label>
        <input type="password" style="display:none">
        <input type="password" id="pwd" name="pwd">
      </div>
      <div class="six columns">
        <label for="pwdConfirm">
          Kirjoita salasana uudelleen
        </label>
        <input type="password" id="pwdConfirm" name="pwdConfirm">
      </div>
    </div>
    <div class="row">
      <div class="six columns">
        <label for="taso">
          Valitse taso
        </label>
        <select id="level" name="level">
          <option disabled selected>Valitse</option>
          <option value="seura">Seura (11,99e/kk)</option>
          <option value="joukkue">Joukkue (6,99e/kk)</option>
        </select>
      </div>
      <div class="six columns">
        <label for="laji">
          Urheilulaji
        </label>
        <select name="laji">
          <option disabled selected>Valitse</option>
          <option value="jalkapallo">Jalkapallo</option>
          <option value="salibandy">Salibändy</option>
          <option value="jaakiekko">Jääkiekko</option>
          <option value="koripallo">Koripallo</option>
        </select>
      </div>
      <div class="twelve columns">
        <button type="button" value="Takaisin" onclick="window.location='index.php'"/>Takaisin</button>
        <input class="button-primary" id="register" name="register" type="submit" value="Rekisteröidy">
      </div>
    </form>
  </div>
</div>
<script>
$('form').submit(function(event){
    event.preventDefault(); // stop the form from submitting
    var username = $('#uid').val();
    var emailaddress = $('#email').val();
    var pass = $('#pwd').val();
    var passconfirm = $('#pwdConfirm').val();
    var level = $('#level').val();
    var finish = $.post("functions.php", { register: 'register', pwd: pass, uid: username, email: emailaddress, pwdConfirm: passconfirm, regLevel: level}, function(data) {
      if(data){
        console.log(data);
      }
        message(data);
    });
});
</script>
<?php include ('inc/footer.php'); ?>
