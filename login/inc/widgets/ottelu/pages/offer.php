<div class="offer">
  <div class="container">
    <div class="row">
      <div class="twelve columns">
          <h1 class="title">Tarjoukset</h1>
          <div class="twelve columns" style="text-align:center">
          <div id="offerMaster" class="offer-master">

            <?php if ($json['offers'] != "") {
              $eventId = $_GET['eventId'];
              $eventId = substr($eventId, 0, strpos($eventId, "_"));
              echo $eventId;
              $ip = $_SERVER['REMOTE_ADDR'];
              $stmt = $conn->prepare("INSERT INTO used_offers (ip, event_id) VALUES (:ip, :eventid)");
              $stmt->bindParam(":ip", $ip);
              $stmt->bindParam(":eventid", $eventId);
              $stmt->execute();

              $stmt = $conn->prepare("SELECT * FROM used_offers WHERE ip = :ip AND event_id = :eventid");
              $stmt->bindParam(":ip", $ip);
              $stmt->bindParam(":eventid", $eventId);
              $stmt->execute();
              $row = $stmt->fetch();
              for ($i=0; $i < 10; $i++) {
              if ($row['offer'.($i+1)] == 0) {
              echo '<div id="offer'.($i+1).'"></div>';
              }
            }
            } ?>

          </div>
          </div>
      </div>
    </div>
  </div>
</div>
