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
        $("#contentWrapper").show();
    }
}

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

    getStuff();

    // Piilotetaan kaikki paitsi etusivu
    $(".players, .info, .guess, .sponsors, .menu, .offer").hide();
    $("#home").addClass("active");
    $("#home").children().css("background-color", "#dc1313");
    $("#home").children().css("color", "#fff");
    // Kun linkkiä painaa ensin piilotetaan kaikki ja sitten näytetään valinta
    $('.on').on("click ", function() {
    if (this.id != "home") {
    $(".content-wrapper").css("margin-bottom","80px");
  } else {
    $(".content-wrapper").css("margin-bottom","0px");
  }
        if (!$(this).hasClass("off") && !$(this).hasClass("active")) {
            $(".home, .players, .info, .guess, .sponsors, .offer").hide();
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
                        $("#chartMaster").css("display", "none");
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
    $("#contentWrapper").show();
    var eventPlace = overview.eventinfo[1];
    var eventDate = overview.eventinfo[2];
    if (typeof overview.guess != "undefined" && overview.eventinfo[3] != "") {
        var jsonText = JSON.parse(overview.eventinfo[3]);
    } else {
        $("#info").children().css("background-color", "#6e6e6e");
        document.getElementById("info").className = "off";
    }

    if (typeof overview.guess != "undefined" && overview.guess[0] != "") {
        var guessName = overview.guess[0];
        var guessType = overview.guess[1];
        document.getElementById("guessName").innerHTML = "<h3>"+guessName+"</h3>";
    } else {
        $("#guess").children().css("background-color", "#6e6e6e");
        document.getElementById("guess").className = "off";
    }


    var homeTeam = overview.teams.home[0];
    var homeLogo = overview.teams.home[1];
    var visitorTeam = overview.teams.visitors[0];
    var visitorLogo = overview.teams.visitors[1];

    // Sponsorit
    for (i = 0; i < 25; i++) {

        eval("ad" + (i + 1) + " = overview.ads.images[i]");
        if (overview.ads.links[i] != null) {
            eval("adlink" + (i + 1) + " = \"<a target='_blank' href=http://www.\" + overview.ads.links[i] + \">\"");
        } else {
            eval("adlink" + (i + 1) + " = \"\"");
        }
        if (i > 4) {
            if (overview.ads.images[i] != null) {

                var hasContentSponsors = 1;
                document.getElementById("sponsorLogos").innerHTML += eval("adlink" + (i + 1)) + "<img alt='sponsori " + eval("ad" + (i + 1)) + "' class='advertisement' style='padding:5px'src='../../../images/ads/event/" + eval("ad" + (i + 1)) + "'></a>";
            }
        }
    }

    // Tarjoukset
    for (i = 0; i <= 10; i++) {
        if (overview.offers.texts[i] != null && overview.offers.prices[i] != null) {
          var hasContentOffers = 1;
        if (overview.offers.images[i] != null) {
        eval("offerimage" + (i + 1) + " = \"<img class='advertisement' alt='Tarjous' src='../../../images/ads/event/\" + overview.offers.images[i] + \"'>\"");
      } else {
        eval("offerimage" + (i + 1) + " = \"\"");
      }
        eval("offertext" + (i + 1) + " = overview.offers.texts[i]");
        eval("offerprice" + (i + 1) + " = overview.offers.prices[i]");
        if (typeof document.getElementById("offer"+(i+1)) != "undefined" && document.getElementById("offer"+(i+1))) {
        document.getElementById("offer"+(i+1)).innerHTML +=
        '<div class="offer-box"><div style="float:right;width:50%"><p id="offerText" class="offer-text">'+eval("offertext" + (i + 1))+'</p><hr></hr><p class="offer-price" id="offerPrice" >'+eval("offerprice" + (i + 1))+'</p></div><div class="offer-image" id="offerImage">'+eval("offerimage" + (i + 1))+'</div></div><input type="submit" id="'+ (i + 1) +'" class="offer-close" value="Käytä">';
      }
    }

    }
    $('#1,#2,#3,#4,#5,#6,#7,#8,#9,#10').click(function(event) {
            event.preventDefault();
            $("#offer"+this.id).fadeOut();
            var url = encodeURI(window.location.href);
            var url = s = url.substring(0, url.indexOf('_'));
            var eventId = url.substring(url.indexOf('=') + 1);
            var offer = this.id;
            var finish = $.post("inc/use_offer.php", {
                useOffer: "offer",
                usedOffer: offer,
                id: eventId
            }, function(data) {
                if (data) {
                    console.log(data);
                }
            });
    });
    if (overview.ads.images[4] != null) {
        $("#popup").show();
        $("#cover").show();

        document.getElementById("popupAd").innerHTML = adlink5 + "<img alt='mainos 5' src='../../../images/ads/event/" + ad5 + "'></a>";
        document.getElementById("popupText").innerHTML = overview.ads.popup[0];
    }
    if (hasContentSponsors != 1) {
        $("#sponsors").children().css("background-color", "#6e6e6e");
        document.getElementById("sponsors").className = "off";
    }
    if (hasContentOffers != 1) {
        $("#offer").children().css("background-color", "#6e6e6e");
        document.getElementById("offer").className = "off";
    }
    document.getElementById("gameDate").innerHTML = '<h3>' + eventDate + '</h3>';
    document.getElementById("gamePlace").innerHTML = '<h3>' + eventPlace + '</h3>';
    document.getElementById("homeName").innerHTML = "<h3>" + homeTeam + "</h3>";
    document.getElementById("homeTeam").innerHTML = "<h3>" + homeTeam + "</h3>";
    document.getElementById("homeLogo").innerHTML = "<img src='../../../"+ homeLogo +"'>";
    document.getElementById("playersHomeLogo").innerHTML = "<img src='../../../"+ homeLogo +"'>";
    if (visitorLogo != null) {
    document.getElementById("visitorLogo").innerHTML = "<img src='../../../"+ visitorLogo +"'>";
    document.getElementById("playersVisitorLogo").innerHTML = "<img style='margin-top:20px' src='../../../"+ visitorLogo +"'>";
  }
    document.getElementById("visitorName").innerHTML = "<h3>" + visitorTeam + "</h3>";
    document.getElementById("visitorTeam").innerHTML = "<h3>" + visitorTeam + "</h3>";
    if (ad1 != null) {
        document.getElementById("gameAd1").innerHTML = adlink1 + "<img class='advertisement' alt='mainos 1' src='../../../images/ads/event/" + ad1 + "'></a>";
    }
    if (ad2 != null) {
        document.getElementById("gameAd2").innerHTML = adlink2 + "<img class='advertisement' alt='mainos 2' src='../../../images/ads/event/" + ad2 + "'></a>";
    }

    var number, first, last, node, i, len, p;
    // Tulostetaan kotijoukkueen pelaajat listaan
    if (guessType == 3 && document.getElementById("guessOptions") !== null) {
    document.getElementById("guessOptions").innerHTML += "<option disabled>--Kotijoukkueen pelaajat--</option>";
    }
    for (i = 0, len = overview.teams.home.players.length; i < len; i++) {
        number = overview.teams.home.players[i].number;
        first = overview.teams.home.players[i].first;
        last = overview.teams.home.players[i].last;
        p = document.createElement("p");
        node = document.createTextNode(number + " " + first + " " + last);
        p.appendChild(node);
        document.getElementById("listHome").appendChild(p);
        if (guessType == 1 || guessType == 3 && document.getElementById("guessOptions") !== null) {
            document.getElementById("guessOptions").innerHTML += "<option value='" + first + " " + last + "'>" + first + " " + last + "</option>";
        }
    }
    // Tulostetaan vierasjoukkueen pelaajat listaan
    if (guessType == 3 && document.getElementById("guessOptions") !== null) {
    document.getElementById("guessOptions").innerHTML += "<option disabled>--Vierasjoukkueen pelaajat--</option>";
    }
    for (i = 0, len = overview.teams.visitors.players.length; i < len; i++) {
        number = overview.teams.visitors.players[i].number;
        first = overview.teams.visitors.players[i].first;
        last = overview.teams.visitors.players[i].last;
        p = document.createElement("p");
        node = document.createTextNode(number + " " + first + " " + last);
        p.appendChild(node);
        document.getElementById("listVisitors").appendChild(p);
        if (guessType == 2 || guessType == 3 && document.getElementById("guessOptions") !== null) {
            document.getElementById("guessOptions").innerHTML += "<option value='" + first + " " + last + "'>" + first + " " + last + "</option>";
        }
    }

    if (guessType == 4) {
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

    // Asetetaan jakolinkit
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
