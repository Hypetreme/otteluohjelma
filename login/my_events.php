<?php
session_start();
include ('dbh.php');

include ('inc/header.php');
include ('functions.php');
?>

<div class="header-bg"></div>
  <div class="container">
  <div class="row">
      <div class="twelve columns" >
        <div class="section-header">
        <h4>
          Tapahtumat
        </h4>
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
    </div>

    <div class="row shadow-box">

        <form id="form" action="functions.php" method="GET">
          <?php listEvents('all');
          ?>
          </table>
          <span id="newrow"></span>
            </form>

    </div>
  <?php
    include ('inc/footer.php');
  ?>
