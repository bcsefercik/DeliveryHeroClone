<div class="contentTitle">Restaurants Around You</div>

<div class="restaurantList">

<?php 
	
		$qq = $mysqli->query("SELECT * FROM restaurants natural left join restaurant_regions where (region_id='$u_region' or region_id is null) and item_count!=0");
		while($i = $qq->fetch_assoc()){
?>
	<div class="restaurantBox" href="<?=$site_address; ?>">
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

<?php } ?>

</div>