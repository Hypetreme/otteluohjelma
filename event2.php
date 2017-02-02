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
      num.name = "number"+c+"";
      num.id = "number"+c+"";
      num.className = "numbers";
      num.value = value;

      var first = document.createElement("input");
      var value = move.querySelectorAll("td")[2].innerHTML;
      first.type = "hidden";
      first.name = "firstName"+c+"";
      first.id = "firstName"+c+"";
      first.className = "firstnames";
      first.value = value;

      var last = document.createElement("input");
      var value = move.querySelectorAll("td")[3].innerHTML;
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
    <div class="row" id="guide">
      <div class="twelve columns" style="text-align: center;">

      <a href="event1.php" style="text-decoration:none">
      <div id="section1" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
      <h3 style="color:white;padding-top:5px">1</h3>
      </div></a>

  <a href="#" style="text-decoration:none">
  <div id="section2" style="float:left;width: 60px; height: 60px; background: green; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">2</h3>
  </div></a>

  <div id="section3" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <input form="home" id="btnEvent3" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" value="3">
  </div>

  <div id="section4" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <input form="home" id="btnEvent4" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" value="4">
  </div>

  <div id="section5" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <input form="home" id="btnEvent5" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" value="5">
  </div>

  <div id="section6" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <input form="home" id="btnEvent6" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" value="6">
  </div>

  </div>
  </div>
  <div class="row">
    <div class="twelve columns">
      <span id="msg" class="msgError"></span>
    </div>
  </div>

    <div class="row">
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
<form name="form" id="home" action="functions.php" method="POST">
          <table class="u-full-width">
          <?php
          listHome();
          ?>
        </table>

      </div>
    </div>

        <div class="row">
          <div class="twelve columns" style="text-align:center;position:absolute;padding-top:50px">
         <input class="button-primary" type="button" value="Takaisin" onclick="window.location='event1.php'"/>

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
