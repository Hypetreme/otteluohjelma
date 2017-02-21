<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
header("Location: index.php");
}
if (!isset($_SESSION['editEvent'])) {
header("Location: profile.php");
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
      //tr.setAttribute("name", count );
      tr.className += "removed";

      playerElement.appendChild(tr);
      //luodaan rowin jokanen kenttä
      var td1 = document.createElement("td");
      var td2 = document.createElement("td");
      var td3 = document.createElement("td");
      var td4 = document.createElement("td");
      var td5 = document.createElement("td");

      td1.innerHTML = '<i id="plus" style="font-size:25px;cursor: pointer;color:green" class="material-icons">add</i>';
      //luodaan funktion kuuntelija
      td1.addEventListener("click", function(){
        movePlayer(id,count);
      }, false);
      td2.innerHTML = '<img style="width: 35px; vertical-align: middle;" src="images/default.png">';
      td3.innerHTML = num;
      td4.innerHTML = first;
      td5.innerHTML = last;

      tr.appendChild(td1);
      tr.appendChild(td2);
      tr.appendChild(td3);
      tr.appendChild(td4);
      tr.appendChild(td5);

    }

    function movePlayer(i,c) {
      var id = i;
      var element = document.getElementById(id);

      var move = document.getElementById(id+"t");
      move.parentNode.removeChild(move);


      var num = document.createElement("input");
      var value = move.querySelectorAll("td")[2].innerHTML;
      num.type = "hidden";
      num.name = "number"+c+"";
      num.id = "number"+c+"";
      num.className = "numbers";
      num.value = value;

      var first = document.createElement("input");
      var value = move.querySelectorAll("td")[3].innerHTML;
      first.type = "hidden";
      first.name = "firstName"+c+"";
      first.id = "firstName"+c+"";
      first.className = "firstnames";
      first.value = value;

      var last = document.createElement("input");
      var value = move.querySelectorAll("td")[4].innerHTML;
      last.type = "hidden";
      last.name = "lastName"+c+"";
      last.id = "lastName"+c+"";
      last.className = "lastnames";
      last.value = value;

      element.appendChild(num);
      element.appendChild(first);
      element.appendChild(last);

      document.getElementById(id).style = "display: grid";
    }
  </script>

  <div class="container">
    <div class="twelve columns" style="text-align:center" id="guide">
    <div id="section1">
    <p class="guideHeader">Tapahtuman tiedot</p>
    <a href="event1.php" style="text-decoration:none">
    <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_1</i>
    </a></div>
    <div class="line" style="background-color:#2bc9c9"></div>

    <div id="section2" style="background-color:#2bc9c9">
    <p class="guideHeader">Kotipelaajat</p>
    <a href="event2.php" style="text-decoration:none">
    <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_2</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div id="section3" style="background-color:gray">
    <p class="guideHeader">Vieraspelaajat</p>
    <a id="btnEvent3" href="#" style="text-decoration:none">
    <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_3</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div id="section4" style="background-color:gray">
    <p class="guideHeader">Ennakkoteksti</p>
    <a id="btnEvent4" href="#" style="text-decoration:none">
    <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_4</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div id="section5" style="background-color:gray">
    <p class="guideHeader">Mainospaikat</p>
    <a id="btnEvent5" href="#" style="text-decoration:none">
    <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_5</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div id="section6" style="background-color:gray">
    <p class="guideHeader">Yhteenveto</p>
    <a id="btnEvent6" href="#" style="text-decoration:none">
    <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_6</i>
    </a></div>
    </div>

  <div class="row">
    <div class="twelve columns">
      <span id="msg" class="msgError"></span>
    </div>
  </div>

    <div class="row" style="border: solid 1px #D1D1D1;padding:15px;margin-top:20px">

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
<form action="functions.php" method="POST">
          <table class="u-full-width">
          <?php
          listHome();
          ?>
        </table>

      </div>
    </div>

        <div class="row">
          <div class="twelve columns" style="text-align:center;position:absolute;padding-top:50px">
         <input type="button" value="Takaisin" onclick="window.location='event1.php'"/>

            <input class="button-primary" type="submit" name="setHomeTeam" id="btnEvent3" value="Seuraava">
            </form>
          </div>
        </div>
      </div>
    <script>
    $('#btnEvent3, #btnEvent4, #btnEvent5, #btnEvent6').click(function(event){
        var selected = ($(this).attr("id"));
        event.preventDefault(); // stop the form from submitting
        var numbers = $('input:hidden.numbers').serializeArray();
        var firstnames = $('input:hidden.firstnames').serializeArray();
        var lastnames = $('input:hidden.lastnames').serializeArray();
        var first = $('#firstName').val();
        var last = $('#lastName').val();
        var num = $('#number').val();
      //console.log(players);
        var finish = $.post("functions.php", { setHomeTeam: 'hometeam', homeNumbers: numbers, homeFirstNames: firstnames, homeLastNames: lastnames }, function(data) {
          if(data){
            console.log(data);
          }
          message(data,selected);

        });
    });
    </script>

  <?php include('inc/footer.php'); ?>
