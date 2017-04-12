<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id']) || !isset($_SESSION['event']['edit']) || !isset($_SESSION['teamId'])) {
header("Location: index.php");
}

include ('inc/header.php');
?>

<!-- Theme included stylesheets -->
<link href="css/quill.snow.css" rel="stylesheet">

<div class="container" style="padding-bottom:60px;">
  <div class="twelve columns" style="text-align:center" class="guide">

  <div class="section1">
  <p class="guide-header">Tapahtuman tiedot</p>
  <a href="event1.php" style="text-decoration:none">
  <i class="material-icons guide">filter_1</i>
  </a></div>
  <div class="line"></div>

  <div class="section2">
  <p class="guide-header">Kotipelaajat</p>
  <a href="event2.php" style="text-decoration:none">
  <i class="material-icons guide">filter_2</i>
  </a></div>
  <div class="line"></div>

  <div class="section3">
  <p class="guide-header">Vieraspelaajat</p>
  <a href="event3.php" style="text-decoration:none">
  <i class="material-icons guide">filter_3</i>
  </a></div>
  <div class="line" style="background-color:#2bc9c9"></div>

  <div class="section4" style="background-color:#2bc9c9">
  <p class="guide-header">Ennakkoteksti</p>
  <a href="#" style="text-decoration:none">
  <i class="material-icons guide">filter_4</i>
  </a></div>
  <div class="line" style="background-color:gray"></div>

  <div class="section5" style="background-color:gray">
  <p class="guide-header">Mainospaikat</p>
  <a id="btnEvent5" href="#" style="text-decoration:none">
  <i class="material-icons guide">filter_5</i>
  </a></div>
  <div class="line" style="background-color:gray"></div>

  <div class="section6" style="background-color:gray">
  <p class="guide-header">    Kilpailu</p>
  <a id="btnEvent6" href="#" style="text-decoration:none">
  <i class="material-icons guide">filter_6</i>
  </a></div>
  <div class="line" style="background-color:gray"></div>

  <div class="section7" style="background-color:gray">
  <p class="guide-header">Yhteenveto</p>
  <a id="btnEvent7" href="#" style="text-decoration:none">
  <i class="material-icons guide">filter_7</i>
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
</div>
<div class="twelve columns event-buttons">
  <button type="button" value="Takaisin" onclick="window.location='event3.php'"/>Takaisin</button>
  <input class="button-primary" type="submit" id="btnEvent5" value="Seuraava">
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

$('#btnEvent5,#btnEvent6, #btnEvent7').click(function(event){
  event.preventDefault();
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
if (isset($_SESSION['event']['matchText'])) {
echo '<script>';
echo 'quill.setContents ('.$_SESSION['event']['matchText'].');';
echo '</script>';
}
?>

  <?php include('inc/footer.php'); ?>
