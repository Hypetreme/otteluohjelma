<?php
if(!isset($_SESSION)) {
session_start();
}
echo '<script type="text/javascript">';
echo 'alert("adasdasdsa");';
echo '</script>';
if(isset($_SESSION['id'])) {
$id = $_SESSION['id'];
$uid = $_SESSION['uid'];
$ownerId = $_SESSION['ownerId'];
if(isset($_SESSION['teamId'])) {
$teamId =	$_SESSION['teamId'];
$teamUid =	$_SESSION['teamUid'];
}
if ($mod !='ad1' || $mod !='ad2' || $mod !='ad3' || $mod !='ad4') {
	$filename = $_FILES["file"]["name"];
	$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
	$file_ext = substr($filename, strripos($filename, '.')); // get file name
	$filesize = $_FILES["file"]["size"];
	$allowed_file_types = array('.jpg','.jpeg','.png','.gif');
} else {
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
		 else {
			$newfilename = $teamUid . $teamId . $file_ext;

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
	 }
		else {
			if ($mod =='ad1') {
		//$newfilename = 's_'. $ownerId .'_ad1'. $file_ext;
		$newfilename = UPLOAD_DIR . 's_'. $ownerUid . '_ad1'. '.png';
			}
			else if ($mod =='ad2') {
		//$newfilename = 's_'. $ownerId .'_ad2'. $file_ext;
		$newfilename = UPLOAD_DIR . 's_'. $ownerUid . '_ad2'. '.png';
				}
			else if ($mod =='ad3') {
		//$newfilename = 's_'. $ownerId .'_ad3'. $file_ext;
		$newfilename = UPLOAD_DIR . 's_'. $ownerUid . '_ad3'. '.png';
					}
			else if ($mod =='ad4') {
		//$newfilename = 's_'. $ownerId .'_ad4'. $file_ext;
		$newfilename = UPLOAD_DIR . 's_'. $ownerUid . '_ad4'. '.png';
						}
			else {
		$newfilename = $uid . $id . $file_ext;
	}
	}

	if (!in_array($file_ext,$allowed_file_types) && (!$filesize < 200000))
	{
		// file type error
		unlink($_FILES["file"]["tmp_name"]);
		echo '<script type="text/javascript">';
		echo 'alert("Kuva ei ole sallitussa muodossa!");';
		if ($mod =='ad1' || $mod =='ad2' || $mod =='ad3' || $mod =='ad4') {
		echo 'document.location.href = "ads.php";';
	} else {
		echo 'document.location.href = "profile.php";';
	}
		echo '</script>';
		//echo "Only these file types are allowed for upload: " . implode(', ',$allowed_file_types);

	}
	elseif (empty($file_basename) || empty($img))
	{
		// file selection error
		echo '<script type="text/javascript">';
		echo 'alert("Valitse ladattava kuva!");';
		if ($mod =='ad1' || $mod =='ad2' || $mod =='ad3' || $mod =='ad4') {
		echo 'document.location.href = "ads.php";';
	} else {
		echo 'document.location.href = "profile.php";';
	}
		echo '</script>';
	}
	elseif ($filesize > 200000)
	{
		// file size error
		echo '<script type="text/javascript">';
		echo 'alert("Kuvan tiedostokoko on liian iso!");';
		if ($mod =='ad1' || $mod =='ad2' || $mod =='ad3' || $mod =='ad4') {
		echo 'document.location.href = "ads.php";';
	} else {
		echo 'document.location.href = "profile.php";';
	}
		echo '</script>';
	}
	else
	{
			if ($mod =='ad1' || $mod =='ad2' || $mod =='ad3' || $mod =='ad4') {
		file_put_contents($newfilename, $data);
		echo '<script type="text/javascript">';
		echo 'alert("Kuvan lataus onnistui.");';
		if (isset($_SESSION['homeName'])) {
		echo 'document.location.href = "event5.php";';
	} else {
	echo 'document.location.href = "ads.php";';
	}
		echo '</script>';
	} else {
move_uploaded_file($_FILES["file"]["tmp_name"], "images/logos/" . $newfilename);
echo '<script type="text/javascript">';
echo 'alert("Kuvan lataus onnistui.");';
echo 'document.location.href = "profile.php";';
echo '</script>';
}
	}
}
?>
