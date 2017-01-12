<nav class="navbar">
  <div class="container">
    <ul class="navbar-list">
      <li class="navbar-item"><a class="navbar-link" onclick="location.href='settings.php'">Asetukset</a></li>
      <li class="navbar-item"><a class="navbar-link" onclick="location.href='goodbye.php'">Kirjaudu ulos</a></li>

        <?php
          $session = $profile = $profile2 = $teams = $url = $url2 = $url3 = "";
          if (isset($_SESSION)) {
            $session = json_encode($_SESSION);
            if (isset($_SESSION['teamId'])) {
            $profile = 'profile.php?teamId='.$_SESSION['teamId'];
          } else {
            $profile = 'profile.php';
          }
          }
          $teams = 'teams.php';
          $url = 'location.href="'.$teams.'"';
          $url2 = 'location.href="'.$profile.'"';

          if (isset($_SESSION)) {
            if (($_SESSION['type']==0)) {
              echo '<li class="navbar-item"><a class="navbar-link" onclick='.$url.'>Joukkueet</a></li>';
                }
              if (!isset($_SESSION['teamId'])) {
                $id = $_SESSION['id'];
                $uid = $_SESSION['uid'];
                $fileName = 'images/logos/'.$uid . $id.'.jpg';

                if (file_exists($fileName)) {
                  echo '<li class="liLogo navbar-item">
                        <a class="navbar-link" onclick='.$url2.'>
                          <div class="logo" style="background-image: url('.$fileName.');"></div>
                        </a>
                        <i class="navMore material-icons">expand_more</i>
                        </li>';
                } else {
                  echo '<li class="liLogo navbar-item">
                        <a class="navbar-link" onclick='.$url2.'>
                        <div class="logo" style="background-image: url(images/logos/seura.png);"></div>
                        </a>
                        <i class="navMore material-icons">expand_more</i>
                        </li>';
          }
        } else {
              $teamId = $_SESSION['teamId'];
              $teamName = $_SESSION['teamName'];
              $fileName = 'images/logos/'.$teamName . $teamId.'.jpg';

              if (file_exists($fileName)) {
                echo '<li class="liLogo navbar-item">
                      <a class="navbar-link" onclick='.$url2.'>
                      <div class="logo" style="background-image: url('.$fileName.');"></div>
                      </a>
                      <i class="navMore material-icons">expand_more</i>
                      </li>';
              } else {
                echo '<li class="liLogo navbar-item">
                      <a class="navbar-link" onclick='.$url2.'>
                      <div class="logo" style="background-image: url(images/logos/seura.png);"></div>
                      </a>
                      <i class="navMore material-icons">expand_more</i>
                      </li>';
              }

            }
          }
          echo '<script>console.log('.$session.')</script>';
        ?>
    </ul>

    <div class="navMoreBox">
      <ul>
        <li><a onclick="alert('hihiihihihihi');">Profile</a></li>
        <li><a onclick="location.href='settings.php'">Asetukset</a></li>
        <li><a onclick="location.href='goodbye.php'">Kirjaudu ulos</a></li>
      </ul>
    </div>

  </div>

</nav>
