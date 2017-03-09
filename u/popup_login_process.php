<?php
session_start();

include('../includes/config.php'); include('../includes/database.php');

include('../includes/functions.php');
 
#Getting post values
$u_username  = $mysqli->real_escape_string(strip_tags(trim($_POST['username'])));
$u_password = $mysqli->real_escape_string(strip_tags(trim($_POST['password'])));
$u_passwordmd5 = md5($u_password);
 
//Checkin values
if($u_username=='Username' ||$u_username=='' || $u_password==''){redirectUrl($site_address.'/u/popup_login.php?warning=Please do not leave empty area.'); exit;}
 
//Checking username
$nicnameControlSql = $mysqli->query("SELECT * FROM users WHERE username = '".$u_username."'");
  if($nicnameControlSql->num_rows != 1 ){
    redirectUrl($site_address.'/u/popup_login.php?warning=Username or password is wrong.');
    exit;
  }
  else{
    //Getting information
      $bilgi = $nicnameControlSql->fetch_assoc();
	  $u_username = $bilgi['username'];
  }
 
//Checking password
  if( $u_passwordmd5 != $bilgi['password'] ){
    redirectUrl($site_address.'/u/popup_login.php?warning=Username or password is wrong.');
    exit;
  }


$_SESSION["u_user"] = md5( "user_" . md5( md5($u_passwordmd5) ) . "_ds785667f5e67w423yjgty" );

$_SESSION["u_username"]  = $u_username;


$mysqli->close();

?>

<title>Logged in...</title>

<script type="text/javascript">window.opener.window.parent.document.location.reload(true); window.close(); </script>

