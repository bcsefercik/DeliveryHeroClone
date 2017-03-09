<?php
//Include files
include('../includes/config.php'); include('../includes/database.php'); include('../includes/functions.php'); include('control.php');

if(!$login || $u_type!=3){redirectUrl($site_address); exit;}
?>

<!doctype html>
<html lang="tr">

<head>
<meta charset="utf-8">
<meta name="language" content="turkish">
<title>Restaurant Settings - <?=$site_titleExtension;?></title>
<?php include('../includes/meta.php'); ?>


<style>
	.registerForm{text-align: center; width: 480px; margin: 0 auto;}
		.registerForm .formLine{clear: both; height:36px; margin-top: 10px;}
		.registerForm .textLine{width: 480px; height: 32px; line-height: -9999px; text-indent: 9px; text-align: left; margin-top:2px; border:1px solid #aaa; border-radius: 8px; outline:none; font-size: 14px; font-weight: bold;}
			.registerForm .textLine #active{border-color: #f1bc1f;}
	.warning{min-height: 50px; line-height: 50px; font-size:18px; font-weight: bold; clear:both; margin-top: 15px; background: rgba(150,0,0,0.8); color: #fff; border-radius: 8px; text-align: center;}
</style>


</head>

<body>

<?php include('../header.php'); ?>
<div class="main">

<div style="clear:both; height:2px; border-top:2px solid #a71c34;"></div>




<div class="content">
	<div class="contentTitle">Choose or Create a Restaurant to Work on</div>


	<?php if(isset($_GET['warning'])){ ?>
		<div class="warning"><?=$_GET['warning'];?></div>
	<?php } ?>

	<div style="clear: both; height: 5px;"></div>
	<div class="registerForm">
	  <form action="<?=$site_address; ?>/u/restaurant-settings_process.php?m=select" method="post">
		<div class="formLine">
			<select name="restid" class="textLine">
			<?php $q = $mysqli->query("SELECT * FROM restaurants WHERE owner_id=$u_id");
				while ($i = $q->fetch_assoc()) {
					echo '<option value="'.$i['restaurant_id'].'">'.$i['name'].'</option>';
			 } ?>
			</select>
		</div>
		<div class="formLine">
		<a href="<?=$site_address; ?>/u/restaurant-settings.php?p=new&id=0" style="width: 234px; height: 32px; line-height: 32px; text-align: center; float: right; font-weight: bold; color: #fff; background: #850715; border-radius: 3px;"> or New Restaurant</a>
			<input type="submit" value="Select" style="width: 234px; height: 32px; line-height: -9999px; text-align: center; float: left; font-weight: bold;" />
		</div>
	  </form>
	</div>

<div style="clear:both;"></div>   
</div>


<div style="clear:both; height:13px;"></div>

<?php include('../footer.php'); ?>
</body>
</html>
<?php $mysqli->close();
ob_end_flush(); ?>