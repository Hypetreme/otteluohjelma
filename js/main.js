$(function(){

  var moreNav = $('.more');
  var links = $(".more li");
  var moreNavBtn = $('.liLogo .openNav');
  var changeTeam = $('.liLogo .changeTeam');
  var navJoukkueet = $('.nav-joukkueet');

  $(".navMoreBox").hide();

  $(document).on("click", function(){
    $(".navMoreBox").hide();
  });

  $(".navMore").on("click", function(e){
    $(".navMoreBox").fadeIn("fast");
    e.stopPropagation();
    return false;
  });

  changeTeam.on("click", function(){
      navJoukkueet.css({
        "display" : "inline-block",
        "position" : "absolute",
        "top" : "10px",
        "left" : "0",
        "height" : "42px",
        "border-top-left-radius" : "0",
        "border-bottom-left-radius" : "0"
      });
  });

  moreNavBtn.on("click", function(e){

    $(this).animate({
      "left":"8px"
    }, 160, function(){

      links.css({
        "display": "inline-block",
        "opacity": "0",
        "margin-left": "-40px"
      });

      links.animate({
        "opacity": "1",
        "margin-left": "0px"
      }, 300, function(){

      });

      $(this).animate({
        "left": "4px"
      }, 160, function(){

      });

    });

    e.stopPropagation();
    return false;
  });

});

function datePicker(){
  $(document).ready(function() {
    $("#eventDate").focus(function () {
      $("#eventDate").pickadate({
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
function message(data,selected) {
  var msg = document.getElementById("msg");
  var errorSymbol = '<i class="material-icons" style="margin-right:10px;vertical-align:-5px">warning</i>';
  var successSymbol = '<i class="material-icons" style="margin-right:10px;vertical-align:-5px">check</i>';
  $("#msg").fadeIn().css("display", "inline-block");

  if (data != "createLink") {
  setTimeout(function () {
   $("#msg").fadeOut();
}, 3000); } else {

}

    // Login
  if (data == "pwdWrong"){
    msg.innerHTML=errorSymbol+"Käyttäjätunnus tai salasana on väärin!";
  } else if (data == "notActivated"){
    msg.innerHTML=errorSymbol+"Käyttäjätunnusta ei ole aktivoitu!";
  } else if (data == "loginSuccess"){
    msg.className="msgSuccess";
    $("#msg").css("display", "none");
   window.location.href = "profile.php";
    }
   // Register
     else if (data == "duplicate"){
     msg.innerHTML=errorSymbol+"Käyttäjänimi on jo olemassa!";
   } else if (data == "uidEmpty"){
     msg.innerHTML=errorSymbol+"Et syöttänyt käyttäjänimeä!";
   } else if (data == "uidInvalid"){
     msg.innerHTML=errorSymbol+"Käyttäjänimi ei saa sisältää välilyöntejä!";
   } else if (data == "pwdEmpty"){
     msg.innerHTML=errorSymbol+"Et syöttänyt salasanaa!";
   } else if (data == "uidShort"){
     msg.innerHTML=errorSymbol+"Käyttäjänimen on oltava vähintään 4 merkkiä pitkä!";
   } else if (data == "pwdShort"){
     msg.innerHTML=errorSymbol+"Salasanan on oltava vähintään 4 merkkiä pitkä!";
   } else if (data == "pwdMismatch"){
     msg.innerHTML=errorSymbol+"Salasanat eivät täsmää!";
   } else if (data == "emailInvalid"){
     msg.innerHTML=errorSymbol+"Syötä sähköposti oikeassa muodossa!";
   } else if (data == "emailFail"){
     msg.innerHTML=errorSymbol+"Käyttäjä rekisteröity! Sähköpostia ei voitu lähettää.";
   } else if (data == "userSuccess"){
     msg.className="msgSuccess";
     msg.innerHTML=successSymbol+"Käyttäjä rekisteröity! Käy aktivoimassa tili linkistä jonka lähetimme sähköpostiisi.";
     setTimeout(function () {
    window.location.href = "index.php";
 }, 4000);
   } else if (data == "teamSuccess"){
     msg.className="msgSuccess";
     msg.innerHTML=successSymbol+"Käyttäjä rekisteröity! Käy aktivoimassa tili linkistä jonka lähetimme sähköpostiisi.";
     setTimeout(function () {
    window.location.href = "teams.php";
 }, 4000);
   }
  // Players
  else if (data == "savePlayerEmpty"){
msg.innerHTML=errorSymbol+"Täytä kaikki pelaajan tiedot!";
  } else if (data == "savePlayerSuccess"){
    msg.className="msgSuccess";
    $("#msg").css("display", "none");
    window.location.href = "team.php";
  }
  // Advertisements
  else if (data == "imgEmpty"){
  msg.innerHTML=errorSymbol+"Valitse ladattava kuva!";
} else if (data == "imgInvalid"){
  msg.innerHTML=errorSymbol+"Kuva ei ole sallitussa muodossa!";
} else if (data == "imgSize"){
  msg.innerHTML=errorSymbol+"Kuvan tiedostokoko on liian suuri!";
} else if (data == "imgEmpty"){
  msg.innerHTML=errorSymbol+"Valitse ladattava kuva!";
} else if (data == "imgError"){
  msg.innerHTML=errorSymbol+"Kuvaa ei voitu ladata.";
}
    else if (data == "adSuccess"){
    $('.image-editor').cropit('disable');
     msg.className="msgSuccess";
     msg.innerHTML=successSymbol+"Kuvan lataus onnistui!";
     setTimeout(function () {
    window.location.href = "ads.php";
 }, 2000);
} else if (data == "eventAdSuccess"){
$('.image-editor').cropit('disable');
msg.className="msgSuccess";
msg.innerHTML=successSymbol+"Kuvan lataus onnistui!";
setTimeout(function () {
window.location.href = "event5.php";
}, 2000);
}
else if (data == "logoSuccess"){
   msg.className="msgSuccess";
   msg.innerHTML=successSymbol+"Kuvan lataus onnistui!";
   setTimeout(function () {
   window.location.href = "settings.php";
   }, 2000);
   }

 // User data
 else if (data == "teamPwdWrong"){
 msg.innerHTML=errorSymbol+"Salasana on väärin!";
 }
 else if (data == "teamEmpty"){
 msg.innerHTML=errorSymbol+"Syötä joukkueen nimi!";
 } else if (data == "nameChangeSuccess"){
 msg.className="msgSuccess";
 msg.innerHTML=successSymbol+"Joukkueen nimi muutettu!";
 setTimeout(function () {
window.location.href = "settings.php";
}, 2000);
} else if (data == "teamRemoveSuccess"){
msg.className="msgSuccess";
msg.innerHTML=successSymbol+"Joukkue poistettu!";
setTimeout(function () {
window.location.href = "settings.php";
}, 2000);
}
 // Event
 else if (data == "event1Empty"){
 msg.innerHTML=errorSymbol+"Täytä kaikki tapahtuman tiedot!";
 } else if (data == "event1Success"){
   msg.className="msgSuccess";
   $("#msg").css("display", "none");

if (selected == "btnEvent2") {
 window.location.href = "event2.php";
 } else if (selected == "btnEvent3") {
   window.location.href = "event3.php";
 } else if (selected == "btnEvent4") {
   window.location.href = "event4.php";
 } else if (selected == "btnEvent5") {
   window.location.href = "event5.php";
 } else if (selected == "btnEvent6") {
   window.location.href = "event_overview.php?c";
 }

 } else if (data == "event2Empty"){
 msg.innerHTML=errorSymbol+"Lisää vähintään yksi pelaaja!";
 } else if (data == "event2Success"){
   msg.className="msgSuccess";
   $("#msg").css("display", "none");
   if (selected == "btnEvent3") {
    window.location.href = "event3.php";
    } else if (selected == "btnEvent4") {
      window.location.href = "event4.php";
    } else if (selected == "btnEvent5") {
      window.location.href = "event5.php";
    } else if (selected == "btnEvent6") {
      window.location.href = "event_overview.php?c";
    }
   }
else if (data == "event3TeamEmpty"){
 msg.innerHTML=errorSymbol+"Lisää vähintään yksi vierasjoukkueen pelaaja!";
   } else if (data == "event3NameEmpty"){
 msg.innerHTML=errorSymbol+"Lisää vierasjoukkueen nimi!";
   } else if (data == "event3PlayerEmpty"){
 msg.innerHTML=errorSymbol+"Täytä kaikki pelaajan tiedot!";
   } else if (data == "event3PlayerSuccess"){
     msg.className="msgSuccess";
     $("#msg").css("display", "none");
     window.location.href = "event3.php";
   } else if (data == "event3Success"){
   msg.className="msgSuccess";
   $("#msg").css("display", "none");
 if (selected == "btnEvent4") {
    window.location.href = "event4.php";
   } else if (selected == "btnEvent5") {
    window.location.href = "event5.php";
  } else if (selected == "btnEvent6") {
    window.location.href = "event_overview.php?c";
  }
} else if (data == "adlink1Invalid"){
msg.innerHTML=errorSymbol+"Syötä 1. mainoksen linkki oikeassa muodossa!";
} else if (data == "adlink2Invalid"){
 msg.innerHTML=errorSymbol+"Syötä 2. mainoksen linkki oikeassa muodossa!";
} else if (data == "adlink3Invalid"){
  msg.innerHTML=errorSymbol+"Syötä 3. mainoksen linkki oikeassa muodossa!";
} else if (data == "adlink4Invalid"){
   msg.innerHTML=errorSymbol+"Syötä 4. mainoksen linkki oikeassa muodossa!";
} else if (data == "eventLinkSuccess"){
  msg.className="msgSuccess";
  $("#msg").css("display", "none");
 window.location.href = "event_overview.php?c";
}
 else if (data == "eventFail") {
  msg.innerHTML=errorSymbol+"Tapahtuman tallennus epäonnistui!";
 }
 else if (data == "createLink") {
  msg.className="msgSuccess";
  var url = "<a style='color:white' target='_blank' href='inc/widgets/ottelu/index.php?eventId="+selected+"'>Linkki katsojanäkymään</a>";
  msg.innerHTML=successSymbol+"Tapahtuma tallennettu!<br>"+url;
  document.getElementById('createEvent').style="display:none";
 }
}
