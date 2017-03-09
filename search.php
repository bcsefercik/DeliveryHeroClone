<?php

//Include files
include('includes/config.php'); include('includes/database.php'); include('includes/functions.php'); include('u/control.php');

if(!$login || $u_type==3 || !isset($_GET['s']) || !isset($_GET['type'])){redirectUrl($site_address); exit;}

$kw = $mysqli->real_escape_string(strip_tags(trim($_GET['s'])));
$type = $mysqli->real_escape_string(strip_tags(trim($_GET['type'])));

if($type!='cuisine')
	$type = 'restaurant';

$orderby = 'name';

if(isset($_GET['sort']) && $_GET['sort']=='avg_delivery')
		$orderby = 'avg_delivery';


if($type=='restaurant'){
	$q = $mysqli->query("SELECT*FROM restaurants natural join restaurant_regions where region_id='$u_region' and item_count!=0 and name LIKE '%$kw%' ORDER BY $orderby ASC");
	$qnull = $mysqli->query("SELECT*FROM restaurants natural left join restaurant_regions where (region_id is null) and item_count!=0 and name LIKE '%$kw%'");
}
if($type=='cuisine'){
	$q = $mysqli->query("SELECT menu_items.name as name,price,restaurants.name as rname, avg_delivery,restaurants.restaurant_id as rid FROM restaurants join restaurant_regions on (restaurants.restaurant_id=restaurant_regions.restaurant_id) join menus on (menus.restaurant_id=restaurants.restaurant_id) join menu_items on (menu_items.menu_id=menus.restaurant_id) where region_id='$u_region' and item_count!=0 and menu_items.name LIKE '%$kw%' ORDER BY $orderby ASC");
	$qnull = $mysqli->query("SELECT menu_items.name as name,price,restaurants.name as rname, avg_delivery,restaurants.restaurant_id as rid FROM restaurants left join restaurant_regions on (restaurants.restaurant_id=restaurant_regions.restaurant_id) join menus on (menus.restaurant_id=restaurants.restaurant_id) join menu_items on (menu_items.menu_id=menus.restaurant_id) where region_id is null and item_count!=0 and menu_items.name LIKE '%$kw%' ORDER BY $orderby ASC");
}

?>

<!doctype html>
<html lang="tr">

<head>
<meta charset="utf-8">
<meta name="language" content="turkish">
<title>Search Results for <?=$kw;?> - <?=$site_titleExtension;?></title>
<?php include('includes/meta.php'); ?>
<style>
	.restaurantList{}
		.restaurantList .restaurantBox{background: rgba(240,240,240,0.8); border-radius:6px; margin-top:8px; clear: both; border:1px solid #fff;transition: all 0.4s; transition-property:opacity, background, border-color;}
			.restaurantList .restaurantBox:hover{background: rgba(255,255,255,0.95); border-color: #ab0012;}
				.restaurantList .restaurantBox:hover .title{border-color: #ab0012;transition: all 0.4s; transition-property:opacity, background, border-color;}
			.restaurantList .restaurantBox .title{font-size: 14px; font-weight: bold; color: #ab0012; height: 30px; line-height: 32px; border-bottom:1px solid #fff; text-indent:8px;}
			.restaurantList .restaurantBox .avgdelivery{float: left; margin-left: 8px; color:#444; height: 30px; line-height: 30px; font-size: 12px;}
			.restaurantList .restaurantBox .servicehours{float: left; margin-left: 8px; color:#444; height: 30px; line-height: 30px; font-size: 12px;}
	.cuisineList{}
		.cuisineList .cuisineItem, .cuisineList a{background: rgba(240,240,240,0.8); clear: both; border-bottom:1px solid #fff;transition: all 0.4s; transition-property:opacity, background, border-color; height: 36px; line-height: 36px; font-size: 14px; font-weight: bold; color: #ab0012; text-indent:8px; margin-top:3px;}
			.cuisineList .cuisineItem:hover{background: rgba(255,255,255,0.95); border-color: #ab0012;}
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
<div class="contentTitle" style="text-align:left; text-indent:8px; border-radius:6px 6px 0 0;">Search Results for <span style="font-style:italic;"><?=$kw;?></span></div>
<div style="clear:both;"></div>


<?php if($type=='restaurant'){?>
<div class="restaurantList">

<?php 

	while($i = $q->fetch_assoc()){
?><div class="restaurantBox" href="<?=$site_address; ?>">
	<a href="<?=$site_address.'/restaurant.php?id='.$i['restaurant_id'];?>">
		<div class="title"><?=$i['name'];?></div>
		<div class="avgdelivery"><span style="font-weight:bold;">Average Delivery: </span><?php echo $i['avg_delivery']>59 ? '1 hour ':' '; 
						echo $i['avg_delivery']%60>0 ? ($i['avg_delivery']%60).' minutes':'';?></div>
		<div class="servicehours"><span style="font-weight:bold;">Service Hours: </span><?php echo $i['start_hr'].'.';
					echo $i['start_min']<10 ? '0':'';
					echo $i['start_min'].' - ';
		 			echo $i['end_hr'].'.';
					echo $i['end_min']<10 ? '0':'';
					echo $i['end_min'];?></div>
		<div style="clear: both; "></div>
	</a>
	</div>

<?php }
	while($i = $qnull->fetch_assoc()){
?>
	<div class="restaurantBox" href="<?=$site_address; ?>">
	<a href="<?=$site_address.'/restaurant.php?id='.$i['restaurant_id'];?>">
		<div class="title"><?=$i['name'];?></div>
		<div class="avgdelivery"><span style="font-weight:bold;">Average Delivery: </span>2 hours</div>
		<div class="servicehours"><span style="font-weight:bold;">Service Hours: </span><?php echo $i['start_hr'].'.';
					echo $i['start_min']<10 ? '0':'';
					echo $i['start_min'].' - ';
		 			echo $i['end_hr'].'.';
					echo $i['end_min']<10 ? '0':'';
					echo $i['end_min'];?></div>
		<div style="clear: both; "></div>
	</a>
	</div>

<?php }} ?><?php
 if($type=='cuisine'){
?><div class="cuisineList"><?php
	while($i = $q->fetch_assoc()){
?>
	
	<div class="cuisineItem">
	<a href="<?=$site_address;?>/restaurant.php?id=<?=$i['rid'];?>">
		<div style="float:left;"><?=$i['name'];?></div>
		<div style="float:left; font-weight:bold; color:#444;">- <?=$i['price'];?> ₺</div>
		<div style="float:left; font-weight:normal; color:#444;">- <?=$i['rname'];?></div>
		<div style="float:left; font-weight:normal; color:#444; font-style:italic;">~<?=$i['avg_delivery'];?> mins</div>
	</a>
		<div style="clear: both; "></div>

	</div>

<?php } 
	while($i = $qnull->fetch_assoc()){
?>
	
	<div class="cuisineItem">
	<a href="<?=$site_address;?>/restaurant.php?id=<?=$i['rid'];?>">
		<div style="float:left;"><?=$i['name'];?></div>
		<div style="float:left; font-weight:bold; color:#444;">- <?=$i['price'];?> ₺</div>
		<div style="float:left; font-weight:normal; color:#444;">- <?=$i['rname'];?></div>
		<div style="float:left; font-weight:normal; color:#444; font-style:italic;">~120 mins</div>
	</a>
		<div style="clear: both; "></div>

	</div>

<?php } } ?>
</div>
</div><div style="clear:both;"></div>   
</div>


<div style="clear:both; height:13px;"></div>

<?php include('footer.php'); ?>
</body>
</html>
<?php $mysqli->close(); ?>