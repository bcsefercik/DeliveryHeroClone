<?php

//Include files
include('includes/config.php'); include('includes/database.php'); include('includes/functions.php'); include('u/control.php');
?>

<!doctype html>
<html lang="tr">

<head>
<meta charset="utf-8">
<meta name="language" content="turkish">
<title>ABA Food Ordering Solution</title>
<?php include('includes/meta.php'); ?>
<style>
	.restaurantList{}
		.restaurantList .restaurantBox{background: rgba(240,240,240,0.8); border-radius:6px; margin-top:8px; clear: both; border:1px solid #fff;transition: all 0.4s; transition-property:opacity, background, border-color;}
			.restaurantList .restaurantBox:hover{background: rgba(255,255,255,0.95); border-color: #ab0012;}
				.restaurantList .restaurantBox:hover .title{border-color: #ab0012;transition: all 0.4s; transition-property:opacity, background, border-color;}
			.restaurantList .restaurantBox .title{font-size: 14px; font-weight: bold; color: #ab0012; height: 30px; line-height: 32px; border-bottom:1px solid #fff; text-indent:8px;}
			.restaurantList .restaurantBox .avgdelivery{float: left; margin-left: 8px; color:#444; height: 30px; line-height: 30px; font-size: 12px;}
			.restaurantList .restaurantBox .servicehours{float: left; margin-left: 8px; color:#444; height: 30px; line-height: 30px; font-size: 12px;}
</style>

</head>

<body>

<?php include('header.php'); ?>
<div class="main">

<div style="clear:both; height:2px; border-top:2px solid #a71c34;"></div>


<div class="sidebar">
    <?php include('sidebar.php'); ?>
</div>


<div class="rightContent">
<?php if($login && $u_type!=3){include('restaurants.php');}
	else{}?>
<div style="clear:both;"></div>   
</div>


<div style="clear:both; height:13px;"></div>

<?php include('footer.php'); ?>
</body>
</html>
<?php $mysqli->close(); ?>