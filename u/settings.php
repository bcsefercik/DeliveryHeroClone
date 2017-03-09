<?php
//Include files
include('../includes/config.php'); include('../includes/database.php'); include('../includes/functions.php'); include('control.php');

if(!$login){redirectUrl($site_address); exit;}
?>
<!doctype html>
<html lang="tr">

<head>
<meta charset="utf-8">
<meta name="language" content="turkish">
<title>Settings - <?=$site_titleExtension;?></title>
<?php include('../includes/meta.php'); ?>

<style>

	.leftLinks {clear: both;width:301px; background: rgba(206,206,206,0.4); padding: 4px 0 8px 0; border-radius: 8px;}
		.leftLinks .alink{border-bottom: 1px solid #fff; clear: both; display: block; color: #850715; font-weight: bold; font-size: 14px; line-height: 36px; height: 34px; text-indent: 10px;}
				.leftLinks .alink:hover{background: rgba(196,196,196,0.8);}
	.warning{min-height: 40px; line-height: 40px; font-size:16px; font-weight: bold; clear:both; margin-top: 10px; background: rgba(150,0,0,0.8); color: #fff; border-radius: 8px; text-align: center;}
	.smsg{min-height: 40px; line-height: 40px; font-size:16px; font-weight: bold; clear:both; margin-top: 10px; background: rgba(0,150,0,0.8); color: #fff; border-radius: 8px; text-align: center;}

	.settingsTitle{height: 40px; line-height: 40px; border-radius: 6px; border-bottom: 2px solid #ab0012; color:#850715; clear:both; display:block;text-align: center; font-size:20px; background: rgba(255,255,255,0.5);}
	.settingsForm{text-align: center; width: 610px; margin: 0 auto;}
		.settingsForm .formLine{clear: both; height:36px; margin-top: 10px;}
		.settingsForm .lineTitle{float:left; width: 195px; height: 34px; line-height: 36px; margin-top: 2px;text-align: right; font-size: 16px; font-weight: bold; color:#850715;}
		.settingsForm .lineText{width: 300px; height: 32px; line-height: -9999px; text-indent: 9px; text-align: left; margin:2px 0 0 15px; border:1px solid #aaa; border-radius: 8px; outline:none; font-size: 14px; font-weight: bold; float: left;}
			.settingsForm .lineText #active{border-color: #f1bc1f;}
</style>
</head>

<body>

<?php include('../header.php'); ?>
<div class="main">

<div style="clear:both; height:2px; border-top:2px solid #a71c34;"></div>


<div class="sidebar">

	<div class="leftLinks">
		<div style="border-bottom: 1px solid #fff; height: 4px; clear: both;"></div>
		<a class="alink" href="<?=$site_address;?>/u/settings.php?p=changepassword">Password</a>
		<a class="alink" href="<?=$site_address;?>/u/settings.php?p=changeemail">Email</a>
		<a class="alink" href="<?=$site_address;?>/u/settings.php?p=personalinfo">Personal Information</a>
		<a class="alink" href="<?=$site_address;?>/u/settings.php?p=favorites">Favorites</a>
	</div>
    <?php include('../sidebar.php'); ?>
</div>


<div class="rightContent">
<?php 
if(isset($_GET['warning']))
	$w = '<div class="warning">'.$_GET['warning'].'</div>';
elseif(isset($_GET['smsg']))
	$w = '<div class="smsg">'.$_GET['smsg'].'</div>';
else
	$w = '';

if(isset($_GET['p']))
	$p = $_GET['p'];
else
	$p = '';

switch ($p) {
	case 'changepassword':
		echo '<div class="settingsTitle">Password Settings</div>'.$w;
		include('s_changepassword.php');
		break;
	case 'changeemail':
		echo '<div class="settingsTitle">Email Settings</div>'.$w;
		include('s_changeemail.php');
		break;
	
	default:
		echo '<div class="settingsTitle">Personal Information Settings</div>'.$w;
		include('s_personalinfo.php');
		break;
}

?>
<div style="clear:both;"></div>   
</div>


<div style="clear:both; height:13px;"></div>

<?php include('../footer.php'); ?>
</body>
</html>
<?php $mysqli->close(); ?>