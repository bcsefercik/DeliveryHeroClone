<?php
//Include files
include('../includes/config.php'); include('../includes/database.php');
include('../includes/functions.php'); include('control.php');

if(!$login){redirectUrl($site_address); exit;}


if(isset($_GET['m']))
	$m = $_GET['m'];
else
	$m = '';




switch ($m) {
	case 'personalinfo':
		$sphone = $mysqli->real_escape_string(strip_tags(trim($_POST['sphone']))); 
		$sname = $mysqli->real_escape_string(strip_tags(trim($_POST['sname']))); 

		$r = checkName($sname);
		if($r!='ok'){
			redirectUrl($site_address.'/u/settings.php?p=s_personalinfo&warning='.$r);
			exit;
		}
		if(strlen($sphone)!=10 || !is_numeric($sphone)){redirectUrl($site_address.'/u/settings.php?p=s_personalinfo&warning=Please enter a valid phone number.'); exit;}

		$mysqli->query("UPDATE users SET name ='$sname', phone = '$sphone' WHERE user_id = '$u_id'");		

		redirectUrl($site_address.'/u/settings.php?p=personalinfo&smsg=Your information has been updated successfully.');
		exit;
		break;
	case 'changeemail':
		$semail = $mysqli->real_escape_string(strip_tags(trim($_POST['semail']))); 

		
		if(!checkEmail($semail)){
			redirectUrl($site_address.'/u/settings.php?p=changeemail&warning=Please enter a valid email address.');
			exit;
		}

		$mysqli->query("UPDATE users SET email ='$semail' WHERE user_id = '$u_id'");		

		redirectUrl($site_address.'/u/settings.php?p=changeemail&smsg=Your email has been updated successfully.');
		exit;
		break;
	case 'changepassword':
		$scpassword = $mysqli->real_escape_string(strip_tags(trim($_POST['scpassword']))); 
		$scpassword = md5($scpassword);
		$spassword = $mysqli->real_escape_string(strip_tags(trim($_POST['spassword']))); 
		$sapassword = $mysqli->real_escape_string(strip_tags(trim($_POST['sapassword'])));


		if($spassword != $sapassword){
			redirectUrl($site_address.'/u/settings.php?p=changepassword&warning=New passwords should be same.');
			exit;
		}

		$nicknamematch = $mysqli->query("SELECT * FROM users WHERE user_id='$u_id' AND password='$scpassword'");
		if ($nicknamematch->num_rows<1){
			redirectUrl($site_address.'/u/settings.php?p=changepassword&warning=Current password is wrong.');
			exit;
		}

		$r = checkPassword($spassword);
		if($r!='ok'){
			redirectUrl($site_address.'/u/settings.php?p=changepassword&warning='.$r);
			exit;
		}
		$spassword = md5($spassword);
		$mysqli->query("UPDATE users SET password ='$spassword' WHERE user_id = '$u_id'");		

		redirectUrl($site_address.'/u/settings.php?p=changeemail&smsg=Your email has been updated successfully.');
		exit;
		break;
	
	default:
		redirectUrl($site_address);
		exit;
		break;
}


$mysqli->close();

echo 'Redirecting...';



ob_end_flush();
?>