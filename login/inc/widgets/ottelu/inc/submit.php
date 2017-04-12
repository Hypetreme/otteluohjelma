<?php
	include('dbh.php');

	$answer = $_POST['guessAnswer'];
	$first = $_POST['firstName'];
	$last = $_POST['lastName'];
	$email = $_POST['email'];
  $eventId = $_POST['id'];

  $stmt = $conn->prepare("INSERT INTO guess (event_id,answer,firstName,lastName,email,ip) VALUES (:eventid, :answer, :firstname, :lastname, :email, :ipaddress)");
  $stmt->bindParam(":answer", $answer);
  $stmt->bindParam(":eventid", $eventId);
  $stmt->bindParam(":firstname", $first);
  $stmt->bindParam(":lastname", $last);
  $stmt->bindParam(":email", $email);
  $stmt->bindParam(":ipaddress", $_SERVER['REMOTE_ADDR']);
  $stmt->execute();
?>
