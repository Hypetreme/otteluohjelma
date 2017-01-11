<nav class="navbar">
  <div class="container">
    <ul class="navbar-list">
        <script type="text/javascript">
        </script>
        <?php
        $session = $profile = $profile2 = $teams = $url = $url2 = $url3 = "";
        if (isset($_SESSION)) {
          $session = json_encode($_SESSION);
          if (isset($_SESSION['teamId'])) {
          $profile2 = 'profile.php?teamId='.$_SESSION['teamId'];
          } }
          $profile = 'profile.php';
          $teams = 'teams.php';

          $url = 'location.href="'.$teams.'"';
          $url2 = 'location.href="'.$profile.'"';
          $url3 = 'location.href="'.$profile2.'"';

        if (isset($_SESSION)) {
          if (($_SESSION['type']==0)) {
            echo '<li class="navbar-item"><a class="navbar-link" onclick='.$url.'>Joukkueet</a></li>';
            echo '<li class="navbar-item"><a class="navbar-link" onclick='.$url3.'><img style="width: 35px; height: 35px; vertical-align: middle;" src="images/logos/seura.png" alt="here_avatar"> <i style="position: absolute; top: 6px; right: 21px; display: inline; font-size: 14px; "class="material-icons">expand_more</i></a></li>';
          } else {
            $teamId = $_SESSION['teamId'];
            $teamName = $_SESSION['teamName'];
            $fileName = 'images/logos/'.$teamName . $teamId.'.jpg';

            if (file_exists($fileName)) {
              echo '<li class="navbar-item">
                    <a class="navbar-link" onclick='.$url2.'>
                    <img style="width: 35px; height: 35px; vertical-align: middle;" src='.$fileName.'></a></li>';
            } else {
              echo '<li class="navbar-item">
                    <a class="navbar-link" onclick='.$url2.'>
                    <img style="width: 35px; height: 35px; vertical-align: middle;" src="images/logos/joukkue.png"></a></li>';
            }

}
          }
            echo '<script>console.log('.$session.')</script>';
        ?>
      <li class="navbar-item"><a class="navbar-link" onclick="location.href='settings.php'">Asetukset</a></li>
      <li class="navbar-item"><a class="navbar-link" onclick="location.href='goodbye.php'">Kirjaudu ulos</a></li>
    </ul>
  </div>
</nav>
