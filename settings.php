<?php
  session_start();
  include ('dbh.php');
  if (isset($_SESSION['teamId'])) {
  $teamId = $_SESSION['teamId'];
}
  if (!isset($_SESSION['id'])) {
    header("Location: index.php");
  }
    unset($_SESSION['homeName']);
    unset($_SESSION['visitorName']);
    unset($_SESSION['eventId']);
    unset($_SESSION['eventName']);
    unset($_SESSION['eventPlace']);
    unset($_SESSION['eventDate']);
    unset($_SESSION['home']);
    unset($_SESSION['visitors']);
    unset($_SESSION['saved']);
    unset($_SESSION['matchText']);
    unset($_SESSION['plainMatchText']);
    unset($_SESSION['popupText']);
    unset($_SESSION['ads']);
    unset($_SESSION['adlinks']);
    unset($_SESSION['editEvent']);
    unset($_SESSION['old']);
  include ('functions.php');
  include ('inc/header.php');
?>

  <div class="container">
    <span id="msg" class="msgError"></span>
    <div class="row" style="text-align:left">
      <div class="twelve columns">
      <div style="float:left">
        <h4>
        Asetukset
        </h4>
      </div>
        <?php
          $url = "";
          if (isset($_SESSION['teamId'])) {
            $team = 'team.php?teamId='.$_SESSION['teamId'];
            $url = 'location.href="'.$team.'"';
          }
            $ads = 'ads.php';
            $url3 = 'location.href="'.$ads.'"';
            $events = 'my_events.php';
            $url2 = 'location.href="'.$events.'"';
          echo '<div style="float:right">';
          if (isset($_SESSION['teamId'])) {
            echo '<button class="button-primary" onclick='.$url.'>Kokoonpano</button>';
            echo '<button class="button-primary" onclick='.$url2.'>Tapahtumasi</button>';
            }
            echo '<button class="button-primary" onclick='.$url3.'>Aseta Mainospaikat</button>';
            echo '</div>';

        ?>
    </div>
    </div>

    <div class="row">
      <div class="six columns" style="float:left">
        <h5>Logo</h5>
        <table style="margin-top:23px" class="u-full-width">
        <form action="functions.php" method="post" enctype="multipart/form-data">
          <tbody>
            <tr>
              <td><input type="file" onchange="loadData()"></td>
            </tr>

              <img src= <?php
              if (isset($_SESSION['teamId'])) {
                  $fileName =  'images/logos/' . $teamUid . $teamId .'.png';
                  echo $fileName .'?'.time();
              } else {
                $fileName = 'images/logos/' . $uid . $id . '.png';
                echo $fileName .'?'.time();
              }
              ?> height="180" alt="Image preview...">
              <input type="hidden" id="imgData">

          </tbody>
        </form>
        </table>
        <input class="button-primary" type="submit" value="Tallenna logo" id="fileUpload" name="fileUpload">
      </div>


      <div class="six columns" style="float:left">
        <h5>Käyttäjätiedot</h5>
        <table class="u-full-width">
          <tbody>
            <tr>
              <?php userData('view'); ?>
            </tr>
          </body>
        </table>
      <button class="button-primary" onclick="window.location='edit_user.php'">Muokkaa</button>

      </div>
      </div>
    <script>
    $('form').submit(function(event){

          event.preventDefault(); // stop the form from submitting
          var logo = document.getElementById("imgData");
          var finish = $.post("functions.php", { fileUpload: 'upload', imgData: logo.value }, function(data) {
            if(data){
              console.log(data);
            }
            message(data);
          });
      });
      function loadData() {
        var preview = document.querySelector('img');
        var file    = document.querySelector('input[type=file]').files[0];
        var logo = document.getElementById("imgData");
        var reader  = new FileReader();
      reader.addEventListener("load", function () {
preview.src = reader.result;
logo.value = reader.result;
}, false);
if (file) {
   reader.readAsDataURL(file);
 }
}
    </script>

  <?php
    include ('inc/footer.php');
  ?>
