<?php
  session_start();
  include 'dbh.php';
unset($_SESSION['teamId']);
unset($_SESSION['teamName']);
  if (!isset($_SESSION['id'])) {
    header("Location: index.php");
  }
  if (($_SESSION['type']!=0)) {
      $teamId = $_SESSION['teamId'];
    header("Location: team.php?teamId=$teamId");
  }

  include('inc/header.php');
  include('functions.php');
?>

  <script type="text/javascript">
    var count = 1;

    function addInput() {
      document.getElementById('newTr').style="width: 100%;";
      document.getElementById('iconAddTeam').style="display:none;";
      document.getElementById('btnSave').style="display:block;";
      var num = document.getElementById('ref').value.match(/\d+/)[0];
      var finalNum = +num + count - 1;

      var etuCount = "joukkuenimi" + finalNum;
      var etuField = document.createElement("input");
      etuField.type = "text";
      etuField.name = etuCount;
      etuField.id = etuCount;
      //etuField.style = "width:200px;height:40px";

      //var etuP = document.createElement("p");
      //var etuText = document.createTextNode("Nimi:");
      //etuP.appendChild(etuText);

      var headerCount = "Joukkue " + finalNum;

      //var header = document.createElement("h4");
      //var headerText = document.createTextNode(headerCount);
     // header.appendChild(headerText);

      //var br = document.createElement("br");

      //document.getElementById('newrow').appendChild(header);
      //document.getElementById('newrow').appendChild(etuP);
      document.getElementById('newrow').appendChild(etuField);
      //document.getElementById('newrow').appendChild(br);

      count += 1;
    }
</script>

  <div class="container">

    <div class="row">
      <div class="twelve columns">
        <h1>
          Joukkueet
        </h1>
      </div>
    </div>

    <div class="row">
      <div class="twelve columns">

        <form name="form" action="functions.php" method="POST">
          <table class='u-full-width'>
          <thead>
              <tr>
                <th>Laji</th>
                <th>Nimi</th>
                <th>Tila</th>
              </tr>
            </thead>
          <?php
            $count = listTeams();
            echo '<input type="hidden" id="ref" value="'.$count.'">';
          ?>
          <tr id="newTr" style="display: none;">
            <td><img style="width: 35px; height: 35px; vertical-align: middle;" src="images/default_team.png"></td>
            <td><span id="newrow"></span></td>
            <td></td>
          </tr>
          </table>
        </div>

        <div class="twelve columns">
          <a href="#" id="iconAddTeam"  onclick="addInput()">
            <i style="position:relative;font-size:40px; left:-10px"class="material-icons">add box</i>
          </a>
          <input style="display:none"class="button-primary" name="saveTeam" type="submit" id="btnSave" value="Tallenna">
        </div>

      </form>
    </div>

  </div>


  <?php
    include ('inc/footer.php');
  ?>
