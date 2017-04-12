<?php
include('inc/chart.php');
 ?>
<div class="guess">
  <div class="container">
    <div class="row">
      <div class="twelve columns">
          <h1 class="title">Kilpailu</h1>
      </div>
      <div class="twelve columns">
        <div style="text-align:center" id="guessName" class="guess-name">
        </div>
      </div>
      <div id="chartMaster" class="twelve columns" style="height:208px;margin-bottom:40px;text-align:center;">
      <div class="chart-header" id="chartHeader"></div>
      <div id="chart" class="chart" style="color:white">
          <div class="spinner">
          <div class="bounce1"></div>
          <div class="bounce2"></div>
          <div class="bounce3"></div>
        </div>
      </div>
      </div>
      <?php if ($answered != true) {
      echo '<form id="form" style="margin:0;">
      <div class="twelve columns" style="text-align:center">
        <label for="guess-options" style="font-weight:100">Vastauksesi</label>
          <select id="guessOptions"></select>
          <select id="guessOptions2" style="display:none"></select>
        </div>
<div class="twelve columns" style="text-align:center">
        <input name="first" id="first" type="text" placeholder="Etunimi" required>
        <input name="last" id="last" type="text" placeholder="Sukunimi"required>
        <input name="email" id="email" type="email" placeholder="Sähköposti" required>
      </div>
<div class="twelve columns" style="text-align:center">
      <input id="setGuess" type="submit" value="Lähetä">
    </form>
      </div>
      </div>
      <div id="thanks" style="color:white;text-align:center;margin-top:60px;display:none"><h3>Kiitos vastauksestasi!</h3></div>';
} else {
echo '</div>
<div id="thanks" style="color:white;text-align:center;margin-top:60px;"><h3>Kiitos vastauksestasi!</h3></div>';
}
?>
  </div>
  <div class="space"></div>
  </div>
