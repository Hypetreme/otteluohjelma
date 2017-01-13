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
    <div class="row" style="background-color: #f7f7f7;">
      <div class="container">
      <ul class="navbar-list">

        <li class="navbar-item"><a class="navbar-link" onclick="location.href='settings.php'">Asetukset</a></li>
        <li class="navbar-item"><a class="navbar-link" onclick="location.href='goodbye.php'">Kirjaudu ulos</a></li>


          <?php
            $session = $profile = $profile2 = $teams = $url = $url2 = $url3 = "";



            if (isset($_SESSION)) {
              $session = json_encode($_SESSION);
              if (isset($_SESSION['teamId'])) {
                $profile = 'profile.php?teamId=' . $_SESSION['teamId'];
              }
              else {
                $profile = 'profile.php';
              }
            }

            $teams = 'teams.php';
            $url = 'location.href="' . $teams . '"';
            $url2 = 'location.href="' . $profile . '"';
            $id = $_SESSION['id'];
            $uid = $_SESSION['uid'];
            $teamName = $_SESSION['teamName'];
            $teamId = $_SESSION['teamId'];

            if (isset($_SESSION)) {
              if (($_SESSION['type'] == 0)) {
                echo '<li class="navbar-item">
                      <a class="navbar-link" onclick=' . $url . '>Joukkueet</a>
                    </li>';
              }

              if (!isset($_SESSION['teamId'])) {



                $fileName = 'images/logos/' . $uid . $id . '.jpg';
                if (file_exists($fileName)) {
                  echo '
                    <li class="liLogo navbar-item">
                    <div class="btn">
                      <a class="navbar-link" onclick=' . $url2 . '>
                        <div class="ctx">
                          <div class="ctx-r">
                            <div class="avatar" style="background-image: url(' . $fileName . ');"></div>
                          </div>
                          <div class="ctx-r">
                            <div class="name">'.$uid.'</div>
                          </div>
                        </div>
                      </a>
                    </div></li>';
                }
                else {
                  echo '
                    <li class="liLogo navbar-item">
                    <div class="btn">
                      <a class="navbar-link" onclick=' . $url2 . '>
                        <div class="ctx">
                          <div class="ctx-r">
                            <div class="avatar" style="background-image: url(images/logos/seura.png);"></div>
                          </div>
                          <div class="ctx-r">
                            <div class="name">'.$uid.'</div>
                          </div>
                        </div>
                      </a>
                    </div></li>';

                }
              } else {

                $fileName = 'images/logos/' . $teamName . $teamId . '.jpg';
                if (file_exists($fileName)) {
                  echo '
                    <li class="liLogo navbar-item">
                    <div class="btn">
                      <a class="navbar-link" onclick=' . $url2 . '>
                        <div class="ctx">
                          <div class="ctx-r">
                            <div class="avatar" style="background-image: url(' . $fileName . ');"></div>
                          </div>
                          <div class="ctx-r">
                            <div class="name">'.$teamName.'</div>
                          </div>
                        </div>
                      </a>
                    </div></li>';
                }
                else {
                  echo '
                    <li class="liLogo navbar-item">
                    <div class="btn">
                      <a class="navbar-link" onclick=' . $url2 . '>
                        <div class="ctx">
                          <div class="ctx-r">
                            <div class="avatar" style="background-image: url(images/logos/seura.png);"></div>
                          </div>
                          <div class="ctx-r">
                            <div class="name">'.$teamName.'</div>
                          </div>
                        </div>
                      </a>
                    </div></li>';
                }
              }
            }

            echo '<script>console.log(' . $session . ')</script>';
            ?>
      </ul>
    </div>
  </div>
</nav>
