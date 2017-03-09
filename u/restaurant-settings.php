<?php
//Include files
include('../includes/config.php'); include('../includes/database.php'); include('../includes/functions.php'); include('control.php');


if(!$login || $u_type!=3 || !isset($_GET['id'])){redirectUrl($site_address); exit;}

$restid = $_GET['id'];


if($restid!=0){
	$q = $mysqli->query("SELECT * FROM restaurants WHERE restaurant_id='$restid'");
	if($q->num_rows!=1){redirectUrl($site_address); exit;}

	$in = $q->fetch_assoc();
	if($in['owner_id']!=$u_id){redirectUrl($site_address); exit;}

	$restname = $in['name'];

}

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
	.restaurantRegions{text-align: left; width: 610px; margin: 0 auto;}
		.restaurantRegions .regionLine{height: 36px; line-height: 36px; font-weight: bold; text-indent: 16px; clear: both; width: %100; border-bottom: 1px solid #ddd;  background: rgba(255,255,255,0.5);}
				.restaurantRegions .regionLine:hover,.restaurantRegions #dark:hover{background: #fff;}
				.restaurantRegions #dark{ background: rgba(225,225,225,0.5);}
		.restaurantRegions .regionDelete{float: right; background: #850715; color: #fff; opacity: 0.5; height: 24px; line-height: 24px; margin: 6px 16px 0 0; font-size: 14px; display: block; padding: 0 8px 0 8px; border-radius: 6px; text-align: center; display: block; text-indent: 0px;}
			.restaurantRegions .regionDelete:hover{opacity: 1;}
		.restaurantRegions .orderDelete{float: right; background: #a90000; color: #fff; opacity: 0.5; height: 20px; line-height: 20px; margin: 8px 8px 0 0; font-size: 12px; display: block; padding: 0 4px 0 4px; border-radius: 6px; text-align: center; display: block; text-indent: 0px;}
			.restaurantRegions .orderDelete:hover{opacity: 1;}
</style>
</head>

<body>

<?php include('../header.php'); ?>
<div class="main">

<div style="clear:both; height:2px; border-top:2px solid #a71c34;"></div>


<div class="sidebar">
	<?php if($restid!=0){?>
	<div style="clear: both; height: 40px; line-height: 40px; font-weight: bold; color: #850715; text-decoration: underline; text-align: center;"><?=$in['name'];?></div>
	<div class="leftLinks">
		<div style="border-bottom: 1px solid #fff; height: 4px; clear: both;"></div>
		<a class="alink" href="<?=$site_address;?>/u/restaurant-settings.php?id=<?=$restid;?>&p=regions">Served Regions</a>
		<a class="alink" href="<?=$site_address;?>/u/restaurant-settings.php?id=<?=$restid;?>&p=menu">Menu</a>
		<a class="alink" href="<?=$site_address;?>/u/restaurant-settings.php?id=<?=$restid;?>">General Information</a>
		<a class="alink" href="<?=$site_address;?>/u/restaurant-settings.php?id=<?=$restid;?>&p=orders">View Orders</a>
		<a class="alink" href="<?=$site_address;?>/u/restaurant-settings_process.php?restid=<?=$restid;?>&m=delete">Delete Restaurant</a>
	</div>
    <?php } include('../sidebar.php'); ?>
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
	case 'regions':
		echo '<div class="settingsTitle">Add New Region</div>'.$w;
		include('rs_regions.php');
		break;
	case 'menu':
		echo '<div class="settingsTitle">Add New Item</div>'.$w;
		include('rs_menu.php');
		break;
	case 'orders':
		echo '<div class="settingsTitle">Recent Orders</div>'.$w;
		include('rs_orders.php');
		break;
	case 'new':
		echo '<div class="settingsTitle">Add a New Restaurant</div>'.$w;
		include('rs_new.php');
		break;
	
	default:
		echo '<div class="settingsTitle">General Settings</div>'.$w;
		include('rs_general.php');
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