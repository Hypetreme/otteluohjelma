<?php
  session_start();
  include ('dbh.php');
  if (!isset($_SESSION['id'])) {
    header("Location: index.php");
  }
  include ('functions.php');
  include ('inc/header.php');
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
?>


  <script type="text/javascript">



    var count = 1;

    $content = "<div class='six columns'>";
    $content += "<h1>Lisää pelaaja</h1>";
    $content += "<label>Etunimi:</label>";
    $content += "<input type='text'>";
    $content += "<label>Sukunimi:</label>";
    $content += "<input type='text'>";
    $content += "</div>";
    $content += "<label>Pelinumero:</label>";
    $content += "<input type='text'>";
    $content += "</div>";

    $(function(){

      $('.addPlayer').avgrund({
      	width: 640, // max is 640px
      	height: 350, // max is 350px
      	showClose: false, // switch to 'true' for enabling close button
      	showCloseText: '', // type your text for close button
      	closeByEscape: true, // enables closing popup by 'Esc'..
      	closeByDocument: true, // ..and by clicking document itself
      	holderClass: '', // lets you name custom class for popin holder..
      	overlayClass: '', // ..and overlay block
      	enableStackAnimation: false, // another animation type
      	onBlurContainer: '', // enables blur filter for specified block
      	openOnEvent: true, // set to 'false' to init on load
      	setEvent: 'click', // use your event like 'mouseover', 'touchmove', etc.
      	//onLoad: function (elem) { ... }, // set custom call before popin is inited..
      	//onUnload: function (elem) { ... }, // ..and after it was closed
      	template: $content // or function (elem) { }, or $('.content')
      });

    });


    function addInput() {
      document.getElementById('newTr').style="display:table-row;height:61px";
      document.getElementById('iconAddPlayer').style="display:none";
      document.getElementById('btnSave').style="display:block";
      var num = document.getElementById('ref').value.match(/\d+/)[0];
      var finalNum = +num + count - 1;

      var etuCount = "firstName";
      var etuField = document.createElement("input");
      etuField.type = "text";
      etuField.name = etuCount;
      etuField.id = etuCount;
      etuField.style = "padding:0; margin:0;margin-left:-10px;width:100px;clear:left;";

      var sukuCount = "lastName";
      var sukuField = document.createElement("input");
      sukuField.type = "text";
      sukuField.name = sukuCount;
      sukuField.id = sukuCount;
      sukuField.style = "padding:0; margin:0;margin-left:-5px;width:100px;clear:left;";

      var nroCount = "number";
      var nroField = document.createElement("input");
      nroField.type = "text";
      nroField.name = nroCount;
      nroField.id = nroCount;
      nroField.style = "padding:0; margin:0; margin-left:5px; width:40px; clear:left;";

      /*var etuP = document.createElement("p");
      var etuText = document.createTextNode("Etunimi:");
      etuP.style = "display: inline-block; text-align: right; width:90px;";
      etuP.appendChild(etuText);

      var sukuP = document.createElement("p");
      var sukuText = document.createTextNode("Sukunimi:");
      sukuP.style = "display: inline-block; text-align: right; width:90px;";
      sukuP.appendChild(sukuText);

      var nroP = document.createElement("p");
      var nroText = document.createTextNode("Pelinumero:");
      nroP.style = "display: inline-block; text-align: right; width:90px;";
      nroP.appendChild(nroText);*/

      //var headerCount = "Pelaaja " + finalNum;

      //var header = document.createElement("h4");
      //var headerText = document.createTextNode(headerCount);
      //header.appendChild(headerText);

      //var br = document.createElement("br");

      //document.getElementById('newrow').appendChild(header);
      //document.getElementById('newrow').appendChild(etuP);
      document.getElementById('firstRow').appendChild(etuField);
      //document.getElementById('newrow').appendChild(sukuP);
      document.getElementById('lastRow').appendChild(sukuField);
      //document.getElementById('newrow').appendChild(nroP);
      document.getElementById('numRow').appendChild(nroField);
      //document.getElementById('newrow').appendChild(br);

      count += 1;
    }

  </script>

  <div class="container">
    <form name="form" action="functions.php" method="POST">
    <div class="row">
      <div class="twelve columns">
         <h4>
          <span><?php echo $_SESSION['teamUid'];?></span>
          <a id="iconEdit" style="display: inline;" href="edit.php">
            <i class="material-icons">mode edit</i>
          </a>
        </h4>
      </div>
      <div class="twelve columns">
          <table class='u-full-width'>
            <thead>
              <tr>
                <th>Avatar</th>
                <th>Nro</th>
                <th>Etunimi</th>
                <th>Sukunimi</th>
                <th>Pelipaikka</th>
              </tr>
            </thead>
            <?php
              $count = listPlayers();
              echo'<input type="hidden" id="ref" value="'.$count.'">';
            ?>
            <tr id="newTr" style="height:61px;display:none">
              <td><img style="width: 35px; vertical-align: middle;" src="images/default.png"></td>
              <td id="numRow" style="padding:0; margin:0 "></td>
              <td id="firstRow" style="padding:0; margin:0 "></td>
              <td id="lastRow" style="padding:0; margin:0 "></td>
            </tr>
          </table>
          <div class="row">
            <div class="twelve columns" style="text-align:left">
              <a href="#" id="iconAddPlayer" onclick="addInput()">
                <i style="position:relative;font-size:40px; left:-10px"class="material-icons">add box</i>
              </a>

              <a href="#" id="iconAddPlayer" class="addPlayer">
                Lisää pelaaja
              </a>

            <input style="display:none"class="button-primary" name="savePlayer" type="submit" id="btnSave" value="Tallenna">
            </div>

          </div>
  </div>
  </form>
</div>
  <?php include('inc/footer.php'); ?>
