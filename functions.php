<?php

function register()
{ session_start();
	include 'dbh.php';

	$uid = $_POST['uid'];
	$email = $_POST['email'];
	$pwd = $_POST['pwd'];
	$uid = strip_tags($uid);
	$stmt = $conn->prepare("SELECT * FROM user WHERE uid = :username");
	$stmt->bindParam(":username", $uid);
	$stmt->execute();
	$result = $stmt->fetch();
	if ($result) {
		echo 'duplicate';
	}
	else
	if (empty($uid)) {
		echo 'uidEmpty';
	}
	else
	if (strlen($uid) < 4) {
    echo 'uidShort';
	}
	else
	if (empty($pwd)) {
		echo 'pwdEmpty';
	}
	else
	if (strlen($pwd) < 4) {
		echo 'pwdShort';
	}
	else
	if (preg_match('/\s/', $uid)) {
		echo 'uidInvalid';
	}
	else
	if (preg_match('/\s/', $pwd)) {
		echo 'pwdInvalid';
	}
	else
	if ($pwd !== $_POST['pwdConfirm']) {
		echo 'pwdMismatch';
	}
	else
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo 'emailInvalid';
	}
	else {

   //Aktivointikoodin luonti
		$hash = md5(rand(0, 1000));
		$hash = strip_tags($hash);

   // Salasanan kryptaus
	  require("PasswordHash.php");
    $pwdHasher = new PasswordHash(8, false);
		$pwdHash = $pwdHasher->HashPassword($pwd);

    //Joukkuetilin luonti seuran näkymästä
		if (isset($_SESSION['id'])) {
		$id = $_SESSION['id'];
		$stmt = $conn->prepare("INSERT INTO team (name,user_id) VALUES (:username, :id)");
		$stmt->bindParam(":username", $uid);
		$stmt->bindParam(":id", $id);
		$stmt->execute();

	  $stmt = $conn->prepare("SELECT * FROM team ORDER BY ID DESC LIMIT 1");
	  $stmt->execute();
    if ($row = $stmt->fetch()) {
		$teamId = $row['id'];
}
    $stmt = $conn->prepare("INSERT INTO user (uid,pwd,type,email,hash,team_id,owner_id) VALUES (:username, :passwordhash, '1', :email, :hash, :teamid, :id)");
		$stmt->bindParam(":username", $uid);
		$stmt->bindParam(":passwordhash", $pwdHash);
		$stmt->bindParam(":email", $email);
		$stmt->bindParam(":hash", $hash);
		$stmt->bindParam(":teamid", $teamId);
		$stmt->bindParam(":id", $id);
    $stmt->execute();
} else {
   //Seuratilin luonti / joukkuetilin luonti rekisteröintilomakkeesta
	  if ($_POST['regLevel'] == "joukkue") {
	  $type = '1';
	} else {
		$type = '0';
	}
		$stmt = $conn->prepare("INSERT INTO user (uid,pwd,type,email,hash) VALUES (:username, :passwordhash, :type, :email, :hash)");
		$stmt->bindParam(":username", $uid);
		$stmt->bindParam(":passwordhash", $pwdHash);
		$stmt->bindParam(":type", $type);
		$stmt->bindParam(":email", $email);
		$stmt->bindParam(":hash", $hash);
		$stmt->execute();
		$stmt = $conn->prepare("SELECT id FROM user WHERE uid = :username");
		$stmt->bindParam(":username", $uid);
		$stmt->execute();
		if ($row = $stmt->fetch()) {
			$id = $row['id'];

			// joukkuetilin luonti rekisteröintilomakkeesta
			if ($_POST['regLevel'] == "joukkue") {
			  $stmt = $conn->prepare("INSERT INTO team (name,user_id) VALUES (:username, :id)");
			  $stmt->bindParam(":username", $uid);
			  $stmt->bindParam(":id", $id);
			  $stmt->execute();

				$stmt = $conn->prepare("SELECT * FROM team ORDER BY ID DESC LIMIT 1");
			  $stmt->execute();
		    if ($row = $stmt->fetch()) {
				$teamId = $row['id'];
		}
				$stmt = $conn->prepare("UPDATE user SET owner_id = :id, team_id = :teamid  WHERE id = :id");
				$stmt->bindParam(":id", $id);
				$stmt->bindParam(":teamid", $teamId);
				$stmt->execute();

			} else {
			$stmt = $conn->prepare("UPDATE user SET owner_id = :id WHERE id = :id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();
		}
		}
	}
	// Tyhjän mainoslinkki rivin luonti
	 $stmt = $conn->prepare("INSERT INTO adlinks (owner_id) VALUES (:ownerid)");
	 $stmt->bindParam(':ownerid',$id);
	 $stmt->execute();

	if(sendEmail('reg',$uid,$pwd,$email,$hash) == FALSE) {
		echo 'emailFail';
	} else {

 if (isset($_SESSION['id'])) {
	if ($_POST['button'] != "add")  {
	echo 'teamSuccess';
} else {
	echo 'teamMore';
}
} else {
  echo 'userSuccess';
}
}
}
}
function sendEmail($mod,$uid,$pwd,$email,$hash) {
	include ('dbh.php');
	// Sähköpostin lähetys
if ($mod == 'resend') {
	$stmt = $conn->prepare("SELECT * FROM user WHERE team_id = :username");
	$stmt->bindParam(':username');
	$stmt->execute();
	$row = $stmt->fetch();
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

	$mail->SetFrom("no_reply@otteluohjelma.fi","Otteluohjelma");
	//$mail->AddReplyTo("vahvistus@otteluohjelma.fi", "Otteluohjelma");
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
}
} else {
	if ($mod == 'reg') {
	return TRUE;
}
}
}

function verifyAccount() {
	include 'dbh.php';
	if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
    $email = $_GET['email']; // Set email variable
    $hash = $_GET['hash']; // Set hash variable

    $stmt = $conn->prepare("SELECT * FROM user WHERE email= :email AND hash= :hash AND activated='0'");
		$stmt->bindParam(':email',$email);
		$stmt->bindParam(':hash',$hash);
		$stmt->execute();

    if ($row = $stmt->fetch()) {
        // We have a match, activate the account
				$stmt = $conn->prepare("UPDATE user SET activated='1' WHERE email= :email AND hash= :hash AND activated='0'");
				$stmt->bindParam(':email',$email);
				$stmt->bindParam(':hash',$hash);
				$stmt->execute();
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
function fileUpload($mod) {
	if(!isset($_SESSION)) {
	session_start();}

	if(isset($_SESSION['id'])) {
	$id = $_SESSION['id'];
	$uid = $_SESSION['uid'];
	$ownerId = $_SESSION['ownerId'];
	if(isset($_SESSION['teamId'])) {
	$teamId =	$_SESSION['teamId'];
	$teamUid =	$_SESSION['teamUid'];
}
  if (!isset($_POST['fileUpload'])) {
  setAdLinks();
}
 //Mainoksen & Logon lataus

    if (!empty($_POST['imgData'])) {
		define('UPLOAD_DIR', 'images/ads/');
		$img = $_POST['imgData'];
		if (strpos($img, 'data:image/png') !== false) {
    $img = str_replace('data:image/png;base64,', '', $img);
} else if (strpos($img, 'data:image/jpeg') !== false) {
	  $img = str_replace('data:image/jpeg;base64,', '', $img);
} else if (strpos($img, 'data:image/jpg') !== false) {
	  $img = str_replace('data:image/jpg;base64,', '', $img);
} else if (strpos($img, 'data:image/gif') !== false) {
	  $img = str_replace('data:image/gif;base64,', '', $img);
}else {
	echo 'imgInvalid';
	exit();
}
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$fileSize =  strlen($data);
		if ($fileSize >= 150000) {
			echo 'imgSize';
			exit();
		}
	} else {
		echo 'imgEmpty';
		exit();
	}
			// Rename file
			if (isset($_POST['submitAd']) && !isset($_SESSION['editEvent']) && isset($_SESSION['teamId'])) {
			 if ($mod ==1) {

			 $newfilename = UPLOAD_DIR . 'j_'. $teamUid . $teamId .'_ad1'. '.png';
		 } else if ($mod ==2) {

			$newfilename = UPLOAD_DIR . 'j_'. $teamUid . $teamId .'_ad2'. '.png';
		} else if ($mod ==3) {

			 $newfilename = UPLOAD_DIR . 'j_'. $teamUid . $teamId .'_ad3'. '.png';
		 }else if ($mod ==4) {

				 $newfilename = UPLOAD_DIR . 'j_'. $teamUid . $teamId .'_ad4'. '.png';
			 }

		 } else if (isset($_POST['submitAd']) && isset($_SESSION['editEvent']) && isset($_SESSION['teamId'])) {
			 if ($mod ==1) {

			 $newfilename = UPLOAD_DIR . 'e_'. $teamUid . $teamId .'_ad1'. '.png';
		 } else if ($mod ==2) {

			$newfilename = UPLOAD_DIR . 'e_'. $teamUid . $teamId .'_ad2'. '.png';
		} else if ($mod ==3) {

			 $newfilename = UPLOAD_DIR . 'e_'. $teamUid . $teamId .'_ad3'. '.png';
		 }else if ($mod ==4) {

			$newfilename = UPLOAD_DIR . 'e_'. $teamUid . $teamId .'_ad4'. '.png';
			 }
		 } else if (isset($_POST['submitAd']) && isset($_SESSION['editEvent']) && !isset($_SESSION['teamId'])) {
			 if ($mod ==1) {

			 $newfilename = UPLOAD_DIR . 'e_'. $ownerId .'_ad1'. '.png';
		 } else if ($mod ==2) {

			$newfilename = UPLOAD_DIR . 'e_'. $ownerId .'_ad2'. '.png';
		} else if ($mod ==3) {

			 $newfilename = UPLOAD_DIR . 'e_'. $ownerId .'_ad3'. '.png';
		 }else if ($mod ==4) {

			$newfilename = UPLOAD_DIR . 'e_'. $ownerId .'_ad4'. '.png';
			 }
		 } else if(isset($_POST['fileUpload']) && isset($_SESSION['teamId'])) {
			 $newfilename = 'images/logos/' . $teamUid . $teamId .'.png';
		 } else if(isset($_POST['fileUpload']) && !isset($_SESSION['teamId'])) {
			 $newfilename = 'images/logos/' . $uid . $id .'.png';
		 }
			else {
				if ($mod ==1) {
			$newfilename = UPLOAD_DIR . 's_'. $ownerId . '_ad1'. '.png';
				}
        else if ($mod ==2) {
			$newfilename = UPLOAD_DIR . 's_'. $ownerId . '_ad2'. '.png';
					}
				else if ($mod ==3) {
			$newfilename = UPLOAD_DIR . 's_'. $$ownerId . '_ad3'. '.png';
						}
				else if ($mod ==4) {
			$newfilename = UPLOAD_DIR . 's_'. $ownerId . '_ad4'. '.png';
							}
		}
			if (@file_put_contents($newfilename, $data)) {
			if (isset($_SESSION['editEvent'])) {
			$_SESSION['ads'][$mod-1] = $newfilename;
			echo 'eventAdSuccess';
		} else if (isset($_POST['fileUpload'])) {
			echo 'logoSuccess';
		}else {
			echo 'adSuccess';
		}
	} else {
		echo 'imgFail';
	}
		}
 }
function removeAd($mod) {

	if(!isset($_SESSION)) {
	session_start();
}
	include 'dbh.php';

	if(isset($_SESSION['teamId'])) {
	$teamId   =  $_SESSION['teamId'];
  $teamUid   =  $_SESSION['teamUid'];
}
	$ownerId = $_SESSION['ownerId'];

	$fileName = str_replace("http://localhost/otteluohjelma/","",$_POST['fileName']);
	$fileName = substr($fileName, 0, strpos($fileName, "?"));

if ($fileName != "images/default_ad.png" && file_exists($fileName)) {

if (@unlink($fileName)) {
echo 'adRemoveSuccess';
} else {
echo 'adRemoveDenied';
exit();
}
} else {
echo 'adRemoveFail';
set_error_handler('error');
}
}
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
	$stmt = $conn->prepare("SELECT * FROM user WHERE uid = :username");
	$stmt->bindParam(':username', $uid);
	$stmt->execute();

	$row = $stmt->fetch();
	//Käyttäjätunnuksen ja salasanan tarkistus
	$pwdHash = $row['pwd'];
	$check = $hasher->CheckPassword($pwd, $pwdHash);

	if ($check == FALSE) {
  echo 'pwdWrong';
}
	else if ($row['activated'] == 0) {
		echo 'notActivated';
		}
	else {
		$stmt = $conn->prepare("SELECT * FROM user WHERE uid = :username");
		$stmt->bindParam(':username',$uid);
		$stmt->execute();
		$row = $stmt->fetch();
		$type = $row['type'];
		$id = $row['id'];
		$ownerId = $row['owner_id'];
		$_SESSION['id'] = $id;
		$_SESSION['uid'] = $uid;
		$_SESSION['type'] = $type;
		$_SESSION['ownerId'] = $ownerId;

if ($type == 0) {
	echo 'loginSuccess';
		}
		else {
			echo 'loginSuccess';
			$stmt = $conn->prepare("SELECT * FROM user WHERE id = :id");
			$stmt->bindParam(':id',$id);
			$stmt->execute();
			$row = $stmt->fetch();
			$_SESSION['teamId'] = $row['team_id'];
			$_SESSION['teamUid'] = $row['uid'];
			$teamId = $_SESSION['teamId'];
			$stmt = $conn->prepare("SELECT * FROM team WHERE id = :teamid");
			$stmt->bindParam(':teamid',$teamId);
			$stmt->execute();
			$row = $stmt->fetch();
			$_SESSION['teamName'] = $row['name'];
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
if ($_POST['firstName'] && $_POST['lastName'] && $_POST['number'] && strlen(trim($_POST['firstName'])) > 0 && strlen(trim($_POST['lastName']) && strlen(trim($_POST['number'])) > 0) > 0) {
		  $firstName = $_POST['firstName'];
			$lastName = $_POST['lastName'];
			$number = $_POST['number'];
			$stmt = $conn->prepare("INSERT INTO player (user_id,team_id,firstName,lastName,number) VALUES (:id, :teamid, :firstname, :lastname, :number)");
			$stmt->bindParam(':id',$id);
			$stmt->bindParam(':teamid',$teamId);
			$stmt->bindParam(':firstname',$firstName);
			$stmt->bindParam(':lastname',$lastName);
			$stmt->bindParam(':number',$number);
      $stmt->execute();
		} else {
			echo 'savePlayerEmpty';
			exit();
		}
		if ($_POST['button'] != "add") {
	  echo 'savePlayerSuccess';
	} else {
		echo 'savePlayerMore';
	}
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

		if (!empty($team)) {
			$stmt= $conn->prepare("INSERT INTO team (name,user_id) VALUES (:team, :id)");
			$stmt->bindParam(':team',$team);
			$stmt->bindParam(':id',$id);
			$stmt->execute();
		}
	}
	$stmt = $conn->prepare("SELECT * FROM team ORDER BY ID DESC LIMIT 1");
	$stmt->execute();
	while ($row = $stmt->fetch()) {
		$teamId = $row['id'];
	}

	// Luodaan joukkuetili

	$stmt = $conn->prepare("INSERT INTO user (uid,pwd,type,team_id) VALUES ('$team','salasana','1','$teamId')");
	$stmt->bindParam(':team',$team);
	$stmt->bindParam(':teamid',$teamId);
	$stmt->execute();
	header("Location: teams.php");
}

function editUser()
{
	if(!isset($_SESSION)) {
	session_start(); }
	$id = $_SESSION["id"];
	$uid = $_SESSION['uid'];
	$teamId = $_SESSION["teamId"];
	$teamName = $_POST['name'];

	include 'dbh.php';
	require("PasswordHash.php");
	$hasher = new PasswordHash(8, false);
	$pwdHash = "*";
	$pwd = $_POST['pwd'];
	$stmt = $conn->prepare("SELECT * FROM user WHERE uid = :username");
	$stmt->bindParam(':username', $uid);
	$stmt->execute();

	$row = $stmt->fetch();
	//Käyttäjätunnuksen ja salasanan tarkistus
	$pwdHash = $row['pwd'];
	$check = $hasher->CheckPassword($pwd, $pwdHash);

	if ($check == FALSE) {
		echo 'teamPwdWrong';
	} else if (empty($teamName) || ctype_space($teamName)) {
			echo 'teamEmpty';
}
		else {
if (!empty($_POST['name'])) {
	    echo 'nameChangeSuccess';
			$stmt = $conn->prepare("UPDATE team SET name = :teamname WHERE id = :teamid");
			$stmt->bindParam(':teamname',$teamName);
			$stmt->bindParam(':teamid',$teamId);
      $stmt->execute();
			$_SESSION['teamName'] = $teamName;
		}
}
}

function updateTeam()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$teamId = $_SESSION['teamId'];
	$id = $_SESSION["id"];
	$teamUid = $_POST['teamUid'];
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
		echo $firstName . " " . $lastName . " " . $nameId . "<br />";
		if (!empty($firstName) && !empty($lastName)) {
			$stmt = $conn->prepare("UPDATE player SET firstName = :firstname, lastName = :lastname, number = :number WHERE id = :nameid");
			$stmt->bindParam(':firstname',$firstName);
			$stmt->bindParam(':lastname',$lastName);
			$stmt->bindParam(':number',$number);
			$stmt->bindParam(':nameid',$nameId);
			$stmt->execute();
			$i++;
		}
	}
	header("Location: team.php?teamId=$teamId");
}

function removePlayer()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$teamId = $_SESSION['teamId'];
	$removeId = $_GET['removePlayer'];
	$stmt = $conn->prepare("DELETE FROM player WHERE id = :removeid");
	$stmt->bindParam(':removeid',$removeId);
	$stmt->execute();
	header("Location: edit.php");
}

function removeEvent()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$id = $_SESSION['id'];
	$removeId = $_GET['removeEvent'];
	$stmt = $conn->prepare("DELETE FROM event WHERE id = :removeid AND owner_id = :id");
	$stmt->bindParam(':removeid',$removeId);
	$stmt->bindParam(':id',$id);
	if ($stmt->execute()) {
		unlink('files/overview' . $removeId . '.json');
		unlink('images/ads/event/' . $removeId . '_ad1.png');
		unlink('images/ads/event/' . $removeId . '_ad2.png');
		unlink('images/ads/event/' . $removeId . '_ad3.png');
		unlink('images/ads/event/' . $removeId . '_ad4.png');
	}

	header("Location: profile.php");
}

function removeTeam()
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';
	require("PasswordHash.php");
	$id = $_SESSION['id'];
	$uid = $_SESSION['uid'];
	$teamId = $_SESSION['teamId'];
	$hasher = new PasswordHash(8, false);
	$pwdHash = "*";
	$pwd = $_POST['pwd'];
	$stmt = $conn->prepare("SELECT * FROM user WHERE uid = :username");
	$stmt->bindParam(':username', $uid);
	$stmt->execute();

	$row = $stmt->fetch();
	//Käyttäjätunnuksen ja salasanan tarkistus
	$pwdHash = $row['pwd'];
	$check = $hasher->CheckPassword($pwd, $pwdHash);

	if ($check == FALSE) {
  echo 'teamPwdWrong';
	} else {
	$stmt = $conn->prepare("DELETE FROM team WHERE id = :teamid AND user_id = :id");
	$stmt->bindParam(':teamid',$teamId);
	$stmt->bindParam(':id',$id);

	$stmt2 = $conn->prepare("DELETE FROM user WHERE team_id = :teamid AND owner_id = :id");
	$stmt2->bindParam(':teamid',$teamId);
	$stmt2->bindParam(':id',$id);

	$stmt3 = $conn->prepare("DELETE FROM player WHERE team_id = :teamid AND user_id = :id");
	$stmt3->bindParam(':teamid',$teamId);
	$stmt3->bindParam(':id',$id);
	$stmt3->execute();

	$stmt4 = $conn->prepare("DELETE FROM adlinks WHERE team_id = :teamid");
	$stmt4->bindParam(':teamid',$teamId);
	$stmt4->execute();

	if ($stmt->execute() && $stmt2->execute()) {
		echo 'teamRemoveSuccess';
		unset($_SESSION['teamId']);
		unset($_SESSION['teamUid']);
		unset($_SESSION['teamName']);
} else {
	set_error_handler('error');
	exit();
}
}
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

	}
	if (!empty($_POST['visitorName'])) {
  $_SESSION['visitorName'] = $_POST['visitorName'];
}
if ($_POST['button'] != "add") {
	echo 'event3PlayerSuccess';
} else {
	echo 'event3More';
}
}

function setEventInfo($mod)
{
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

$_SESSION['eventName'] = $_POST['eventName'];
$_SESSION['eventPlace'] = $_POST['eventPlace'];
$_SESSION['eventDate'] = $_POST['eventDate'];
	echo "event1Success";
}
function setHomeTeam($mod) {
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

	$i = 0;
	unset($_SESSION['saved']);
	foreach( $_POST['homeNumbers'] as $value) {
    $_SESSION['saved']['home']['number'][$i] = $_POST['homeNumbers'][$i]['value'];
		$i++;
	}

	$i = 0;
	foreach( $_POST['homeFirstNames'] as $value) {
		$_SESSION['saved']['home']['firstName'][$i] = $_POST['homeFirstNames'][$i]['value'];
		$i++;
	}

	$i = 0;
	foreach( $_POST['homeLastNames'] as $value) {
		$_SESSION['saved']['home']['lastName'][$i] = $_POST['homeLastNames'][$i]['value'];
		$i++;
	}

	//$eventId = $_SESSION['eventId'];

	if ($mod == '4') {
	header("Location:event4.php");
}
else if ($mod == '5') {
header("Location:event5.php");
}
	else if ($mod == '6') {
	header("Location:event_overview.php?c");
} else {
	echo 'event2Success';
}
}

function setVisitorTeam($mod)
{
	if(!isset($_SESSION)) {
	session_start(); }
if ($_POST['visitorName']) {
$_SESSION['visitorName'] = $_POST['visitorName'];
}
	 if ($mod == '5') {
	  header("Location:event5.php");
	 }
	 else if ($mod == '6') {
		header("Location:event_overview.php?c");
	} else {
		  echo 'event3Success';
		}
}
function validateEvent() {
	if(!isset($_SESSION)) {
	session_start(); }
	if (isset($_SESSION['eventId'])) {
	$eventId = $_SESSION['eventId'];
	}
	if (isset($_POST['setEventInfo'])) {
	if (empty($_POST['eventName']) || empty($_POST['eventPlace']) || empty($_POST['eventDate'])) {
		echo 'event1Empty';
		return false;
		exit();
	} }
	if (isset($_POST['setHomeTeam'])) {
	if (empty($_POST['homeNumbers'])){
		echo 'event2Empty';
		return false;
		exit();
	} }
	if (isset($_POST['setVisitorTeam'])) {
	if (!isset($_SESSION['visitors'])) {
		echo 'event3TeamEmpty';
		return false;
		exit();
	} }
	if (isset($_POST['setVisitorTeam'])) {
	if (empty($_POST['visitorName'])) {
		echo 'event3NameEmpty';
		return false;
		exit();
	} }
	if (isset($_POST['addVisitor'])) {
	if (preg_match('/\s/',$_POST['firstName']) || preg_match('/\s/',$_POST['lastName']) || preg_match('/\s/',$_POST['number'])) {
		echo 'event3PlayerEmpty';
		return false;
		exit();
	} }
		return true;
}
function showHome()
{
	if(!isset($_SESSION)) {
	session_start(); }

	if (isset($_SESSION['eventId'])) {
	$eventId = $_SESSION['eventId'];
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
		if (isset($_SESSION['home'])) {
		foreach($_SESSION['old']['firstName'] as $value) {
			$showFirst = $_SESSION['old']['firstName'][$i];
			$showLast = $_SESSION['old']['lastName'][$i];
			$showNum = $_SESSION['old']['number'][$i];
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
	} else {
		echo '<h4 style="color:gray">Lisää kotijoukkueen pelaajat!</h4>';
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
} else {
	echo '<h4 style="color:gray">Lisää vierasjoukkueen pelaajat!</h4>';
}
}

function listVisitors()
{
	if(!isset($_SESSION)) {
	session_start(); }
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
		//Pelipaikka
		echo '<td></td>';
		echo '<td><a href="functions.php?removeVisitor=' . $i . '" id="iconRemove"><i class="material-icons">delete</i></a></td>';
		/*echo '<input type="hidden" id="number" name="number[' . $i . ']" value="' . $showNum . '">';
		echo '<input type="hidden" id="firstName" name="firstName[' . $i . ']" value="' . $showFirst . '">';
		echo '<input type="hidden" id="lastName" name="lastName[' . $i . ']" value="' . $showLast . '">';*/
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
	if (isset($_SESSION['teamId'])) {
	$teamId = $_SESSION['teamId'];
} else {
	$eventId = $_SESSION['eventId'];
	$stmt = $conn->prepare("SELECT * from event WHERE id = :eventid");
	$stmt->bindParam(':eventid',$eventId);
	$stmt->execute();
	$row = $stmt->fetch();
	$teamId = $row['team_id'];
}
	$i = 0;
	$stmt = $conn->prepare("SELECT * from player WHERE team_id = :teamid");
	$stmt->bindParam(':teamid',$teamId);
	$stmt->execute();

	/*while ($row = $stmt->fetch()) {
	  $showId = $row['id'];
		$_SESSION['home']['firstName'][$i] = $row['firstName'];
		$_SESSION['home']['lastName'][$i] = $row['lastName'];
		$_SESSION['home']['number'][$i] = $row['number'];
		$i++;
	}*/
	if ($stmt->rowCount() > 0 || isset($_SESSION['eventId'])) {
	$i = 0;
	foreach($_SESSION['home']['firstName'] as $value) {
		$showId = $i;
		$showFirst = $_SESSION['home']['firstName'][$i];
		$showLast = $_SESSION['home']['lastName'][$i];
		$showNum = $_SESSION['home']['number'][$i];
		echo '<tr id="' . $showId . '">';
		echo '<td>';
		echo '<i onclick="removePlayer(&quot;' . $showId . '&quot;, &quot;' . $showFirst . '&quot;, &quot;' . $showLast . '&quot;, &quot;' . $showNum . '&quot;)" style="font-size:25px;cursor: pointer;color:red" class="material-icons">close</i>';
		echo '</td>';
		echo '<td class="all img" id="playerpic' . $i . '"><img style="width: 35px; vertical-align: middle;" src="images/default.png"></td>';
		echo '<td class="all" id="number' . $i . '">' . $showNum . '</td>';
		echo '<td class="all" style="text-transform: capitalize;" id="first' . $i . '">' . $showFirst . '</td>';
		echo '<td class="all" style="text-transform: capitalize;" id="last' . $i . '">' . $showLast . '</td>';
		echo '<input class="numbers" type="hidden" name="number' . $i . '" value="' . $showNum . '">';
		echo '<input class="firstnames" type="hidden" name="firstName' . $i . '" value="' . $showFirst . '">';
		echo '<input class="lastnames" type="hidden" name="lastName' . $i . '" value="' . $showLast . '">';
		echo '</tr>';
		$i++;
	}
} else {
	echo '<h3 style="color:gray">Ei pelaajia</h3>';
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
			$stmt = $conn->prepare("SELECT * from event WHERE team_id = :teamid ");
			$stmt->bindParam(':teamid',$teamId);
	}

	if ($mod == "upcoming") {
		if (!isset($_SESSION['teamId'])) {
			$stmt = $conn->prepare("SELECT * from event WHERE date >= CURDATE() AND owner_id = :id");
			$stmt->bindParam(':id',$id);
		}
		else {
			$stmt = $conn->prepare("SELECT * from event WHERE date >= CURDATE() AND team_id = :teamid");
			$stmt->bindParam(':teamid',$teamId);
		}
	}

	if ($mod == "past") {
		if (!isset($_SESSION['teamId'])) {
			$stmt = $conn->prepare("SELECT * from event WHERE date < CURDATE() AND owner_id = :id");
			$stmt->bindParam(':id',$id);
		}
		else {
			$stmt = $conn->prepare("SELECT * from event WHERE date < CURDATE() AND team_id = :teamid");
			$stmt->bindParam(':teamid',$teamId);
		}
	}

	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo '<table class="u-full-width">';
		if ($mod != 'all') {
			echo '<thead>
			 <tr>
				 <th>Tapahtuman nimi</th>';
				if (!isset($_SESSION['teamId'])) {
				echo '<th>Joukkue</th>';
			}
				echo '<th>Päivämäärä</th>
					</tr>
				</thead>
				<tbody>';
     } else {
		 echo '<thead>
			 <tr>
		 <th>Laji</th>
		 <th>Tapahtuman nimi</th>
			 </tr>
		 </thead>
		 <tbody>
		 <tr>';
	 }
	while ($row = $stmt->fetch()) {
		$showId = $row['id'];
		$showName = $row['name'];
		$showTeam = $row['team_id'];
		$showDate = strtotime($row['date']);
		$showDate = date("d.m.Y", $showDate);

		if ($mod != "all") {
		echo '<td><a style="text-decoration:none;" href="event_overview.php?eventId=' . $showId . '">' . $showName . '</a></td>';
		if (!isset($teamId)) {
			$stmt2 = $conn->prepare("SELECT * from user WHERE team_id = :teamid");
			$stmt2->bindParam(':teamid',$showTeam);
			$stmt2->execute();
			$row2 = $stmt2->fetch();
			$teamUid = $row2['uid'];
			echo '<td><p style="margin-bottom: 0;">' . $teamUid . '</p></td>';
		}
			echo '<td><p style="margin-bottom: 0;">' . $showDate . '</p></td>';
		}
		else {
			$encodeName = rawurlencode($eventName);
			$fileDest = glob('files/overview_'. $encodeName . '_' . $showId .'_*.json');
			$fileDest = substr(strstr($fileDest[0], '_'), strlen('_'));
			$fileDest = substr($fileDest, 0, strpos($fileDest, "."));

			echo '<td><img src="default_team.png"></td>';
			echo '<td><a style="text-decoration:none;" href="event_overview.php?eventId=' . $showId . '">' . $showName . '</a></td>';
			//echo "<td><a target='_blank' href='inc/widgets/ottelu/index.php?eventId=". $fileDest ."'><i class='material-icons'>input</i></a></td>";
		}
		echo "</tr></tbody>";
		$i++;
}} else {
		echo '<h4 style="color:gray">Ei tapahtumia</h4>';
	}
}

function eventData()
{
	include 'dbh.php';
	if(!isset($_SESSION)) {
	session_start(); }
	$_SESSION['editEvent'] = true;
	$id = $_SESSION['id'];
	$ownerId = $_SESSION['ownerId'];
	$_SESSION['eventId'] = $_GET['eventId'];
	$eventId = $_SESSION['eventId'];
	if (isset($_SESSION['teamId'])) {
	$teamId = $_SESSION['teamId'];
} else {
	$stmt = $conn->prepare("SELECT * from event WHERE id= :eventid AND owner_id = :id");
	$stmt->bindParam(':eventid',$eventId);
	$stmt->bindParam(':id',$id);
	$stmt->execute();
	if ($row = $stmt->fetch()) {
		$_SESSION['teamId'] = $row['team_id'];
		$teamId = $_SESSION['teamId'];
	}
	$stmt = $conn->prepare("SELECT * from user WHERE team_id= :teamid");
	$stmt->bindParam(':teamid',$teamId);
	$stmt->execute();
	if ($row = $stmt->fetch()) {
		$_SESSION['teamUid'] = $row['uid'];
	}
	$stmt = $conn->prepare("SELECT * from team WHERE id= :teamid");
	$stmt->bindParam(':teamid',$teamId);
	$stmt->execute();
	if ($row = $stmt->fetch()) {
		$_SESSION['teamName'] = $row['name'];
	}
}

$i = 0;
$stmt = $conn->prepare("SELECT * from player WHERE team_id = :teamid");
$stmt->bindParam(':teamid',$teamId);
$stmt->execute();

while ($row = $stmt->fetch()) {
	$showId = $row['id'];
	$_SESSION['home']['firstName'][$i] = $row['firstName'];
	$_SESSION['home']['lastName'][$i] = $row['lastName'];
	$_SESSION['home']['number'][$i] = $row['number'];
	$i++;
}

	if (!empty($_SESSION['eventId'])) {
		if ($_SESSION['type'] == 0) {
			$stmt = $conn->prepare("SELECT * from event WHERE id= :eventid AND owner_id = :id");
			$stmt->bindParam(':eventid',$eventId);
			$stmt->bindParam(':id',$id);
		}
		else {
			$stmt = $conn->prepare("SELECT * from event WHERE id= :eventid AND team_id = :teamid");
			$stmt->bindParam(':eventid',$eventId);
			$stmt->bindParam(':teamid',$teamId);
		}
      $stmt->execute();
		if ($row = $stmt->fetch()) {
			$eventId = $row['id'];
			$eventName = $row['name'];
			$encodeName = rawurlencode($eventName);
			$fileDest = glob('files/overview_'. $eventId . '_' . $encodeName . '_*.json');
			$json = file_get_contents($fileDest[0]);
			$json = json_decode($json, true);
			if (!isset($_GET['c'])) {
				$_SESSION['eventName'] = $json['eventinfo'][0];
				$_SESSION['eventPlace'] = $json['eventinfo'][1];
				$_SESSION['eventDate'] = $json['eventinfo'][2];
				if (!empty($json['eventinfo'][3])) {
				$_SESSION['matchText'] = $json['eventinfo'][3];
			}
				$_SESSION['homeName'] = $json['teams']['home'][0];
				$_SESSION['visitorName'] = $json['teams']['visitors'][0];

        fetchAds();
				$i = 0;
        $j = 0;
				foreach($json['teams']['home']['players'] as $value) {

				$_SESSION['old']['firstName'][$j] = $json['teams']['home']['players'][$j]['first'];
				$_SESSION['old']['lastName'][$j] = $json['teams']['home']['players'][$j]['last'];
				$_SESSION['old']['number'][$j] = $json['teams']['home']['players'][$j]['number'];

					$j++;
				}
			$_SESSION['home']['firstName'] = array_values($_SESSION['home']['firstName']);
			$_SESSION['home']['lastName'] = array_values($_SESSION['home']['lastName']);
			$_SESSION['home']['number'] = array_values($_SESSION['home']['number']);

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
  $homeName = $_SESSION['homeName'];
	$visitorName = $_SESSION['visitorName'];
	$eventName = $_SESSION['eventName'];
	$eventPlace = $_SESSION['eventPlace'];
	$eventDate = $_SESSION['eventDate'];
	$matchText = "";
	$plainMatchText = "";
	if (isset($_SESSION['matchText'])) {
		$matchText = $_SESSION['matchText'];
}
  if (isset($_SESSION['plainMatchText'])) {
    $plainMatchText = $_SESSION['plainMatchText'];
}
	$date = date_create($eventDate);
	$realDate = date_format($date, "Y-m-d");
	$overview = array(
		'eventinfo' => array(
			$eventName,
			$eventPlace,
			$eventDate,
			$matchText,
			$plainMatchText
		) , 'ads' => array(
				'images' => array(),
				'links' => array()
		),

		'teams' => array(
			'home' => array(
				$homeName,
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
		$stmt = $conn->prepare("UPDATE event SET name = :eventname,date = :realdate WHERE id = :eventid");
		$stmt->bindParam(':eventname',$eventName);
		$stmt->bindParam(':realdate',$realDate);
		$stmt->bindParam(':eventid',$eventId);
		$stmt->execute();
	}
	else {
		$stmt = $conn->prepare("SELECT * from user WHERE id = :id");
		$stmt->bindParam(':id',$id);
		$stmt->execute();
		$row = $stmt->fetch();
		$ownerId = $row['owner_id'];
		$stmt = $conn->prepare("INSERT INTO event (user_id,team_id,owner_id,name,date) VALUES ('$id','$teamId','$ownerId','$eventName','$realDate')");
		$stmt->bindParam(':id',$id);
		$stmt->bindParam(':teamid',$teamId);
		$stmt->bindParam(':ownerid',$ownerId);
		$stmt->bindParam(':eventname',$eventName);
		$stmt->bindParam(':realdate',$realDate);
		$stmt->execute();
	}

	// Haetaan tapahtuman ID

	$stmt = $conn->prepare("SELECT * from event WHERE user_id = :id AND name = :eventname");
	$stmt->bindParam(':id',$id);
	$stmt->bindParam(':eventname',$eventName);
	$stmt->execute();
	while ($row = $stmt->fetch()) {
		$eventId = $row['id'];
	}

	// Vanhojen mainoksien poisto
	if (file_exists('images/ads/event/' . $eventId . '_ad1.png')){
	unlink('images/ads/event/' . $eventId . '_ad1.png');
}
  if (file_exists('images/ads/event/' . $eventId . '_ad2.png')){
	unlink('images/ads/event/' . $eventId . '_ad2.png');
}
  if (file_exists('images/ads/event/' . $eventId . '_ad3.png')){
	unlink('images/ads/event/' . $eventId . '_ad3.png');
}
  if (file_exists('images/ads/event/' . $eventId . '_ad4.png')){
	unlink('images/ads/event/' . $eventId . '_ad4.png');
}

	// Mainoksien tallennus
	if (isset($_SESSION['ads'])) {
	$i = 0;
	foreach($_SESSION['ads'] as $key => $value) {
	$filename = $value;
	$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
	$file_ext = substr($filename, strripos($filename, '.')); // get file name
	$newfilename = $eventId . "_ad". ($key+1) . $file_ext;
	$overview['ads']['images'][$key] = $newfilename;
	if (!empty($_SESSION['adlinks'][$i])) {
	$overview['ads']['links'][$key] = $_SESSION['adlinks'][$key];
}
	if (copy($filename, "images/ads/event/" . $newfilename)) {
	if (strpos($filename, 'e_') !== false) {
	unlink($filename);
}
	$i++;
} else {
	set_error_handler('error');
	unset($_SESSION['eventId']);
	unset($_SESSION['homeName']);
	unset($_SESSION['visitorName']);
	unset($_SESSION['eventName']);
	unset($_SESSION['eventPlace']);
	unset($_SESSION['eventDate']);
	unset($_SESSION['matchText']);
	unset($_SESSION['plainMatchText']);
	unset($_SESSION['home']);
	unset($_SESSION['visitors']);
	unset($_SESSION['saved']);
	unset($_SESSION['ads']);
	unset($_SESSION['adlinks']);
	unset($_SESSION['editEvent']);
	exit();
}
}
}

	// luodaan json

	$json = json_encode($overview);

	// kirjoitetaan tiedosto
  $hash = md5($eventId);
	$encodeName = rawurlencode($eventName);
	$fp = fopen('files/overview_'. $eventId . '_' . $encodeName .'_'. $hash .'.json', 'wb');

	if (fwrite($fp, $json)) {
		echo 'createLink='. $eventId . '_' . $encodeName .'_'. $hash;
	}
	else {
    echo 'eventFail';
	}
	fclose($fp);

	// Tyhjennetään Tapahtumamuuttujat

	unset($_SESSION['eventId']);
	unset($_SESSION['homeName']);
	unset($_SESSION['visitorName']);
	unset($_SESSION['eventName']);
	unset($_SESSION['eventPlace']);
	unset($_SESSION['eventDate']);
	unset($_SESSION['matchText']);
	unset($_SESSION['plainMatchText']);
	unset($_SESSION['home']);
	unset($_SESSION['visitors']);
	unset($_SESSION['saved']);
	unset($_SESSION['ads']);
	unset($_SESSION['adlinks']);
	unset($_SESSION['editEvent']);
	unset($_SESSION['old']);
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
		unset($_SESSION['teamUid']);
	}

	$stmt = $conn->prepare("SELECT * from team WHERE user_id='$id'");
	$stmt->execute();
  while ($row = $stmt->fetch()) {
  $teamId = $row['id'];
  $showId = $row['id'];

	$stmt2 = $conn->prepare("SELECT * from user WHERE team_id='$teamId'");
	$stmt2->execute();
  $row2 = $stmt2->fetch();
	$showName = $row2['uid'];

	$fileName = 'images/logos/'.$showName.$teamId.'.png';
	if (file_exists($fileName)){
	$logo = 'images/logos/'.$showName.$teamId.'.png';
} else {
	$logo = "images/default_team.png";
}
		echo '<tr style="min-height: 80px; height: 80px;">';
		echo '<td><img style="width: 35px; height: 35px; vertical-align: middle;" src="'.$logo.'"></td>';
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
	$stmt = $conn->prepare("SELECT * from player WHERE team_id = :teamid");
	$stmt->bindParam(':teamid',$teamId);
	if ($stmt->execute()) {
		if ($stmt->rowCount() > 0) {
			echo '<script>
      document.getElementById("edit").style="display:initial";
			</script>';
			echo '<thead>
				<tr>
					<th>Avatar</th>
					<th>Nro</th>
					<th>Etunimi</th>
					<th>Sukunimi</th>
					<th>Pelipaikka</th>
				</tr>
			</thead>';
		while ($row = $stmt->fetch()) {
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
		echo '<h3 style="color:gray">Ei pelaajia</h3>';
	}
}
	else {
		set_error_handler('error');
		exit();
	}
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
		$stmt = $conn->prepare("SELECT * from user WHERE team_id = :teamid AND owner_id = :id");
		$stmt->bindParam(':teamid',$teamId);
		$stmt->bindParam(':id',$id);
		$stmt->execute();

		$stmt2 = $conn->prepare("SELECT * from team WHERE id = :teamid AND user_id = :id");
		$stmt2->bindParam(':teamid',$teamId);
		$stmt2->bindParam(':id',$id);
		$stmt2->execute();
		if ($row2 = $stmt2->fetch()) {
		$_SESSION['teamName'] = $row2['name'];
		}
		if ($row = $stmt->fetch()) {
			$_SESSION['teamId'] = $row['team_id'];
			$_SESSION['teamUid'] = $row['uid'];
		}
		else  {
			unset($_SESSION['teamId']);
			unset($_SESSION['teamUid']);
			set_error_handler('error');
			exit();
		}
	}
	else {
		if (isset($_GET['teamId'])) {
			$teamId = $_SESSION['teamId'];
			$stmt = $conn->prepare("SELECT * from user WHERE team_id = :teamid");
			$stmt->bindParam(':teamid',$teamId);
			$stmt->execute();
			$row = $stmt->fetch();
			if ($_GET['teamId'] == $row['team_id']) {
				$_SESSION['teamId'] = $_GET['teamId'];
				$stmt = $conn->prepare("SELECT * from team WHERE id = :teamid");
				$stmt->bindParam(':teamid',$teamId);
				$stmt->execute();
				if ($row = $stmt->fetch()) {
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
	$stmt = $conn->prepare("SELECT * from player WHERE team_id = :teamid");
	$stmt->bindParam(':teamid',$teamId);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
  echo "<table class='u-full-width'>";
	while ($row = $stmt->fetch()) {
		$showId = $row['id'];
		$showFirst = $row['firstName'];
		$showLast = $row['lastName'];
		$showNum = $row['number'];
		echo '<tr>';
		echo '<td class="fetch img" id="playerpic' . $i . '"><img style="width: 35px; vertical-align: middle;" src="images/default.png"></td>';
		echo '<td class="fetch" id="number' . $i . '"><input type="text" style="width:60px;" name="number' . $i . '"value="' . $showNum . '"></td>';
		echo '<td class="fetch" style="text-transform: capitalize;" id="first' . $i . '"><input type="text" style="width:120px;" name="first' . $i . '"value="' . $showFirst . '"></td>';
		echo '<td class="fetch" style="text-transform: capitalize;" id="last' . $i . '"><input type="text" style="width:160px;" name="last' . $i . '"value="' . $showLast . '"></td>';
		echo '<td><a href="functions.php?removePlayer=' . $showId . '" id="iconRemove"><i class="material-icons">delete</i></a></td>';
		echo '<input type="hidden" name="id' . $i . '" value="' . $showId . '">';
		echo '</tr>';
		$i++;
	}
echo '</table>';
} else {
	echo '<script>window.location = "team.php"</script>';
}
}

function newEvent()
{
	include 'dbh.php';
	if(!isset($_SESSION)) {
	session_start(); }
	$teamId = $_SESSION['teamId'];
	$i = 0;
  $stmt = $conn->prepare("SELECT * from player WHERE team_id = :teamid");
  $stmt->bindParam(':teamid',$teamId);
  $stmt->execute();

  while ($row = $stmt->fetch()) {
  	$showId = $row['id'];
  	$_SESSION['home']['firstName'][$i] = $row['firstName'];
  	$_SESSION['home']['lastName'][$i] = $row['lastName'];
  	$_SESSION['home']['number'][$i] = $row['number'];
  	$i++;
  }

 fetchAds();
}

function error()
{
	header("Location: error.php");
}

function userData($mod)
{ 	include 'dbh.php';
	if(!isset($_SESSION)) {
	session_start();
}
	$id = $_SESSION['id'];
	$teamId = "";
	if (isset($_SESSION['teamId'])) {
	$teamId = $_SESSION['teamId'];
	$teamUid = $_SESSION['teamUid'];
	$teamName = $_SESSION['teamName'];
	}
	$stmt = $conn->prepare("SELECT * FROM user WHERE team_id = :teamid");
	$stmt->bindParam(':teamid',$teamId);
	$stmt->execute();
	$row = $stmt->fetch();
	$userName = $row['uid'];
	$type = $row['type'];
  if ($mod == 'view') {
	echo '<tr>';
	echo '<td class="bold">Käyttäjänimi</td>';
	echo '<td>' . $userName . '</td>';
	echo '</tr>';
}
if (isset($_SESSION['teamId'])) {
	echo '<tr>';
	echo '<td class="bold">Joukkueen nimi</td>';
	if ($mod == 'view') {
	echo '<td>' . $teamName . '</td>';
} else {
	echo '<td><input type="text" name="name" id="name" value="' . $teamName . '"</td>';
}
	echo '</tr>';
}
if ($mod == 'view') {
	echo '<tr>';
	echo '<td class="bold">Tilintyyppi</td>';
	if ($type == 1) {
		echo '<td>Joukkuetaso</td>';
	}
	else {
		echo '<td>Seurataso</td>';
	}
}
	echo '</tr>';
}
function setMatchText($mod) {
	if(!isset($_SESSION)) {
	session_start();
	}
unset($_SESSION['matchText']);
unset($_SESSION['plainMatchText']);
if ($_POST['matchText'] && !empty($_POST['matchText']) && $_POST['matchText'] != '{"ops":[{"insert":"\n"}]}') {
	$_SESSION['matchText'] = $_POST['matchText'];
	$_SESSION['plainMatchText'] = $_POST['plainMatchText'];
}
if ($mod == "6"){
	header("Location: event_overview.php?c");
}
else {
	header("Location:event5.php");
}
}
function listAdLinks() {
	if(!isset($_SESSION)) {
	session_start();}
	include('dbh.php');
	$link1= $link2 = $link3 = $link4 = "";
	if(isset($_SESSION['teamId'])) {
	$teamId= $_SESSION['teamId'];
	}
  $ownerId = $_SESSION['ownerId'];
	if(isset($_SESSION['teamId'])) {
	$stmt = $conn->prepare("SELECT * FROM adlinks WHERE team_id = :teamid");
	$stmt->bindParam(":teamid", $teamId);
	} else {
	$stmt = $conn->prepare("SELECT * FROM adlinks WHERE owner_id = :ownerid");
	$stmt->bindParam(":ownerid", $ownerId);
  }
	$stmt->execute();
	if ($row = $stmt->fetch()) {
	$link1 = $row['link1'];
	$link2 = $row['link2'];
	$link3 = $row['link3'];
	$link4 = $row['link4'];
}
if (isset($_SESSION['adlinks'][0])) {
	$link1 = $_SESSION['adlinks'][0];
}
if (isset($_SESSION['adlinks'][1])) {
	$link2 = $_SESSION['adlinks'][1];
}
if (isset($_SESSION['adlinks1'][2])) {
	$link3 = $_SESSION['adlinks'][2];
}
if (isset($_SESSION['adlinks'][3])) {
	$link4 = $_SESSION['adlinks'][3];
}
	echo '
	<br>
	<label id="linkHeader" style="display:none" for="link">Mainoksen linkki</label>
	<p style="font-size:20px;font-weight:400;display:inline-block">www.</p>
	<input style="display:none" type="text" name="link" name="link1" id="link1" value="'.$link1.'">
	<input style="display:none" type="text" name="link" name="link2" id="link2" value="'.$link2.'">
	<input style="display:none" type="text" name="link" name="link3" id="link3" value="'.$link3.'">
	<input style="display:none" type="text" name="link" name="link4" id="link4" value="'.$link4.'">';
}
function setAdLinks() {
	if(!isset($_SESSION)) {
	session_start();}
	include('dbh.php');
	if (isset($_SESSION['teamId'])) {
		$teamId = $_SESSION['teamId'];
	}
	$ownerId = $_SESSION['ownerId'];

  //$pattern = '/(?:https?:\/\/)?(?:[a-zA-Z0-9.-]+?\.(?:[a-zA-Z])|\d+\.\d+\.\d+\.\d+)/';
	$pattern = '(^www\.|^http(.*)|\`|\~|\!|\@|\#|\$|^\%|\^|\&|\*|\(|\)|\+|\[|\{|\]|\}|\||\\|\'|\<|\,|^\.|\.$|\,$|\>|^\?|^\/|\"|\;|^\:|\s)i';

  if (!empty($_POST['imgData'] || isset($_SESSION['ads'][0]))) {
  if (!preg_match($pattern, $_POST['link1'])) {
	if (isset($_SESSION['editEvent'])) {
  $_SESSION['adlinks'][0] = $_POST['link1'];
	} else {
 	$link = $_POST['link1'];
	if (isset($_SESSION['teamId'])) {
  $stmt = $conn->prepare("UPDATE adlinks SET link1 = :adlink WHERE team_id = :teamid");
	$stmt->bindParam(':teamid',$teamId);
} else {
	$stmt = $conn->prepare("UPDATE adlinks SET link1 = :adlink WHERE owner_id = :ownerid");
	$stmt->bindParam(':ownerid',$ownerId);
}
 	$stmt->bindParam(':adlink',$link);
 	$stmt->execute();
}
  } else {
  	echo 'adlink1Invalid';
  	exit();
  }
  }
  if (!empty($_POST['imgData'] || isset($_SESSION['ads'][1]))) {
  if (!preg_match($pattern, $_POST['link2'])) {
		if (isset($_SESSION['editEvent'])) {
	  $_SESSION['adlinks'][1] = $_POST['link2'];
		} else {
	$link = $_POST['link2'];
	if (isset($_SESSION['teamId'])) {
	$stmt = $conn->prepare("UPDATE adlinks SET link2 = :adlink WHERE team_id = :teamid");
	$stmt->bindParam(':teamid',$teamId);
} else {
	$stmt = $conn->prepare("UPDATE adlinks SET link2 = :adlink WHERE owner_id = :ownerid");
	$stmt->bindParam(':ownerid',$ownerId);
}
 	$stmt->bindParam(':adlink',$link);
 	$stmt->execute();
}
  } else {
  	echo 'adlink2Invalid';
  	exit();
  }
  }
  if (!empty($_POST['link3']) && (!empty($_POST['imgData']) || isset($_SESSION['ads'][2]))) {
  if (preg_match($pattern, $_POST['link3'])) {
		if (isset($_SESSION['editEvent'])) {
	  $_SESSION['adlinks'][2] = $_POST['link3'];
		} else {
	$link = $_POST['link3'];
	$stmt = $conn->prepare("UPDATE adlinks SET link3= :adlink  WHERE owner_id= :ownerid");
 	$stmt->bindParam(':adlink',$link);
	$stmt->bindParam(':ownerid',$ownerId);
	$stmt->bindParam(':teamid',$teamId);
 	$stmt->execute();
}
  } else {
  	echo 'adlink3Invalid';
  }
  }
  if (!empty($_POST['link4']) && (!empty($_POST['imgData']) || isset($_SESSION['ads'][3]))) {
  if (preg_match($pattern, $_POST['link4'])) {
		if (isset($_SESSION['editEvent'])) {
	  $_SESSION['adlinks'][3] = $_POST['link4'];
		} else {
	$link = $_POST['link4'];
	$stmt = $conn->prepare("UPDATE adlinks SET link4= :adlink WHERE owner_id= :ownerid");
 	$stmt->bindParam(':adlink',$link);
	$stmt->bindParam(':ownerid',$ownerId);
	$stmt->bindParam(':teamid',$teamId);
 	$stmt->execute();
}
  } else {
  	echo 'adlink4Invalid';
  }
  }
}
function fetchAds() {
	if(!isset($_SESSION)) {
	session_start();}
	include('dbh.php');
	if (isset($_SESSION['teamId'])) {
		$teamId = $_SESSION['teamId'];
	}
	$ownerId = $_SESSION['ownerId'];
	$teamUid = $_SESSION['teamUid'];

	// Seuran asettamat mainokset
	$fileName1s = 'images/ads/s_'.$ownerId.'_ad1.png';
	$fileName2s = 'images/ads/s_'.$ownerId.'_ad2.png';
	$fileName3s = 'images/ads/s_'.$ownerId.'_ad3.png';
	$fileName4s = 'images/ads/s_'.$ownerId.'_ad4.png';

	// Joukkueen asettamat mainokset
	$fileName1j = 'images/ads/j_'.$teamUid.$teamId.'_ad1.png';
	$fileName2j = 'images/ads/j_'.$teamUid.$teamId.'_ad2.png';
	$fileName3j = 'images/ads/j_'.$teamUid.$teamId.'_ad3.png';
	$fileName4j = 'images/ads/j_'.$teamUid.$teamId.'_ad4.png';

if (file_exists($fileName1s)){
$_SESSION['ads'][0] = $fileName1s;
} else if (file_exists($fileName1j)){
$_SESSION['ads'][0] = $fileName1j;
}
if (file_exists($fileName2s)){
$_SESSION['ads'][1] = $fileName2s;
} else if (file_exists($fileName2j)){
$_SESSION['ads'][1] = $fileName2j;
}
if (file_exists($fileName3s)){
$_SESSION['ads'][2] = $fileName3s;
} else if (file_exists($fileName3j)){
$_SESSION['ads'][2] = $fileName3j;
}
if (file_exists($fileName4s)){
$_SESSION['ads'][3] = $fileName4s;
} else if (file_exists($fileName4j)){
$_SESSION['ads'][3] = $fileName4j;
}

// Haetaan asetetut linkit
$stmt = $conn->prepare("SELECT * from adlinks WHERE team_id = :teamid");
$stmt->bindParam(':teamid',$teamId);
$stmt->execute();
if ($row = $stmt->fetch()) {
if (!empty($row['link1'])) {
$_SESSION['adlinks'][0] = $row['link1'];
}
if (!empty($row['link2'])) {
$_SESSION['adlinks'][1] = $row['link2'];
}
if (!empty($row['link3'])) {
$_SESSION['adlinks'][2] = $row['link3'];
}
if (!empty($row['link4'])) {
$_SESSION['adlinks'][3] = $row['link4'];
}
}
if (!isset($_SESSION['editEvent'])) {
header("Location:event1.php");
}
}

if (isset($_POST['fetchAds'])){
	fetchAds();
}

if (isset($_POST['setMatchText'])){
	setMatchText();
}

if (isset($_POST['setMatchTextGuide6'])){
	setMatchText('6');
}

if (isset($_POST['setEventInfo'])){
	if(validateEvent() != false) {
		setEventInfo(null);
	}
}

if (isset($_POST['setHomeTeam'])) {
	if(validateEvent() != false) {
		setHomeTeam(null);
	}
}

if (isset($_POST['setVisitorTeam'])) {
	if(validateEvent() != false) {
		setVisitorTeam(null);
	}
}

if (isset($_POST['addVisitor'])) {
	if(validateEvent() != false) {
		addVisitor();
	}
}

if (isset($_POST['savePlayer'])) {
	savePlayer();
}

if (isset($_POST['editUser'])) {
	editUser();
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
	eventData();
}

if (isset($_GET['removeEvent'])) {
	removeEvent();
}

if (isset($_GET['removeVisitor'])) {
	removeVisitor();
}

if (isset($_POST['removeTeam'])) {
	removeTeam();
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

if (isset($_POST['fileUpload'])) {
	fileUpload(null);
}

if (isset($_POST['submitAd']) && ($_POST['submitAd'])=="1") {
	fileUpload(1);
}

if (isset($_POST['submitAd']) && ($_POST['submitAd'])=="2") {
	fileUpload(2);
}

if (isset($_POST['submitAd']) && ($_POST['submitAd'])=="3") {
	fileUpload(3);
}

if (isset($_POST['submitAd']) && ($_POST['submitAd'])=="4") {
	fileUpload(4);
}

if (isset($_POST['removeAd']) && ($_POST['removeAd'])=="1") {
	removeAd(1);
}

if (isset($_POST['removeAd']) && ($_POST['removeAd'])=="2") {
	removeAd(2);
}

if (isset($_POST['removeAd']) && ($_POST['removeAd'])=="3") {
	removeAd(3);
}

if (isset($_POST['removeAd']) && ($_POST['removeAd'])=="4") {
	removeAd(4);
}

if (isset($_GET['sendActivation'])) {
	sendEmail('resend',$_POST['teamId'],null,null,null);
}
?>
