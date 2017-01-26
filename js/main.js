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
function message(data) {
  var msg = document.getElementById("msg");
  var errorSymbol = '<i class="material-icons" style="margin-right:10px;vertical-align:-5px">warning</i>';
  var successSymbol = '<i class="material-icons" style="margin-right:10px;vertical-align:-5px">check</i>';

    // Login
    if (data == "pwdWrong"){
    msg.style="visibility:initial";
    msg.innerHTML=errorSymbol+"Käyttäjätunnus tai salasana on väärin!";
  } else if (data == "notActivated"){
    msg.style="visibility:initial";
    msg.innerHTML=errorSymbol+"Käyttäjätunnusta ei ole aktivoitu!";
  } else if (data == "loginSuccess"){
    msg.style="visibility:initial";
    msg.className="msgSuccess";
    msg.innerHTML=successSymbol+"Salasana oikein!";
    setTimeout(function () {
   window.location.href = "profile.php";
}, 1500);
    }
   // Register
   else if (data == "duplicate"){
   msg.style="visibility:initial";
   msg.innerHTML=errorSymbol+"Käyttäjänimi on jo olemassa!";
   } else if (data == "uidEmpty"){
     msg.style="visibility:initial";
     msg.innerHTML=errorSymbol+"Et syöttänyt käyttäjänimeä!";
   } else if (data == "pwdEmpty"){
     msg.style="visibility:initial";
     msg.innerHTML=errorSymbol+"Et syöttänyt salasanaa!";
   } else if (data == "uidShort"){
     msg.style="visibility:initial";
     msg.innerHTML=errorSymbol+"Käyttäjänimen on oltava vähintään 4 merkkiä pitkä!";
   } else if (data == "pwdShort"){
     msg.style="visibility:initial";
     msg.innerHTML=errorSymbol+"Salasanan on oltava vähintään 4 merkkiä pitkä!";
   } else if (data == "emailInvalid"){
     msg.style="visibility:initial";
     msg.innerHTML=errorSymbol+"Syötä sähköposti oikeassa muodossa!";
   } else if (data == "emailFail"){
     msg.style="visibility:initial";
     msg.innerHTML=errorSymbol+"Käyttäjä rekisteröity! Sähköpostia ei voitu lähettää.";
   } else if (data == "userSuccess"){
     msg.style="visibility:initial";
     msg.className="msgSuccess";
     msg.innerHTML=successSymbol+"Käyttäjä rekisteröity! Käy aktivoimassa tili linkistä jonka lähetimme sähköpostiisi.";
     setTimeout(function () {
    window.location.href = "index.php";
 }, 4000);
   }
}
