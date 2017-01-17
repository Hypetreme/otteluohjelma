<?php
  session_start();
  include ('dbh.php');
  if (isset($_SESSION['teamId'])) {
  $teamid = $_SESSION['teamId'];
}
  if (!isset($_SESSION['id'])) {
    header("Location: index.php");
  }
  if (isset($_SESSION['eventId'])) {
    unset($_SESSION['homeName']);
    unset($_SESSION['visitorName']);
    unset($_SESSION['eventId']);
    unset($_SESSION['eventName']);
    unset($_SESSION['eventPlace']);
    unset($_SESSION['eventDate']);
    unset($_SESSION['home']);
    unset($_SESSION['visitors']);
    unset($_SESSION['saved']);
  }
  include ('functions.php');
  include ('inc/header.php');
?>

  <div class="container">
    <div class="row">
      <div class="twelve columns" style="text-align:center">
        <h4>
          Mainokset
        </h4>
      </div>

    </div>
    <div class="row">
      <div class="twelve columns" style="text-align:center">
      <div id="adSelector" style="position:relative;margin-left:auto ;margin-right:auto;width:375px;height:667px;border-style:solid;">
        <div onclick="addAd(this);" id="1" style="border-style:solid;height:50px">AD 1</div>
        <div onclick="addAd(this);" id="2" style="border-style:solid;height:50px">AD 2</div>
        <div onclick="addAd(this);" id="3" style="position:absolute;bottom:7%;border-style:solid;width:100%;height:50px;">AD 3</div>
        <div onclick="addAd(this);" id="4" style="position:absolute;bottom:0;border-style:solid;width:100%;height:50px;">AD 4</div>
      </div>
      </div>
    </div>

    <div class="row">
      <div class="twelve columns" style="text-align:center">
        <h5 id="adHeader">Mainoskuva</h5>
        <span id="upload" style="visibility:hidden">
        <table class="u-full-width">
        <form action="functions.php" method="post" enctype="multipart/form-data">
          <tbody>
            <tr>
              <td><input type="file" name="file" id="file"></td>
              <td><input id="submitAd" type="submit" value="Tallenna Mainos" name="adUpload"></td>
            </tr>
          </tbody>
        </form>
        </table>
      </span>
      </div>
    </div>
  </div>
  <script>

  $("#1, #2, #3, #4").on("mouseenter focus click", function(){
    if(!$(this).hasClass('active')){
    $(this).css({"background-color":"gray"});
  }
  });

  $("#1, #2, #3, #4").on("mouseleave", function(){
     if(!$(this).hasClass('active')){
    $(this).css({"background-color":"transparent"});
  }
  });



  function addAd(element) {
    $(function(){
      if($(element).hasClass('active')){
        $("#1").removeClass('active')
        $("#2").removeClass('active')
        $("#3").removeClass('active')
        $("#4").removeClass('active')
        $(element).removeClass('active')
    }
     else {
        $(element).addClass('active')
      $("#1").css({"background-color":"transparent"});
      $("#2").css({"background-color":"transparent"});
      $("#3").css({"background-color":"transparent"});
      $("#4").css({"background-color":"transparent"});
      $(element).css({"background-color":"red"});
      }
    });
document.getElementById('adHeader').innerHTML="Mainoskuva "+element.id;
document.getElementById('upload').style="visibility:visible";
document.getElementById('submitAd').name="adUpload "+element.id;
}

  </script>


  <?php
    include ('inc/footer.php');
  ?>
