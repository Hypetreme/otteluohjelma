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
      var num = document.getElementById('ref').value.match(/\d+/)[0];
      var finalNum = +num + count - 1;

      var etuCount = "firstName" + "["+finalNum+"]";
      var etuField = document.createElement("input");
      etuField.type = "text";
      etuField.name = etuCount;
      etuField.id = etuCount;

      var sukuCount = "lastName" + "["+finalNum+"]";
      var sukuField = document.createElement("input");
      sukuField.type = "text";
      sukuField.name = sukuCount;
      sukuField.id = sukuCount;

      var nroCount = "number" + "["+finalNum+"]";
      var nroField = document.createElement("input");
      nroField.type = "text";
      nroField.name = nroCount;
      nroField.id = nroCount;

      var etuP = document.createElement("p");
      var etuText = document.createTextNode("Etunimi:");
      etuP.style = "display: inline-block;text-align: right;width:90px;";
      etuP.appendChild(etuText);

      var sukuP = document.createElement("p");
      var sukuText = document.createTextNode("Sukunimi:");
      sukuP.style = "display: inline-block;text-align: right;width:90px;";
      sukuP.appendChild(sukuText);

      var nroP = document.createElement("p");
      var nroText = document.createTextNode("Pelinumero:");
      nroP.style = "display: inline-block;text-align: right;width:90px;";
      nroP.appendChild(nroText);


      var headerCount = "Pelaaja " + finalNum;

      var header = document.createElement("h4");
      var headerText = document.createTextNode(headerCount);
      header.appendChild(headerText);

      var br = document.createElement("br");

      document.getElementById('newrow').appendChild(header);
      document.getElementById('newrow').appendChild(etuP);
      document.getElementById('newrow').appendChild(etuField);
      document.getElementById('newrow').appendChild(sukuP);
      document.getElementById('newrow').appendChild(sukuField);
      document.getElementById('newrow').appendChild(nroP);
      document.getElementById('newrow').appendChild(nroField);
      document.getElementById('newrow').appendChild(br);

      count += 1;
    }
  </script>
  <div class="container">

    <div class="row">
<br>
      <div class="twelve columns" style="text-align: center">
        <h4>
          <span>Lisää vierasjoukkueen tiedot</span>
        </h4>
        <form id="visitors2" action="functions.php" method="POST">
       <label for="visitorName">Vierasjoukkueen nimi:</label>
      <input type="text" name="visitorName" value="<?php 
         echo $_SESSION['visitorName'];
        ?>">
        </form>    
      </div>
      </div>


      <div class="twelve columns">
        <form id="visitors" action="functions.php" method="POST">
          <table class="u-full-width">
          <?php
          $count = listVisitors(); 
          ?>
        </table>
        <span id="newrow"></span>  
</form>
      
    </div>

        <input type="hidden" name="eventName" value= "<?php echo $_GET['eventName'];?>"> 
        <input type="hidden" name="eventDate" value= "<?php echo $_GET['eventDate'];?>">     
  
    </div>
<?php 
        echo'<input type="hidden" id="ref" value="'.$count.'">';  
  ?>   
<div class="row" style="text-align:center">
  
  
  <div class="twelve columns" style="text-align:center">
<input style="background-color:black;border-color:black" class="button-primary" type="button" id="btnAdd" onclick="addInput()" value="Lisää pelaaja">
<input form="visitors" style="background-color:black;border-color:black" class="button-primary" name="addVisitor" type="submit" id="btnAddVisitor" value="Tallenna pelaajat">    
    
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