<?php
session_start();
include ('dbh.php');
include ('inc/header.php');
include ('functions.php');
?>
<div class="header-bg"></div>
  <div class="container">
    <span class="msg msg-fail" id="msg"></span>
    <div class="row">
      <div class="twelve columns">
        <div class="section-header">
        <h4>Kilpailut</h4>
      </div>
          <?php
            $url = "";
            if (isset($_SESSION['teamId'])) {
                $team = 'team.php?teamId='.$_SESSION['teamId'];
                $url = 'location.href="'.$team.'"';
            }
              $url2 = 'location.href="my_events.php"';
              $url3 = 'location.href="guess.php"';
              $url4 = 'location.href="ads.php"';
            echo '<div>';
            if (isset($_SESSION['teamId'])) {
                echo '<button class="button-primary" onclick='.$url.'>Kokoonpano</button>';
            }
              echo '<button class="button-primary" onclick='.$url2.'>Tapahtumasi</button>';
              if (isset($_SESSION['teamId'])) {
                  echo '<button class="button-primary" onclick='.$url3.'>Kilpailut</button>';
              }
              echo '<button class="button-primary" onclick='.$url4.'>Aseta Mainospaikat</button>';
              echo '</div>';

          ?>
          </div>
<?php
listGuess();
?>
</div>
<div id="populate" class="shadow-box2"></div>
</table>

</div>

  <?php include('inc/footer.php'); ?>
<script>
  $("#answers").on("change",function() {

      var eventid = $('#answers').val();

      var finish = $.post("functions.php", { populateGuess: 'list', eventId: eventid}, function(data) {
        if(data){
          $("#populate").html(data);
        }
      });
  });
</script>
