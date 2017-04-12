<?php

function register()
{
    session_start();
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
    } elseif (empty($uid)) {
        echo 'uidEmpty';
    } elseif (strlen($uid) < 4) {
        echo 'uidShort';
    } elseif (empty($pwd)) {
        echo 'pwdEmpty';
    } elseif (strlen($pwd) < 4) {
        echo 'pwdShort';
    } elseif (preg_match('/\s/', $uid)) {
        echo 'uidInvalid';
    } elseif (preg_match('/\s/', $pwd)) {
        echo 'pwdInvalid';
    } elseif ($pwd !== $_POST['pwdConfirm']) {
        echo 'pwdMismatch';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'emailInvalid';
    } elseif (empty($_POST['regLevel']) && !isset($_SESSION['id'])) {
        echo 'regLevelInvalid';
    } elseif (empty($_POST['regSport']) && !isset($_SESSION['id'])) {
        echo 'regSportInvalid';
    } else {

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

            $stmt = $conn->prepare("SELECT * FROM user WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            if ($row = $stmt->fetch()) {
                $sport = $row['sport'];
            }
            $serie = '13';
            $stmt = $conn->prepare("INSERT INTO team (name,user_id,serie) VALUES (:username, :id, :serie)");
            $stmt->bindParam(":username", $uid);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":serie", $serie);
            $stmt->execute();

            $stmt = $conn->prepare("SELECT * FROM team ORDER BY ID DESC LIMIT 1");
            $stmt->execute();
            if ($row = $stmt->fetch()) {
                $teamId = $row['id'];
            }
            $stmt = $conn->prepare("INSERT INTO user (uid,sport,pwd,type,email,hash,team_id,owner_id) VALUES (:username, :sport, :passwordhash, '1', :email, :hash, :teamid, :id)");
            $stmt->bindParam(":username", $uid);
            $stmt->bindParam("sport", $sport);
            $stmt->bindParam(":passwordhash", $pwdHash);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":hash", $hash);
            $stmt->bindParam(":teamid", $teamId);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            // Tyhjän mainoslinkki rivin luonti

            $stmt = $conn->prepare("INSERT INTO adlinks (owner_id,team_id) VALUES (:ownerid, :teamid)");
            $stmt->bindParam(':ownerid', $id);
            $stmt->bindParam(":teamid", $teamId);
            $stmt->execute();

            // Kopioidaan seuran asettamat mainokset

            $stmt = $conn->prepare("SELECT * FROM adlinks WHERE owner_id = :id AND team_id IS NULL");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch();

            for ($i = 0; $i < 25; $i++) {
                $stmt2 = $conn->prepare("UPDATE adlinks SET link".($i+1)." = :link WHERE team_id = :teamid");
                $stmt2->bindParam(':teamid', $teamId);
                $stmt2->bindParam(':link', $row['link'.($i+1).'']);
                $stmt2->execute();
            }

            for ($i = 0; $i < 10; $i++) {
                $stmt2 = $conn->prepare("UPDATE adlinks SET offer".($i+1)." = :offer WHERE team_id = :teamid");
                $stmt2->bindParam(':teamid', $teamId);
                $stmt2->bindParam(':offer', $row['offer'.($i+1).'']);
                $stmt2->execute();
            }

            for ($i = 0; $i < 10; $i++) {
                $stmt2 = $conn->prepare("UPDATE adlinks SET price".($i+1)." = :price WHERE team_id = :teamid");
                $stmt2->bindParam(':teamid', $teamId);
                $stmt2->bindParam(':price', $row['price'.($i+1).'']);
                $stmt2->execute();
            }
            $stmt2 = $conn->prepare("UPDATE adlinks SET text = :text WHERE team_id = :teamid");
            $stmt2->bindParam(':teamid', $teamId);
            $stmt2->bindParam(':text', $row['text']);
            $stmt2->execute();
        } else {
            //Seuratilin luonti / joukkuetilin luonti rekisteröintilomakkeesta
      $sport = $_POST['regSport'];
            if ($_POST['regLevel'] == "joukkue") {
                $type = '1';
            } else {
                $type = '0';
            }
            $stmt = $conn->prepare("INSERT INTO user (uid,sport,pwd,type,email,hash) VALUES (:username, :sport, :passwordhash, :type, :email, :hash)");
            $stmt->bindParam(":username", $uid);
            $stmt->bindParam("sport", $sport);
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
                $serie = '13';
                $stmt = $conn->prepare("INSERT INTO team (name,user_id,serie) VALUES (:username, :id, :serie)");
                $stmt->bindParam(":username", $uid);
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":serie", $serie);
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

                // Tyhjän mainoslinkki rivin luonti
                $stmt = $conn->prepare("INSERT INTO adlinks (owner_id,team_id) VALUES (:ownerid, :teamid)");
                $stmt->bindParam(':ownerid', $id);
                $stmt->bindParam(":teamid", $teamId);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("UPDATE user SET owner_id = :id WHERE id = :id");
                $stmt->bindParam(":id", $id);
                $stmt->execute();
            }
            }
            // Tyhjän mainoslinkki rivin luonti
             $stmt = $conn->prepare("INSERT INTO adlinks (owner_id,team_id) VALUES (:ownerid, :teamid)");
            $stmt->bindParam(':ownerid', $id);
            $stmt->bindParam(":teamid", $teamId);
            $stmt->execute();
        }

        if (sendEmail('reg', $uid, $pwd, $email, $hash) == false) {
            echo 'emailFail';
        } else {
            if (isset($_SESSION['id'])) {
                if (isset($_POST['button'])) {
                    if ($_POST['button'] != "add") {
                        echo 'teamSuccess';
                    } else {
                        echo 'teamMore';
                    }
                }
            } else {
                echo 'userSuccess';
            }
        }
    }
}
function sendEmail($mod, $uid, $pwd, $email, $hash)
{
    include('dbh.php');
    // Sähköpostin lähetys
if ($mod == 'resend') {
    $stmt = $conn->prepare("SELECT * FROM user WHERE team_id = :username");
    $stmt->bindParam(':username', $uid);
    $stmt->execute();
    $row = $stmt->fetch();
    $email = $row['email'];
    $hash = $row['hash'];
}
    require 'inc/widgets/phpmailer/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.zoner.fi';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'no_reply@otteluohjelma.fi';                 // SMTP username
    $mail->Password = 'vWV1md6ils';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->SetFrom("no_reply@otteluohjelma.fi", "Otteluohjelma");
    //$mail->AddReplyTo("vahvistus@otteluohjelma.fi", "Otteluohjelma");
    $mail->addAddress($email, $uid);     // Add a recipient
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Otteluohjelma: Vahvistus';
    if ($mod == 'reg') {
        $mail->Body = 'Kiitos rekisteröinnistä!<br><br>
Tilisi on luotu ja voit kirjautua sisään seuraavilla tunnuksilla,<br>
kun olet aktivoinut tilisi painamalla alla olevaa linkkiä<br>

------------------------<br>
Käyttäjänimi: '.$uid.'<br>
Salasana: '.$pwd.'<br>
------------------------<br>
Paina tätä linkkiä aktivoidaksesi tilisi:<br>
http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']).'/verify.php?email='.$email.'&hash='.$hash.''; // Our message above including the link
    } else {
        $mail->Body =
    'Paina tätä linkkiä aktivoidaksesi tilisi:<br>
	http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']).'/verify.php?email='.$email.'&hash='.$hash.'';
    }
    if (!$mail->send()) {
        if ($mod == 'reg') {
            //echo 'Mailer Error:'.$mail->ErrorInfo.'';
    return false;
        } else {
            echo 'emailFail';
        }
    } else {
        if ($mod == 'reg') {
            return true;
        } else {
            echo 'emailSuccess';
        }
    }
}

function verifyAccount()
{
    include 'dbh.php';
    if (isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['hash']) && !empty($_GET['hash'])) {
        // Verify data
    $email = $_GET['email']; // Set email variable
    $hash = $_GET['hash']; // Set hash variable

    $stmt = $conn->prepare("SELECT * FROM user WHERE email= :email AND hash= :hash AND activated='0'");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':hash', $hash);
        $stmt->execute();

        if ($row = $stmt->fetch()) {
            // We have a match, activate the account
                $stmt = $conn->prepare("UPDATE user SET activated='1' WHERE email= :email AND hash= :hash AND activated='0'");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':hash', $hash);
            $stmt->execute();
            echo 'Käyttäjätili aktivoitu. Voit nyt kirjautua sisään.';
        } else {
            // No match -> invalid url or account has already been activated.
        echo 'Linkki on väärä tai olet jo aktivoinut tilisi.';
        }
    } else {
        // Invalid approach
    echo 'Käytä sinulle lähetettyä linkkiä.';
    }
}
function fileUpload($mod)
{
    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $uid = $_SESSION['uid'];
        $ownerId = $_SESSION['ownerId'];
        if (isset($_SESSION['teamId'])) {
            $teamId =    $_SESSION['teamId'];
            $teamUid =    $_SESSION['teamUid'];
        }
        if ($_POST['fileUpload'] == "ad" || $_POST['fileUpload'] == "offer") {
            setAdLinks();
        }
 //Mainoksen & Logon lataus

    if (!empty($_POST['imgData'])) {
        $img = $_POST['imgData'];
        if (strpos($img, 'data:image/png') !== false) {
            $img = str_replace('data:image/png;base64,', '', $img);
        } elseif (strpos($img, 'data:image/jpeg') !== false) {
            $img = str_replace('data:image/jpeg;base64,', '', $img);
        } elseif (strpos($img, 'data:image/jpg') !== false) {
            $img = str_replace('data:image/jpg;base64,', '', $img);
        } elseif (strpos($img, 'data:image/gif') !== false) {
            $img = str_replace('data:image/gif;base64,', '', $img);
        } else {
            if ($_POST['fileUpload'] != "offer") {
                echo 'imgInvalid';
            }
            exit();
        }
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $fileSize =  strlen($data);
        if ($fileSize >= 500000) {
            echo 'imgSize';
            exit();
        }
    } else {
        if ($_POST['fileUpload'] != "offer") {
            echo 'imgEmpty';
            exit();
        } else {
            if (!isset($_SESSION['event']['edit'])) {
                echo 'offerSuccess';
                exit();
            } else {
                echo 'eventOfferSuccess';
                exit();
            }
        }
    }

        if ($_POST['fileUpload'] == "ad" && !isset($_SESSION['event']['edit']) && isset($_SESSION['teamId'])) {
            // Mainosten asetus perusnäkymässä (Joukkue)
                $newfilename = 'images/ads/' . 'j_'. $teamUid . $teamId .'_ad'.$mod. '.png';
        } elseif ($_POST['fileUpload'] == "ad" && !isset($_SESSION['event']['edit']) && !isset($_SESSION['teamId'])) {
            // Mainosten asetus perusnäkymässä (Seura)
                $newfilename = 'images/ads/' . 's_'. $ownerId .'_ad'.$mod. '.png';
        } elseif ($_POST['fileUpload'] == "ad" && isset($_SESSION['event']['edit'])) {
            // Mainosten asetus tapahtumanäkymässä
                $newfilename = 'images/ads/' . 'e_'. $teamUid . $teamId .'_ad'.$mod. '.png';
        } elseif ($_POST['fileUpload'] == "offer" && !isset($_SESSION['event']['edit']) && isset($_SESSION['teamId'])) {
            // Tarjousten asetus perusnäkymässä (Joukkue)
                $newfilename = 'images/ads/' . 'j_'. $teamUid . $teamId.'_'.$mod. '.png';
        } elseif ($_POST['fileUpload'] == "offer" && !isset($_SESSION['event']['edit']) && !isset($_SESSION['teamId'])) {
            // Tarjousten asetus perusnäkymässä (Seura)
                $newfilename = 'images/ads/' . 's_'. $ownerId.'_'.$mod. '.png';
        } elseif ($_POST['fileUpload'] == "offer" && isset($_SESSION['event']['edit'])) {
            // Tarjousten asetus tapahtumanäkymässä
                $newfilename = 'images/ads/' . 'e_'. $teamUid . $teamId.'_'.$mod. '.png';
        } elseif ($_POST['fileUpload'] == "user" && isset($_SESSION['teamId'])) {
            // Joukkueen logon asetus
            $newfilename = 'images/logos/' . $teamUid . $teamId .'.png';
        } elseif ($_POST['fileUpload'] == "user" && !isset($_SESSION['teamId'])) {
            // Seuran logon asetus
            $newfilename = 'images/logos/' . $uid . $id .'.png';
        } elseif ($_POST['fileUpload'] == "visitor" && isset($_SESSION['teamId'])) {
            // Vierasjoukkueen logon asetus
            $i = 1;
            $newfilename = 'images/logos/visitors/' . 'visitor'.$i.'.png';
            while (file_exists($newfilename)) {
                $i++;
                $newfilename = 'images/logos/visitors/' . 'visitor'.$i.'.png';
            }
        } else {
            // Mainosten asetus perusnäkymässä (Seura)
            $newfilename = 'images/ads/' . 's_'. $ownerId . '_ad'.$mod. '.png';
        }
        if (@file_put_contents($newfilename, $data)) {
            if (isset($_SESSION['event']['edit']) && $_POST['fileUpload'] == "ad") {
                $_SESSION['event']['ads'][$mod-1] = $newfilename;
                echo 'eventAdSuccess';
            } elseif (isset($_SESSION['event']['edit']) && $_POST['fileUpload'] == "offer") {
                $index = str_replace("offer", "", $mod);
                $index = $index-1;
                $_SESSION['event']['offers']['images'][$index] = $newfilename;
                echo 'eventAdSuccess';
            } elseif (!isset($_SESSION['event']['edit']) && $_POST['fileUpload'] == "ad" || $_POST['fileUpload'] == "offer") {
                echo 'adSuccess';
            } elseif ($_POST['fileUpload'] == "user") {
                echo 'logoSuccess';
            } elseif ($_POST['fileUpload'] == "visitor") {
                $_SESSION['event']['visitorLogo'] = $newfilename;
                echo 'visitorLogoSuccess';
            }
        } else {
            echo 'imgFail';
        }
    }
}
function removeAd($ad, $mod)
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include 'dbh.php';

    if (isset($_SESSION['teamId'])) {
        $teamId   =  $_SESSION['teamId'];
        $teamUid   =  $_SESSION['teamUid'];
    }
    $ownerId = $_SESSION['ownerId'];

    if (isset($_POST['fileName'])) {
        $url = 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']).'/';
        $fileName = str_replace($url, "", $_POST['fileName']);
        $fileName = substr($fileName, 0, strpos($fileName, "?"));
    } else {
        echo 'adRemoveFail';
        exit();
    }
    if (file_exists($fileName)) {
        if (@unlink($fileName)) {
            if (!isset($_SESSION['event']['edit'])) {
                echo 'adRemoveSuccess';
            } else {
                echo 'eventAdRemoveSuccess';
            }
        } else {
            echo 'adRemoveDenied';
            exit();
        }
    } else {
        echo 'adRemoveFail';
    }
}
function logIn()
{
    if (!isset($_SESSION)) {
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

    if ($check == false) {
        echo 'pwdWrong';
    } elseif ($row['activated'] == 0) {
        echo 'notActivated';
    } else {
        $stmt = $conn->prepare("SELECT * FROM user WHERE uid = :username");
        $stmt->bindParam(':username', $uid);
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
        } else {
            echo 'loginSuccess';
            $stmt = $conn->prepare("SELECT * FROM user WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch();
            $_SESSION['teamId'] = $row['team_id'];
            $_SESSION['teamUid'] = $row['uid'];
            $teamId = $_SESSION['teamId'];
            $stmt = $conn->prepare("SELECT * FROM team WHERE id = :teamid");
            $stmt->bindParam(':teamid', $teamId);
            $stmt->execute();
            $row = $stmt->fetch();
            $_SESSION['teamName'] = $row['name'];
        }
    }
}

function logOut()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    session_unset();
    session_destroy();
    header("Location:login.php");
    exit();
}

function addPlayer()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include 'dbh.php';
    $teamId = $_SESSION["teamId"];
    $id = $_SESSION["id"];
    if ($_POST['firstName'] && $_POST['lastName'] && $_POST['number'] && strlen(trim($_POST['firstName'])) > 0 && strlen(trim($_POST['lastName']) && strlen(trim($_POST['number'])) > 0) > 0 && is_numeric($_POST['number'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $number = str_pad($_POST['number'], 2, '0', STR_PAD_LEFT);
        $stmt = $conn->prepare("INSERT INTO player (user_id,team_id,firstName,lastName,number) VALUES (:id, :teamid, :firstname, :lastname, :number)");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':teamid', $teamId);
        $stmt->bindParam(':firstname', $firstName);
        $stmt->bindParam(':lastname', $lastName);
        $stmt->bindParam(':number', $number);
        $stmt->execute();
    } elseif (!is_numeric($_POST['number'])) {
        echo 'addPlayerInvalidNumber';
        exit();
    } else {
        echo 'addPlayerEmpty';
        exit();
    }
    if ($_POST['button'] != "add") {
        echo 'addPlayerSuccess';
    } else {
        echo 'addPlayerMore';
    }
}

function addTeam()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include 'dbh.php';

    $id = $_SESSION["id"];
    $teams = array(
        'name' => array(),
        'email' => array()
    );
    $i = 0;
    foreach ($_POST as $key => $value) {
        $teams['name'][$i] = $value;
        $i++;
    }

    $i = 0;
    foreach ($_POST as $key => $value) {
        $teams['email'][$i] = $value;
        $i++;
    }

    $i = 0;
    $count = count($teams['name']);
    foreach ($teams['name'] as $value) {
        if (--$count <= 0) {
            break;
        }

        $team = $teams['name'][$i];
        $team = strip_tags($team);

        $email = $teams[''][$i];
        $team = strip_tags($team);

        if (!empty($team)) {
            $stmt= $conn->prepare("INSERT INTO team (name,user_id) VALUES (:team, :id)");
            $stmt->bindParam(':team', $team);
            $stmt->bindParam(':id', $id);
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
    $stmt->bindParam(':team', $team);
    $stmt->bindParam(':teamid', $teamId);
    $stmt->execute();
    header("Location: teams.php");
}

function setUser()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    $id = $_SESSION["id"];
    $uid = $_SESSION['uid'];
    $teamId = $_SESSION["teamId"];
    $teamName = $_POST['name'];
    $teamSerie = $_POST['teamSerie'];

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

    if ($check == false) {
        echo 'teamPwdWrong';
    } elseif (empty($teamName) || ctype_space($teamName)) {
        echo 'teamEmpty';
    } else {
        if (!empty($_POST['name'])) {
            $stmt = $conn->prepare("UPDATE team SET name = :teamname, serie = :serie WHERE id = :teamid");
            $stmt->bindParam(':teamname', $teamName);
            $stmt->bindParam(':teamid', $teamId);
            $stmt->bindParam(':serie', $teamSerie);
            $stmt->execute();
            $_SESSION['teamName'] = $teamName;
            echo 'nameChangeSuccess';
        }
    }
}

function setPlayers()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include 'dbh.php';

    $teamId = $_SESSION['teamId'];
    $id = $_SESSION["id"];

    $i = 0;

    foreach ($_POST['numbers'][$i] as $value) {
        if (!is_numeric($_POST['numbers'][$i]['value'])) {
            echo 'addPlayerInvalidNumber';
            exit();
        }
        $i++;
    }

    $i = 0;
    foreach ($_POST['ids'] as $value) {
        $firstName[$i] = $_POST['firstNames'][$i]['value'];
        $lastName[$i] = $_POST['lastNames'][$i]['value'];
        $number[$i] = str_pad($_POST['numbers'][$i]['value'], 2, '0', STR_PAD_LEFT);
        $nameId[$i] = $_POST['ids'][$i]['value'];

        if (!empty($firstName[$i]) && !empty($lastName[$i]) && !empty($number[$i])) {
            $stmt = $conn->prepare("UPDATE player SET firstName = :firstname, lastName = :lastname, number = :number WHERE id = :nameid AND team_id = :teamid");
            $stmt->bindParam(':firstname', $firstName[$i]);
            $stmt->bindParam(':lastname', $lastName[$i]);
            $stmt->bindParam(':number', $number[$i]);
            $stmt->bindParam(':nameid', $nameId[$i]);
            $stmt->bindParam(':teamid', $teamId);
            $stmt->execute();
        }
        $i++;
    }
    echo 'setPlayerSuccessful';
}


function removePlayer()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include 'dbh.php';

    $teamId = $_SESSION['teamId'];
    $removeId = $_GET['removePlayer'];
    $stmt = $conn->prepare("DELETE FROM player WHERE id = :removeid");
    $stmt->bindParam(':removeid', $removeId);
    $stmt->execute();
    header("Location: edit_team.php");
}

function removeEvent()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include 'dbh.php';
    if (isset($_SESSION['teamid'])) {
        $id = $_SESSION['id'];
    } else {
        $id = $_SESSION['ownerId'];
    }
    $removeId = $_GET['removeEvent'];
    $stmt = $conn->prepare("DELETE FROM event WHERE id = :removeid AND owner_id = :id");
    $stmt->bindParam(':removeid', $removeId);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        $fileDest = glob('files/overview_' . $removeId .'_*.json');
        unlink($fileDest[0]);
        for ($i = 0; $i <= 25; $i++) {
            if (file_exists('images/ads/event/' . $removeId . '_ad'.$i.'.png')) {
                unlink('images/ads/event/' . $removeId . '_ad'.$i.'.png');
            }
        }
    }

    header("Location: index.php");
}

function removeTeam()
{
    if (!isset($_SESSION)) {
        session_start();
    }
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

    if ($check == false) {
        echo 'teamPwdWrong';
    } else {
        $stmt = $conn->prepare("DELETE FROM user WHERE team_id = :teamid AND owner_id = :id");
        $stmt->bindParam(':teamid', $teamId);
        $stmt->bindParam(':id', $id);

        $stmt2 = $conn->prepare("DELETE FROM team WHERE id = :teamid AND user_id = :id");
        $stmt2->bindParam(':teamid', $teamId);
        $stmt2->bindParam(':id', $id);

        $stmt3 = $conn->prepare("DELETE FROM player WHERE team_id = :teamid AND user_id = :id");
        $stmt3->bindParam(':teamid', $teamId);
        $stmt3->bindParam(':id', $id);
        $stmt3->execute();

        $stmt4 = $conn->prepare("DELETE FROM adlinks WHERE team_id = :teamid");
        $stmt4->bindParam(':teamid', $teamId);
        $stmt4->execute();

        if ($stmt->execute() && $stmt2->execute()) {
            echo 'teamRemoveSuccess';
            unset($_SESSION['teamId']);
            unset($_SESSION['teamUid']);
            unset($_SESSION['teamName']);
        } else {
            echo 'teamRemoveFail';
            exit();
        }
    }
}

function removeVisitor()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include 'dbh.php';

    $eventId = $_SESSION['event']['id'];
    $removeId = $_GET['removeVisitor'];
    unset($_SESSION['event']['visitors']['firstName'][$removeId]);
    unset($_SESSION['event']['visitors']['lastName'][$removeId]);
    unset($_SESSION['event']['visitors']['number'][$removeId]);
    $_SESSION['event']['visitors']['firstName'] = array_values($_SESSION['event']['visitors']['firstName']);
    $_SESSION['event']['visitors']['lastName'] = array_values($_SESSION['event']['visitors']['lastName']);
    $_SESSION['event']['visitors']['number'] = array_values($_SESSION['event']['visitors']['number']);
    if (empty($_SESSION['event']['visitors']['firstName'])) {
        unset($_SESSION['event']['visitors']);
    }
    header("Location:event3.php");
}

function addVisitor()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include 'dbh.php';
    //unset($_SESSION['event']['visitors']);
    $i = 0;
    if ($_POST['firstName'] && $_POST['lastName'] && $_POST['number']) {
        while (!empty($_SESSION['event']['visitors']['firstName'][$i])) {
            $i++;
        }
        if (!empty($_SESSION['event']['visitors']['firstName'])) {
            array_unshift($_SESSION['event']['visitors']['firstName'], $_POST['firstName']);
            array_unshift($_SESSION['event']['visitors']['lastName'], $_POST['lastName']);
            array_unshift($_SESSION['event']['visitors']['number'], str_pad($_POST['number'], 2, '0', STR_PAD_LEFT));
        } else {
            $_SESSION['event']['visitors']['firstName'][$i] = $_POST['firstName'];
            $_SESSION['event']['visitors']['lastName'][$i] = $_POST['lastName'];
            $_SESSION['event']['visitors']['number'][$i] = $_POST['number'];
        }
    }
    if (!empty($_POST['visitorName'])) {
        $_SESSION['event']['visitorName'] = $_POST['visitorName'];
    }
    if ($_POST['button'] != "add") {
        echo 'event3PlayerSuccess';
    } else {
        echo 'event3More';
    }
}

function setEventInfo()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include 'dbh.php';

    $_SESSION['event']['name'] = $_POST['eventName'];
    $_SESSION['event']['place'] = $_POST['eventPlace'];
    $_SESSION['event']['date'] = $_POST['eventDate'];
    echo "event1Success";
}
function setHomeTeam()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include 'dbh.php';

    $i = 0;
    unset($_SESSION['event']['saved']);
    foreach ($_POST['homeNumbers'] as $value) {
        $_SESSION['event']['saved']['home']['number'][$i] = $_POST['homeNumbers'][$i]['value'];
        $i++;
    }

    $i = 0;
    foreach ($_POST['homeFirstNames'] as $value) {
        $_SESSION['event']['saved']['home']['firstName'][$i] = $_POST['homeFirstNames'][$i]['value'];
        $i++;
    }

    $i = 0;
    foreach ($_POST['homeLastNames'] as $value) {
        $_SESSION['event']['saved']['home']['lastName'][$i] = $_POST['homeLastNames'][$i]['value'];
        $i++;
    }
    echo 'event2Success';
}

function setVisitorTeam($mod)
{
    if (!isset($_SESSION)) {
        session_start();
    }
    if ($_POST['visitorName']) {
        $_SESSION['event']['visitorName'] = $_POST['visitorName'];
    }
    if ($mod == '5') {
        header("Location:event5.php");
    } elseif ($mod == '6') {
        header("Location:event_overview.php?c");
    } else {
        echo 'event3Success';
    }
}
function validateEvent()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_SESSION['event']['id'])) {
        $eventId = $_SESSION['event']['id'];
    }
    if (isset($_POST['setEventInfo'])) {
        if (empty($_POST['eventName']) || empty($_POST['eventPlace']) || empty($_POST['eventDate'])) {
            echo 'event1Empty';
            return false;
            exit();
        }
    }
    if (isset($_POST['setHomeTeam'])) {
        if (empty($_POST['homeNumbers'])) {
            echo 'event2Empty';
            return false;
            exit();
        }
    }
    if (isset($_POST['setVisitorTeam'])) {
        if (!isset($_SESSION['event']['visitors'])) {
            echo 'event3TeamEmpty';
            return false;
            exit();
        }
    }
    if (isset($_POST['setVisitorTeam'])) {
        if (empty($_POST['visitorName'])) {
            echo 'event3NameEmpty';
            return false;
            exit();
        }
    }
    if (isset($_POST['addVisitor'])) {
        if (preg_match('/\s/', $_POST['firstName']) || preg_match('/\s/', $_POST['lastName']) || preg_match('/\s/', $_POST['number'])) {
            echo 'event3PlayerEmpty';
            return false;
            exit();
        } elseif (!is_numeric($_POST['number'])) {
            echo 'event3PlayerInvalidNumber';
            return false;
            exit();
        }
    }
    if (isset($_POST['guessName'])) {
        if ($_POST['guessType'] > 0 && empty($_POST['guessName'])) {
            echo 'event6Empty';
            return false;
            exit();
        }
    }
    return true;
}
function showHomeTeam()
{
    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_SESSION['event']['id'])) {
        $eventId = $_SESSION['event']['id'];
    }
    $i = 0;
    if (isset($_GET['c']) && isset($_SESSION['event']['saved'])) {
        foreach ($_SESSION['event']['saved']['home']['firstName'] as $value) {
            $showFirst = $_SESSION['event']['saved']['home']['firstName'][$i];
            $showLast = $_SESSION['event']['saved']['home']['lastName'][$i];
            $showNum = $_SESSION['event']['saved']['home']['number'][$i];
            echo '<td img"><img alt="pelaajan kuva" style="width: 35px; vertical-align: middle;" src="images/logos/joukkue.png"></td>';
            echo '<td>' . $showNum . '</td>';
            echo '<td style="text-transform: capitalize;">' . $showFirst . '</td>';
            echo '<td style="text-transform: capitalize;">' . $showLast . '</td>';
            echo '</tr>';
            $i++;
        }
    } elseif (isset($_SESSION['event']['home']) && isset($_SESSION['event']['old'])) {
        foreach ($_SESSION['event']['old']['firstName'] as $value) {
            $showFirst = $_SESSION['event']['old']['firstName'][$i];
            $showLast = $_SESSION['event']['old']['lastName'][$i];
            $showNum = $_SESSION['event']['old']['number'][$i];
            echo '<td><img alt="pelaajan kuva" style="width: 35px; vertical-align: middle;" src="images/logos/joukkue.png"></td>';
            echo '<td>' . $showNum . '</td>';
            echo '<td style="text-transform: capitalize;">' . $showFirst . '</td>';
            echo '<td style="text-transform: capitalize;">' . $showLast . '</td>';
            echo '</tr>';
            $i++;
        }
    } else {
        echo '<h4 style="color:gray">Lisää kotijoukkueen pelaajat!</h4>';
    }
}

function showVisitorTeam()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_GET['eventId'])) {
        $eventId = $_GET['eventId'];
    }
    $i = 0;
    if (isset($_SESSION['event']['visitors'])) {
        foreach ($_SESSION['event']['visitors']['firstName'] as $value) {
            $showFirst = $_SESSION['event']['visitors']['firstName'][$i];
            $showLast = $_SESSION['event']['visitors']['lastName'][$i];
            $showNum = $_SESSION['event']['visitors']['number'][$i];
            echo '<td><img alt="pelaajan kuva" style="width: 35px; vertical-align: middle;" src="images/logos/joukkue.png"></td>';
            echo '<td>' . $showNum . '</td>';
            echo '<td style="text-transform: capitalize;">' . $showFirst . '</td>';
            echo '<td style="text-transform: capitalize;">' . $showLast . '</td>';
            echo '</tr>';
            $i++;
        }
    } else {
        echo '<h4 style="color:gray">Lisää vierasjoukkueen pelaajat!</h4>';
    }
}

function listVisitorTeam()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_SESSION['event']['id'])) {
        $eventId = $_SESSION['event']['id'];
    }
    $i = 0;
    if (!empty($_SESSION['event']['visitors'])) {
        foreach ($_SESSION['event']['visitors']['firstName'] as $value) {
            $showFirst = $_SESSION['event']['visitors']['firstName'][$i];
            $showLast = $_SESSION['event']['visitors']['lastName'][$i];
            $showNum = $_SESSION['event']['visitors']['number'][$i];
            echo '<td><img alt="pelaajan kuva" style="width: 35px; vertical-align: middle;" src="images/logos/joukkue.png"></td>';
            echo '<td>' . $showNum . '</td>';
            echo '<td style="text-transform: capitalize;">' . $showFirst . '</td>';
            echo '<td style="text-transform: capitalize;">' . $showLast . '</td>';
        //Pelipaikka
        echo '<td></td>';
            echo '<td><a href="functions.php?removeVisitor=' . $i . '" id="iconRemove"><i class="material-icons">delete</i></a></td>';
            echo '</tr>';
            $i++;
        }
    }

    return $i + 1;
}

function listHomeTeam()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include 'dbh.php';

    $id = $_SESSION['id'];
    if (isset($_SESSION['teamId'])) {
        $teamId = $_SESSION['teamId'];
    } else {
        $eventId = $_SESSION['event']['id'];
        $stmt = $conn->prepare("SELECT * from event WHERE id = :eventid");
        $stmt->bindParam(':eventid', $eventId);
        $stmt->execute();
        $row = $stmt->fetch();
        $teamId = $row['team_id'];
    }
    $i = 0;
    $stmt = $conn->prepare("SELECT * from player WHERE team_id = :teamid");
    $stmt->bindParam(':teamid', $teamId);
    $stmt->execute();

    if ($stmt->rowCount() > 0 || isset($_SESSION['event']['id'])) {
        $i = 0;
        foreach ($_SESSION['event']['home']['firstName'] as $value) {
            $showId = $i;
            $showFirst = $_SESSION['event']['home']['firstName'][$i];
            $showLast = $_SESSION['event']['home']['lastName'][$i];
            $showNum = $_SESSION['event']['home']['number'][$i];
            echo '<tr style="display:table-row" id="' . $showId . '">';
            echo '<td>';
            echo '<i onclick="removePlayer(&quot;' . $showId . '&quot;, &quot;' . $showFirst . '&quot;, &quot;' . $showLast . '&quot;, &quot;' . $showNum . '&quot;)" style="font-size:25px;cursor: pointer;color:red" class="material-icons">close</i>';
            echo '</td>';
            echo '<td class="img"><img alt="pelaajan kuva" style="width: 35px; vertical-align: middle;" src="images/logos/joukkue.png"></td>';
            echo '<td id="number' . $i . '">' . $showNum . '</td>';
            echo '<td style="text-transform: capitalize;">' . $showFirst . '</td>';
            echo '<td style="text-transform: capitalize;">' . $showLast . '</td>';
            echo '<input class="numbers" type="hidden" name="number' . $i . '" value="' . $showNum . '" readonly>';
            echo '<input class="firstnames" type="hidden" name="firstName' . $i . '" value="' . $showFirst . '" readonly>';
            echo '<input class="lastnames" type="hidden" name="lastName' . $i . '" value="' . $showLast . '" readonly>';
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

    if (!isset($_SESSION)) {
        session_start();
    }
    $id = $_SESSION['id'];
    if (isset($_SESSION['teamId'])) {
        $teamId = $_SESSION['teamId'];
    }
    $i = 1;
    if ($mod == "all") {
        if (!isset($_SESSION['teamId'])) {
            $stmt = $conn->prepare("SELECT * from event WHERE owner_id = :id");
            $stmt->bindParam(':id', $id);
        } else {
            $stmt = $conn->prepare("SELECT * from event WHERE team_id = :teamid ");
            $stmt->bindParam(':teamid', $teamId);
        }
    }

    if ($mod == "upcoming") {
        if (!isset($_SESSION['teamId'])) {
            $stmt = $conn->prepare("SELECT * from event WHERE date >= CURDATE() AND owner_id = :id");
            $stmt->bindParam(':id', $id);
        } else {
            $stmt = $conn->prepare("SELECT * from event WHERE date >= CURDATE() AND team_id = :teamid");
            $stmt->bindParam(':teamid', $teamId);
        }
    }

    if ($mod == "past") {
        if (!isset($_SESSION['teamId'])) {
            $stmt = $conn->prepare("SELECT * from event WHERE date < CURDATE() AND owner_id = :id");
            $stmt->bindParam(':id', $id);
        } else {
            $stmt = $conn->prepare("SELECT * from event WHERE date < CURDATE() AND team_id = :teamid");
            $stmt->bindParam(':teamid', $teamId);
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

		 <th>Tapahtuman nimi</th>';
            if (!isset($_SESSION['teamId'])) {
                echo '<th>Joukkue</th>';
            }
            echo '<th>Päivämäärä</th>
		 <th>Linkki</th>
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

            if (!isset($teamId)) {
                $stmt2 = $conn->prepare("SELECT * from user WHERE team_id = :teamid");
                $stmt2->bindParam(':teamid', $showTeam);
                $stmt2->execute();
                $row2 = $stmt2->fetch();
                $teamUid = $row2['uid'];
            }

            if ($mod != "all") {
                echo '<td><a style="text-decoration:none;" href="event_overview.php?eventId=' . $showId . '">' . $showName . '</a></td>';
                if (!isset($teamId)) {
                    echo '<td><p style="margin-bottom: 0;">' . $teamUid . '</p></td>';
                }
                echo '<td><p style="margin-bottom: 0;">' . $showDate . '</p></td>';
            } else {
                $fileDest = glob('files/overview_' . $showId .'*.json');
                $fileDest = substr(strstr($fileDest[0], '_'), strlen('_'));
                $fileDest = substr($fileDest, 0, strrpos($fileDest, ".json"));

                echo '<td><a style="text-decoration:none;" href="event_overview.php?eventId=' . $showId . '">' . $showName . '</a></td>';
                if (!isset($teamId)) {
                    echo '<td><p style="margin-bottom: 0;">' . $teamUid . '</p></td>';
                }
                echo '<td>'.$showDate.'</td>';
                echo "<td><a target='_blank' href='inc/widgets/ottelu/index.php?eventId=". $fileDest ."'><i class='material-icons'>input</i></a></td>";
            }
            echo "</tr></tbody>";
            $i++;
        }
    } else {
        echo '<h4 style="color:gray">Ei tapahtumia</h4>';
    }
}

function getEvent()
{
    include 'dbh.php';
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION['event']['edit'] = true;
    $id = $_SESSION['id'];
    $ownerId = $_SESSION['ownerId'];
    $_SESSION['event']['id'] = $_GET['eventId'];
    $eventId = $_SESSION['event']['id'];
    if (isset($_SESSION['teamId'])) {
        $teamId = $_SESSION['teamId'];
    } else {
        $stmt = $conn->prepare("SELECT * from event WHERE id= :eventid AND owner_id = :id");
        $stmt->bindParam(':eventid', $eventId);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            $_SESSION['teamId'] = $row['team_id'];
            $teamId = $_SESSION['teamId'];
        }
        $stmt = $conn->prepare("SELECT * from user WHERE team_id= :teamid");
        $stmt->bindParam(':teamid', $teamId);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            $_SESSION['teamUid'] = $row['uid'];
        }
        $stmt = $conn->prepare("SELECT * from team WHERE id= :teamid");
        $stmt->bindParam(':teamid', $teamId);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            $_SESSION['teamName'] = $row['name'];
        }
    }

    $i = 0;
    $stmt = $conn->prepare("SELECT * from player WHERE team_id = :teamid");
    $stmt->bindParam(':teamid', $teamId);
    $stmt->execute();

    while ($row = $stmt->fetch()) {
        $showId = $row['id'];
        $_SESSION['event']['home']['firstName'][$i] = $row['firstName'];
        $_SESSION['event']['home']['lastName'][$i] = $row['lastName'];
        $_SESSION['event']['home']['number'][$i] = $row['number'];
        $i++;
    }

    if (!empty($_SESSION['event']['id'])) {
        if ($_SESSION['type'] == 0) {
            $stmt = $conn->prepare("SELECT * from event WHERE id= :eventid AND owner_id = :id");
            $stmt->bindParam(':eventid', $eventId);
            $stmt->bindParam(':id', $id);
        } else {
            $stmt = $conn->prepare("SELECT * from event WHERE id= :eventid AND team_id = :teamid");
            $stmt->bindParam(':eventid', $eventId);
            $stmt->bindParam(':teamid', $teamId);
        }
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            $eventId = $row['id'];
            $eventName = $row['name'];
            $fileDest = glob('files/overview_'. $eventId . '_*.json');
            $json = file_get_contents($fileDest[0]);
            $json = json_decode($json, true);
            if (!isset($_GET['c'])) {
                $_SESSION['event']['name'] = $json['eventinfo'][0];
                $_SESSION['event']['place'] = $json['eventinfo'][1];
                $_SESSION['event']['date'] = $json['eventinfo'][2];
                if (!empty($json['eventinfo'][3])) {
                    $_SESSION['event']['matchText'] = $json['eventinfo'][3];
                }
                if (!empty($json['guess'][0])) {
                    $_SESSION['event']['guessName'] = $json['guess'][0];
                    $_SESSION['event']['guessType'] = $json['guess'][1];
                }
                $_SESSION['event']['homeName'] = $json['teams']['home'][0];
                $_SESSION['event']['visitorName'] = $json['teams']['visitors'][0];
                if (!empty($json['teams']['visitors'][1])) {
                    $_SESSION['event']['visitorLogo'] = $json['teams']['visitors'][1];
                }
                getAds();
                $i = 0;
                $j = 0;
                foreach ($json['teams']['home']['players'] as $value) {
                    $_SESSION['event']['old']['firstName'][$j] = $json['teams']['home']['players'][$j]['first'];
                    $_SESSION['event']['old']['lastName'][$j] = $json['teams']['home']['players'][$j]['last'];
                    $_SESSION['event']['old']['number'][$j] = $json['teams']['home']['players'][$j]['number'];

                    $j++;
                }
                $_SESSION['event']['home']['firstName'] = array_values($_SESSION['event']['home']['firstName']);
                $_SESSION['event']['home']['lastName'] = array_values($_SESSION['event']['home']['lastName']);
                $_SESSION['event']['home']['number'] = array_values($_SESSION['event']['home']['number']);

                $i = 0;
                foreach ($json['teams']['visitors']['players'] as $value) {
                    $_SESSION['event']['visitors']['firstName'][$i] = $json['teams']['visitors']['players'][$i]['first'];
                    $_SESSION['event']['visitors']['lastName'][$i] = $json['teams']['visitors']['players'][$i]['last'];
                    $_SESSION['event']['visitors']['number'][$i] = $json['teams']['visitors']['players'][$i]['number'];
                    $i++;
                }
            }
        } else {
            unset($_SESSION['event']['id']);
            exit();
        }
    }
}

function createEvent()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include 'dbh.php';

    $id = $_SESSION["id"];
    $ownerId = $_SESSION["ownerId"];
    if (isset($_SESSION['teamId'])) {
        $teamId = $_SESSION['teamId'];
        $teamName = $_SESSION['teamName'];
        $teamUid = $_SESSION['teamUid'];
    }
    $homeName = $_SESSION['event']['homeName'];
    $visitorName = $_SESSION['event']['visitorName'];
    $homeLogo = 'images/logos/' . $teamUid . $teamId .'.png';

    $eventName = $_SESSION['event']['name'];
    $eventPlace = $_SESSION['event']['place'];
    $eventDate = $_SESSION['event']['date'];
    $matchText = $plainMatchText = $popupText = $guessName = $guessType = $visitorLogo ="";

    if (isset($_SESSION['event']['matchText'])) {
        $matchText = $_SESSION['event']['matchText'];
    }
    if (isset($_SESSION['event']['plainMatchText'])) {
        $plainMatchText = $_SESSION['event']['plainMatchText'];
    }
    if (isset($_SESSION['event']['popupText'])) {
        $popupText = $_SESSION['event']['popupText'];
    }
    if (isset($_SESSION['event']['guessName'])) {
        $guessName = $_SESSION['event']['guessName'];
        $guessType = $_SESSION['event']['guessType'];
    }
    if (isset($_SESSION['event']['visitorLogo'])) {
        $visitorLogo = $_SESSION['event']['visitorLogo'];
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
              'popup' => array($popupText),
                'images' => array(),
                'links' => array()
        ),
        'offers' => array(
        'texts' => array(),
        'prices' => array(),
        'images' => array(),
        ),
        'guess' => array(
         $guessName,
         $guessType
        ),

        'teams' => array(
            'home' => array(
                $homeName,
                $homeLogo,
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
                $visitorLogo,
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
    if (!isset($_SESSION['event']['saved'])) {
        foreach ($_SESSION['event']['home']['firstName'] as $key => $value) {
            $_SESSION['event']['saved']['home']['firstName'] = $_SESSION['event']['home']['firstName'];
            $_SESSION['event']['saved']['home']['lastName'] = $_SESSION['event']['home']['lastName'];
            $_SESSION['event']['saved']['home']['number'] = $_SESSION['event']['home']['number'];
            $i++;
        }
    }
    $i = 0;
    foreach ($_SESSION['event']['saved']['home']['firstName'] as $key => $value) {
        $overview['teams']['home']['players'][$i]['first'] = $_SESSION['event']['saved']['home']['firstName'][$i];
        $overview['teams']['home']['players'][$i]['last'] = $_SESSION['event']['saved']['home']['lastName'][$i];
        $overview['teams']['home']['players'][$i]['number'] = $_SESSION['event']['saved']['home']['number'][$i];
        $i++;
    }

    $i = 0;
    foreach ($_SESSION['event']['visitors']['firstName'] as $key => $value) {
        $overview['teams']['visitors']['players'][$i]['first'] = $_SESSION['event']['visitors']['firstName'][$i];
        $overview['teams']['visitors']['players'][$i]['last'] = $_SESSION['event']['visitors']['lastName'][$i];
        $overview['teams']['visitors']['players'][$i]['number'] = $_SESSION['event']['visitors']['number'][$i];
        $i++;
    }

    if (isset($_SESSION['event']['id'])) {
        $eventId = $_SESSION['event']['id'];
        $stmt = $conn->prepare("UPDATE event SET name = :eventname,date = :realdate WHERE id = :eventid");
        $stmt->bindParam(':eventname', $eventName);
        $stmt->bindParam(':realdate', $realDate);
        $stmt->bindParam(':eventid', $eventId);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO event (user_id,team_id,owner_id,name,date) VALUES (:id, :teamid , :ownerid, :eventname, :realdate)");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':teamid', $teamId);
        $stmt->bindParam(':ownerid', $ownerId);
        $stmt->bindParam(':eventname', $eventName);
        $stmt->bindParam(':realdate', $realDate);
        $stmt->execute();

        // Haetaan tapahtuman ID
        $stmt = $conn->prepare("SELECT * from event WHERE user_id = :id ORDER BY ID DESC LIMIT 1");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $eventId = $row['id'];
        }
    }

    // Vanhojen mainoksien poisto
for ($i = 0; $i <= 25; $i++) {
    if (file_exists('images/ads/event/' . $eventId . '_ad'.$i.'.png')) {
        unlink('images/ads/event/' . $eventId . '_ad'.$i.'.png');
    }
}
   // Vanhojen tarjouksien poisto
for ($i = 0; $i <= 10; $i++) {
    if (file_exists('images/ads/event/' . $eventId . '_offer'.$i.'.png')) {
        unlink('images/ads/event/' . $eventId . '_offer'.$i.'.png');
    }
}

    // Mainoksien tallennus
    if (isset($_SESSION['event']['ads'])) {
        foreach ($_SESSION['event']['ads'] as $key => $value) {
            $filename = $value;
            $file_basename = substr($filename, 0, strripos($filename, '.'));
            $file_ext = substr($filename, strripos($filename, '.'));
            $newfilename = $eventId . "_ad". ($key+1) . $file_ext;
            $overview['ads']['images'][$key] = $newfilename;
            if (!empty($_SESSION['event']['adlinks'][$key])) {
                $overview['ads']['links'][$key] = $_SESSION['event']['adlinks'][$key];
            }
            if (copy($filename, "images/ads/event/" . $newfilename)) {
                if (strpos($filename, 'e_') !== false) {
                    unlink($filename);
                }
            } else {
                unset($_SESSION['event']);
                exit();
            }
        }
    }

   // Tarjouksien tallennus
    if (isset($_SESSION['event']['offers'])) {
        foreach ($_SESSION['event']['offers']['texts'] as $key => $value) {
            if (isset($_SESSION['event']['offers']['images'][$key])) {
                $filename = $_SESSION['event']['offers']['images'][$key];
                $file_basename = substr($filename, 0, strripos($filename, '.'));
                $file_ext = substr($filename, strripos($filename, '.'));
                $newfilename = $eventId . "_offer". ($key+1) . $file_ext;
                $overview['offers']['images'][$key] = $newfilename;
                if (copy($filename, "images/ads/event/" . $newfilename)) {
                } else {
                    unset($_SESSION['event']);
                    exit();
                }
            }
            if (!empty($_SESSION['event']['offers']['texts'][$key])) {
                $overview['offers']['texts'][$key] = $_SESSION['event']['offers']['texts'][$key];
            }
            if (!empty($_SESSION['event']['offers']['prices'][$key])) {
                $overview['offers']['prices'][$key] = $_SESSION['event']['offers']['prices'][$key];
            }
        }
    }

    // luodaan json

    $json = json_encode($overview);

    // kirjoitetaan tiedosto
  $hash = md5($eventId);
    if ($oldFile = glob('files/overview_*'. $hash .'.json')) {
        unlink($oldFile[0]);
    }
    $fp = fopen('files/overview_'. $eventId . '_' . $hash .'.json', 'wb');

    if (fwrite($fp, $json)) {
        echo 'createLink='. $eventId . '_' . $hash;
    } else {
        echo 'eventFail';
    }
    fclose($fp);

    // Tyhjennetään Tapahtumamuuttujat

      unset($_SESSION['event']);
}

function listTeams()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include 'dbh.php';
    $id = $_SESSION['id'];
    if (isset($_SESSION['teamId'])) {
        unset($_SESSION['teamId']);
        unset($_SESSION['teamUid']);
    }

    $stmt = $conn->prepare("SELECT * from team WHERE user_id='$id' ORDER BY ID DESC");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo '<thead>
          <tr>
            <th></th>
            <th>Nimi</th>
            <th>Tila</th>
           <th></th>
              </tr>
        </thead>';
        while ($row = $stmt->fetch()) {
            $teamId = $row['id'];
            $showId = $row['id'];

            $stmt2 = $conn->prepare("SELECT * from user WHERE team_id='$teamId' ORDER BY ID DESC");
            $stmt2->execute();
            $row2 = $stmt2->fetch();
            $showName = $row2['uid'];

            $fileName = 'images/logos/'.$showName.$teamId.'.png';
            if (file_exists($fileName)) {
                $logo = 'images/logos/'.$showName.$teamId.'.png';
            } else {
                $logo = "images/logos/joukkue.png";
            }
            echo '<tr style="min-height: 80px; height: 80px;">';
            echo '<td><img alt="joukkueen logo" style="width: 35px; height: 35px; vertical-align: middle;" src="'.$logo.'"></td>';
            if ($row2['activated'] == 1) {
                echo '<td><a style="text-decoration:none;" href="index.php?teamId=' . $showId . '">' . $showName . '</a></td>';
                echo '<td><i style="color: #003400;" class="material-icons">check_circle</i></td>';
            } else {
                echo '<td><a style="text-decoration:none; color:gray;" href="#">' . $showName . '</a></td>';
                echo '<td><i style="color: #670a1c;" class="material-icons">cancel</i></td>';
                echo '<td>
				<a id="'.$showId.'" name="activation" style="display: inline-block; text-decoration: none; vertical-align: middle;" href="#"><i style="float: left; padding-right: 3px;" class="material-icons">refresh</i>Lähetä vahvistus</a>
				<br/>';
                echo '</td>';
            }
            echo '</tr>';
        }
    } else {
        echo '<h4 id="emptyHeader" style="color:gray">Ei joukkueita</h4>';
    }
}

function listPlayers()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include 'dbh.php';

    $id = $_SESSION['id'];
    $teamId = $_SESSION['teamId'];
    $i = 0;
    $stmt = $conn->prepare("SELECT * from player WHERE team_id = :teamid ORDER BY ID DESC");
    $stmt->bindParam(':teamid', $teamId);
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
                echo '<td class="fetch img"><img alt="pelaajan kuva" style="width: 35px; vertical-align: middle;" src="images/logos/joukkue.png"></td>';
                echo '<td id="number' . $i . '">' . $showNum . '</td>';
                echo '<td style="text-transform: capitalize;" class="first">' . $showFirst . '</td>';
                echo '<td style="text-transform: capitalize;" class="last">' . $showLast . '</td>';
                echo '<td style="text-transform: capitalize;" class="position"></td>';
                echo '</tr>';
                $i++;
            }
        } else {
            echo '<h4 id="emptyHeader" style="color:gray">Ei pelaajia</h4>';
        }
    } else {
        exit();
    }
}
function listGuess()
{
    include 'dbh.php';
    $teamId = $_SESSION['teamId'];
    $stmt = $conn->prepare("SELECT * from event WHERE team_id = :teamid");
    $stmt->bindParam(':teamid', $teamId);
    $stmt->execute();
    $i = 0;
    while ($row = $stmt->fetch()) {
        $eventId = $row['id'];
        $name = $row['name'];
        $options[$i] = '<option value='.$eventId.'>'.$name.'</option>';
        $i++;
    }
    echo '<select id="answers">
  <option disabled selected>Valitse tapahtuma</option>';
    foreach ($options as $value) {
        echo $value;
    }
    echo '</select>';
}

function populateGuess()
{
    include 'dbh.php';
    $eventId = $_POST['eventId'];
    $stmt = $conn->prepare("SELECT * from guess WHERE event_id = :eventid ORDER BY lastName ASC");

    $stmt->bindParam(':eventid', $eventId);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $i = 0;
        echo '<h5>Vastauksia: '.$stmt->rowCount()." kpl</h5>";
        echo '<div class="row">
  <div class="twelve columns" style="text-align:left">
  <table class="u-full-width">
  <thead>
  <tr>
  <th style="width:240px">Vastaus</th>
  <th style="width:240px">Etunimi</th>
  <th style="width:240px">Sukunimi</th>
  <th>Sähköposti</th>
  </tr>
  </thead>';
        while ($row = $stmt->fetch()) {
            $showFirst = $row['firstName'];
            $showLast = $row['lastName'];
            $showEmail = $row['email'];
            $showAnswer = $row['answer'];
            echo '<tr>';
            echo '<td id="answer' . $i . '">' . $showAnswer . '</td>';
            echo '<td style="text-transform: capitalize;" class="first">' . $showFirst . '</td>';
            echo '<td style="text-transform: capitalize;" class="last">' . $showLast . '</td>';
            echo '<td class="email">' . $showEmail . '</td>';
            echo '</tr>';
            $i++;
        }
    } else {
        echo '<h4 style="color:gray">Ei vastauksia</h4>';
    }
}
function getTeamName()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include 'dbh.php';

    $id = $_SESSION['id'];
    if ($_SESSION['type'] == 0 && isset($_GET['teamId'])) {
        $_SESSION['teamId'] = $_GET['teamId'];
        $teamId = $_SESSION['teamId'];
        $stmt = $conn->prepare("SELECT * from user WHERE team_id = :teamid AND owner_id = :id");
        $stmt->bindParam(':teamid', $teamId);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $stmt2 = $conn->prepare("SELECT * from team WHERE id = :teamid AND user_id = :id");
        $stmt2->bindParam(':teamid', $teamId);
        $stmt2->bindParam(':id', $id);
        $stmt2->execute();
        if ($row2 = $stmt2->fetch()) {
            $_SESSION['teamName'] = $row2['name'];
        }
        if ($row = $stmt->fetch()) {
            $_SESSION['teamId'] = $row['team_id'];
            $_SESSION['teamUid'] = $row['uid'];
        } else {
            unset($_SESSION['teamId']);
            unset($_SESSION['teamUid']);
            exit();
        }
    } else {
        if (isset($_GET['teamId'])) {
            $teamId = $_SESSION['teamId'];
            $stmt = $conn->prepare("SELECT * from user WHERE team_id = :teamid");
            $stmt->bindParam(':teamid', $teamId);
            $stmt->execute();
            $row = $stmt->fetch();
            if ($_GET['teamId'] == $row['team_id']) {
                $_SESSION['teamId'] = $_GET['teamId'];
                $stmt = $conn->prepare("SELECT * from team WHERE id = :teamid");
                $stmt->bindParam(':teamid', $teamId);
                $stmt->execute();
                if ($row = $stmt->fetch()) {
                    $_SESSION['teamName'] = $row['name'];
                }
            }
        }
    }
}

function editPlayers()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include 'dbh.php';

    $i =0;
    $id = $_SESSION['id'];
    $teamId = $_SESSION['teamId'];
    $stmt = $conn->prepare("SELECT * from player WHERE team_id = :teamid ORDER BY ID DESC");
    $stmt->bindParam(':teamid', $teamId);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo "<table class='u-full-width'>";
        while ($row = $stmt->fetch()) {
            $showId = $row['id'];
            $showFirst = $row['firstName'];
            $showLast = $row['lastName'];
            $showNum = $row['number'];
            echo '<tr>';
            echo '<td class="fetch img"><img alt="pelaajan kuva" style="width: 35px; vertical-align: middle;" src="images/logos/joukkue.png"></td>';

            echo '<td><input maxlength="3" class="numbers" type="text" style="margin-bottom:0;width:60px;" name="number' . $i . '" value="' . $showNum . '"></td>';
            echo '<td style="text-transform: capitalize;"><input maxlength="30" class="firstnames" type="text" style="margin-bottom:0;width:120px;" name="firstName' . $i . '" value="' . $showFirst . '"></td>';
            echo '<td style="text-transform: capitalize;"><input maxlength="30" class="lastnames" type="text" style="margin-bottom:0;width:160px;" name="lastName' . $i . '" value="' . $showLast . '"></td>';
            echo '<input class="ids" type="hidden" name="id' . $i . '" value="' . $showId . '" readonly>';
            echo '<td><a href="functions.php?removePlayer=' . $showId . '" id="iconRemove"><i class="material-icons">delete</i></a></td>';

            echo '</tr>';
            $i++;
        }
        echo '</table>';
    } else {
        echo '<script>window.location = "team.php"</script>';
    }
}

function addEvent()
{
    include 'dbh.php';
    if (!isset($_SESSION)) {
        session_start();
    }
    $teamId = $_SESSION['teamId'];
    $i = 0;
    $stmt = $conn->prepare("SELECT * from player WHERE team_id = :teamid");
    $stmt->bindParam(':teamid', $teamId);
    $stmt->execute();

    while ($row = $stmt->fetch()) {
        $showId = $row['id'];
        $_SESSION['event']['home']['firstName'][$i] = $row['firstName'];
        $_SESSION['event']['home']['lastName'][$i] = $row['lastName'];
        $_SESSION['event']['home']['number'][$i] = $row['number'];
        $_SESSION['event']['saved']['home']['firstName'][$i] = $row['firstName'];
        $_SESSION['event']['saved']['home']['lastName'][$i] = $row['lastName'];
        $_SESSION['event']['saved']['home']['number'][$i] = $row['number'];
        $i++;
    }

    getAds();
}

function error()
{
    header("Location: error.php");
}

function userData($mod)
{
    include 'dbh.php';
    if (!isset($_SESSION)) {
        session_start();
    }
    $id = $_SESSION['id'];
    $teamId = "";
    if (isset($_SESSION['teamId'])) {
        $teamId = $_SESSION['teamId'];
        $teamUid = $_SESSION['teamUid'];
        $teamName = $_SESSION['teamName'];
    }
    $stmt = $conn->prepare("SELECT * FROM user WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch();
    $userName = $row['uid'];
    $type = $row['type'];
    if ($row['sport'] == 1) {
        $sport = 'Salibandy';
    } elseif ($row['sport'] == 2) {
        $sport = 'Jääkiekko';
    } elseif ($row['sport'] == 3) {
        $sport = 'Jalkapallo';
    } elseif ($row['sport'] == 4) {
        $sport = 'Koripallo';
    }
    $stmt = $conn->prepare("SELECT * FROM team WHERE id = :teamid");
    $stmt->bindParam(':teamid', $teamId);
    $stmt->execute();
    $row = $stmt->fetch();
    $serie = $row['serie'];
    $serieArray = array("Miesten Salibandyliiga","Miesten Divari","Miesten 2-Divisioona",
"Naisten Salibandyliiga","Naisten 1-Divisioona","A-Poikien SM-Sarja","B-Poikien SM-Sarja",
"C1-Poikien SM-Sarja","C2-Poikien SM-Sarja","A-Tyttöjen SM-Sarja","B-Tyttöjen SM-Sarja",
"C-Tyttöjen SM-Sarja","Muu sarjataso");

    if ($mod == 'view') {
        echo '<tr>';
        echo '<td>Käyttäjänimi</td>';
        echo '<td>' . $userName . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td >Laji</td>';
        echo '<td >'.$sport.'</td>';
        echo '</tr>';
    }
    if (isset($_SESSION['teamId'])) {
        if ($mod == 'view') {
            echo '<tr>';
            echo '<td >Joukkueen nimi</td>';
            echo '<td>' . $teamName . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td >Sarjataso</td>';
            echo '<td>' . $serieArray[$serie-1] . '</td>';
            echo '</tr>';
        } else {
            echo '<tr>';
            echo '<td >Joukkueen nimi</td>';
            echo '<td><input maxlength="30" type="text" id="name" value="' . $teamName . '"</td>';
            echo '</tr>';
            echo '<tr><td >Sarjataso</td>
	<td><select id="serie">';
            $i = 1;
            foreach ($serieArray as $value) {
                if ($i == $serie) {
                    echo '<option selected="selected" value="'.$i.'">'.$value.'</option>';
                } else {
                    echo '<option value="'.$i.'">'.$value.'</option>';
                }
                $i++;
            }
            echo '</td></select></tr>';
        }
    }
    if ($mod == 'view') {
        echo '<tr>';
        echo '<td >Tilintyyppi</td>';
        if ($type == 1) {
            echo '<td>Joukkue</td>';
        } else {
            echo '<td>Seura</td>';
        }
    }
    echo '</tr>';
}
function setMatchText()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    unset($_SESSION['event']['matchText']);
    unset($_SESSION['event']['plainMatchText']);
    if ($_POST['matchText'] && !empty($_POST['matchText']) && $_POST['matchText'] != '{"ops":[{"insert":"\n"}]}') {
        $_SESSION['event']['matchText'] = $_POST['matchText'];
        $_SESSION['event']['plainMatchText'] = $_POST['plainMatchText'];
    }
    echo 'event4Success';
}

function setEventGuess()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include('dbh.php');
    if (!empty($_POST['guessName']) && !empty($_POST['guessType'])) {
        $_SESSION['event']['guessName'] = $_POST['guessName'];
        $_SESSION['event']['guessType'] = $_POST['guessType'];
    }
    echo 'event6Success';
}
function listAdLinks()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include('dbh.php');
    $linkArray = array();

    for ($i = 0; $i < 25; $i++) {
        array_push($linkArray, ${'link' . $i} = "");
    }

    if (isset($_SESSION['teamId'])) {
        $teamId= $_SESSION['teamId'];
    }
    $ownerId = $_SESSION['ownerId'];
    if (isset($_SESSION['teamId'])) {
        $stmt = $conn->prepare("SELECT * FROM adlinks WHERE team_id = :teamid");
        $stmt->bindParam(":teamid", $teamId);
    } else {
        $stmt = $conn->prepare("SELECT * FROM adlinks WHERE owner_id = :ownerid");
        $stmt->bindParam(":ownerid", $ownerId);
    }
    $stmt->execute();
    echo'<div id="link-box">
  <br>
  <label id="linkHeader" style="display:none" for="link">Mainoksen linkki</label>
  <p style="font-size:20px;font-weight:400;display:inline-block">www.</p>';

    if ($row = $stmt->fetch()) {
        $i = 1;
        foreach ($linkArray as $value) {
            ${'link'.$i} = $row['link'.$i];
            if (isset($_SESSION['event']['adlinks'][$i-1])) {
                ${'link'.$i} = $_SESSION['event']['adlinks'][$i-1];
            }
            echo '<input maxlength="100" style="display:none" type="text" class="link" id="link'.$i.'" value="'.${'link'.$i}.'">';
            $i++;
        }
    }
    echo '</div>';

    echo '<div id="popupDiv">
<label for="popupText">Mainosteksti</label>
<textarea class="popup-text" id="popupText" maxlength="75">';
    if (isset($_SESSION['event']['popupText'])) {
        echo $_SESSION['event']['popupText'];
    } else {
        echo $row['text'];
    }
    echo '</textarea></div>';
}
function listOffer()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include('dbh.php');
    $offerArray = array();
    $priceArray = array();
    for ($i = 0; $i < 10; $i++) {
        array_push($offerArray, ${'offer' . $i} = "");
        array_push($priceArray, ${'price' . $i} = "");
    }

    if (isset($_SESSION['teamId'])) {
        $teamId= $_SESSION['teamId'];
    }
    $ownerId = $_SESSION['ownerId'];
    if (isset($_SESSION['teamId'])) {
        $stmt = $conn->prepare("SELECT * FROM adlinks WHERE team_id = :teamid");
        $stmt->bindParam(":teamid", $teamId);
    } else {
        $stmt = $conn->prepare("SELECT * FROM adlinks WHERE owner_id = :ownerid");
        $stmt->bindParam(":ownerid", $ownerId);
    }
    $stmt->execute();
    $row = $stmt->fetch();
    echo '<div id="offer-box" style="display:none">
  <br>';
    echo '<label for="offerText">Tarjouksen otsikko</label>';

    $i = 1;
    foreach ($offerArray as $value) {
        ${'offer'.$i} = $row['offer'.$i];
        if (isset($_SESSION['event']['offers']['texts'][$i-1])) {
            ${'offer'.$i} = $_SESSION['event']['offers']['texts'][$i-1];
        }

        echo '<input style="display:none" type="text" maxlength="30" class="offer-text" id="offerInput'.$i.'" value="'.${'offer'.$i}.'">';
        $i++;
    }
    echo '<label for="offerPrice">Hinta</label>';
    $i = 1;
    foreach ($offerArray as $value) {
        ${'price'.$i} = $row['price'.$i];
        if (isset($_SESSION['event']['offers']['prices'][$i-1])) {
            ${'price'.$i} = $_SESSION['event']['offers']['prices'][$i-1];
        }
        echo '<input style="display:none" type="text" maxlength="5" class="offer-price" id="priceInput'.$i.'" value="'.${'price'.$i}.'">';
        $i++;
    }

    echo '</div>';
}

function setAdLinks()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include('dbh.php');
    if (isset($_SESSION['teamId'])) {
        $teamId = $_SESSION['teamId'];
    }
    $ownerId = $_SESSION['ownerId'];
    $pattern = '(^www\.|^http(.*)|\`|\~|\!|\@|\#|\$|^\%|\^|\&|\*|\(|\)|\+|\[|\{|\]|\}|\||\\|\'|\<|\,|^\.|\.$|\,$|\>|^\?|^\/|\"|\;|^\:|\s)i';
    for ($i = 1; $i <= 25; $i++) {
        if (!empty($_POST['link'.$i])) {
            if (!empty($_POST['imgData'] || isset($_SESSION['event']['ads'][$i]))) {
                if (!preg_match($pattern, $_POST['link'.$i])) {
                    if (isset($_SESSION['event']['edit'])) {
                        $_SESSION['event']['adlinks'][$i-1] = $_POST['link'.$i];
                    } else {
                        $link = $_POST['link'.$i];
                        if (isset($_SESSION['teamId'])) {
                            $stmt = $conn->prepare("UPDATE adlinks SET link".$i." = :adlink WHERE team_id = :teamid");
                            $stmt->bindParam(':teamid', $teamId);
                        } else {
                            $stmt = $conn->prepare("UPDATE adlinks SET link".$i." = :adlink WHERE owner_id = :ownerid");
                            $stmt->bindParam(':ownerid', $ownerId);
                        }
                        $stmt->bindParam(':adlink', $link);
                        $stmt->execute();
                    }
                } else {
                    echo 'adlink'.$i.'Invalid';
                    exit();
                }
            }
        }
    }
    if (isset($_POST['text'])) {
        if (isset($_SESSION['event']['edit'])) {
            $_SESSION['event']['popupText'] = $_POST['text'];
        } else {
            if (isset($_SESSION['teamId'])) {
                $stmt = $conn->prepare("UPDATE adlinks SET text = :popuptext WHERE team_id = :teamid");
                $stmt->bindParam(':teamid', $teamId);
            } else {
                $stmt = $conn->prepare("UPDATE adlinks SET text = :popuptext WHERE owner_id = :ownerid");
                $stmt->bindParam(':ownerid', $ownerId);
            }
            $stmt->bindParam(':popuptext', $_POST['text']);
            $stmt->execute();
        }
    }
    for ($i = 1; $i <= 10; $i++) {
        if (isset($_SESSION['event']['edit'])) {
            $_SESSION['event']['offers']['texts'][$i-1] = $_POST['offer'.$i];
        } else {
            $offer = $_POST['offer'.$i];
            if (isset($_SESSION['teamId'])) {
                $stmt = $conn->prepare("UPDATE adlinks SET offer".$i." = :offer WHERE team_id = :teamid");
                $stmt->bindParam(':teamid', $teamId);
            } else {
                $stmt = $conn->prepare("UPDATE adlinks SET offer".$i." = :offer WHERE owner_id = :ownerid");
                $stmt->bindParam(':ownerid', $ownerId);
            }
            $stmt->bindParam(':offer', $offer);
            $stmt->execute();
        }
    }
    for ($i = 1; $i <= 10; $i++) {
        if (isset($_SESSION['event']['edit'])) {
            $_SESSION['event']['offers']['prices'][$i-1] = $_POST['price'.$i];
        } else {
            $price = $_POST['price'.$i];
            if (isset($_SESSION['teamId'])) {
                $stmt = $conn->prepare("UPDATE adlinks SET price".$i." = :price WHERE team_id = :teamid");
                $stmt->bindParam(':teamid', $teamId);
            } else {
                $stmt = $conn->prepare("UPDATE adlinks SET price".$i." = :price WHERE owner_id = :ownerid");
                $stmt->bindParam(':ownerid', $ownerId);
            }
            $stmt->bindParam(':price', $price);
            $stmt->execute();
        }
    }
}
function getAds()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    include('dbh.php');
    if (isset($_SESSION['teamId'])) {
        $teamId = $_SESSION['teamId'];
    }
    $ownerId = $_SESSION['ownerId'];
    $teamUid = $_SESSION['teamUid'];

    for ($i = 1; $i <= 25; $i++) {
        ${'fileName' . $i . 's'} = 'images/ads/s_'.$ownerId.'_ad'.$i.'.png';
        ${'fileName' . $i . 'j'} = 'images/ads/j_'.$teamUid.$teamId.'_ad'.$i.'.png';
    }

    for ($i = 1; $i <= 25; $i++) {
        if (file_exists(${'fileName' . $i . 's'})) {
            $_SESSION['event']['ads'][$i-1] = ${'fileName' . $i . 's'};
        } elseif (file_exists(${'fileName' . $i . 'j'})) {
            $_SESSION['event']['ads'][$i-1] = ${'fileName' . $i . 'j'};
        }
    }
    for ($i = 1; $i <= 10; $i++) {
        ${'fileName' . $i . 's'} = 'images/ads/s_'.$ownerId.'_offer'.$i.'.png';
        ${'fileName' . $i . 'j'} = 'images/ads/j_'.$teamUid.$teamId.'_offer'.$i.'.png';
    }

    for ($i = 1; $i <= 10; $i++) {
        if (file_exists(${'fileName' . $i . 's'})) {
            $_SESSION['event']['offers']['images'][$i-1] = ${'fileName' . $i . 's'};
        } elseif (file_exists(${'fileName' . $i . 'j'})) {
            $_SESSION['event']['offers']['images'][$i-1] = ${'fileName' . $i . 'j'};
        }
    }

// Haetaan asetetut linkit
$stmt = $conn->prepare("SELECT * from adlinks WHERE team_id = :teamid");
    $stmt->bindParam(':teamid', $teamId);
    $stmt->execute();
    if ($row = $stmt->fetch()) {
        for ($i = 1; $i <= 25; $i++) {
            if (!empty($row['link'.$i])) {
                $_SESSION['event']['adlinks'][$i-1] = $row['link'.$i];
            }
        }
        for ($i = 1; $i <= 10; $i++) {
            if (!empty($row['offer'.$i])) {
                $_SESSION['event']['offers']['texts'][$i-1] = $row['offer'.$i];
            }
            if (!empty($row['price'.$i])) {
                $_SESSION['event']['offers']['prices'][$i-1] = $row['price'.$i];
            }
        }
    }
    $_SESSION['event']['popupText'] = $row['text'];
    if (!isset($_SESSION['event']['edit'])) {
        header("Location:event1.php");
    }
}

if (isset($_POST['getAds'])) {
    getAds();
}

if (isset($_POST['setMatchText'])) {
    setMatchText();
}

if (isset($_POST['setEventInfo'])) {
    if (validateEvent() != false) {
        setEventInfo();
    }
}
if (isset($_POST['setEventGuess'])) {
    if (validateEvent() != false) {
        setEventGuess();
    }
}

if (isset($_POST['setHomeTeam'])) {
    if (validateEvent() != false) {
        setHomeTeam();
    }
}

if (isset($_POST['setVisitorTeam'])) {
    if (validateEvent() != false) {
        setVisitorTeam(null);
    }
}

if (isset($_POST['addVisitor'])) {
    if (validateEvent() != false) {
        addVisitor();
    }
}

if (isset($_POST['addPlayer'])) {
    addPlayer();
}

if (isset($_POST['setUser'])) {
    setUser();
}

if (isset($_POST['addTeam'])) {
    addTeam();
}

if (isset($_POST['setPlayers'])) {
    setPlayers();
}

if (isset($_GET['removePlayer'])) {
    removePlayer();
}

if (isset($_GET['eventId'])) {
    getEvent();
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

if (isset($_POST['addEvent'])) {
    addEvent();
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
    if ($_POST['fileUpload'] == "ad" || $_POST['fileUpload'] == "offer") {
        fileUpload($_POST['number']);
    } else {
        fileUpload(null);
    }
}

if (isset($_POST['removeAd'])) {
    removeAd($_POST['removeAd'], null);
}

if (isset($_POST['populateGuess'])) {
    populateGuess();
}

if (isset($_POST['removeEventAd'])) {
    removeAd($_POST['removeEventAd'], 'event');
}

if (isset($_POST['sendActivation'])) {
    sendEmail('resend', $_POST['activationId'], null, null, null);
}
