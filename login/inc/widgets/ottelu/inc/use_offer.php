<?php
	include('dbh.php');

  $ip = $_SERVER['REMOTE_ADDR'];
	$number = $_POST['usedOffer'];
	$eventId = $_POST['id'];
  $stmt = $conn->prepare("UPDATE used_offers SET offer".$number." = 1 WHERE ip = :ipaddress AND event_id = :eventid");
  $stmt->bindParam(":ipaddress", $ip);
	$stmt->bindParam(":eventid", $eventId);
  $stmt->execute();
?>
