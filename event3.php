<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
header("Location: index.php");
}
include ('inc/header.php');
include 'functions.php';
?>

  <script>
    var count = 1;

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
      nroField.style = "padding:0; margin:0;margin-left:5px;width:40px;clear:left;";

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
    <div class="row" id="guide">
      <div class="twelve columns" style="text-align: center;">

      <a href="event1.php" style="text-decoration:none"><div id="section1" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
      <h3 style="color:white;padding-top:5px">1</h3>
    </div></a>

  <a href="event2.php" style="text-decoration:none"><div id="section2" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">2</h3>
  </div></a>

  <a href="event3.php" style="text-decoration:none"><div id="section3" style="float:left;width: 60px; height: 60px; background: green; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">3</h3>
  </div></a>

  <div id="section4" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <input form="visitors2" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" name ="setVisitorTeam" value ="4">
  </div>

  </div>
  </div>
    <div class="row">
<br>
      <div class="twelve columns" style="text-align: center">
        <h4>
          <span>Lisää vierasjoukkueen tiedot</span>
        </h4>
        <form id="visitors2" action="functions.php" method="POST">
       <label for="visitorName">Vierasjoukkueen nimi:</label>
      <input type="text" name="visitorName" value="<?php
      if (isset($_SESSION['visitorName'])) {
         echo $_SESSION['visitorName'];
       }
        ?>">
        </form>
      </div>
      </div>


      <div class="twelve columns">
        <form name="form" action="functions.php" method="POST">
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
          $count = listVisitors();
          ?>

        <input type="hidden" name="eventName" value= "<?php echo $_GET['eventName'];?>">
        <input type="hidden" name="eventDate" value= "<?php echo $_GET['eventDate'];?>">

    </div>
<?php
        echo'<input type="hidden" id="ref" value="'.$count.'">';
  ?>
  <table>
  <tr id="newTr" style="height:61px;display:none">
    <td><img style="width: 35px; vertical-align: middle;" src="images/default.png"></td>
  <td id="numRow" style="padding:0; margin:0 "></td>
   <td id="firstRow" style="padding:0; margin:0 "></td>
   <td id="lastRow" style="padding:0; margin:0 "></td>
  </tr>
  </table>

  <div class="row">
    <div class="twelve columns" style="text-align:left">
   <a href="#" id="iconAddPlayer"  onclick="addInput()">
    <i style="position:relative;font-size:40px; left:-10px"class="material-icons">add box</i>
  </a>
  <input style="display:none"class="button-primary" name="addVisitor" type="submit" id="btnSave" value="Tallenna">
</form>
</div>
</div>
<div class="row">
      <div class="twelve columns" style='text-align:center;padding-top:50px'>
<button class="button-primary" type="button" value="Takaisin" onclick="window.location='event2.php'"/>Takaisin</button>
<input form="visitors2" class="button-primary" type="submit" name="setVisitorTeam" value="Seuraava">

      </div>
    </div>
</div>

  <?php include('inc/footer.php'); ?>
