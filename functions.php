<?php

function register()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$uid = $_POST['uid'];
	$email = $_POST['email'];
	$pwd = $_POST['pwd'];
	$uid = strip_tags($uid);
	$uid = mysqli_real_escape_string($conn, $uid);
	$email = strip_tags($email);
	$email = mysqli_real_escape_string($conn, $email);
	$pwd = strip_tags($pwd);
	$pwd = mysqli_real_escape_string($conn, $pwd);
	$check_uid = "SELECT * FROM user WHERE uid = '$uid'";
	$result_uid = mysqli_query($conn, $check_uid);
	if (mysqli_num_rows($result_uid) >= 1) {
		echo '<script type="text/javascript">';
		echo 'alert("Käyttäjänimi on jo olemassa!");';
		echo 'document.location.href = "register.php";';
		echo '</script>';
	}
	else
	if (empty($uid)) {
		echo '<script type="text/javascript">';
		echo 'alert("Et syöttänyt käyttäjänimeä!");';
		echo 'document.location.href = "register.php";';
		echo '</script>';
	}
	else
	if (strlen($uid) < 4) {
		echo '<script type="text/javascript">';
		echo 'alert("Käyttäjänimen on oltava vähintään 4 merkkiä pitkä!");';
		echo 'document.location.href = "register.php";';
		echo '</script>';
	}
	else
	if (empty($pwd)) {
		echo '<script type="text/javascript">';
		echo 'alert("Et syöttänyt salasanaa!");';
		echo 'document.location.href = "register.php";';
		echo '</script>';
	}
	else
	if (strlen($pwd) < 4) {
		echo '<script type="text/javascript">';
		echo 'alert("Salasanan on oltava vähintään 4 merkkiä pitkä!");';
		echo 'document.location.href = "register.php";';
		echo '</script>';
	}
	else
	if (preg_match('/\s/', $uid)) {
		echo '<script type="text/javascript">';
		echo 'alert("Käyttäjänimi tai salasana ei saa sisältää välilyöntejä!");';
		echo 'document.location.href = "register.php";';
		echo '</script>';
	}
	else
	if (preg_match('/\s/', $pwd)) {
		echo '<script type="text/javascript">';
		echo 'alert("Käyttäjänimi tai salasana ei saa sisältää välilyöntejä!");';
		echo 'document.location.href = "register.php";';
		echo '</script>';
	}
	else
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo '<script type="text/javascript">';
		echo 'alert("Syötä sähköpostiosoite oikeassa muodossa!");';
		echo 'document.location.href = "register.php";';
		echo '</script>';
	}
	else {

		// Luodaan seuratili

		$hash = md5(rand(0, 1000));
		$hash = strip_tags($hash);
		$hash = mysqli_real_escape_string($conn, $hash);
		$sql = "INSERT INTO user (uid,pwd,type,email,hash) VALUES ('$uid','$pwd','0','$email','$hash')";
		$result = mysqli_query($conn, $sql);
		$sql = "SELECT id FROM user WHERE uid='$uid'";
		$result = mysqli_query($conn, $sql);
		if ($row = mysqli_fetch_assoc($result)) {
			$id = $row['id'];
		}
      require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'localhost';
    $mail->SMTPAuth = true;
    $mail->Username = 'info@appstudios.fi';
    $mail->Password = 'Kupari-6102';
    $mail->SMTPSecure = '';
    $mail->SMTPAutoTLS = false;
    $mail->Port = 587;
    $mail->setFrom("vahvistus@otteluohjelma.fi");
    $mail->AddAddress("hypetremethewanderer@gmail.com");
    $mail->WordWrap = 50;
    $mail->CharSet = 'UTF-8';
    $mail->IsHTML(true);
    $mail->Subject = "Asia";
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

		echo '<script type="text/javascript">';
		echo 'alert("Käyttäjä rekisteröity!");';
		//echo 'document.location.href = "index.php";';
		echo '</script>';
	}

	// Sähköpostin lähetys

	/*$to = $email; // Send email to our user
	$subject = 'Signup | Verification'; // Give the email a subject
	$message = '

Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

------------------------
Username: ' . $name . '
Password: ' . $password . '
------------------------

Please click this link to activate your account:
http://ottelu-jannekarppinen96814.codeanyapp.com/verify.php?email=' . $email . '&hash=' . $hash . '

'; // Our message above including the link
	$headers = 'From:noreply@otteluohjelma.fi' . "\r\n"; // Set from headers
	mail($to, $subject, $message, $headers); // Send our email*/

}

function logIn()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$uid = $_POST['uid'];
	$pwd = $_POST['pwd'];
	$uid = strip_tags($uid);
	$uid = mysqli_real_escape_string($conn, $uid);
	$pwd = strip_tags($pwd);
	$pwd = mysqli_real_escape_string($conn, $pwd);
	$sql = "SELECT * FROM user WHERE uid='$uid' AND pwd='$pwd'";
	$result = mysqli_query($conn, $sql);
	if (!$row = mysqli_fetch_assoc($result)) {
		echo '<script type="text/javascript">';
		echo 'alert("Käyttäjätunnus tai salasana on väärin!");';
		echo 'document.location.href = "index.php";';
		echo '</script>';
	}
	else {
		$sql = "SELECT * FROM user WHERE uid='$uid'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$type = $row['type'];
		$id = $row['id'];
		$_SESSION['id'] = $id;
		$_SESSION['uid'] = $uid;
		$_SESSION['type'] = $type;
		if ($type == 0) {
			header("Location: teams.php");
		}
		else {
			$sql = "SELECT * FROM user WHERE id='$id'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);
			$_SESSION['teamId'] = $row['team_id'];
			$teamId = $_SESSION['teamId'];
			$sql = "SELECT * FROM team WHERE id='$teamId'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);
			$_SESSION['teamName'] = $row['name'];
			header("Location: profile.php");
		}
	}
}

function logOut()
{
	if(!isset($_SESSION)) {
	session_start(); }
	session_unset();
	session_destroy();
	header("Location:index.php");
	exit();
}

function savePlayer()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$teamId = $_SESSION["teamId"];
	$id = $_SESSION["id"];
	$names = array(
		'first' => array() ,
		'last' => array() ,
		'number' => array()
	);
	$i = 0;
	foreach($_POST as $key => $value) {
		if (strpos($key, 'first') !== false) {
			$names['first'][$i] = $value;
			$i++;
		}
	}

	$i = 0;
	foreach($_POST as $key => $value) {
		if (strpos($key, 'last') !== false) {
			$names['last'][$i] = $value;
			$i++;
		}
	}

	$i = 0;
	foreach($_POST as $key => $value) {
		if (strpos($key, 'number') !== false) {
			$names['number'][$i] = $value;
			$i++;
		}
	}

	$i = 0;
	foreach($names['first'] as $value) {
		$firstName = $names['first'][$i];
		$lastName = $names['last'][$i];
		$number = $names['number'][$i];
		$firstName = strip_tags($firstName);
		$firstName = mysqli_real_escape_string($conn, $firstName);
		$lastName = strip_tags($lastName);
		$lastName = mysqli_real_escape_string($conn, $lastName);
		$number = strip_tags($number);
		$number = mysqli_real_escape_string($conn, $number);
		if (!empty($firstName) && !empty($lastName)) {
			$sql = "INSERT INTO player (user_id,team_id,firstName,lastName,number) VALUES ('$id','$teamId','$firstName','$lastName','$number')";
			$result = mysqli_query($conn, $sql);
		}

		$i++;
	}

	header("Location: team.php?teamId=$teamId");
}

function saveTeam()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$id = $_SESSION["id"];
	$teams = array(
		'name' => array()
	);
	$i = 0;
	foreach($_POST as $key => $value) {
		$teams['name'][$i] = $value;
		$i++;
	}

	$i = 0;
	$count = count($teams['name']);
	foreach($teams['name'] as $value) {
		if (--$count <= 0) {
			break;
		}

		$team = $teams['name'][$i];
		$team = strip_tags($team);
		$team = mysqli_real_escape_string($conn, $team);
		if (!empty($team)) {
			$sql = "INSERT INTO team (name,user_id) VALUES ('$team','$id')";
			$result = mysqli_query($conn, $sql);
		}
	}

	$sql = "SELECT * FROM team ORDER BY ID DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result)) {
		$teamId = $row['id'];
		echo $eventId;
	}

	// Luodaan joukkuetili

	$sql = "INSERT INTO user (uid,pwd,type,team_id) VALUES ('$team','salasana','1','$teamId')";
	$result = mysqli_query($conn, $sql);
	header("Location: teams.php");
}

function updateTeam()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$teamId = $_SESSION['teamId'];
	$id = $_SESSION["id"];
	$teamName = $_POST['teamName'];
	print_r($_POST);
	$names = array(
		'first' => array() ,
		'last' => array() ,
		'number' => array() ,
		'id' => array()
	);
	$i = 0;
	foreach($_POST as $key => $value) {
		if (strpos($key, 'first') !== false) {
			$names['first'][$i] = $value;
			$i++;
		}
	}

	$i = 0;
	foreach($_POST as $key => $value) {
		if (strpos($key, 'last') !== false) {
			$names['last'][$i] = $value;
			$i++;
		}
	}

	$i = 0;
	foreach($_POST as $key => $value) {
		if (strpos($key, 'number') !== false) {
			$names['number'][$i] = $value;
			$i++;
		}
	}

	$i = 0;
	foreach($_POST as $key => $value) {
		if (strpos($key, 'id') !== false) {
			$names['id'][$i] = $value;
			$i++;
		}
	}

	$i = 0;
	foreach($names['first'] as $value) {
		$firstName = $names['first'][$i];
		$lastName = $names['last'][$i];
		$number = $names['number'][$i];
		$nameId = $names['id'][$i];
		$firstName = strip_tags($firstName);
		$firstName = mysqli_real_escape_string($conn, $firstName);
		$lastName = strip_tags($lastName);
		$lastName = mysqli_real_escape_string($conn, $lastName);
		$number = strip_tags($number);
		$number = mysqli_real_escape_string($conn, $number);
		echo $firstName . " " . $lastName . " " . $nameId . "<br />";
		if (!empty($firstName) && !empty($lastName)) {
			$sql = "UPDATE player SET firstName='$firstName',lastName='$lastName',number='$number' WHERE id ='$nameId'";
			$result = mysqli_query($conn, $sql);
			$i++;
		}
	}

	$sql = "UPDATE team SET name='$teamName' WHERE id='$teamId'";
	$result = mysqli_query($conn, $sql);
	$_SESSION['teamName'] = $teamName;
	header("Location: team.php?teamId=$teamId");
}

function removePlayer()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$teamId = $_SESSION['teamId'];
	$removeId = $_GET['removePlayer'];
	$sql = "DELETE FROM player WHERE id='$removeId'";
	mysqli_query($conn, $sql);
	header("Location: team.php?teamId=$teamId");
}

function removeEvent()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$id = $_SESSION['id'];
	$removeId = $_GET['removeEvent'];
	$sql = "DELETE FROM event WHERE id='$removeId' AND user_id='$id'";
	if (mysqli_query($conn, $sql)) {
		unlink('files/overview' . $removeId . '.json');
	}

	header("Location: my_events.php");
}

function removeVisitor()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$eventId = $_SESSION['eventId'];
	$removeId = $_GET['removeVisitor'];
	unset($_SESSION['visitors']['firstName'][$removeId]);
	unset($_SESSION['visitors']['lastName'][$removeId]);
	unset($_SESSION['visitors']['number'][$removeId]);
	$_SESSION['visitors']['firstName'] = array_values($_SESSION['visitors']['firstName']);
	$_SESSION['visitors']['lastName'] = array_values($_SESSION['visitors']['lastName']);
	$_SESSION['visitors']['number'] = array_values($_SESSION['visitors']['number']);
	header("Location:event3.php");
}

function addVisitor()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	unset($_SESSION['visitors']);
	$i = 0;
	if (!empty($_POST)) {
		foreach($_POST['firstName'] as $key => $value) {
			while (!empty($_SESSION['visitors']['firstName'][$i])) {
				$i++;
			}

			$_SESSION['visitors']['firstName'][$i] = $value;
			$i++;
		}

		$i = 0;
		foreach($_POST['lastName'] as $key => $value) {
			while (!empty($_SESSION['visitors']['lastName'][$i])) {
				$i++;
			}

			$_SESSION['visitors']['lastName'][$i] = $value;
			$i++;
		}

		$i = 0;
		foreach($_POST['number'] as $key => $value) {
			while (!empty($_SESSION['visitors']['number'][$i])) {
				$i++;
			}

			$_SESSION['visitors']['number'][$i] = $value;
			$i++;
		}
	}

	$eventId = $_SESSION['eventId'];
	header("Location:event3.php");
}

function setEventInfo()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$_SESSION['eventName'] = $_POST['eventName'];
	$_SESSION['eventPlace'] = $_POST['eventPlace'];
	$_SESSION['eventDate'] = $_POST['eventDate'];
	header("Location:event2.php");
}

function setHomeTeam()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$i = 0;
	unset($_SESSION['saved']);
	foreach($_POST['firstName'] as $value) {
		$_SESSION['saved']['home']['firstName'][$i] = $value;
		$i++;
	}

	$i = 0;
	foreach($_POST['lastName'] as $value) {
		$_SESSION['saved']['home']['lastName'][$i] = $value;
		$i++;
	}

	$i = 0;
	foreach($_POST['number'] as $value) {
		$_SESSION['saved']['home']['number'][$i] = $value;
		$i++;
	}

	$eventId = $_SESSION['eventId'];
	header("Location:event3.php");
}

function setVisitorTeam()
{
	if(!isset($_SESSION)) {
	session_start(); }
	$_SESSION['visitorName'] = $_POST['visitorName'];
	header("Location:event_overview.php?c");
}

function showHome()
{
	if(!isset($_SESSION)) {
	session_start(); }
	if (isset($_SESSION['eventId'])) {
	$eventId = $_SESSION['eventId'];
	}
	$i = 0;
	if (isset($_GET['c'])) {
		foreach($_SESSION['saved']['home']['firstName'] as $value) {
			$showFirst = $_SESSION['saved']['home']['firstName'][$i];
			$showLast = $_SESSION['saved']['home']['lastName'][$i];
			$showNum = $_SESSION['saved']['home']['number'][$i];
			echo '<td class="all img" id="playerpic' . $i . '"><img style="width: 35px; vertical-align: middle;" src="images/default.png"></td>';
			echo '<td class="all" id="number' . $i . '">' . $showNum . '</td>';
			echo '<td class="all" style="text-transform: capitalize;" id="first' . $i . '">' . $showFirst . '</td>';
			echo '<td class="all" style="text-transform: capitalize;" id="last' . $i . '">' . $showLast . '</td>';
			echo '<input type="hidden" name="number[' . $i . ']" value="' . $showNum . '">';
			echo '<input type="hidden" name="firstName[' . $i . ']" value="' . $showFirst . '">';
			echo '<input type="hidden" name="lastName[' . $i . ']" value="' . $showLast . '">';
			echo '</tr>';
			$i++;
		}
	}
	else {
		foreach($_SESSION['home']['firstName'] as $value) {
			$showFirst = $_SESSION['home']['firstName'][$i];
			$showLast = $_SESSION['home']['lastName'][$i];
			$showNum = $_SESSION['home']['number'][$i];
			echo '<td class="all img" id="playerpic' . $i . '"><img style="width: 35px; vertical-align: middle;" src="images/default.png"></td>';
			echo '<td class="all" id="number' . $i . '">' . $showNum . '</td>';
			echo '<td class="all" style="text-transform: capitalize;" id="first' . $i . '">' . $showFirst . '</td>';
			echo '<td class="all" style="text-transform: capitalize;" id="last' . $i . '">' . $showLast . '</td>';
			echo '<input type="hidden" name="number[' . $i . ']" value="' . $showNum . '">';
			echo '<input type="hidden" name="firstName[' . $i . ']" value="' . $showFirst . '">';
			echo '<input type="hidden" name="lastName[' . $i . ']" value="' . $showLast . '">';
			echo '</tr>';
			$i++;
		}
	}
}

function showVisitors()
{
	if(!isset($_SESSION)) {
	session_start(); }
	if (isset($_GET['eventId'])) {
	$eventId = $_GET['eventId'];
	}
	$i = 0;
	if(isset($_SESSION['visitors'])) {
	foreach($_SESSION['visitors']['firstName'] as $value) {
		$showFirst = $_SESSION['visitors']['firstName'][$i];
		$showLast = $_SESSION['visitors']['lastName'][$i];
		$showNum = $_SESSION['visitors']['number'][$i];
		echo '<td class="all img" id="playerpic' . $i . '"><img style="width: 35px; vertical-align: middle;" src="images/default.png"></td>';
		echo '<td class="all" id="number' . $i . '">' . $showNum . '</td>';
		echo '<td class="all" style="text-transform: capitalize;" id="first' . $i . '">' . $showFirst . '</td>';
		echo '<td class="all" style="text-transform: capitalize;" id="last' . $i . '">' . $showLast . '</td>';
		echo '<input type="hidden" name="number[' . $i . ']" value="' . $showNum . '">';
		echo '<input type="hidden" name="firstName[' . $i . ']" value="' . $showFirst . '">';
		echo '<input type="hidden" name="lastName[' . $i . ']" value="' . $showLast . '">';
		echo '</tr>';
		$i++;
	}
} }

function listVisitors()
{
	if(!isset($_SESSION)) {
	session_start(); }
	if (isset($_SESSION['eventId'])) {
	$eventId = $_SESSION['eventId'];
}
	$i = 0;
		if (isset($_SESSION['visitors'])) {
	foreach($_SESSION['visitors']['firstName'] as $value) {
		if (empty($_SESSION['visitors']['firstName'][$i])) {
			$i++;
		}

		$showFirst = $_SESSION['visitors']['firstName'][$i];
		$showLast = $_SESSION['visitors']['lastName'][$i];
		$showNum = $_SESSION['visitors']['number'][$i];
		echo '<td class="all img" id="playerpic' . $i . '"><img style="width: 35px; vertical-align: middle;" src="images/default.png"></td>';
		echo '<td class="all" id="number' . $i . '">' . $showNum . '</td>';
		echo '<td class="all" style="text-transform: capitalize;" id="first' . $i . '">' . $showFirst . '</td>';
		echo '<td class="all" style="text-transform: capitalize;" id="last' . $i . '">' . $showLast . '</td>';
		echo '<td><a href="functions.php?removeVisitor=' . $i . '" id="iconRemove"><i class="material-icons">delete</i></a></td>';
		echo '<input type="hidden" name="number[' . $i . ']" value="' . $showNum . '">';
		echo '<input type="hidden" name="firstName[' . $i . ']" value="' . $showFirst . '">';
		echo '<input type="hidden" name="lastName[' . $i . ']" value="' . $showLast . '">';
		echo '</tr>';
		$i++;
	} 	}

	return $i + 1;
}

function listHome()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$id = $_SESSION['id'];
	$teamId = $_SESSION['teamId'];
	$i = 0;
	$sql = "SELECT * from player WHERE team_id='$teamId'";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result)) {
		$showId = $row['id'];
		$_SESSION['home']['firstName'][$i] = $row['firstName'];
		$_SESSION['home']['lastName'][$i] = $row['lastName'];
		$_SESSION['home']['number'][$i] = $row['number'];
		$i++;
	}

	$i = 0;
	foreach($_SESSION['home']['firstName'] as $value) {
		$showId = $i;
		$showFirst = $_SESSION['home']['firstName'][$i];
		$showLast = $_SESSION['home']['lastName'][$i];
		$showNum = $_SESSION['home']['number'][$i];
		echo '<tr id="' . $showId . '" onclick="removePlayer(&quot;' . $showId . '&quot;, &quot;' . $showFirst . '&quot;, &quot;' . $showLast . '&quot;, &quot;' . $showNum . '&quot;)">';
		echo '<td class="all img" id="playerpic' . $i . '"><img style="width: 35px; vertical-align: middle;" src="images/default.png"></td>';
		echo '<td class="all" id="number' . $i . '">' . $showNum . '</td>';
		echo '<td class="all" style="text-transform: capitalize;" id="first' . $i . '">' . $showFirst . '</td>';
		echo '<td class="all" style="text-transform: capitalize;" id="last' . $i . '">' . $showLast . '</td>';
		echo '<input type="hidden" name="number[' . $i . ']" value="' . $showNum . '">';
		echo '<input type="hidden" name="firstName[' . $i . ']" value="' . $showFirst . '">';
		echo '<input type="hidden" name="lastName[' . $i . ']" value="' . $showLast . '">';
		echo '</tr>';
		$i++;
	}
}

function listEvents($mod)
{
	include 'dbh.php';

	if(!isset($_SESSION)) {
	session_start(); }
	$id = $_SESSION['id'];
	$teamId = $_SESSION['teamId'];
	$i = 1;
	if ($mod == "all") {
		if ($_SESSION['type'] == 0) {
			$sql = "SELECT * from event WHERE team_id='$teamId'";
		}
		else {
			$sql = "SELECT * from event WHERE team_id='$teamId'";
		}
	}

	if ($mod == "upcoming") {
		if ($_SESSION['type'] == 0) {
			$sql = "SELECT * from event WHERE date >= CURDATE() AND team_id='$teamId'";
		}
		else {
			$sql = "SELECT * from event WHERE date >= CURDATE() AND team_id='$teamId'";
		}
	}

	if ($mod == "past") {
		if ($_SESSION['type'] == 0) {
			$sql = "SELECT * from event WHERE date < CURDATE() AND team_id='$teamId'";
		}
		else {
			$sql = "SELECT * from event WHERE date < CURDATE() AND team_id='$teamId'";
		}
	}

	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result)) {
		$showId = $row['id'];
		$showName = $row['name'];
		echo "<tr>";
		if ($mod != "all") {
			echo '<td><a style="text-decoration:none;" href="event_overview.php?eventId=' . $showId . '">' . $showName . '</a></td>';
		}
		else {
			echo '<td><img src="default_team.png"></td>';
			echo '<td><a style="text-decoration:none;" href="event_overview.php?eventId=' . $showId . '"><h4>' . $showName . '</h4></a></td>';
		}

		echo '<td></td>';
		echo '<td></td>';
		echo '<td></td>';
		echo "</tr>";
		$i++;
	}
}

function eventId()
{
	include 'dbh.php';

	if(!isset($_SESSION)) {
	session_start(); }
	$id = $_SESSION['id'];
	$teamId = $_SESSION['teamId'];
	$_SESSION['eventId'] = $_GET['eventId'];
	$eventId = $_SESSION['eventId'];
	$i = 0;
	if (!empty($_SESSION['eventId'])) {
		if ($_SESSION['type'] == 0) {
			$sql = "SELECT * from event WHERE id='$eventId' AND team_id='$teamId'";
		}
		else {
			$sql = "SELECT * from event WHERE id='$eventId' AND team_id='$teamId'";
		}

		$result = mysqli_query($conn, $sql);
		if ($row = mysqli_fetch_array($result)) {
			$eventId = $row['id'];
			$json = file_get_contents('files/overview' . $eventId . '.json');
			$json = json_decode($json, true);
			if (!isset($_GET['c'])) {
				$_SESSION['eventName'] = $json['eventinfo'][0];
				$_SESSION['eventPlace'] = $json['eventinfo'][1];
				$_SESSION['eventDate'] = $json['eventinfo'][2];
				$_SESSION['homeName'] = $json['teams']['home'][0];
				$_SESSION['visitorName'] = $json['teams']['visitors'][0];
				foreach($json['teams']['home']['players'] as $value) {
					$_SESSION['home']['firstName'][$i] = $json['teams']['home']['players'][$i]['first'];
					$_SESSION['home']['lastName'][$i] = $json['teams']['home']['players'][$i]['last'];
					$_SESSION['home']['number'][$i] = $json['teams']['home']['players'][$i]['number'];
					$i++;
				}

				$i = 0;
				foreach($json['teams']['visitors']['players'] as $value) {
					$_SESSION['visitors']['firstName'][$i] = $json['teams']['visitors']['players'][$i]['first'];
					$_SESSION['visitors']['lastName'][$i] = $json['teams']['visitors']['players'][$i]['last'];
					$_SESSION['visitors']['number'][$i] = $json['teams']['visitors']['players'][$i]['number'];
					$i++;
				}
			}
		}
		else {
			unset($_SESSION['eventId']);
			set_error_handler('error');
		}
	}
}

function createEvent()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$id = $_SESSION["id"];
	$teamId = $_SESSION['teamId'];
	$teamName = $_SESSION['teamName'];
	$visitorName = $_SESSION['visitorName'];
	$eventName = $_SESSION['eventName'];
	$eventPlace = $_SESSION['eventPlace'];
	$eventDate = $_SESSION['eventDate'];
	$date = date_create($eventDate);
	$realDate = date_format($date, "Y-m-d");
	$visitorName = strip_tags($visitorName);
	$visitorName = mysqli_real_escape_string($conn, $visitorName);
	$eventName = strip_tags($eventName);
	$eventName = mysqli_real_escape_string($conn, $eventName);
	$eventPlace = strip_tags($eventPlace);
	$eventPlace = mysqli_real_escape_string($conn, $eventPlace);
	$eventDate = strip_tags($eventDate);
	$eventDate = mysqli_real_escape_string($conn, $eventDate);
	$overview = array(
		'eventinfo' => array(
			$eventName,
			$eventPlace,
			$eventDate
		) ,
		'teams' => array(
			'home' => array(
				$teamName,
				'players' => array(
					array(
						'first' => array() ,
						'last' => array() ,
						'number' => array()
					)
				)
			) ,
			'visitors' => array(
				$visitorName,
				'players' => array(
					array(
						'first' => array() ,
						'last' => array() ,
						'number' => array()
					)
				)
			)
		)
	);
	$i = 0;
	foreach($_SESSION['saved']['home']['firstName'] as $key => $value) {
		$overview['teams']['home']['players'][$i]['first'] = $value;
		$i++;
	}

	$i = 0;
	foreach($_SESSION['saved']['home']['lastName'] as $key => $value) {
		$overview['teams']['home']['players'][$i]['last'] = $value;
		$i++;
	}

	$i = 0;
	foreach($_SESSION['saved']['home']['number'] as $key => $value) {
		$overview['teams']['home']['players'][$i]['number'] = $value;
		$i++;
	}

	$i = 0;
	foreach($_SESSION['visitors']['firstName'] as $key => $value) {
		$overview['teams']['visitors']['players'][$i]['first'] = $value;
		$i++;
	}

	$i = 0;
	foreach($_SESSION['visitors']['lastName'] as $key => $value) {
		$overview['teams']['visitors']['players'][$i]['last'] = $value;
		$i++;
	}

	$i = 0;
	foreach($_SESSION['visitors']['number'] as $key => $value) {
		$overview['teams']['visitors']['players'][$i]['number'] = $value;
		$i++;
	}

	if (!empty($_SESSION['eventId'])) {
		$eventId = $_SESSION['eventId'];
		$sql = "UPDATE event SET name='$eventName',date='$realDate' WHERE id ='$eventId'";
		$result = mysqli_query($conn, $sql);
	}
	else {
		$sql = "INSERT INTO event (user_id,team_id,name,date) VALUES ('$id','$teamId','$eventName','$realDate')";
		$result = mysqli_query($conn, $sql);
	}

	// Haetaan tapahtuman ID

	$sql = "SELECT * from event WHERE user_id='$id' AND name='$eventName'";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result)) {
		$eventId = $row['id'];
	}

	// luodaan json

	$json = json_encode($overview);

	// kirjoitetaan tiedosto

	$fp = fopen("files/overview" . $eventId . ".json", "wb");
	fwrite($fp, $json);
	if (fwrite) {
		$ok = "SUCCESSFULLY UPLOADED FILE";
		echo "<script type='text/javascript'>alert('$ok');</script>";
	}
	else {
		$fail = "FAILED TO UPLOAD FILE";
		echo "<script type='text/javascript'>alert('$fail');</script>";
	}

	fclose($fp);

	// Tyhjennetään Tapahtumamuuttujat

	unset($_SESSION['eventId']);
	unset($_SESSION['visitorName']);
	unset($_SESSION['eventName']);
	unset($_SESSION['eventPlace']);
	unset($_SESSION['eventDate']);
	unset($_SESSION['home']);
	unset($_SESSION['visitors']);
	echo "<script>window.location.href='my_events.php'</script>";
}

function listTeams()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$i = 1;
	$id = $_SESSION['id'];
	if (isset($_SESSION['teamId'])) {
		unset($_SESSION['teamId']);
		unset($_SESSION['teamName']);
	}

	$sql = "SELECT * from team WHERE user_id='$id'";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result)) {
		$showId = $row['id'];
		$showName = $row['name'];
		echo "<tr'>";
		echo '<td><img style="width: 35px; height: 35px; vertical-align: middle;" src="images/default_team.png"></td>';
		echo '<td><a style="text-decoration:none;" href="profile.php?teamId=' . $showId . '">' . $showName . '</a></td>';
		echo '<td></td>';
		echo "</tr>";
		$i++;
	}

	return $i;
}

function listPlayers()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$id = $_SESSION['id'];
	$teamId = $_SESSION['teamId'];
	$i = 0;
	$sql = "SELECT * from player WHERE team_id='$teamId'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_array($result)) {
			$showId = $row['id'];
			$showFirst = $row['firstName'];
			$showLast = $row['lastName'];
			$showNum = $row['number'];
			echo '<tr>';
			echo '<td class="fetch img" id="playerpic' . $i . '"><img style="width: 35px; vertical-align: middle;" src="images/default.png"></td>';
			echo '<td class="fetch" id="number' . $i . '">' . $showNum . '</td>';
			echo '<td class="fetch" style="text-transform: capitalize;" id="first' . $i . '">' . $showFirst . '</td>';
			echo '<td class="fetch" style="text-transform: capitalize;" id="last' . $i . '">' . $showLast . '</td>';
			echo '<td class="fetch" style="text-transform: capitalize;" id="pelipaikka' . $i . '"></td>';
			echo '</tr>';
			$i++;
		}
	}
	else {
		set_error_handler('error');
	}

	return $i + 1;
}

function getTeamName()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$id = $_SESSION['id'];
	if ($_SESSION['type'] == 0) {
		$_SESSION['teamId'] = $_GET['teamId'];
		$teamId = $_SESSION['teamId'];
		$sql = "SELECT * from team WHERE id='$teamId' AND user_id='$id'";
		$result = mysqli_query($conn, $sql);
		if ($row = mysqli_fetch_array($result)) {
			$_SESSION['teamId'] = $row['id'];
			$_SESSION['teamName'] = $row['name'];
		}
		else {
			unset($_SESSION['teamId']);
			unset($_SESSION['teamName']);
			set_error_handler('error');
		}
	}
	else {
		if (isset($_GET['teamId'])) {
			$teamId = $_SESSION['teamId'];
			$sql = "SELECT * from user WHERE team_id='$teamId'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result);
			if ($_GET['teamId'] == $row['team_id']) {
				$_SESSION['teamId'] = $_GET['teamId'];
				$sql = "SELECT * from team WHERE id='$teamId'";
				$result = mysqli_query($conn, $sql);
				if ($row = mysqli_fetch_array($result)) {
					$_SESSION['teamName'] = $row['name'];
				}
			}
		}
	}
}

function editTeam()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$i = 1;
	$id = $_SESSION['id'];
	$teamId = $_SESSION['teamId'];
	$sql = "SELECT * FROM player WHERE team_id='$teamId'";
	$result = mysqli_query($conn, $sql);
	echo "<table class='u-full-width'>";
	while ($row = mysqli_fetch_array($result)) {
		$showId = $row['id'];
		$showFirst = $row['firstName'];
		$showLast = $row['lastName'];
		$showNum = $row['number'];
		echo '<tr>';
		echo '<td class="fetch img" id="playerpic' . $i . '"><img style="width: 35px; vertical-align: middle;" src="images/default.png"></td>';
		echo '<td>Pelaaja ' . $i . '</td>';
		echo '<td class="fetch" id="number' . $i . '"><input type="text" name="number' . $i . '"value="' . $showNum . '"></td>';
		echo '<td class="fetch" style="text-transform: capitalize;" id="first' . $i . '"><input type="text" name="first' . $i . '"value="' . $showFirst . '"></td>';
		echo '<td class="fetch" style="text-transform: capitalize;" id="last' . $i . '"><input type="text" name="last' . $i . '"value="' . $showLast . '"></td>';
		echo '<td><a href="functions.php?removePlayer=' . $showId . '" id="iconRemove"><i class="material-icons">delete</i></a></td>';
		echo '<input type="hidden" name="id' . $i . '" value="' . $showId . '">';
		echo '</tr>';
		$i++;
	}

	echo '</table>';
}

function newEvent()
{
	if(!isset($_SESSION)) {
	session_start(); }
	$_SESSION['homeName'] = $_SESSION['teamName'];
	if (isset($_SESSION['eventId'])) {
		unset($_SESSION['eventId']);
		unset($_SESSION['homeName']);
		unset($_SESSION['visitorName']);
		unset($_SESSION['eventName']);
		unset($_SESSION['eventPlace']);
		unset($_SESSION['eventDate']);
		unset($_SESSION['home']);
		unset($_SESSION['visitors']);
	}

	header("Location:event1.php");
}

function error()
{
	header("Location: error.php");
}

function userData()
{ 	include 'dbh.php';
	if(!isset($_SESSION)) {
	session_start();
}
	$id = $_SESSION['id'];
	$teamId = "";
	if (isset($_SESSION['teamId'])) {
	$teamId = $_SESSION['teamId'];
	}
	$sql = "SELECT * FROM user WHERE team_id='$teamId'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$userName = $row['uid'];
	$type = $row['type'];
	echo '<tr>';
	echo '<td>Käyttäjänimi:</td>';
	echo '<td>' . $userName . '</td';
	echo '</tr>';
	echo '<tr>';
	echo '<td>Tilintyyppi:</td>';
	if ($type == 1) {
		echo '<td>Joukkuetaso</td';
	}
	else {
		echo '<td>Seurataso</td';
	}

	echo '</tr>';
}

if (isset($_POST['setEventInfo'])) {
	setEventInfo();
}

if (isset($_POST['setHomeTeam'])) {
	setHomeTeam();
}

if (isset($_POST['setVisitorTeam'])) {
	setVisitorTeam();
}

if (isset($_POST['addVisitor'])) {
	addVisitor();
}

if (isset($_POST['savePlayer'])) {
	savePlayer();
}

if (isset($_POST['saveTeam'])) {
	saveTeam();
}

if (isset($_POST['updateTeam'])) {
	updateTeam();
}

if (isset($_GET['removePlayer'])) {
	removePlayer();
}

if (isset($_GET['eventId'])) {
	eventId();
}

if (isset($_GET['removeEvent'])) {
	removeEvent();
}

if (isset($_GET['removeVisitor'])) {
	removeVisitor();
}

if (isset($_POST['addToEvent'])) {
	addToEvent();
}

if (isset($_POST['createEvent'])) {
	createEvent();
}

if (isset($_POST['newEvent'])) {
	newEvent();
}

if (isset($_POST['register'])) {
	register();
}

if (isset($_POST['logIn'])) {
	logIn();
}

if (isset($_POST['logOut'])) {
	logOut();
}

?>
