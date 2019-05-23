function removePlayer(id, first, last, num) {
      //poistetaan n‰kyvist‰ valittu
      document.getElementById(id).style = "display: none";
      var element = document.getElementById(id);
      var count = element.querySelectorAll("input")[0].name.match(/\d+/)[0];
      var remNum = element.querySelectorAll("input")[0];
      remNum.parentNode.removeChild(remNum);
      var remFirst = element.querySelectorAll("input")[0];
      remFirst.parentNode.removeChild(remFirst);
      var remLast = element.querySelectorAll("input")[0];
      remLast.parentNode.removeChild(remLast);
       //m‰‰ritet‰‰n table
      var playerElement = document.getElementById("removedPlayers");
      var tr = document.createElement("tr");
      //voidaan lis‰‰ id suoraan tr:n
      tr.id = id + "t";
      tr.className += "removed";
       playerElement.appendChild(tr);
      //luodaan rowin jokanen kentt‰
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
      td2.innerHTML = '<img alt="pelaajan kuva" style="width: 35px; vertical-align: middle;" src="images/logos/joukkue.png">';
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
       document.getElementById(id).style = "display: table-row";
    }