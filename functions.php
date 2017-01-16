<?php

function register()
{ session_start();
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

   //Aktivointikoodin luonti
		$hash = md5(rand(0, 1000));
		$hash = strip_tags($hash);
		$hash = mysqli_real_escape_string($conn, $hash);

   // Salasanan kryptaus
	  require("PasswordHash.php");
    $pwdHasher = new PasswordHash(8, false);
		$pwdHash = $pwdHasher->HashPassword($pwd);

    //Joukkuetilin luonti
		if (isset($_SESSION['id'])) {
		$id = $_SESSION['id'];
		$sql = "INSERT INTO team (name,user_id) VALUES ('$uid','$id')";
		$result = mysqli_query($conn, $sql);

	  $sql = "SELECT * FROM team ORDER BY ID DESC LIMIT 1";
	  $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($result)) {
		$teamId = $row['id'];
}
    $sql = "INSERT INTO user (uid,pwd,type,email,hash,team_id,owner_id) VALUES ('$uid','$pwdHash','1','$email','$hash','$teamId','$id')";
    $result = mysqli_query($conn, $sql);
} else {
   //Seuratilin luonti
		$sql = "INSERT INTO user (uid,pwd,type,email,hash) VALUES ('$uid','$pwdHash','0','$email','$hash')";
		$result = mysqli_query($conn, $sql);
		$sql = "SELECT id FROM user WHERE uid='$uid'";
		$result = mysqli_query($conn, $sql);
		if ($row = mysqli_fetch_assoc($result)) {
			$id = $row['id'];
			$sql = "UPDATE user SET owner_id = $id WHERE id = $id";
			$result = mysqli_query($conn, $sql);
		} }

	if(sendEmail('reg',$uid,$pwd,$email,$hash) == FALSE) {
		echo '<script type="text/javascript">';
		echo 'alert("Käyttäjä rekisteröity! Sähköpostia ei voitu lähettää.");';
		echo '</script>';
	} else {
		echo '<script type="text/javascript">';
		echo 'alert("Käyttäjä rekisteröity! Käy aktivoimassa tili linkistä jonka lähetimme sähköpostiisi.");';
		echo '</script>';
	}
} if (isset($_SESSION['id'])) {
	echo '<script type="text/javascript">';
	echo 'document.location.href = "teams.php";';
	echo '</script>';
} else {
  echo '<script type="text/javascript">';
  echo 'document.location.href = "index.php";';
  echo '</script>';
}
}
function sendEmail($mod,$uid,$pwd,$email,$hash) {
	include ('dbh.php');
	// Sähköpostin lähetys
if ($mod == 'resend') {
	$sql = "SELECT * FROM user WHERE team_id = '$uid'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$email = $row['email'];
	$hash = $row['hash'];
}
	require 'phpmailer/PHPMailerAutoload.php';

	$mail = new PHPMailer;

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'mail.zoner.fi';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'no_reply@otteluohjelma.fi';                 // SMTP username
	$mail->Password = 'vWV1md6ils';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->SetFrom("vahvistus@otteluohjelma.fi", "Otteluohjelma");
	$mail->AddReplyTo("vahvistus@otteluohjelma.fi", "Otteluohjelma");
	$mail->addAddress($email, $uid);     // Add a recipient
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'Otteluohjelma: Vahvistus';
  if ($mod == 'reg') {
	$mail->Body = 'Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

------------------------
Username: '.$uid.'
Password: '.$pwd.'
------------------------
Please click this link to activate your account:
http://'.$_SERVER['SERVER_NAME'].'/otteluohjelma/verify.php?email='.$email.'&hash='.$hash.''; // Our message above including the link
} else {
	$mail->Body =
	'Please click this link to activate your account:
	http://'.$_SERVER['SERVER_NAME'].'/otteluohjelma/verify.php?email='.$email.'&hash='.$hash.'';

}

$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
if (!$mail->send()) {
	if ($mod == 'reg') {
	echo 'Mailer Error:'.$mail->ErrorInfo.'';
	return FALSE;
} else {
	echo '<script type="text/javascript">';
	echo 'alert("Aktivointikoodia ei voitu lähettää!");';
	echo 'document.location.href = "teams.php";';
	echo '</script>';

}
} else {
	if ($mod == 'reg') {
	return TRUE;
} else {
	echo '<script type="text/javascript">';
	echo 'alert("Aktivointikoodi lähetetty sähköpostiin");';
	echo 'document.location.href = "teams.php";';
	echo '</script>';

}
}
}

function verifyAccount() {
	include 'dbh.php';
	if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
    $email = mysqli_escape_string($conn,$_GET['email']); // Set email variable
    $hash = mysqli_escape_string($conn,$_GET['hash']); // Set hash variable

    $sql = "SELECT * FROM user WHERE email='$email' AND hash='$hash' AND activated='0'";
		$result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        // We have a match, activate the account
				$sql = "UPDATE user SET activated='1' WHERE email='".$email."' AND hash='".$hash."' AND activated='0'";
        $result = mysqli_query($conn,$sql);
        echo 'Käyttäjätili aktivoitu. Voit nyt kirjautua sisään.';
    }else{
        // No match -> invalid url or account has already been activated.
        echo 'Linkki on väärä tai olet jo aktivoinut tilisi.';
    }

}else{
    // Invalid approach
    echo 'Käytä sinulle lähetettyä linkkiä.';
}
}
function logoUpload() {
	if(!isset($_SESSION)) {
	session_start();
}
	if(isset($_SESSION['id'])) {
	$id = $_SESSION['id'];
	$uid = $_SESSION['uid'];
	if(isset($_SESSION['teamId'])) {
	$teamId =	$_SESSION['teamId'];
	$teamName =	$_SESSION['teamName'];
}
	if (isset($_POST['logoUpload']))
	{
		$filename = $_FILES["file"]["name"];
		$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
		$file_ext = substr($filename, strripos($filename, '.')); // get file name
		$filesize = $_FILES["file"]["size"];
		$allowed_file_types = array('.jpg','.jpeg','.png','.gif');

			// Rename file
			if (!$_SESSION['type'] == 0) {
			$newfilename = $teamName . $teamId . $file_ext;
		} else {
			$newfilename = $uid . $id . $file_ext;
		}

		if (!in_array($file_ext,$allowed_file_types) && (!$filesize < 200000))
		{
			// file type error
			unlink($_FILES["file"]["tmp_name"]);
			echo '<script type="text/javascript">';
			echo 'alert("Kuva ei ole sallitussa muodossa!");';
			echo 'document.location.href = "profile.php";';
			echo '</script>';
			//echo "Only these file types are allowed for upload: " . implode(', ',$allowed_file_types);

		}
		elseif (empty($file_basename))
		{
			// file selection error
			echo '<script type="text/javascript">';
			echo 'alert("Valitse ladattava logo!");';
			echo 'document.location.href = "profile.php";';
			echo '</script>';
		}
		elseif ($filesize > 200000)
		{
			// file size error
			echo '<script type="text/javascript">';
			echo 'alert("Kuvan tiedostokoko on liian iso!");';
			echo 'document.location.href = "profile.php";';
			echo '</script>';
		}
		else
		{
			move_uploaded_file($_FILES["file"]["tmp_name"], "images/logos/" . $newfilename);
			echo '<script type="text/javascript">';
			echo 'alert("Logon lataus onnistui.");';
			echo 'document.location.href = "profile.php";';
			echo '</script>';
		}

	} }}
function logIn()
{
	if(!isset($_SESSION)) {
	session_start();
}
	include 'dbh.php';
	require("PasswordHash.php");
	$hasher = new PasswordHash(8, false);
	$pwdHash = "*";

	$uid = $_POST['uid'];
	$pwd = $_POST['pwd'];
	$uid = strip_tags($uid);
	$uid = mysqli_real_escape_string($conn, $uid);
	$pwd = strip_tags($pwd);
	$pwd = mysqli_real_escape_string($conn, $pwd);
	$sql = "SELECT * FROM user WHERE uid='$uid'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	//Käyttäjätunnuksen ja salasanan tarkistus
	$pwdHash = $row['pwd'];
	$check = $hasher->CheckPassword($pwd, $pwdHash);

	if ($check == FALSE) {
		echo '<script type="text/javascript">';
		echo 'alert("Käyttäjätunnus tai salasana on väärin!");';
		echo 'document.location.href = "index.php";';
		echo '</script>';
	} else if ($row['activated'] == 0) {
		echo '<script type="text/javascript">';
		echo 'alert("Käyttäjätunnusta ei ole aktivoitu!");';
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
if ($_POST['firstName'] && $_POST['lastName'] && $_POST['number']) {
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$number = $_POST['number'];
			$sql = "INSERT INTO player (user_id,team_id,firstName,lastName,number) VALUES ('$id','$teamId','$firstName','$lastName','$number')";
			$result = mysqli_query($conn, $sql);
		} else {
			echo '<script type="text/javascript">';
			echo 'alert("Täytä kaikki pelaajan tiedot!");';
			echo 'document.location.href = "team.php?teamId='.$teamId.'"';
			echo '</script>';
			exit();
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
		'name' => array(),
		'email' => array()
	);
	$i = 0;
	foreach($_POST as $key => $value) {
		$teams['name'][$i] = $value;
		$i++;
	}

	$i = 0;
	foreach($_POST as $key => $value) {
		$teams['email'][$i] = $value;
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

		$email = $teams[''][$i];
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
	if (empty($_SESSION['visitors']['firstName'])) {
	unset($_SESSION['visitors']);
	}
	header("Location:event3.php");
}

function addVisitor()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';
	//unset($_SESSION['visitors']);
	$i = 0;
	if ($_POST['firstName'] && $_POST['lastName'] && $_POST['number']) {
			while (!empty($_SESSION['visitors']['firstName'][$i])) {
				$i++;
			}
			$_SESSION['visitors']['firstName'][$i] = $_POST['firstName'];

		$i = 0;
			while (!empty($_SESSION['visitors']['lastName'][$i])) {
				$i++;
			}
			$_SESSION['visitors']['lastName'][$i] = $_POST['lastName'];

		$i = 0;
			while (!empty($_SESSION['visitors']['number'][$i])) {
				$i++;
			}
			$_SESSION['visitors']['number'][$i] = $_POST['number'];

	} else {
		echo '<script type="text/javascript">';
		echo 'alert("Täytä kaikki pelaajan tiedot!");';
		echo 'document.location.href = "event3.php";';
		echo '</script>';
		exit();
	}
	if (!empty($_POST['visitorName'])) {
  $_SESSION['visitorName'] = $_POST['visitorName'];
}
	$eventId = $_SESSION['eventId'];
	header("Location:event3.php");
}

function setEventInfo($mod)
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';
	if (empty($_POST['eventName']) || empty($_POST['eventPlace']) || empty($_POST['eventDate'])) {
 	echo '<script type="text/javascript">';
 	echo 'alert("Täytä kaikki tapahtuman tiedot!");';
 	echo 'document.location.href = "event1.php"';
 	echo '</script>';
 	exit();
 }

if ($mod == 'guide' || $mod == 'guide2') {
if (!isset($_SESSION['visitors'])) {
	echo '<script type="text/javascript">';
	echo 'alert("Lisää vähintään yksi vierasjoukkueen pelaaja!");';
	echo 'document.location.href = "event3.php"';
	echo '</script>';
	exit(); }
 else if (!isset($_SESSION['visitorName'])) {
	echo '<script type="text/javascript">';
	echo 'alert("Aseta vierasjoukkueen nimi!");';
	echo 'document.location.href = "event3.php"';
	echo '</script>';
	exit();
} if($mod == 'guide') {
header("Location:event3.php");
} else {
header("Location:event_overview.php");
}
}
else {
	$_SESSION['eventName'] = $_POST['eventName'];
	$_SESSION['eventPlace'] = $_POST['eventPlace'];
	$_SESSION['eventDate'] = $_POST['eventDate'];
	header("Location:event2.php");
}
}
function setHomeTeam($mod) {
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	if (!isset($_SESSION['eventName']) && !isset($_SESSION['eventPlace']) && !isset($_SESSION['eventDate'])) {
			echo '<script type="text/javascript">';
			echo 'alert("Täytä kaikki tapahtuman tiedot!");';
			echo 'document.location.href = "event1.php"';
			echo '</script>';
			exit();
		}
	$i = 0;
	unset($_SESSION['saved']);
	if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['number'])) {
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
	if ($mod == 'guide') {
	header("Location:event_overview.php");
} else {
	header("Location:event3.php");
}
}
else {
		echo '<script type="text/javascript">';
		echo 'alert("Lisää vähintään yksi pelaaja!");';
		echo 'document.location.href = "event2.php"';
		echo '</script>';
	}
}

function setVisitorTeam()
{
	if(!isset($_SESSION)) {
	session_start(); }
if ($_POST['visitorName']) {
$_SESSION['visitorName'] = $_POST['visitorName'];
}
if (!$_POST['visitorName']) {
			echo '<script type="text/javascript">';
			echo 'alert("Aseta vierasjoukkueen nimi!");';
			echo 'document.location.href = "event3.php"';
			echo '</script>';
		}
else if(!isset($_SESSION['visitors'])) {
	echo '<script type="text/javascript">';
	echo 'alert("Lisää vähintään yksi vierasjoukkueen pelaaja!");';
	echo 'document.location.href = "event3.php"';
	echo '</script>';
}
 else {
		header("Location:event_overview.php?c");
	}
}

function showHome()
{
	if(!isset($_SESSION)) {
	session_start(); }

	if (isset($_SESSION['eventId'])) {
	$eventId = $_SESSION['eventId'];
}
	if (empty($_SESSION['eventName']) && empty($_SESSION['eventPlace']) && empty($_SESSION['eventDate'])) {
		echo '<script type="text/javascript">';
		echo 'alert("Täytä kaikki tapahtuman tiedot!");';
		echo 'document.location.href = "event1.php"';
		echo '</script>';
		exit();
	}
	if (!isset($_SESSION['visitors'])) {
		echo '<script type="text/javascript">';
		echo 'alert("Lisää vähintään yksi vierasjoukkueen pelaaja!");';
		echo 'document.location.href = "event3.php"';
		echo '</script>';
		exit();
	}
	if (!isset($_SESSION['visitorName'])) {
		echo '<script type="text/javascript">';
		echo 'alert("Aseta vierasjoukkueen nimi!");';
		echo 'document.location.href = "event3.php"';
		echo '</script>';
		exit();
	}
	$i = 0;
	if (isset($_GET['c']) && isset($_SESSION['saved'])) {
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

	if (empty($_SESSION['eventName']) && empty($_SESSION['eventPlace']) && empty($_SESSION['eventDate'])) {
		echo '<script type="text/javascript">';
		echo 'alert("Täytä kaikki tapahtuman tiedot!");';
		echo 'document.location.href = "event1.php"';
		echo '</script>';
	}
	if (isset($_SESSION['eventId'])) {
	$eventId = $_SESSION['eventId'];
}
	$i = 0;
		if (!empty($_SESSION['visitors'])) {
	foreach($_SESSION['visitors']['firstName'] as $value) {

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
	if (empty($_SESSION['eventName']) && empty($_SESSION['eventPlace']) && empty($_SESSION['eventDate'])) {
	  echo '<script type="text/javascript">';
		echo 'alert("Täytä kaikki tapahtuman tiedot!");';
		echo 'document.location.href = "event1.php"';
		echo '</script>';
	}

	$id = $_SESSION['id'];
	if (isset($_SESSION['teamId'])) {
	$teamId = $_SESSION['teamId'];
} else {
	$eventId = $_SESSION['eventId'];
	$sql = "SELECT * from event WHERE id ='$eventId'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	$teamId = $row['team_id'];
}
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
	if (isset($_SESSION['teamId'])) {
	$teamId = $_SESSION['teamId'];
}
	$i = 1;
	if ($mod == "all") {
			$sql = "SELECT * from event WHERE team_id='$teamId'";
	}

	if ($mod == "upcoming") {
		if (!isset($_SESSION['teamId'])) {
			$sql = "SELECT * from event WHERE date >= CURDATE() AND owner_id='$id'";
		}
		else {
			$sql = "SELECT * from event WHERE date >= CURDATE() AND team_id='$teamId'";
		}
	}

	if ($mod == "past") {
		if (!isset($_SESSION['teamId'])) {
			$sql = "SELECT * from event WHERE date < CURDATE() AND owner_id='$id'";
		}
		else {
			$sql = "SELECT * from event WHERE date < CURDATE() AND team_id='$teamId'";
		}
	}

	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result)) {
		$showId = $row['id'];
		$showName = $row['name'];
		$showDate = $row['date'];
		echo "<tr>";
		if ($mod != "all") {
			echo '<td><a style="text-decoration:none;" href="event_overview.php?eventId=' . $showId . '">' . $showName . '</a></td>';
			echo '<td><p style="margin-bottom: 0;">' . $showDate . '</p></td>';
		}
		else {
			echo '<td><img src="default_team.png"></td>';
			echo '<td><a style="text-decoration:none;" href="event_overview.php?eventId=' . $showId . '">' . $showName . '</a></td>';
		}
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
	if (isset($_SESSION['teamId'])) {
	$teamId = $_SESSION['teamId'];
}
	$_SESSION['eventId'] = $_GET['eventId'];
	$eventId = $_SESSION['eventId'];
	$i = 0;
	if (!empty($_SESSION['eventId'])) {
		if ($_SESSION['type'] == 0) {
			$sql = "SELECT * from event WHERE id='$eventId' AND owner_id='$id'";
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
	if (isset($_SESSION['teamId'])) {
	$teamId = $_SESSION['teamId'];
	$teamName = $_SESSION['teamName'];
}
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
	if (!isset($_SESSION['saved'])) {
		foreach($_SESSION['home']['firstName'] as $key => $value) {
			$_SESSION['saved']['home']['firstName'] = $_SESSION['home']['firstName'];
			$_SESSION['saved']['home']['lastName'] = $_SESSION['home']['lastName'];
			$_SESSION['saved']['home']['number'] = $_SESSION['home']['number'];
			$i++;
		}
	}
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
		$sql = "SELECT * from user WHERE id='$id'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($result);
		$ownerId = $row['owner_id'];
		$sql = "INSERT INTO event (user_id,team_id,owner_id,name,date) VALUES ('$id','$teamId','$ownerId','$eventName','$realDate')";
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

	if (fwrite($fp, $json)) {
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
	unset($_SESSION['saved']);
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
  $teamId = $row['id'];

	$sql2 = "SELECT * from user WHERE team_id='$teamId'";
	$result2 = mysqli_query($conn, $sql2);
  $row2 = mysqli_fetch_array($result2);

		$showId = $row['id'];
		$showName = $row['name'];
		echo '<tr style="min-height: 80px; height: 80px;">';
		echo '<td><img style="width: 35px; height: 35px; vertical-align: middle;" src="images/default_team.png"></td>';
		if ($row2['activated'] == 1) {
			echo '<td><a style="text-decoration:none;" href="profile.php?teamId=' . $showId . '">' . $showName . '</a></td>';
			echo '<td><i style="color: #003400;" class="material-icons">check_circle</i></td>';
			echo '<td><a style="display: inline-block; text-decoration: none; vertical-align: middle;" href="#"><i style="float: left; padding-right: 3px;" class="material-icons">open_in_browser</i>Siirry</a></td>';
		} else {
			echo '<td><a style="text-decoration:none; color:gray;" href="#">' . $showName . '</a></td>';
			echo '<td><i style="color: #670a1c;" class="material-icons">cancel</i></td>';

			echo '<form action="functions.php" method="POST">';
			echo '<input type="hidden" name="teamId" value='.$showId.'>';
			echo '<td>
				<a style="display: inline-block; text-decoration: none; vertical-align: middle;" href="?sendActivation" name="sendActivation"><i style="float: left; padding-right: 3px;" class="material-icons">refresh</i>Lähetä vahvistus</a>
				<br/>
				<a style="display: inline-block; text-decoration: none; vertical-align: middle;" href="#"><i style="float: left; padding-right: 3px;" class="material-icons">open_in_browser</i>Siirry</a>
			</td>';
			echo '</form>';
		}
		echo '</tr>';
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
	if ($_SESSION['type'] == 0 && isset($_GET['teamId'])) {
		$_SESSION['teamId'] = $_GET['teamId'];
		$teamId = $_SESSION['teamId'];
		$sql = "SELECT * from team WHERE id='$teamId' AND user_id='$id'";
		$result = mysqli_query($conn, $sql);
		if ($row = mysqli_fetch_array($result)) {
			$_SESSION['teamId'] = $row['id'];
			$_SESSION['teamName'] = $row['name'];
		}
		else  {
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
	echo '<td class="bold">Käyttäjänimi</td>';
	echo '<td>' . $userName . '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td class="bold">Tilintyyppi:</td>';
	if ($type == 1) {
		echo '<td>Joukkuetaso</td>';
	}
	else {
		echo '<td>Seurataso</td>';
	}

	echo '</tr>';
}

if (isset($_POST['setEventInfo'])){
	setEventInfo();
}

if (isset($_POST['setEventInfoGuide'])){
	setEventInfo('guide');
}

if (isset($_POST['setEventInfoGuide2'])){
	setEventInfo('guide2');
}

if (isset($_POST['setHomeTeam'])) {
	setHomeTeam();
}

if (isset($_POST['setHomeTeamGuide'])) {
	setHomeTeam('guide');
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

if (isset($_POST['logoUpload'])) {
	logoUpload();
}

if (isset($_GET['sendActivation'])) {
	sendEmail('resend',$_POST['teamId'],null,null,null);
	//print_r($_POST);
}
?>
