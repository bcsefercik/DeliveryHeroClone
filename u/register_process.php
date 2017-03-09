<?php
//Include files
include('../includes/config.php'); include('../includes/database.php');
include('../includes/functions.php');



$u_username = $mysqli->real_escape_string(strip_tags(trim($_POST['username'])));
$u_password = $mysqli->real_escape_string(strip_tags(trim($_POST['password'])));
$u_passwordmd5 = md5($u_password);
$u_email = $mysqli->real_escape_string(strip_tags(trim($_POST['email']))); 
$u_phone = $mysqli->real_escape_string(strip_tags(trim($_POST['phone']))); 
$u_name = $mysqli->real_escape_string(strip_tags(trim($_POST['name']))); 
$u_doornumber = $mysqli->real_escape_string(strip_tags(trim($_POST['door_number'])));
$u_street = $mysqli->real_escape_string(strip_tags(trim($_POST['street'])));
$u_district = $mysqli->real_escape_string(strip_tags(trim($_POST['district'])));
$u_city = $mysqli->real_escape_string(strip_tags(trim($_POST['city'])));
$u_type = 1;

if(isset($_POST['owner'])){
	$u_type = 3;
	$_SESSION['u_regtype'] = "behlul";
}else{
	if(isset($_SESSION['u_regtype']))
		unset($_SESSION['u_regtype']);
}



//Checking posts
if($u_username=='Username' || empty($u_password) || $u_email=='Email' || $u_phone=='Phone' || $u_name=='Name Surname' || $u_doornumber=='Door #' || $u_street=='Street' || $u_district=='Distrcit' || $u_city=='City'
	||empty($u_username) || empty($u_password) || empty($u_email) || empty($u_phone) || empty($u_district) || empty($u_name) || empty($u_doornumber) || empty($u_street) || empty($u_city)
	){redirectUrl($site_address.'/u/register.php?warning=You cannot leave any area empty.'); exit;}

$_SESSION['u_regusername'] = $u_username;$_SESSION['u_regpassword']='yes';$_SESSION['u_regemail'] = $u_email;$_SESSION['u_regname'] = $u_name;$_SESSION['u_regdoornumber'] = $u_doornumber;$_SESSION['u_regstreet'] = $u_street; $_SESSION['u_regdistrict'] = $u_district; $_SESSION['u_regcity'] = $u_city; $_SESSION['u_regphone'] = $u_phone; 


//Checking username
if(strlen($u_username)<3){unset($_SESSION['u_regusername']); redirectUrl($site_address.'/u/register.php?warning=You need a longer username!'); exit;}
$nicknamematch = $mysqli->query("SELECT username FROM users WHERE username='$u_username'");
if ($nicknamematch->num_rows>0){unset($_SESSION['u_regusername']); redirectUrl($site_address.'/u/register.php?warning='.$u_username.' is used by another user. Please choose a different username.'); exit;}

//Checking password
$res = checkPassword($u_password);
if($res!='ok'){redirectUrl($site_address.'/u/register.php?warning='.$res); exit;}

//Checkin email
if(!checkEmail($u_email)){redirectUrl($site_address.'/u/register.php?warning=Please enter a valid email address.'); exit;}

$nicknamematch = $mysqli->query("SELECT email FROM users WHERE email='$u_email'");
if ($nicknamematch->num_rows>0){unset($_SESSION['u_regemail']); redirectUrl($site_address.'/u/register.php?warning='.$u_email.' is used by another user. Please enter a different email address.'); exit;}

//name check
$res = checkName($u_name);
if($res!='ok'){redirectUrl($site_address.'/u/register.php?warning='.$res); exit;}

//phone check
if(strlen($u_phone)!=10 || !is_numeric($u_phone)){redirectUrl($site_address.'/u/register.php?warning=Please enter a valid phone number.'); exit;}

//door num

if(!is_numeric($u_doornumber)){redirectUrl($site_address.'/u/register.php?warning=Please enter a valid door number.'); exit;}

//Registering user
$mysqli->query("INSERT INTO users (username,password,email,name,phone,type) VALUES ('$u_username', '$u_passwordmd5', '$u_email', '$u_name', '$u_phone', '$u_type')");

$u_id = mysqli_insert_id($mysqli);

$mysqli->query("INSERT INTO addresses (user_id,door_number,street,district,city) VALUES ('$u_id', '$u_doornumber', '$u_street', '$u_district', '$u_city')");

$mysqli->query("INSERT INTO users_customer (user_id,bonus) VALUES ($u_id,0)");


unset($_SESSION['u_regusername']); unset($_SESSION['u_regpassword']); unset($_SESSION['u_regemail']); unset($_SESSION['u_regname']); unset($_SESSION['u_regdoornumber']);unset($_SESSION['u_regstreet']);unset($_SESSION['u_regdistrict']);unset($_SESSION['u_regcity']);unset($_SESSION['u_regphone']);

 

$_SESSION["u_user"] = md5( "user_" . md5( md5($u_passwordmd5) ) . "_ds785667f5e67w423yjgty" );

$_SESSION["u_username"]  = $u_username;


$mysqli->close();

echo 'Redirecting...';

redirectUrl($site_address);

exit;

ob_end_flush();
?>