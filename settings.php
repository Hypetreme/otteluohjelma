<?php
  session_start();
  include('dbh.php');
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
    unset($_SESSION['guessName']);
    unset($_SESSION['guessType']);
    unset($_SESSION['popupText']);
    unset($_SESSION['ads']);
    unset($_SESSION['adlinks']);
    unset($_SESSION['editEvent']);
    unset($_SESSION['old']);
  include('functions.php');
  include('inc/header.php');
?>

  <div class="container">
    <span id="msg" class="msg-fail"></span>
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
            $url2 = 'location.href="my_events.php"';
            $url3 = 'location.href="guess.php"';
            $url4 = 'location.href="ads.php"';
          echo '<div style="float:right">';
          if (isset($_SESSION['teamId'])) {
              echo '<button class="button-primary" onclick='.$url.'>Kokoonpano</button>';
              echo '<button class="button-primary" onclick='.$url2.'>Tapahtumasi</button>';
              echo '<button class="button-primary" onclick='.$url3.'>Kilpailut</button>';
          }
            echo '<button class="button-primary" onclick='.$url4.'>Aseta Mainospaikat</button>';
            echo '</div>';

        ?>
    </div>
    </div>

    <div class="row">
      <div class="six columns" style="float:left">
        <h5>Logo</h5>
        <form action="functions.php" method="post" enctype="multipart/form-data">
        <table style="margin-top:23px" class="u-full-width">
          <tbody>
            <tr>
              <td>
                <p style="font-size:14px;color:gray;margin:0">Kuvan maksimikoko 500kt</p>
                <input style="max-width:375px"type="file" onchange="loadData()"></td>
            </tr>

              <div style="height:166px">
              <img alt="logo" src= <?php
              if (isset($_SESSION['teamId'])) {
                  $fileName =  'images/logos/' . $teamUid . $teamId .'.png';
                  $default = 'images/logos/joukkue.png';
                  if (file_exists($fileName)) {
                      echo $fileName .'?'.time();
                  } else {
                      echo $default;
                  }
              } else {
                  $fileName = 'images/logos/' . $uid . $id . '.png';
                  $default = 'images/logos/seura.png';
                  if (file_exists($fileName)) {
                      echo $fileName .'?'.time();
                  } else {
                      echo $default;
                  }
              }
              ?> style="max-width:370px;max-height:202px;vertical-align:-160px">
            </div>
              <input type="hidden" id="imgData">

          </tbody>
        </table>
        <input class="button-primary" type="submit" value="Tallenna logo" id="fileUpload" name="fileUpload">
        </form>
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
    include('inc/footer.php');
  ?>
