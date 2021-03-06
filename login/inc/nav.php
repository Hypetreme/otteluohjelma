<nav class="navbar">
  <div class="row" style="background-color: #eee; display: none;">
      <div class="container">
        <ul style="list-style: none; padding: 0; margin: 0;">
          <li style="padding: 16px 0px; margin: 0;">
            <a href="#" style="text-transform: uppercase; font-size: 40px; text-decoration: none;">Otteluohjelma.fi</a>
          </li>
        </ul>
      </div>
    </div>
    <?php
    if ($_SESSION['type'] != 2) {
        echo '<div class="time"><p>Käyttöaikaa jäljellä '.$_SESSION['time'].' päivää</p></div>';
    }
    if (isset($_SESSION)) {
        if (!isset($_SESSION['teamId'])) {
            echo '<style>
      .navbar-link,.open-nav {
      color: white;
      }

      </style>';
            echo '<div class="row" style="background-color: #6172BD;">';
        } else {
            echo '<div class="row" style="background-color: #f7f7f7;">';
        }
    }
    ?>
    <div class="one column" style="width:auto;text-align:center;position: relative;">
      <div style="margin-left:10px;display:inline-block;">
        <?php
          $profile  = 'index.php?back';
          $url  = 'location.href="'.$profile.'"';
          if (isset($_SESSION['teamId']) && $_SESSION['type'] == 0) {
              echo '<button class="host" onclick='.$url.'>< Seuraan</button>';
          }
        ?>
      </div>
    </div>
      <div class="container">

        <ul class="navbar-list">
          <?php
          include('dbh.php');
          $session = $profile = $profile2 = $teams = $url = $url2 = $url3 = "";

          if (isset($_SESSION)) {
              $session = json_encode($_SESSION);

              if (isset($_SESSION['teamId'])) {
                  $profile = 'index.php?teamId=' . $_SESSION['teamId'];
              } elseif ($_SESSION['type'] == 2) {
                  $profile = 'control.php';
              } else {
                  $profile = 'index.php';
              }

          //defining variables
              $team       =   'teams.php';
              $url        =   'location.href="'.$profile.'"';
              $id         =   $_SESSION['id'];
              $uid        =   $_SESSION['uid'];
              if (isset($_SESSION['teamId'])) {
                  $teamUid   =   $_SESSION['teamUid'];
                  $teamId     =   $_SESSION['teamId'];
              }
              $stmt = $conn->prepare("SELECT * FROM team WHERE user_id = :user_id");
              $stmt->bindParam(":user_id", $id);
              $stmt->execute();
              $result = $stmt->fetchAll();

          //if there is session teamId
          if (isset($_SESSION['teamId'])) {
              $fileName = 'images/logos/'.$teamUid.$teamId.'.png';
              if (file_exists($fileName)) {
                  $profileLink = $url;
                  $profileFile = $fileName;
                  $profileName = $teamUid;
              } else {
                  $profileLink = $url;
                  $profileFile = "images/logos/joukkue.png";
                  $profileName = $teamUid;
              }
          } else {
              $fileName = 'images/logos/'.$uid.$id.'.png';
              if (file_exists($fileName)) {
                  $profileLink = $url;
                  $profileFile = $fileName;
                  $profileName = $uid;
              } else {
                  $profileLink = $url;
                  $profileFile = "images/logos/seura.png";
                  $profileName = $uid;
              }
          }

              echo '<li class="li-logo navbar-item">
                  <i style="display:none" class="material-icons change-team">import_export</i>
                  <div class="btn open-nav">
                    <a class="navbar-link">
                      <div class="ctx">
                        <div class="ctx-r">
                          <div class="avatar" style="background-image: url(' . $profileFile . '?'.time().');"></div>
                        </div>
                        <div class="ctx-r">
                          <div class="name">' . $profileName . '</div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <i class="material-icons open-nav">keyboard_arrow_right</i>
                </li>';
          }
          echo '<script>console.log(' . $session . ')</script>';
          ?>
        <script type="text/javascript">

          /*$(function(){

            var moreNav = $('.more');
            var links = $(".more li");
            var moreNavBtn = $('.open-nav');
            var changeTeam = $('.change-team');
            var navJoukkueet = $('.nav-joukkueet');

            changeTeam.on("click", function(){
                navJoukkueet.css({
                  "display" : "inline-block",
                  "position" : "absolute",
                  "top" : "10px",
                  "left" : "0",
                  "height" : "42px",
                  "border-top-left-radius" : "0",
                  "border-bottom-left-radius" : "0"
                });
            });

            moreNavBtn.on("click", function(){
              $(this).animate({
                "left":"8px"
              }, 160, function(){
                links.css({
                  "display": "inline-block",
                  "opacity": "0",
                  "margin-left": "-40px"
                });
                links.animate({
                  "opacity": "1",
                  "margin-left": "0px"
                }, 300, function(){
                });
                $(this).animate({
                  "left": "4px"
                }, 160, function(){
                });
              });
            });
          });*/
        </script>

        <div class="more">
          <li class="navbar-item"><a class="navbar-link" onclick=' <?php echo $url ?>'>Etusivu</a></li>
          <?php
          if ($_SESSION['type'] != 2) {
              if (!isset($_SESSION['teamId'])) {
                  echo '<li class="navbar-item"><a class="navbar-link" href="teams.php">Joukkueet</a></li>';
              } else {
                  echo '<li class="navbar-item"><a class="navbar-link" href="team.php?teamId='.$teamId.'">Kokoonpano</a></li>';
              }
          }
          ?>
          <li class="navbar-item"><a class="navbar-link" onclick="location.href='settings.php'">Asetukset</a></li>
          <li class="navbar-item"><a class="navbar-link" onclick="location.href='goodbye.php'">Kirjaudu ulos</a></li>
        </div>

        <!--<select id="nav-joukkueet" name="nav-joukkueet" class="nav-joukkueet" onchange="location = this.value;">
          <option value="current" selected disabled>Valitse joukkue</option>
          <?php
            /*foreach ($result as $row) {
                echo "<option value='index.php?teamId=".$row['id']."'>".$row['name']."</option>";
            }*/
          ?>
        </select>-->

      </ul>
    </div>
  </div>
</nav>
