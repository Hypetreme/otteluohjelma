//Haetaan -tiedosto
function getStuff() {
    var url = encodeURI(window.location.href);
    var eventId = url.substring(url.indexOf('=') + 1);
    var overview = {};
    if (url.includes("eventId")) {
        $.ajax({
            url: "../../../files/overview_" + eventId + ".json",
            async: "false",
            dataType: 'json',
            success: function(json) {
                overview = json;
                doSomething(overview);
            },
            error: function(jqXHR, exception) {
                console.log(jqXHR);
                window.location.href = "index.php";
            }
        });
    } else {
        $("#content-wrapper").show();
    }
}

//Korkeusmuuttujat
var verticalFull = screen.height;
var horizontalFull = screen.height + 418;
var vertical = screen.height - 80;
var horizontal = screen.height + 202;
var isFirefox = typeof InstallTrigger !== 'undefined';
if (isFirefox) {
    vertical = screen.height - 73;
}

/*function toggleFullScreen() {
  var doc = window.document;
  var docEl = doc.documentElement;
  var pic = document.getElementById("fullscreen").children[0];
  var requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
  var cancelFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;

  if(!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
    //Kokonäyttö
    $('#fullscreen').css('background-color', '#00b776');
    if (screen.width >= 640) {
    document.getElementById("content-wrapper").style="height:"+horizontalFull+"px";
    document.getElementById("up").style="height:39.2%";
    console.log('vaaka');
  } else {
    document.getElementById("content-wrapper").style="height:"+verticalFull+"px";
    document.getElementById("up").style="height:91.2%";
    console.log('vaaka');
  }
    document.getElementsByTagName("ul")[2].style="padding-top:7px";
    requestFullScreen.call(docEl);
    $(pic).attr("class","fa fa-window-restore");
  }
  else {
   //Ei kokonäyttö
    $('#fullscreen').css('background-color', '#1EAEDB');
    if (screen.width >= 640) {
    document.getElementById("content-wrapper").style="height:"+horizontal+"px";
    document.getElementById("up").style="height:40%";
  } else {
    document.getElementById("content-wrapper").style="height:"+vertical+"px";
    document.getElementById("up").style="height:90%";
  }
    document.getElementsByTagName("ul")[2].style="padding-top:7px";
    cancelFullScreen.call(doc);
    $(pic).attr("class","fa fa-window-maximize");
  }
}*/

$(function() {


    $('#form').submit(function(event) {
      event.preventDefault();
      if ($('#first').val() != "" && $('#last').val() != "" && $('#email').val() != "") {
        $("#form").fadeOut();
        setTimeout(function() {
            $("#thanks").fadeIn();
        }, 1000);
        var url = encodeURI(window.location.href);
        var url = s = url.substring(0, url.indexOf('_'));
        var eventId = url.substring(url.indexOf('=') + 1);
        if ($("#guessOptions2").hasClass("on")) {
        var answer = $('#guessOptions').val() + ":" + $('#guessOptions2').val();
      } else {
        var answer = $('#guessOptions').val();
      }
        var first = $('#first').val();
        var last = $('#last').val();
        var emailAdress = $('#email').val();
        var finish = $.post("inc/submit.php", {
            submitGuess: "guess",
            guessAnswer: answer,
            firstName: first,
            lastName: last,
            email: emailAdress,
            id: eventId
        }, function(data) {
            if (data) {
                console.log(data);
            }


        });
      }
    });

    document.addEventListener('gesturestart', function(e) {
        e.preventDefault();
    });

    $('#close').click(function(event) {
        $("#cover").fadeOut();
        $("#popup").fadeOut();

    });

    //Asetetaan sivun korkeus
    if (window.innerHeight > window.innerWidth) {
        //Pystytaso
        document.getElementById("content-wrapper").style = "height:" + vertical + "px";
    } else {
        //Vaakataso
        document.getElementById("content-wrapper").style = "height:" + horizontal + "px";
    }
    /*var fullscreen = document.getElementById("fullscreen");
    fullscreen.addEventListener("click", function() {
        toggleFullScreen();
    }, false);*/
    getStuff();

    // piilotetaan kaikki paitsi etusivu
    $(".players, .info, .guess, .sponsors, .menu").hide();
    //kun linkkiä painaa ensin piilotetaan kaikki ja sitten näytetään valinta
    $('.on').on("click ", function() {
        if (!$(this).hasClass("off") && !$(this).hasClass("active")) {
            $(".home, .players, .info, .guess, .sponsors").hide();
            var sL = $(this).attr("name");
            var active = $("." + sL);
            $(active).fadeIn();
            $(".on").removeClass("active");
            $(this).addClass("active");
            $(".on").children().css("background-color", "#e2e2e2");
            $(".on").children().css("color", "black");
            $(this.children[0]).css("background-color", "#dc1313");
            $(this.children[0]).css("color", "#fff");
            if (this.id == "guess") {
                if (!$(this).hasClass("started")) {
                    $(this).addClass("started");

                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    if (draw == true) {
                    google.charts.setOnLoadCallback(drawRightY);
                  } else {
                    $("#chart-master").css("display","none");
                  }
                }
            }
        }
    });
    $(".on").hover(function() {
        if (!$(this).hasClass("off")) {
            if (!$(this).hasClass("active")) {
                $(this.children[0]).css("background-color", "#dc1313");
                $(this.children[0]).css("color", "#fff");
            }
        }
    }, function() {
        if (!$(this).hasClass("off")) {
            if (!$(this).hasClass("active")) {
                $(this.children[0]).css("background-color", "#e2e2e2");
                $(this.children[0]).css("color", "black");
            }
        }
    })
});

function doSomething(overview) {
    $("#content-wrapper").show();
    var eventName = overview.eventinfo[0];
    var eventPlace = overview.eventinfo[1];
    var eventDate = overview.eventinfo[2];
    if (overview.eventinfo[3] != "") {
        var jsonText = JSON.parse(overview.eventinfo[3]);
    } else {
        $("#info").children().css("background-color", "#6e6e6e");
        document.getElementById("info").className = "off";
    }

    if (overview.guess[0] != "") {
        var guessName = overview.guess[0];
        var guessType = overview.guess[1];
        document.getElementById("guess-name").innerHTML = guessName;
    } else {
        $("#guess").children().css("background-color", "#6e6e6e");
        document.getElementById("guess").className = "off";
    }

    var homeTeam = overview.teams.home[0];
    var visitorTeam = overview.teams.visitors[0];

    //Sponsorit
    for (i = 0; i < 25; i++) {

        eval("ad" + (i + 1) + " = overview.ads.images[i]");
        if (overview.ads.links[i] != null) {
        eval("adlink" + (i + 1) + " = \"<a target='_blank' href=http://www.\" + overview.ads.links[i] + \">\"");
      } else {
        eval("adlink" + (i + 1) + " = \"\"");
      }
        if (i > 4) {
            if (overview.ads.images[i] != null) {

                var hasContent = 1;
                document.getElementById("sponsor-logos").innerHTML += eval("adlink" + (i + 1)) +"<img alt='sponsori " + eval("ad" + (i + 1)) + "' style='padding:5px'src='../../../images/ads/event/" + eval("ad" + (i + 1)) + "'></a>";
            }
        }
    }
    if (overview.ads.images[4] != null) {
        $("#popup").show();
        $("#cover").show();

        document.getElementById("popup-ad").innerHTML = adlink5 + "<img alt='mainos 5' src='../../../images/ads/event/" + ad5 + "'></a>";
        document.getElementById("popup-text").innerHTML = overview.ads.popup[0];
    }
    if (hasContent != 1) {
        $("#sponsors").children().css("background-color", "#6e6e6e");
        document.getElementById("sponsors").className = "off";
    }
    document.getElementById("game-name").innerHTML = '<h2>' + eventName + '</h2>';
    document.getElementById("game-date").innerHTML = '<h2>' + eventDate + '</h2>';
    document.getElementById("game-place").innerHTML = '<h2>' + eventPlace + '</h2>';
    document.getElementById("homeTeam").innerHTML = "<h3 style='text-transform: uppercase'>" + homeTeam + "</h3>";
    document.getElementById("visitorTeam").innerHTML = "<h3 style='text-transform: uppercase'>" + visitorTeam + "</h3>";
    if (ad1 != null) {
        document.getElementById("gameAd1").innerHTML = adlink1 + "<img alt='mainos 1' src='../../../images/ads/event/" + ad1 + "'></a>";
    }
    if (ad2 != null) {
        document.getElementById("gameAd2").innerHTML = adlink2 + "<img alt='mainos 2' src='../../../images/ads/event/" + ad2 + "'></a>";
    }

    var number, first, last, li, node, i, len;
    //Tulostetaan kotijoukkueen pelaajat listaan
    for (i = 0, len = overview.teams.home.players.length; i < len; i++) {
        number = overview.teams.home.players[i].number;
        first = overview.teams.home.players[i].first;
        last = overview.teams.home.players[i].last;
        li = document.createElement("li");
        node = document.createTextNode(number + " " + first + " " + last);
        li.appendChild(node);
        document.getElementById("list-home").appendChild(li);
        if (guessType == 1 && document.getElementById("guessOptions") !== null) {
        document.getElementById("guessOptions").innerHTML += "<option value='" + first + " " + last + "'>" + first + " " + last + "</option>";
} else if (guessType == 2) {
        $("#guessOptions2").css("display","initial");
        $("#guessOptions2").addClass("on");
  for (var i = 0; i < 60; i++) {
        if (i<10) {
        i = "0"+i;
        }
        document.getElementById("guessOptions").innerHTML += "<option value='"+i+"'>"+i+"</option>";
        document.getElementById("guessOptions2").innerHTML += "<option value='"+i+"'>"+i+"</option>";
      }
}
    }
    //Tulostetaan vierasjoukkueen pelaajat listaan
    for (i = 0, len = overview.teams.visitors.players.length; i < len; i++) {
        number = overview.teams.visitors.players[i].number;
        first = overview.teams.visitors.players[i].first;
        last = overview.teams.visitors.players[i].last;
        li = document.createElement("li");
        node = document.createTextNode(number + " " + first + " " + last);
        li.appendChild(node);
        document.getElementById("list-visitors").appendChild(li);
    }

    //Asetetaan jakolinkit
    var url = window.location.href;
    document.getElementById('facebook').children[0].setAttribute('data-href', url);
    document.getElementById('facebook').children[0].children[0].href = 'https://www.facebook.com/sharer/sharer.php?u=' + url + '&amp;src=sdkpreparse';
    //<div class="fb-share-button" data-href="http://localhost/otteluohjelma/inc/widgets/ottelu/index.php?eventId=18_6f4922f45568161a8cdf4ad2299f6d23" data-layout="button_count" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Flocalhost%2Fotteluohjelma%2Finc%2Fwidgets%2Fottelu%2Findex.php%3FeventId%3D18_6f4922f45568161a8cdf4ad2299f6d23&amp;src=sdkpreparse">Jaa</a></div>
    document.getElementById('twitter').children[0].setAttribute('href', 'https://twitter.com/intent/tweet?text=Tässä ottelumme käsiohjelma suoraan mobiliisi:' + url);

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
