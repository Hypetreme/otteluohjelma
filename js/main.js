$(function(){
  $(".navMoreBox").hide();

  $(document).on("click", function(){
    $(".navMoreBox").hide();
  });

  $(".navMore").on("click", function(e){
    $(".navMoreBox").fadeIn("fast");
    e.stopPropagation();
    return false;
  });

});
