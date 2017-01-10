$(function(){
    // piilotetaan kaikki paitsi etusivu
    $(".players, .stats, .favourites, .share").hide();
  
    //kun linkkiä painaa ensin piilotetaan kaikki ja sitten näytetään valinta
    $('nav ul li a').on("click", function(){
      $(".home, .players, .stats, .favourites, .share").hide();
      var sL = $(this).attr("name"); 
      var active = $("."+sL);
      $(active).fadeIn();
    });
  
});



/*window.setInterval(function(){
  // stuff I want to run every 5 seconds
   }, 5000);*/

//Haetaan JSON -tiedosto
$.getJSON("../../../files/overview27.json", function(json) {
  
  console.log(json);
 //Asetetaan tapahtuman tiedot
  var eventName = json.eventinfo[0];
  var eventPlace = json.eventinfo[1];
  var eventDate = json.eventinfo[2];
  var homeTeam = json.teams.home[0];
  var visitorTeam = json.teams.visitors[0];
  document.getElementById("gameName").innerHTML="<h1>"+eventName+"</h1>";
  document.getElementById("gameDate").innerHTML="<h1>"+eventDate+"</h1>";
  document.getElementById("gamePlace").innerHTML="<h1>"+eventPlace+"</h1>";
  document.getElementById("homeTeam").innerHTML="<h3 style='text-transform: uppercase'>"+homeTeam+"</h3>";
  document.getElementById("visitorTeam").innerHTML="<h3 style='text-transform: uppercase'>"+visitorTeam+"</h3>";
  
  var number, first, last, li, node, i, len;
  //Tulostetaan kotijoukkueen pelaajat listaan
  for (i = 0, len = json.teams.home.players.length; i < len; i++) {
  number = json.teams.home.players[i].number;  
  first = json.teams.home.players[i].first;
  last = json.teams.home.players[i].last;
    
  li = document.createElement("li");
  node = document.createTextNode(number+" "+first+" " +last);  
  li.appendChild(node);    
  document.getElementById("playerListHome").appendChild(li);
  }
  //Tulostetaan vierasjoukkueen pelaajat listaan
  for (i = 0, len = json.teams.home.players.length; i < len; i++) {
  number = json.teams.visitors.players[i].number;  
  first = json.teams.visitors.players[i].first;
  last = json.teams.visitors.players[i].last;
    
  li = document.createElement("li");
  node = document.createTextNode(number+" "+first+" " +last);  
  li.appendChild(node);    
  document.getElementById("playerListVisitors").appendChild(li);
  }
});

