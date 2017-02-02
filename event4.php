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
<link href="//cdn.quilljs.com/1.2.0/quill.snow.css" rel="stylesheet">

<div class="container">
  <div class="row" id="guide">
    <div class="twelve columns" style="text-align: center;">
    <a href="event1.php" style="text-decoration:none"><div id="section1" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
    <h3 style="color:white;padding-top:5px">1</h3>
  </div></a>

  <a href="event2.php" style="text-decoration:none"><div id="section2" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">2</h3>
  </div></a>

  <a href="event3.php" style="text-decoration:none"><div id="section3" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
  <h3 style="color:white;padding-top:5px">3</h3>
  </div></a>

<a href="#" style="text-decoration:none"><div id="section4" style="float:left;width: 60px; height: 60px; background: green; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<h3 style="color:white;padding-top:5px">4</h3>
</div></a>

<div id="section5" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<input form="form" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" name="setMatchText" value="5">
</div>

<div id="section6" style="float:left;width: 60px; height: 60px; background: gray; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px;">
<input form="form" type="submit" style="height:50px;border:0;color:white;padding-left:20px;padding-top:5px;font-size: 3.5rem; line-height:1.3;letter-spacing:-.1rem;font-weight: 300;" name ="setMatchTextGuide6" value ="6">
</div>

</div>
</div>

  <div class="row">
    <div class="twelve columns" style="text-align: center;">
      <h4>
        <span>Ennakot</span>
      </h4>
    </div>

  </div>
<form id="form" action="functions.php" method="POST">
  <div class="row">
    <div id="toolbar"></div>
    <div id="editor" class="twelve columns" style="min-height:200px"></div>
    <input name="matchText" type="hidden">
    <input name="plainMatchText" type="hidden">
    </div>

  <div class="row">
    <div class="twelve columns" style="text-align:center;position:absolute;padding-top:50px">
      <button class="button-primary" type="button" value="Takaisin" onclick="window.location='event3.php'"/>Takaisin</button>
      <input class="button-primary" type="submit" name="setMatchText" id="btnEvent4" value="Seuraava">
</form>
    </div>
  </div>

</div>

<!-- Main Quill library -->
<script src="//cdn.quilljs.com/1.2.0/quill.js"></script>

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


var form = document.querySelector('form');
form.onsubmit = function() {

  // Lisätään formin tiedot piilotettuun kenttään
  var matchText = document.querySelector('input[name=matchText]');
  matchText.value = JSON.stringify(quill.getContents());
  console.log(matchText.value);
  var plainMatchText = document.querySelector('input[name=plainMatchText]');
  plainMatchText.value = JSON.stringify(quill.getText());

  /*var obj = JSON.parse(matchText.value);
  console.log(obj);
  console.log("Submitted", $(form).serialize(), $(form).serializeArray());*/
};
var matchText = document.querySelector('input[name=matchText]');
</script>
<?php
if (isset($_SESSION['matchText'])) {
echo '<script>';
echo 'quill.setContents ('.$_SESSION['matchText'].');';
echo '</script>';
}
?>

  <?php include('inc/footer.php'); ?>
