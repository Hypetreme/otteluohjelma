<?php
  session_start();
  include('dbh.php');
  if (!isset($_SESSION['id'])) {
      header("Location: index.php");
  }
  include('functions.php');
  include('inc/header.php');
    unset($_SESSION['event']['homeName']);
    unset($_SESSION['event']['visitorName']);
    unset($_SESSION['event']['id']);
    unset($_SESSION['event']['name']);
    unset($_SESSION['event']['place']);
    unset($_SESSION['event']['date']);
    unset($_SESSION['event']['home']);
    unset($_SESSION['event']['visitors']);
    unset($_SESSION['event']['saved']);
    unset($_SESSION['event']['matchText']);
    unset($_SESSION['event']['plainMatchText']);
    unset($_SESSION['event']['popupText']);
    unset($_SESSION['event']['ads']);
    unset($_SESSION['event']['adlinks']);
    unset($_SESSION['event']['edit']);
    unset($_SESSION['event']['old']);
?>

  <div class="container">
    <span class="msg msg-fail" id="msg"></span>
    <div class="row">
      <div class="twelve columns">
        <h4>Kilpailut<h4>
          </div>
<?php
listGuess();
?>
</div>
<div id="populate"></div>
</table>

</div>

  <?php include('inc/footer.php'); ?>
<script>
  $("#answers").on("change",function() {

      var eventid = $('#answers').val();

      var finish = $.post("functions.php", { populateGuess: 'list', eventId: eventid}, function(data) {
        if(data){
          $("#populate").html(data);
        }
      });
  });
</script>
