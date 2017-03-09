<?php

//Include files
include('includes/config.php'); include('includes/database.php'); include('includes/functions.php'); include('u/control.php');

if((!$login || $u_type==3)){redirectUrl($site_address); exit;}


$cartq = $mysqli->query("SELECT sum(price) as total, restaurant_id FROM cart natural join cart_items natural join menu_items WHERE customer_id='$u_id'")->fetch_assoc();
$tPrice = $cartq['total'];
$restid = $cartq['restaurant_id'];


if($tPrice==0 && !isset($_GET['smsg'])){redirectUrl($site_address); exit;}
$ri = $mysqli->query("SELECT * FROM restaurants natural left join restaurant_regions where  restaurant_id='$restid'")->fetch_assoc();
?>

<!doctype html>
<html lang="tr">

<head>
<meta charset="utf-8">
<meta name="language" content="turkish">
<title>Purchase - <?=$site_titleExtension;?></title>
<?php include('includes/meta.php'); ?>
<style>
	


	.avgdelivery,.servicehours{float: left; margin-left: 8px; color:#444; height: 40px; line-height: 42px; font-size: 14px;}
	.date{float: left; margin-left: 8px; color:#444; height: 50px; line-height: 52px; font-size: 14px;}
	.warning{min-height: 40px; line-height: 40px; font-size:16px; font-weight: bold; clear:both; margin-top: 10px; background: rgba(150,0,0,0.8); color: #fff; border-radius: 8px; text-align: center;}
	.smsg{min-height: 40px; line-height: 40px; font-size:16px; font-weight: bold; clear:both; margin-top: 10px; background: rgba(0,150,0,0.8); color: #fff; border-radius: 8px; text-align: center;}
</style>

</head>

<body>

<?php include('header.php'); 

$maxdate = new DateTime($serverDate);
$maxdate->add(new DateInterval('PT48H1M'));
?>
<div class="main">

<div style="clear:both; height:2px; border-top:2px solid #a71c34;"></div>


<div class="sidebar">
    <?php include('sidebar.php'); ?>
</div>


<div class="rightContent">

<?php
	if(isset($_GET['warning']))
		$w = '<div class="warning">'.$_GET['warning'].'</div>'.'<div style="clear:both; height:15px;"></div>';
	elseif(isset($_GET['smsg']))
		$w = '<div class="smsg">'.$_GET['smsg'].'</div>'.'<div style="clear:both; height:15px;"></div>';
	else
		$w = '';

	echo $w;
?>

<?php if(!isset($_GET['smsg'])){ ?>
<div class="contentTitle" style="text-align:left; text-indent:8px; border-radius:6px 6px 0 0;">Purchase</div>


<div style="clear:both;"></div>
<form method="post" action="<?=$site_address.'/purchase_process.php';?>">
<div class="avgdelivery"><span style="font-weight:bold;">Average Delivery: </span><?php echo $ri['avg_delivery']>59 ? '1 hour ':' '; 
						echo $ri['avg_delivery']%60>0 ? ($ri['avg_delivery']%60).' minutes':'';?></div>
		<div class="servicehours"><span style="font-weight:bold;">Service Hours: </span><?php echo $ri['start_hr'].'.';
					echo $ri['start_min']<10 ? '0':'';
					echo $ri['start_min'].' - ';
		 			echo $ri['end_hr'].'.';
					echo $ri['end_min']<10 ? '0':'';
					echo $ri['end_min'];?></div>
<div style="clear:both; height:1px; border-bottom:1px solid #ccc;"></div>
<div class="date">
	<div style="float:left; font-weight:bold;">Delivery Date:</div> 
	<label><div style="float: left; margin-left:10px;"><input type="radio" name="ddate" value="now" checked="checked" style="margin:19px 2px; float:left;">ASAP</div></label>
	<label><div style="float: left; margin-left:15px;"><input type="radio" name="ddate" value="later" style="margin:19px 2px; float:left;">Later: <input type="date" name="deldate" min="<?=date('Y-m-d');?>" max="<?=$maxdate->format('Y-m-d');?>" value="<?=date('Y-m-d');?>"> <input type="time" name="deltime" step="900" min="<?php echo ($ri['start_hr']<10?'0':'').$ri['start_hr'].':'.($ri['start_min']<10?'0':'').$ri['start_min']; ?>" max="<?php echo ($ri['end_hr']<10?'0':'').$ri['end_hr'].':'.($ri['end_min']<10?'0':'').$ri['end_min']; ?>" ></div></label>

 </div>
<div style="clear:both; height:1px; border-bottom:1px solid #ccc;"></div>
<div class="date">
	<div style="float:left; font-weight:bold;">Payment Type:</div> 
	<label><div style="float: left; margin-left:10px;"><input type="radio" name="daeete" value="noww" checked="checked" style="margin:19px 2px; float:left;">Credit Card</div></label>
	<label><div style="float: left; margin-left:15px;"><input type="radio" name="dateee" value="lateeer" style="margin:19px 2px; float:left;">Cash</div></label>

 </div>
<div style="clear:both; height:1px; border-bottom:1px solid #ccc;"></div>
<div class="date" style="float:right; font-size:24px;">
	<div style="float: right; margin-right:10px;"><?=$tPrice;?> ₺</div>
	<div style="float:right; font-weight:bold; margin-right:10px;">Total:</div> 

</div>
<div style="clear:both;height:19px;"></div>
<div class="date" style="float:right; font-size:24px;">
	<input type="submit" name="Finish" value="FINISH" style="background:#00a900; float:right; border-radius:8px; height:44px; border:2px solid #00ff00; font-weight: bold; color:#003900; line-height:-9999px; width:120px; "> 

</div>
<div style="clear:both;"></div>   
</div>
</form>
<?php }?>
</div>
<div style="clear:both; height:13px;"></div>

<?php include('footer.php'); ?>
</body>
</html>
<?php $mysqli->close(); ?>