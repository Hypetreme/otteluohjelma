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
      <div class="six columns">
        <label for="uid">
          Käyttäjänimi:
        </label>
        <input type="text" name="uid">
      </div>

      <div class="six columns">
        <label for="email">
          Sähköposti:
        </label>
        <input type="text" name="email">
        <input type="text" style="display:none">
      </div>
    </div>
    <div class="row">
      <div class="six columns">
        <label for="pwd">
          Salasana:
        </label>
        <input type="password" style="display:none">
        <input type="password" name="pwd">
      </div>
      <div class="six columns">
        <label for="pwdConfirm">
          Kirjoita salasana uudelleen:
        </label>
        <input type="password" name="pwdConfirm">
      </div>
    </div>
    <div class="row">
      <div class="six columns">
        <label for="taso">
          Valitse taso:
        </label>
        <select name="taso">
          <option disabled selected>Valitse</option>
          <option value="seura">Seura (11,99e/kk)</option>
          <option value="joukkue">Joukkue (6,99e/kk)</option>
        </select>
      </div>
      <div class="six columns">
        <label for="laji">
          Urheilulaji:
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
        <input class="button-primary" name="register" type="submit" value="Rekisteröidy">
      </div>
    </form>
  </div>
</div>

<?php include ('inc/footer.php'); ?>
