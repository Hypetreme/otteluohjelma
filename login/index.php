<?php
  session_start();
  include ('dbh.php');
  /*include ('unset.php');*/
  include('inc/header.php');
  include ('functions.php');
  getTeamName();
?>
<div class="header-bg"></div>
  <div class="container">
<span class="msg msg-fail" id="msg"></span>

    <div class="row">
      <div class="twelve columns">
        <div class="section-header">
        <h4>
          Etusivu
           </h4>
         </div>
           <?php if (isset($_SESSION['teamId'])) {
           echo '<form action="functions.php" method="POST" style="margin-bottom:0px;">';
           echo '<input class="button-primary" type="button" id="startEvent" name="startEvent" value="Luo Tapahtuma">';
       }
               echo '</form>';
           ?>
      </div>
    </div>

    <div class="shadow-box">
    <div class="row">
        <div class="six columns">
            <h5>
              Tulevat tapahtumat
            </h5>

                <?php
                listEvents('upcoming'); ?>
          </table>
       </div>
    </div>

    <div class="row">
      <div class="six columns">
            <h5>
              Viimeisimmät tapahtumat
            </h5>

                <?php listEvents('past'); ?>
          </table>
       </div>
    </div>
  </div>
    <?php
      include('inc/footer.php');
    ?>
<script>
$('#startEvent').click(function(event){
    event.preventDefault();

    var finish = $.post("functions.php", { startEvent: 'start' }, function(data) {
      if(data){
        console.log(data);
      }
      message(data);

    });
});
</script>
