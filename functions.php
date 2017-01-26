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

    //Joukkuetilin luonti
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
   //Seuratilin luonti
		$stmt = $conn->prepare("INSERT INTO user (uid,pwd,type,email,hash) VALUES (:username, :passwordhash, '0', :email, :hash)");
		$stmt->bindParam(":username", $uid);
		$stmt->bindParam(":passwordhash", $pwdHash);
		$stmt->bindParam(":email", $email);
		$stmt->bindParam(":hash", $hash);
		$stmt->execute();
		$stmt = $conn->prepare("SELECT id FROM user WHERE uid= :username");
		$stmt->bindParam(":username", $uid);
		$stmt->execute();
		if ($row = $stmt->fetch()) {
			$id = $row['id'];
			$stmt = $conn->prepare("UPDATE user SET owner_id = :id WHERE id = :id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();
		} }

	if(sendEmail('reg',$uid,$pwd,$email,$hash) == FALSE) {
		echo 'emailFail';
	} else {

 if (isset($_SESSION['id'])) {
	echo 'teamSuccess';
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
	session_start();
}

	if(isset($_SESSION['id'])) {
	$id = $_SESSION['id'];
	$uid = $_SESSION['uid'];
	$ownerId = $_SESSION['ownerId'];
	if(isset($_SESSION['teamId'])) {
	$teamId =	$_SESSION['teamId'];
	$teamUid =	$_SESSION['teamUid'];
}
// Logon lataus
if (!isset($_POST['adUpload1']) && !isset($_POST['adUpload2']) && !isset($_POST['adUpload3']) && !isset($_POST['adUpload4'])) {

		$filename = $_FILES["file"]["name"];
		$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
		$file_ext = substr($filename, strripos($filename, '.')); // get file name
		$filesize = $_FILES["file"]["size"];
		$allowed_file_types = array('.jpg','.jpeg','.png','.gif');

		if (!isset($_SESSION['homeName']) && isset($_SESSION['teamId'])) {
			$newfilename = $teamUid . $teamId . $file_ext;
	 } else {
		$newfilename = $uid . $id . $file_ext;
	}
	if (!in_array($file_ext,$allowed_file_types) && (!$filesize < 200000)) {
		// file type error
		unlink($_FILES["file"]["tmp_name"]);
		echo '<script type="text/javascript">';
		echo 'alert("Kuva ei ole sallitussa muodossa!");';
		echo 'document.location.href = "settings.php";';
		echo '</script>';
		//echo "Only these file types are allowed for upload: " . implode(', ',$allowed_file_types);

	}
	elseif (empty($file_basename))
	{
		// file selection error
		echo '<script type="text/javascript">';
		echo 'alert("Valitse ladattava kuva!");';
		echo 'document.location.href = "settings.php";';
		echo '</script>';
	}
	elseif ($filesize > 200000)
	{
		// file size error
		echo '<script type="text/javascript">';
		echo 'alert("Kuvan tiedostokoko on liian iso!");';
		echo 'document.location.href = "settings.php";';
		echo '</script>';
	}
	else {
move_uploaded_file($_FILES["file"]["tmp_name"], "images/logos/" . $newfilename);
echo '<script type="text/javascript">';
echo 'alert("Kuvan lataus onnistui.");';
echo 'document.location.href = "settings.php";';
echo '</script>';
}
	}
 //Mainoksen lataus
else {

		define('UPLOAD_DIR', 'images/ads/');
		$img = $_POST['image-data'];
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
	}
			// Rename file

			if (!isset($_SESSION['homeName']) && isset($_SESSION['teamId'])) {
			 if ($mod =='ad1') {
			 //$newfilename = 'j_'. $teamUid . $teamId .'_ad1'. $file_ext;
			 $newfilename = UPLOAD_DIR . 'j_'. $teamUid . $teamId .'_ad1'. '.png';
			 } else if ($mod =='ad2') {
			//$newfilename = 'j_'. $teamUid . $teamId .'_ad2'. $file_ext;
			$newfilename = UPLOAD_DIR . 'j_'. $teamUid . $teamId .'_ad2'. '.png';
		} else if ($mod =='ad3') {
			 //$newfilename = 'j_'. $teamUid . $teamId .'_ad3'. $file_ext;
			 $newfilename = UPLOAD_DIR . 'j_'. $teamUid . $teamId .'_ad3'. '.png';
		 }else if ($mod =='ad4') {
				 //$newfilename = 'j_'. $teamUid . $teamId .'_ad4'. $file_ext;
				 $newfilename = UPLOAD_DIR . 'j_'. $teamUid . $teamId .'_ad4'. '.png';
			 }

		 } else if (isset($_SESSION['homeName']) && isset($_SESSION['teamId'])) {
			 if ($mod =='ad1') {
			 //$newfilename = 'e_'. $teamUid . $teamId .'_ad1'. $file_ext;
			 $newfilename = UPLOAD_DIR . 'e_'. $teamUid . $teamId .'_ad1'. '.png';
			 } else if ($mod =='ad2') {
			//$newfilename = 'e_'. $teamUid . $teamId .'_ad2'. $file_ext;
			$newfilename = UPLOAD_DIR . 'e_'. $teamUid . $teamId .'_ad2'. '.png';
		} else if ($mod =='ad3') {
			 //$newfilename = 'e_'. $teamUid . $teamId .'_ad3'. $file_ext;
			 $newfilename = UPLOAD_DIR . 'e_'. $teamUid . $teamId .'_ad3'. '.png';
		 }else if ($mod =='ad4') {
			//$newfilename = 'e_'. $teamUid . $teamId .'_ad4'. $file_ext;
			$newfilename = UPLOAD_DIR . 'e_'. $teamUid . $teamId .'_ad4'. '.png';
			 }
		 } else if (isset($_SESSION['homeName']) && !isset($_SESSION['teamId'])) {
			 if ($mod =='ad1') {
			 //$newfilename = 'e_'. $teamUid . $teamId .'_ad1'. $file_ext;
			 $newfilename = UPLOAD_DIR . 'e_'. $ownerId .'_ad1'. '.png';
			 } else if ($mod =='ad2') {
			//$newfilename = 'e_'. $teamUid . $teamId .'_ad2'. $file_ext;
			$newfilename = UPLOAD_DIR . 'e_'. $ownerId .'_ad2'. '.png';
		} else if ($mod =='ad3') {
			 //$newfilename = 'e_'. $teamUid . $teamId .'_ad3'. $file_ext;
			 $newfilename = UPLOAD_DIR . 'e_'. $ownerId .'_ad3'. '.png';
		 }else if ($mod =='ad4') {
			//$newfilename = 'e_'. $teamUid . $teamId .'_ad4'. $file_ext;
			$newfilename = UPLOAD_DIR . 'e_'. $ownerId .'_ad4'. '.png';
			 }
		 }
			else {
				if ($mod =='ad1') {
			//$newfilename = 's_'. $ownerId .'_ad1'. $file_ext;
			$newfilename = UPLOAD_DIR . 's_'. $ownerId . '_ad1'. '.png';
				}
        else if ($mod =='ad2') {
			//$newfilename = 's_'. $ownerId .'_ad2'. $file_ext;
			$newfilename = UPLOAD_DIR . 's_'. $ownerId . '_ad2'. '.png';
					}
				else if ($mod =='ad3') {
			//$newfilename = 's_'. $ownerId .'_ad3'. $file_ext;
			$newfilename = UPLOAD_DIR . 's_'. $$ownerId . '_ad3'. '.png';
						}
				else if ($mod =='ad4') {
			//$newfilename = 's_'. $ownerId .'_ad4'. $file_ext;
			$newfilename = UPLOAD_DIR . 's_'. $ownerId . '_ad4'. '.png';
							}
		}

		if (empty($img))
		{
			// file selection error
			echo '<script type="text/javascript">';
			echo 'alert("Valitse ladattava kuva!");';
			echo 'document.location.href = "ads.php";';
			echo '</script>';
		}
		else
		{
			file_put_contents($newfilename, $data);
			echo '<script type="text/javascript">';
			echo 'alert("Kuvan lataus onnistui.");';
			if (isset($_SESSION['homeName'])) {
			echo 'document.location.href = "event5.php";';
		} else {
		echo 'document.location.href = "ads.php";';
		}
			echo '</script>';
		}
} }
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
if ($_POST['firstName'] && $_POST['lastName'] && $_POST['number']) {
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

function saveUser()
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
		echo '<script type="text/javascript">';
		echo 'alert("Salasana on väärin!");';
		echo 'document.location.href = "edit_user.php"';
		echo '</script>';
	} else if (empty($teamName) || ctype_space($teamName)) {
			echo '<script type="text/javascript">';
			echo 'alert("Et syöttänyt joukkueen nimeä!");';
			echo 'document.location.href = "edit_user.php";';
			echo '</script>';
}
		else {
if (!empty($_POST['name'])) {
			$stmt = $conn->prepare("UPDATE team SET name = :teamname WHERE id = :teamid");
			$stmt->bindParam(':teamname',$teamName);
			$stmt->bindParam(':teamid',$teamId);
      $stmt->execute();
			echo '<script type="text/javascript">';
			echo 'alert("Joukkueen nimi muutettu.");';
			echo 'document.location.href = "settings.php"';
			echo '</script>';
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
	header("Location: team.php?teamId=$teamId");
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
		echo '<script type="text/javascript">';
		echo 'alert("Salasana on väärin!");';
		echo 'document.location.href = "edit_user.php"';
		echo '</script>';
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

	if ($stmt->execute() && $stmt2->execute()) {
		unset($_SESSION['teamId']);
		unset($_SESSION['teamUid']);
		unset($_SESSION['teamName']);
		echo '<script type="text/javascript">';
		echo 'alert("Joukkue poistettu.");';
		echo 'document.location.href = "profile.php"';
		echo '</script>';
} else {
	set_error_handler('error');
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

$_SESSION['eventName'] = $_POST['eventName'];
$_SESSION['eventPlace'] = $_POST['eventPlace'];
$_SESSION['eventDate'] = $_POST['eventDate'];
if ($mod == "3"){
	header("Location:event3.php");
}
else if ($mod == "4"){
	header("Location:event4.php");
}
else if ($mod == "5"){
	header("Location:event5.php");
}
else if ($mod == "6"){
	header("Location:event_overview.php?c");
}

else  {
	header("Location:event2.php");
}
}
function setHomeTeam($mod) {
	if(!isset($_SESSION)) {
	session_start(); }
	include 'dbh.php';

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
	}
	$eventId = $_SESSION['eventId'];

	if ($mod == '4') {
	header("Location:event4.php");
}
else if ($mod == '5') {
header("Location:event5.php");
}
	else if ($mod == '6') {
	header("Location:event_overview.php?c");
} else {
	header("Location:event3.php");
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
			header("Location:event4.php");
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
	else if (!isset($_SESSION['saved']) && !isset($_SESSION['eventId'])){
		echo '<script type="text/javascript">';
		echo 'alert("Lisää vähintään yksi pelaaja!");';
		echo 'document.location.href = "event2.php"';
		echo '</script>';
		exit();
	}
	else if (!isset($_SESSION['visitors'])) {
		echo '<script type="text/javascript">';
		echo 'alert("Lisää vähintään yksi vierasjoukkueen pelaaja!");';
		echo 'document.location.href = "event3.php"';
		echo '</script>';
		exit();
	}
	else if (!isset($_SESSION['visitorName'])) {
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
	while ($row = $stmt->fetch()) {
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
	while ($row = $stmt->fetch()) {
		$showId = $row['id'];
		$showName = $row['name'];
		$showTeam = $row['team_id'];
		$showDate = $row['date'];
		echo "<tr>";
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
			$json = file_get_contents('files/overview' . $eventId . '.json');
			$json = json_decode($json, true);
			if (!isset($_GET['c'])) {
				$_SESSION['eventName'] = $json['eventinfo'][0];
				$_SESSION['eventPlace'] = $json['eventinfo'][1];
				$_SESSION['eventDate'] = $json['eventinfo'][2];
				$_SESSION['matchText'] = $json['eventinfo'][3];
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
  $homeName = $_SESSION['homeName'];
	$visitorName = $_SESSION['visitorName'];
	$eventName = $_SESSION['eventName'];
	$eventPlace = $_SESSION['eventPlace'];
	$eventDate = $_SESSION['eventDate'];
	$matchText = $_SESSION['matchText'];
	$plainMatchText = $_SESSION['plainMatchText'];

	$date = date_create($eventDate);
	$realDate = date_format($date, "Y-m-d");
	$overview = array(
		'eventinfo' => array(
			$eventName,
			$eventPlace,
			$eventDate,
			$matchText,
			$plainMatchText
		) , 'ads' => array(),

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
	unlink('images/ads/event/' . $eventId . '_ad1.png');
	unlink('images/ads/event/' . $eventId . '_ad2.png');
	unlink('images/ads/event/' . $eventId . '_ad3.png');
	unlink('images/ads/event/' . $eventId . '_ad4.png');

	// Mainoksien tallennus
	$i = 0;
	foreach($_SESSION['ads'] as $key => $value) {
	$filename = $value;
	$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
	$file_ext = substr($filename, strripos($filename, '.')); // get file name
	$newfilename = $eventId . "_ad". ($i+1) . $file_ext;
	$overview['ads'][$i] = $newfilename;
	copy($filename, "images/ads/event/" . $newfilename);
	if (strpos($filename, 'e_') !== false) {
	unlink($filename);
}
	$i++;
}
	// luodaan json

	$json = json_encode($overview);

	// kirjoitetaan tiedosto

	$fp = fopen("files/overview" . $eventId . ".json", "wb");

	if (fwrite($fp, $json)) {
		$ok = "Tapahtuma tallennettu.";
		echo "<script type='text/javascript'>alert('$ok');</script>";
	}
	else {
		$fail = "Tapahtumaa ei voitu tallentaa!";
		echo "<script type='text/javascript'>alert('$fail');</script>";
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
	unset($_SESSION['ad1']);
	unset($_SESSION['ad2']);
	unset($_SESSION['ad3']);
	unset($_SESSION['ad4']);
	echo "<script>window.location.href='profile.php'</script>";
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

	$fileName = 'images/logos/'.$showName.$teamId.'.jpg';
	if (file_exists($fileName)){
	$logo = 'images/logos/'.$showName.$teamId.'.jpg';
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
	$stmt->execute();
	if ($stmt->execute()) {
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
	echo "<table class='u-full-width'>";
	while ($row = $stmt->fetch()) {
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
	echo '<td class="bold">Käyttäjänimi:</td>';
	echo '<td>' . $userName . '</td>';
	echo '</tr>';
}
if (isset($_SESSION['teamId'])) {
	echo '<tr>';
	echo '<td class="bold">Joukkueen nimi:</td>';
	if ($mod == 'view') {
	echo '<td>' . $teamName . '</td>';
} else {
	echo '<td><input type="text" name="name" value="' . $teamName . '"</td>';
}
	echo '</tr>';
}
if ($mod == 'view') {
	echo '<tr>';
	echo '<td class="bold">Tilintyyppi:</td>';
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
if ($_POST['matchText']) {
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
function setEventAds() {
	if(!isset($_SESSION)) {
	session_start();
	}
	if (!empty($_POST['ad1']) && $_POST['ad1'] != 'images/default_ad.png') {
	$_SESSION['ads'][0] = $_POST['ad1'] ;
}
  if (!empty($_POST['ad2']) && $_POST['ad2'] != 'images/default_ad.png') {
	$_SESSION['ads'][1] = $_POST['ad2'];
}
	if (!empty($_POST['ad3']) && $_POST['ad3'] != 'images/default_ad.png') {
	$_SESSION['ads'][2] = $_POST['ad3'];
}
	if (!empty($_POST['ad4']) && $_POST['ad4'] != 'images/default_ad.png') {
	$_SESSION['ads'][3] = $_POST['ad4'];
}
 header("Location:event_overview.php?c");
}
if (isset($_POST['setMatchText'])){
	setMatchText();
}

if (isset($_POST['setMatchTextGuide6'])){
	setMatchText('6');
}

if (isset($_POST['setEventInfo'])){
	setEventInfo();
}

if (isset($_POST['setEventInfoGuide3'])){
	setEventInfo('3');
}

if (isset($_POST['setEventInfoGuide4'])){
	setEventInfo('4');
}

if (isset($_POST['setEventInfoGuide5'])){
	setEventInfo('5');
}

if (isset($_POST['setEventInfoGuide6'])){
	setEventInfo('6');
}

if (isset($_POST['setHomeTeam'])) {
	setHomeTeam();
}

if (isset($_POST['setHomeTeamGuide4'])) {
	setHomeTeam('4');
}

if (isset($_POST['setHomeTeamGuide5'])){
	setHomeTeam('5');
}

if (isset($_POST['setHomeTeamGuide6'])) {
	setHomeTeam('6');
}

if (isset($_POST['setVisitorTeam'])) {
	setVisitorTeam();
}

if (isset($_POST['setVisitorTeamGuide5'])) {
	setVisitorTeam('5');
}

if (isset($_POST['setVisitorTeamGuide6'])) {
	setVisitorTeam('6');
}

if (isset($_POST['setEventAds'])) {
	setEventAds();
}

if (isset($_POST['addVisitor'])) {
	addVisitor();
}

if (isset($_POST['savePlayer'])) {
	savePlayer();
}

if (isset($_POST['saveUser'])) {
	saveUser();
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

if (isset($_POST['adUpload1'])) {
	fileUpload('ad1');
}

if (isset($_POST['adUpload2'])) {
	fileUpload('ad2');
}

if (isset($_POST['adUpload3'])) {
	fileUpload('ad3');
}

if (isset($_POST['adUpload4'])) {
	fileUpload('ad4');
}

if (isset($_GET['sendActivation'])) {
	sendEmail('resend',$_POST['teamId'],null,null,null);
	//print_r($_POST);
}
?>
