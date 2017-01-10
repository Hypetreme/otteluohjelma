<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
header("Location: index.php");
} 
include ('inc/header.php'); 
include 'functions.php';

?>
  <script type="text/javascript">
    function removePlayer(id, first, last, num) {
      //poistetaan näkyvistä valittu
      document.getElementById(id).style = "display: none";
      var element = document.getElementById(id);
      var count = element.querySelectorAll("input")[0].name.match(/\d+/)[0];
      var remNum = element.querySelectorAll("input")[0];
      remNum.parentNode.removeChild(remNum);
      var remFirst = element.querySelectorAll("input")[0];
      remFirst.parentNode.removeChild(remFirst);
      var remLast = element.querySelectorAll("input")[0];
      remLast.parentNode.removeChild(remLast);
      
      //määritetään table
      var playerElement = document.getElementById("removedPlayers");
      var tr = document.createElement("tr");
      //voidaan lisää id suoraan tr:n
      tr.id = id + "t";
      tr.setAttribute("name", count );
      tr.className += "inteam";
      
      

      //luodaan funktion kuuntelija     
      tr.addEventListener("click", function(){
        movePlayer(id,count);
      }, false);
      playerElement.appendChild(tr);

      //luodaan rowin jokanen kenttä
      var td1 = document.createElement("td");
      var td2 = document.createElement("td");
      var td3 = document.createElement("td");
      var td4 = document.createElement("td");

      td1.innerHTML = "<img style='width: 35px; vertical-align: middle;' src='images/default.png'>";
      td2.innerHTML = num;
      td3.innerHTML = first;
      td4.innerHTML = last;

      tr.appendChild(td1);
      tr.appendChild(td2);
      tr.appendChild(td3);
      tr.appendChild(td4);

    }

    function movePlayer(i,c) {
      var id = i;      
      var element = document.getElementById(id);   
      
      var move = document.getElementById(id+"t");
      move.parentNode.removeChild(move);
      
      var num = document.createElement("input");
      var value = move.querySelectorAll("td")[1].innerHTML;
      num.type = "hidden";
      num.name = "number["+c+"]"
      num.value = value;
      
      var first = document.createElement("input");
      var value = move.querySelectorAll("td")[2].innerHTML;
      first.type = "hidden";
      first.name = "firstName["+c+"]"
      first.value = value;
      
      var last = document.createElement("input");
      var value = move.querySelectorAll("td")[3].innerHTML;
      last.type = "hidden";
      last.name = "lastName["+c+"]"
      last.value = value;
      
      element.appendChild(num);
      element.appendChild(first);
      element.appendChild(last);
      
      document.getElementById(id).style = "display: grid";
    }
  </script>

  <div class="container">

    

    <div class="row">
<br>
      <div class="twelve columns" style="text-align: center;">
        <h4>
          <span>Lisää kotijoukkueen pelaajat</span>
        </h4>
      </div>
      </div>
      
    <div class="row">

      <div class="six columns">
        <h5>
          <span>Poistetut pelaajat</span>
        </h5>
         <table class="u-full-width" id="removedPlayers">

          </table>
      </div>

      <div class="six columns">
        <h5>
          <span>Tapahtuman pelaajat</span>
        </h5>
        <form name="form" action="functions.php" method="POST">
          <table class="u-full-width">
          <?php
          listHome();
          ?>
        </table>     

      </div>
    </div>

        <input type="hidden" name="eventName" value= "<?php echo $_SESSION['eventName'];?>"> 
        <input type="hidden" name="eventDate" value= "<?php echo $_SESSION['eventDate'];?>">     
  
    </div>


    <div class="row">
      <div class="twelve columns" style="text-align:center;position:absolute;padding-top:50px">
     <input class="button-primary" type="button" value="Takaisin" onclick="window.location='event1.php'"/>

        <input class="button-primary" type="submit" name="setHomeTeam" id="btnEvent2" value="Seuraava">
        </form>
      </div>
    </div>

  </div>


  <?php include('inc/footer.php'); ?>