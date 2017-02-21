<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
header("Location: index.php");
}
if (!isset($_SESSION['editEvent'])) {
header("Location: profile.php");
}

include ('inc/header.php');
?>

<!-- Theme included stylesheets -->
<link href="css/quill.snow.css" rel="stylesheet">

<div class="container">
  <div class="twelve columns" style="text-align:center" id="guide">

  <div id="section1">
  <p class="guideHeader">Tapahtuman tiedot</p>
  <a href="event1.php" style="text-decoration:none">
  <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_1</i>
  </a></div>
  <div class="line"></div>

  <div id="section2">
  <p class="guideHeader">Kotipelaajat</p>
  <a href="event2.php" style="text-decoration:none">
  <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_2</i>
  </a></div>
  <div class="line"></div>

  <div id="section3">
  <p class="guideHeader">Vieraspelaajat</p>
  <a href="event3.php" style="text-decoration:none">
  <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_3</i>
  </a></div>
  <div class="line" style="background-color:#2bc9c9"></div>

  <div id="section4" style="background-color:#2bc9c9">
  <p class="guideHeader">Ennakkoteksti</p>
  <a href="#" style="text-decoration:none">
  <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_4</i>
  </a></div>
  <div class="line" style="background-color:gray"></div>

  <div id="section5" style="background-color:gray">
  <p class="guideHeader">Mainospaikat</p>
  <a id="btnEvent5" href="#" style="text-decoration:none">
  <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_5</i>
  </a></div>
  <div class="line" style="background-color:gray"></div>

  <div id="section6" style="background-color:gray">
  <p class="guideHeader">Yhteenveto</p>
  <a id="btnEvent6" href="#" style="text-decoration:none">
  <i style="position:relative;bottom:15px;font-size:35px;color:white;" class="material-icons">filter_6</i>
  </a></div>
</div>


  <div class="row">
  </div>
  <div class="row" style="border: solid 1px #D1D1D1;padding:15px;margin-top:20px">
  <div class="row">
    <div id="toolbar"></div>
    <div id="editor" class="twelve columns" style="min-height:253px"></div>
    </div>
  </div>
  <div class="row">
    <div class="twelve columns" style="text-align:center;position:absolute;padding-top:50px">
      <button type="button" value="Takaisin" onclick="window.location='event3.php'"/>Takaisin</button>
      <input class="button-primary" type="submit" name="setMatchText" id="btnEvent5" value="Seuraava">
    </div>
  </div>
</div>

<!-- Main Quill library -->
<script src="js/quill.min.js"></script>

<script>

var quill = new Quill('#editor', {
  formats: ['bold','italic','underline','link', 'blockquote', 'image', 'video','header'],
  modules: {
    toolbar: [
      ['bold', 'italic','underline'],
      ['link', 'blockquote', 'image', 'video'],
      [{ 'header': 1 }, { 'header': 2 }],
    ]
  },
  placeholder: 'Lisää ennakkoteksti...',
  theme: 'snow',
});

$('#btnEvent5,#btnEvent6').click(function(event){
  event.preventDefault(); // stop the form from submitting
  var selected = ($(this).attr("id"));
  var text = JSON.stringify(quill.getContents());
  var plainText = JSON.stringify(quill.getText());

  var finish = $.post("functions.php", { setMatchText: "matchtext", matchText: text, plainMatchText: plainText }, function(data) {
    if(data){
      console.log(data);
    }
    message(data,selected);

  });
});
</script>
<?php
if (isset($_SESSION['matchText'])) {
echo '<script>';
echo 'quill.setContents ('.$_SESSION['matchText'].');';
echo '</script>';
}
?>

  <?php include('inc/footer.php'); ?>
