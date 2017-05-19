<?php
session_start();
include ('dbh.php');
include ('unset.php');
include ('inc/header.php');
include ('functions.php');
?>
<div class="header-bg"></div>
  <div class="container">
    <span class="msg msg-fail" id="msg"></span>
    <div class="row">
      <div class="twelve columns">
        <div class="section-header">
        <h4>
          Muokkaa käyttäjätietoja
        </h4>
      </div>
        <input form="form" class="button-primary" type="submit" id="setUser" value="Tallenna">
        <?php
         if ($_SESSION['type'] == 0 && isset($_SESSION['teamId'])) {
        echo '<button class="remove-btn" type="submit" id="removeTeam">Poista joukkue</button>';
        } ?>
      </div>
      <div class="shadow-box">
      <div class="six columns">

        <table class="u-full-width">
        <form id="form">
          <tbody>
            <tr>
              <?php userData('edit'); ?>

<tr>
<th>Vahvista salasana</th>
<td><input type="password" id="pwd"></td></tr>
            </tr>
          </body>
        </table>
        </div>

      </form>
      </div>
      </div>
    </div>
    </div>
    <script>
    $('#setUser').click(function(event){
        event.preventDefault();
        var teamname = $('#name').val();
        var pass = $('#pwd').val();
        var serie = $('#serie').val();
        var finish = $.post("functions.php", { setUser: 'edit', pwd: pass, name: teamname, teamSerie: serie }, function(data) {
          if(data){
            console.log(data);
          }
          message(data);

        });
    });
    $('#removeTeam').click(function(event){
        event.preventDefault();
        var teamname = $('#name').val();
        var pass = $('#pwd').val();
        var finish = $.post("functions.php", { removeTeam: 'remove', pwd: pass }, function(data) {
          if(data){
            console.log(data);
          }
          message(data);

        });
    });
    </script>

  <?php
    include ('inc/footer.php');
  ?>
