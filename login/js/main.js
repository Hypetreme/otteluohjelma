/*$(function() {

    var moreNav = $('.more');
    var links = $(".more li");
    var moreNavBtn = $('.li-logo .open-nav');
    var changeTeam = $('.li-logo .change-team');
    var navJoukkueet = $('.nav-joukkueet');

    $(".navMoreBox").hide();

    $(document).on("click", function() {
        $(".navMoreBox").hide();
    });

    $(".navMore").on("click", function(e) {
        $(".navMoreBox").fadeIn("fast");
        e.stopPropagation();
        return false;
    });

    changeTeam.on("click", function() {
        navJoukkueet.css({
            "display": "inline-block",
            "position": "absolute",
            "top": "10px",
            "left": "0",
            "height": "42px",
            "border-top-left-radius": "0",
            "border-bottom-left-radius": "0"
        });
    });

    moreNavBtn.on("click", function(e) {

        $(this).animate({
            "left": "8px"
        }, 160, function() {

            links.css({
                "display": "inline-block",
                "opacity": "0",
                "margin-left": "-40px"
            });

            links.animate({
                "opacity": "1",
                "margin-left": "0px"
            }, 300, function() {

            });

            $(this).animate({
                "left": "4px"
            }, 160, function() {

            });

        });

        e.stopPropagation();
        return false;
    });

});*/

function datePicker() {
    // Kalenteri
    $(document).ready(function() {
        $(".calendar").focus(function() {
            $(".calendar").pickadate({
                today: 'Tänään',
                clear: '',
                close: '',
                monthsFull: ['Tammikuu', 'Helmikuu', 'Maaliskuu', 'Huhtikuu', 'Toukokuu', 'Kesäkuu', 'Heinäkuu', 'Elokuu', 'Syyskuu', 'Lokakuu', 'Marraskuu', 'Joulukuu'],
                weekdaysShort: ['Ma', 'Ti', 'Ke', 'To', 'Pe', 'La', 'Su'],
                format: 'dd.mm.yyyy',
                // An integer (positive/negative) sets it relative to today.
                min: -1,
                // `true` sets it to today. `false` removes any limits.
                max: false
            });
        });
    });

}

function message(data, selected) {
    // Ilmoitusten esitys
    var msg = document.getElementById("msg");
    var errorSymbol = '<i class="material-icons" style="margin-right:10px;vertical-align:-5px">warning</i>';
    var successSymbol = '<i class="material-icons" style="margin-right:10px;vertical-align:-5px">check</i>';
    $("#msg").fadeIn().css("display", "inline-block");

    if (data != "createLink") {
        setTimeout(function() {
            $("#msg").fadeOut();
        }, 3000);
    } else {
        $("#share").fadeIn().css("display", "inline-block");

    }

    // Login
    if (data == "pwdWrong") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Käyttäjätunnus tai salasana on väärin!";
    } else if (data == "notActivated") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Käyttäjätunnusta ei ole aktivoitu!";
    } else if (data == "expired") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Tilin käyttöaika on umpeutunut!";
    } else if (data == "loginSuccess") {
        msg.className = "msg-success";
        $("#msg").css("display", "none");
        window.location.href = "index.php";
    } else if (data == "adminLoginSuccess") {
        msg.className = "msg-success";
        $("#msg").css("display", "none");
        window.location.href = "control.php";
    }
    // Register
    else if (data == "duplicate") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Käyttäjänimi on jo olemassa!";
    } else if (data == "uidEmpty") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Et syöttänyt käyttäjänimeä!";
    } else if (data == "uidInvalid") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Käyttäjänimi ei saa sisältää välilyöntejä!";
    } else if (data == "pwdEmpty") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Et syöttänyt salasanaa!";
    } else if (data == "uidShort") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Käyttäjänimen on oltava vähintään 4 merkkiä pitkä!";
    } else if (data == "pwdShort") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Salasanan on oltava vähintään 4 merkkiä pitkä!";
    } else if (data == "pwdMismatch") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Salasanat eivät täsmää!";
    } else if (data == "emailInvalid") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Syötä sähköposti oikeassa muodossa!";
    } else if (data == "emailFail") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Sähköpostia ei voitu lähettää.";
    } else if (data == "emailSuccess") {
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Sähköposti lähetetty!";
    } else if (data == "regLevelInvalid") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Et valinnut tilin tasoa!";
    } else if (data == "regSportInvalid") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Et valinnut tilin urheilulajia!";
    } else if (data == "userSuccess") {
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Käyttäjä rekisteröity! Käy aktivoimassa tili linkistä jonka lähetimme sähköpostiisi.";
        $('#register').prop('disabled', true);
        setTimeout(function() {
            window.location.href = "index.php";
        }, 2800);
    } else if (data == "teamSuccess") {
        vex.closeAll();
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Joukkue lisätty! Käy aktivoimassa tili linkistä jonka lähetimme sähköpostiisi.";

    } else if (data == "teamMore") {
        vex.closeAll();
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Joukkue lisätty!";
    } else if (data == "teamClose") {
        $("#msg").css("display", "none");
    }
    // Players
    else if (data == "addPlayerEmpty") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Täytä kaikki pelaajan tiedot!";
    } else if (data == "addPlayerInvalidNumber") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Syötä pelinumero oikeassa muodossa!";
    } else if (data == "addPlayerSuccess") {
        vex.closeAll();
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Pelaaja lisätty!";
    } else if (data == "setPlayerSuccess") {
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Kokoonpanon tiedot muutettu!";
        setTimeout(function() {
            window.location.href = "team.php";
        }, 1800);
    } else if (data == "addPlayerMore") {
        vex.closeAll();
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Pelaaja lisätty!";
    } else if (data == "addPlayerClose") {
        $("#msg").css("display", "none");
    }
    // Advertisements, Pictures
    else if (data == "imgEmpty") {
        msg.innerHTML = errorSymbol + "Valitse ladattava kuva!";
    } else if (data == "imgInvalid") {
        msg.innerHTML = errorSymbol + "Kuva ei ole sallitussa muodossa!";
    } else if (data == "imgSize") {
        msg.innerHTML = errorSymbol + "Kuvan tiedostokoko on liian suuri!";
    } else if (data == "imgEmpty") {
        msg.innerHTML = errorSymbol + "Valitse ladattava kuva!";
    } else if (data == "imgError") {
        msg.innerHTML = errorSymbol + "Kuvaa ei voitu ladata.";
    } else if (data == "eventAdReserved") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Tämä paikka on jo asetettu!";
    } else if (data == "adReserved") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Seurasi on asettanut tämän paikan!";
    } else if (data == "adSuccess") {
        $('.image-editor').cropit('disable');
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Kuva tallennettu!";
        $('#setAd').prop('disabled', true);
        $('#removeAd').prop('disabled', true);
        setTimeout(function() {
            window.location.href = "ads.php";
        }, 1800);
    } else if (data == "offerSuccess") {
        $('.image-editor').cropit('disable');
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Tarjouksen tiedot tallennettu!";
        $('#setAd').prop('disabled', true);
        $('#removeAd').prop('disabled', true);
        setTimeout(function() {
            window.location.href = "ads.php";
        }, 1800);
    } else if (data == "eventAdSuccess") {
        $('.image-editor').cropit('disable');
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Kuva tallennettu!";
        $('#setAd').prop('disabled', true);
        $('#removeAd').prop('disabled', true);
        setTimeout(function() {
            window.location.href = "event5.php";
        }, 1800);
    } else if (data == "eventOfferSuccess") {
        $('.image-editor').cropit('disable');
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Tarjouksen tiedot tallennettu!";
        $('#setAd').prop('disabled', true);
        $('#removeAd').prop('disabled', true);
        setTimeout(function() {
            window.location.href = "event5.php";
        }, 1800);
    } else if (data == "logoSuccess") {
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Kuva tallennettu!!";
        $('#fileUpload').prop('disabled', true);
        setTimeout(function() {
            window.location.href = "settings.php";
        }, 1800);
    } else if (data == "visitorLogoSuccess") {
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Kuva tallennettu!!";
        $('#fileUpload').prop('disabled', true);
        setTimeout(function() {
            window.location.href = "event3.php";
        }, 1800);
    } else if (data == "imgFail") {
        msg.innerHTML = errorSymbol + "Kuvaa ei voitu tallentaa!";
    } else if (data == "adRemoveSuccess") {
        $("#msg").css("display", "none");
        msg.className = "msg-success";
        $('#setAd').prop('disabled', true);
        $('#removeAd').prop('disabled', true);
        window.location.href = "ads.php";
    } else if (data == "eventAdRemoveSuccess") {
        $("#msg").css("display", "none");
        msg.className = "msg-success";
        $('#setAd').prop('disabled', true);
        $('#removeAd').prop('disabled', true);
        window.location.href = "event5.php";
    } else if (data == "adRemoveFail") {
        msg.innerHTML = errorSymbol + "Ei poistettavaa kuvaa!";
    } else if (data == "adRemoveDenied") {
        msg.innerHTML = errorSymbol + "Kuvaa ei voitu poistaa!";
    }

    // User data
    else if (data == "teamPwdWrong") {
        msg.innerHTML = errorSymbol + "Salasana on väärin!";
    } else if (data == "teamEmpty") {
        msg.innerHTML = errorSymbol + "Syötä joukkueen nimi!";
    } else if (data == "nameChangeSuccess") {
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Joukkueen tiedot muutettu!";
        $('#removeTeam').prop('disabled', true);
        $('#setUser').prop('disabled', true);
        setTimeout(function() {
            window.location.href = "settings.php";
        }, 1800);
    } else if (data == "teamRemoveSuccess") {
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Joukkue poistettu!";
        $('#removeTeam').prop('disabled', true);
        $('#setUser').prop('disabled', true);
        setTimeout(function() {
            window.location.href = "settings.php";
        }, 1800);
    } else if (data == "teamRemoveSuccess") {
        msg.className = "msg-fail";
        msg.innerHTML = successSymbol + "Joukkueen poistaminen epäonnistui!";
    } else if (data == "userRemoveSuccess") {
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Käyttäjä poistettu!";
        $('.remove-btn').prop('disabled', true);
        setTimeout(function() {
            window.location.href = "control.php";
        }, 1800);
    } else if (data == "userRemoveFail") {
        msg.className = "msg-fail";
        msg.innerHTML = successSymbol + "Käyttäjän poistaminen epäonnistui!";
    } else if (data == "setDateSuccess") {
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Käyttäjien tiedot muutettu!";
        setTimeout(function() {
            window.location.href = "control.php";
        }, 1800);
    }
    // Event
    else if (data == "startEventFail") {
        msg.innerHTML = errorSymbol + "Lisää joukkueen <a style='color:white' href='team.php'>Kokoonpano</a> ennen tapahtuman luomista!";
    } else if (data == "startEventSuccess") {
        $("#msg").css("display", "none");
        window.location.href = "event1.php";
    } else if (data == "event1Empty") {
        msg.innerHTML = errorSymbol + "Täytä kaikki tapahtuman tiedot!";
    } else if (data == "event1Success") {
        $("#msg").css("display", "none");
        msg.className = "msg-success";

        if (selected == "btnEvent2") {
            window.location.href = "event2.php";
        } else if (selected == "btnEvent3") {
            window.location.href = "event3.php";
        } else if (selected == "btnEvent4") {
            window.location.href = "event4.php";
        } else if (selected == "btnEvent5") {
            window.location.href = "event5.php";
        } else if (selected == "btnEvent6") {
            window.location.href = "event6.php";
        } else if (selected == "btnEvent7") {
            window.location.href = "event_overview.php?c";
        }

    } else if (data == "event2Empty") {
        msg.innerHTML = errorSymbol + "Lisää vähintään yksi pelaaja!";
    } else if (data == "event2Success") {
        $("#msg").css("display", "none");
        msg.className = "msg-success";
        if (selected == "btnEvent3") {
            window.location.href = "event3.php";
        } else if (selected == "btnEvent4") {
            window.location.href = "event4.php";
        } else if (selected == "btnEvent5") {
            window.location.href = "event5.php";
        } else if (selected == "btnEvent6") {
            window.location.href = "event6.php";
        } else if (selected == "btnEvent7") {
            window.location.href = "event_overview.php?c";
        }
    } else if (data == "event3TeamEmpty") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Lisää vähintään yksi vierasjoukkueen pelaaja!";
    } else if (data == "event3NameEmpty") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Lisää vierasjoukkueen nimi!";
    } else if (data == "event3PlayerEmpty") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Täytä kaikki pelaajan tiedot!";
    } else if (data == "event3PlayerInvalidNumber") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Syötä pelinumero oikeassa muodossa!";
    } else if (data == "event3PlayerSuccess") {
        vex.closeAll();
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Pelaaja lisätty!";
    } else if (data == "event3More") {
        vex.closeAll();
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Pelaaja lisätty!";
    } else if (data == "event3Close") {
        $("#msg").css("display", "none");
    } else if (data == "event3Success") {
        vex.closeAll();
        $("#msg").css("display", "none");
        msg.className = "msg-success";
        window.location.href = "event4.php";
        if (selected == "btnEvent4") {
            window.location.href = "event4.php";
        } else if (selected == "btnEvent5") {
            window.location.href = "event5.php";
        } else if (selected == "btnEvent6") {
            window.location.href = "event6.php";
        } else if (selected == "btnEvent7") {
            window.location.href = "event_overview.php?c";
        }
    } else if (data == "event4Success") {
        if (selected == "btnEvent5") {
            window.location.href = "event5.php";
        } else if (selected == "btnEvent6") {
            window.location.href = "event6.php";
        } else if (selected == "btnEvent7") {
            window.location.href = "event_overview.php?c";
        }
    } else if (data == "adlink1Invalid") {
        msg.innerHTML = errorSymbol + "Syötä 1. mainoksen linkki oikeassa muodossa!";
    } else if (data == "adlink2Invalid") {
        msg.innerHTML = errorSymbol + "Syötä 2. mainoksen linkki oikeassa muodossa!";
    } else if (data == "adlink3Invalid") {
        msg.innerHTML = errorSymbol + "Syötä 3. mainoksen linkki oikeassa muodossa!";
    } else if (data == "adlink4Invalid") {
        msg.innerHTML = errorSymbol + "Syötä 4. mainoksen linkki oikeassa muodossa!";
    } else if (data == "event6Empty") {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Syötä kilpailun nimi!";
    } else if (data == "event6Success") {
        $("#msg").css("display", "none");
        window.location.href = "event_overview.php?c";
    } else if (data == "eventLinkSuccess") {
        $("#msg").css("display", "none");
        msg.className = "msg-success";
        $('#setAd').prop('disabled', true);
        $('#removeAd').prop('disabled', true);
        window.location.href = "event_overview.php?c";
    } else if (data == "eventFail") {
        msg.innerHTML = errorSymbol + "Tapahtuman tallennus epäonnistui!";
    } else if (data == "copySuccess") {
        msg.className = "msg-success";
        msg.innerHTML = successSymbol + "Linkki kopioitu leikepöydälle!";
    } else if (data == "copyFail") {
        msg.className = "msg-fail";
        msg.innerHTML = console.error();
        Symbol + "Linkkiä ei voitu kopioida!";
    } else if (data == "createLink") {
        $('#createEvent').prop('disabled', true);
        msg.className = "msg-success";
        $("#msg").css("display", "none");

        // QR-koodin luominen
        $("#cover").fadeIn().css("display", "initial");
        var url = window.location.href;
        url = url.substring(0, url.indexOf('event'));
        console.log(url);
        var qrcode = new QRCode("qrCode", {
            text: url + 'inc/widgets/ottelu/index.php?eventId=' + selected,
            width: 150,
            height: 150,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        // Jakolinkit
        document.getElementById('facebook').children[0].setAttribute('data-href', url + 'inc/widgets/ottelu/index.php?eventId=' + selected);
        document.getElementById('facebook').children[0].children[0].href = 'https://www.facebook.com/sharer/sharer.php?u=' + url + 'inc/widgets/ottelu/index.php?eventId=' + selected + '&amp;src=sdkpreparse';
        document.getElementById('twitter').children[0].setAttribute('href', 'https://twitter.com/intent/tweet?text=Tässä ottelumme käsiohjelma suoraan mobiliisi:' + url + 'inc/widgets/ottelu/index.php?eventId=' + selected + '&hashtags=otteluohjelma');
        document.getElementById('link').children[0].setAttribute('data-clipboard-text', url + 'inc/widgets/ottelu/index.php?eventId=' + selected);
        document.getElementById('email').children[0].setAttribute('href', 'mailto:?subject=Otteluohjelma&body=Tässä ottelumme käsiohjelma suoraan mobiliisi:' + url + 'inc/widgets/ottelu/index.php?eventId=' + selected);
    } else {
        msg.className = "msg-fail";
        msg.innerHTML = errorSymbol + "Tapahtui virhe!";
    }
}
