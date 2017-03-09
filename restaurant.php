<?php

//Include files
include('includes/config.php'); include('includes/database.php'); include('includes/functions.php'); include('u/control.php');

if(!$login || $u_type==3 || !isset($_GET['id'])){redirectUrl($site_address); exit;}

$restid = $_GET['id'];

$ri = $mysqli->query("SELECT * FROM restaurants natural left join restaurant_regions where  restaurant_id='$restid'")->fetch_assoc();

$appetizerq = $mysqli->query("SELECT * FROM restaurants natural join menus join menu_items on (menus.menu_id=menu_items.menu_id) WHERE restaurant_id='$restid' and type='Appetizer' ORDER BY istatus DESC ,menu_items.name ASC");
$soupq = $mysqli->query("SELECT * FROM restaurants natural join menus join menu_items on (menus.menu_id=menu_items.menu_id) WHERE restaurant_id='$restid' and type='Soup' ORDER BY istatus DESC ,menu_items.name ASC");
$maindishq = $mysqli->query("SELECT * FROM restaurants natural join menus join menu_items on (menus.menu_id=menu_items.menu_id) WHERE restaurant_id='$restid' and type='Main' ORDER BY istatus DESC ,menu_items.name ASC");
$dessertq = $mysqli->query("SELECT * FROM restaurants natural join menus join menu_items on (menus.menu_id=menu_items.menu_id) WHERE restaurant_id='$restid' and type='Dessert' ORDER BY istatus DESC ,menu_items.name ASC");
$drinkq = $mysqli->query("SELECT * FROM restaurants natural join menus join menu_items on (menus.menu_id=menu_items.menu_id) WHERE restaurant_id='$restid' and type='Drink' ORDER BY istatus DESC ,menu_items.name ASC");
$popq = $mysqli->query("SELECT * FROM restaurants natural join menus join menu_items on (menus.menu_id=menu_items.menu_id) WHERE restaurant_id='$restid' ORDER BY hit DESC LIMIT 1");

$qq = $mysqli->query("SELECT * FROM restaurants natural join menus join menu_items on (menus.menu_id=menu_items.menu_id) WHERE restaurant_id='$restid'");


$rf = $mysqli->query("SELECT avg(service_rank) as sr, avg(taste_rank) as tr, avg(speed_rank) as spr FROM restaurants natural join orders join restaurant_feedbacks on(orders.order_id=restaurant_feedbacks.order_id) WHERE restaurants.restaurant_id='$restid'")->fetch_assoc();

?>

<!doctype html>
<html lang="tr">

<head>
<meta charset="utf-8">
<meta name="language" content="turkish">
<title><?=$ri['name'];?> - <?=$site_titleExtension;?></title>
<?php include('includes/meta.php'); ?>
<style>
	
	.category{margin-top: 15px;clear: both; background: rgba(255,255,255,0.4); border-radius:8px; border-bottom: 2px solid #ccc; border-top: 2px solid #ccc; transition:all ease 0.4s;}
		.category:hover{border-color:#ab0012;}
		.category .title{font-size: 14px; font-weight: bold; height: 32px; line-height: 32px; text-indent: 8px; border-bottom: 1px solid #aaa; color:#222;}
		.category .item{border-bottom:1px solid #ccc; color:#444; font-size: 13px; font-weight: normal; height: 32px; line-height: 32px; clear: both; text-indent: 12px; transition:all ease 0.4s;}
			.category .item:hover{color: #000; background: #fff;}
			.category .item .add{display: block; float: right; margin: 5px 12px; background: #00a900; opacity: 0.6; transition:all ease 0.4s; height: 22px; line-height: 24px; border-radius: 4px; font-weight: bold; font-size: 14px; text-align: center; text-indent: 0px; width: 22px;}
				.category .item .add:hover{opacity: 1;}

	.avgdelivery{float: left; margin-left: 8px; color:#444; height: 30px; line-height: 32px; font-size: 14px;}
	.servicehours{float: left; margin-left: 8px; color:#444; height: 30px; line-height: 32px; font-size: 14px;}
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
<div class="contentTitle" style="text-align:left; text-indent:8px; border-radius:6px 6px 0 0;"><?=$ri['name'];?></div>
<div style="clear:both;"></div>
<div class="avgdelivery"><span style="font-weight:bold;">Service Rank: </span><?=round($rf['sr'],2);?></div><div class="avgdelivery"><span style="font-weight:bold;">Taste Rank: </span><?=round($rf['tr'],2);?></div><div class="avgdelivery"><span style="font-weight:bold;">Speed Rank: </span><?=round($rf['spr'],2);?></div>
		
<div style="clear:both; height:1px; border-bottom:1px solid #ccc;"></div>
<div class="avgdelivery"><span style="font-weight:bold;">Average Delivery: </span><?php echo $ri['avg_delivery']>59 ? '1 hour ':' '; 
						echo $ri['avg_delivery']%60>0 ? ($ri['avg_delivery']%60).' minutes':'';?></div>
		<div class="servicehours"><span style="font-weight:bold;">Service Hours: </span><?php echo $ri['start_hr'].'.';
					echo $ri['start_min']<10 ? '0':'';
					echo $ri['start_min'].' - ';
		 			echo $ri['end_hr'].'.';
					echo $ri['end_min']<10 ? '0':'';
					echo $ri['end_min'];?></div>
<div style="clear:both; height:1px; border-bottom:1px solid #ccc;"></div>

<?php if($popq->num_rows>0){?>
<div class="category">
	<div class="title">Most Popular Item</div>	

	<?php while($mi = $popq->fetch_assoc()){?>

	<div class="item"><?=$mi['name'];?> - <span style="font-weight:bold; font-style:  italic;"><?=$mi['price'];?> ₺</span>
			<span style="font-style:italic;">&nbsp;(<?=$mi['hit'];?> times ordered.)</span>

		<?php if($mi['istatus']==1){?>
			<a  href="#" onclick="window.open('<?=$site_address; ?>/u/cart_add.php?id=<?=$mi['item_id'];?>','POPUP','width=400,height=380,scrollbars=0');return false;"  class="add">+</a>	
		<?php }else{?>
			<span style="font-style:italic;">&nbsp;(Not Available)</span>
		<?php }?>
		</div>
	<?php }?>
<div style="clear:both; height:10px;"></div>	
</div>
<?php }
if($appetizerq->num_rows>0){?>
<div class="category">
	<div class="title">Appetizers</div>	

	<?php while($mi = $appetizerq->fetch_assoc()){?>

	<div class="item"><?=$mi['name'];?> - <span style="font-weight:bold; font-style:  italic;"><?=$mi['price'];?> ₺</span>

		<?php if($mi['istatus']==1){?>
			<a  href="#" onclick="window.open('<?=$site_address; ?>/u/cart_add.php?id=<?=$mi['item_id'];?>','POPUP','width=400,height=380,scrollbars=0');return false;"  class="add">+</a>	
		<?php }else{?>
			<span style="font-style:italic;">&nbsp;(Not Available)</span>
		<?php }?>
		</div>
	<?php }?>
<div style="clear:both; height:10px;"></div>	
</div>
<?php }
if($soupq->num_rows>0){?>
<div class="category">
	<div class="title">Soups</div>	

	<?php while($mi = $soupq->fetch_assoc()){?>

	<div class="item"><?=$mi['name'];?> - <span style="font-weight:bold; font-style:  italic;"><?=$mi['price'];?> ₺</span>

		<?php if($mi['istatus']==1){?>
			<a  href="#" onclick="window.open('<?=$site_address; ?>/u/cart_add.php?id=<?=$mi['item_id'];?>','POPUP','width=400,height=380,scrollbars=0');return false;"  class="add">+</a>	
		<?php }else{?>
			<span style="font-style:italic;">&nbsp;(Not Available)</span>
		<?php }?>
		</div>
	<?php }?>
<div style="clear:both; height:10px;"></div>	
</div>
<?php }
if($maindishq->num_rows>0){?>
<div class="category">
	<div class="title">Main Dishes</div>	

	<?php while($mi = $maindishq->fetch_assoc()){?>

	<div class="item"><?=$mi['name'];?> - <span style="font-weight:bold; font-style:  italic;"><?=$mi['price'];?> ₺</span>

		<?php if($mi['istatus']==1){?>
			<a  href="#" onclick="window.open('<?=$site_address; ?>/u/cart_add.php?id=<?=$mi['item_id'];?>','POPUP','width=400,height=380,scrollbars=0');return false;"  class="add">+</a>	
		<?php }else{?>
			<span style="font-style:italic;">&nbsp;(Not Available)</span>
		<?php }?>
		</div>
	<?php }?>
<div style="clear:both; height:10px;"></div>	
</div>
<?php }
if($dessertq->num_rows>0){?>
<div class="category">
	<div class="title">Desserts</div>	

	<?php while($mi = $dessertq->fetch_assoc()){?>

	<div class="item"><?=$mi['name'];?> - <span style="font-weight:bold; font-style:  italic;"><?=$mi['price'];?> ₺</span>

		<?php if($mi['istatus']==1){?>
			<a  href="#" onclick="window.open('<?=$site_address; ?>/u/cart_add.php?id=<?=$mi['item_id'];?>','POPUP','width=400,height=380,scrollbars=0');return false;"  class="add">+</a>	
		<?php }else{?>
			<span style="font-style:italic;">&nbsp;(Not Available)</span>
		<?php }?>
		</div>
	<?php }?>
<div style="clear:both; height:10px;"></div>	
</div>
<?php }
if($drinkq->num_rows>0){?>
<div class="category">
	<div class="title">Drinks</div>	

	<?php while($mi = $drinkq->fetch_assoc()){?>

	<div class="item"><?=$mi['name'];?> - <span style="font-weight:bold; font-style:  italic;"><?=$mi['price'];?> ₺</span>

		<?php if($mi['istatus']==1){?>
			<a  href="#" onclick="window.open('<?=$site_address; ?>/u/cart_add.php?id=<?=$mi['item_id'];?>','POPUP','width=400,height=380,scrollbars=0');return false;"  class="add">+</a>	
		<?php }else{?>
			<span style="font-style:italic;">&nbsp;(Not Available)</span>
		<?php }?>
		</div>
	<?php }?>
<div style="clear:both; height:10px;"></div>	
</div>
<?php }?>

<div style="clear:both;"></div>   
</div>


<div style="clear:both; height:13px;"></div>

<?php include('footer.php'); ?>
</body>
</html>
<?php $mysqli->close(); ?>