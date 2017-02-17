$(function() {

    getStuff();

    // piilotetaan kaikki paitsi etusivu
    $(".players, .stats, .favourites, .share, .menu").hide();

    //kun linkkiä painaa ensin piilotetaan kaikki ja sitten näytetään valinta
    $('nav ul li a').on("click", function() {
        $(".home, .players, .stats, .favourites, .share").hide();
        var sL = $(this).attr("name");
        var active = $("." + sL);
        $(active).fadeIn();
    });

});

//Haetaan -tiedosto
function getStuff() {
  var url = encodeURI(window.location.href);
  var eventId = url.substring(url.indexOf('=')+1);
    var jsonIssue = {};
    $.ajax({
        url: "../../../files/overview_"+eventId+".json",
        async: "false",
        dataType: 'json',
        success: function(json){
          jsonIssue = json;
          doSomething(jsonIssue);
        }
    });
}

function doSomething(jsonIssue){
  var eventName = jsonIssue.eventinfo[0];
  var eventPlace = jsonIssue.eventinfo[1];
  var eventDate = jsonIssue.eventinfo[2];
  //var jsonText = JSON.stringify(jsonIssue.eventinfo[3]);
  //var matchText = JSON.parse(jsonText);
  if (jsonIssue.eventinfo[3] != "") {
  var jsonText = JSON.parse(jsonIssue.eventinfo[3]);
}
  var homeTeam = jsonIssue.teams.home[0];
  var visitorTeam = jsonIssue.teams.visitors[0];
  var ad1 = jsonIssue.ads.images[0];
  var ad2 = jsonIssue.ads.images[1];
  var adlink1 = jsonIssue.ads.links[0];
  var adlink2 = jsonIssue.ads.links[1];
  document.getElementById("gameName").innerHTML = "<h1>" + eventName + "</h1>";
  document.getElementById("gameDate").innerHTML = "<h1>" + eventDate + "</h1>";
  document.getElementById("gamePlace").innerHTML = "<h1>" + eventPlace + "</h1>";
  document.getElementById("homeTeam").innerHTML = "<h3 style='text-transform: uppercase'>" + homeTeam + "</h3>";
  document.getElementById("visitorTeam").innerHTML = "<h3 style='text-transform: uppercase'>" + visitorTeam + "</h3>";
  if (ad1 != null) {
  document.getElementById("gameAd1").innerHTML = "<a target='_blank' href=http://www."+ adlink1 +"><img src='../../../images/ads/event/" + ad1 + "'></a>";
}
  if (ad2 != null) {
  document.getElementById("gameAd2").innerHTML = "<a target='_blank' href=http://www."+ adlink2 +"><img src='../../../images/ads/event/" + ad2 + "'></a>";
}
  var number, first, last, li, node, i, len;
  //Tulostetaan kotijoukkueen pelaajat listaan
  for (i = 0, len = jsonIssue.teams.home.players.length; i < len; i++) {
      number = jsonIssue.teams.home.players[i].number;
      first = jsonIssue.teams.home.players[i].first;
      last = jsonIssue.teams.home.players[i].last;
      li = document.createElement("li");
      node = document.createTextNode(number + " " + first + " " + last);
      li.appendChild(node);
      document.getElementById("playerListHome").appendChild(li);
  }
  //Tulostetaan vierasjoukkueen pelaajat listaan
  for (i = 0, len = jsonIssue.teams.visitors.players.length; i < len; i++) {
      number = jsonIssue.teams.visitors.players[i].number;
      first = jsonIssue.teams.visitors.players[i].first;
      last = jsonIssue.teams.visitors.players[i].last;
      li = document.createElement("li");
      node = document.createTextNode(number + " " + first + " " + last);
      li.appendChild(node);
      document.getElementById("playerListVisitors").appendChild(li);
  }
  var editor = new Quill('#editor', {
    modules: {
      toolbar: null
    },
    readOnly: true,
    scrollingContainer: true,
    theme: 'snow'
  });
  editor.setContents(jsonText);
}
