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
