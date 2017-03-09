
<div style="clear:both; height:13px;"></div>

<?php if($login && $u_type!=3){
	$cartq = $mysqli->query("SELECT name,price,count(*) as C ,item_id, cart_id FROM cart natural join cart_items natural join menu_items WHERE customer_id='$u_id' GROUP BY item_id");

	$oodate = new DateTime($serverDate);
	$interval = new DateInterval('P30D');
	$inter = new DateInterval('P2W');
	$rankdate = $oodate->sub($inter)->format('Y-m-d H:i:s');
	$oodate = $oodate->sub($interval);
	$oodate =  $oodate->format('Y-m-d H:i:s');
	$orderq = $mysqli->query("SELECT * FROM orders natural join restaurants WHERE customer_id='$u_id' AND order_date>'$oodate' ORDER BY order_date DESC");
	?>

<div id="cart">
	<div id="title">Cart</div>
	<?php if($cartq->num_rows>0){
		$tPrice = 0;
		while($cq = $cartq->fetch_assoc()){
			$price = $cq['price']*$cq['C'];
			$tPrice = $tPrice+$price;
		?>
		<div class="item">
			<div class="name"><?=$cq['name'];?><a href="#" onclick="window.open('<?=$site_address; ?>/u/cart_process.php?m=delitem&amp;iid=<?=$cq['item_id'];?>','POPUP','width=100,height=80,scrollbars=0');return false;" class="deleteI">X</a></div>
			<div class="iprice"><?=$cq['C'];?> x <?=$cq['price'];?> = <span style="font-weight:bold;"><?=$price;?> ₺</span></div>

		</div>
	<?php } ?>
	<div class="total">Total: <span style="font-weight:bold;"><?=$tPrice;?> ₺</span></div>
	<div style="clear:both;"></div>
	<a class="empty" href="#" onclick="window.open('<?=$site_address; ?>/u/cart_process.php?m=empty','POPUP','width=100,height=80,scrollbars=0');return false;">Empty Cart</a>
	<a class="finish" href="<?=$site_address;?>/purchase.php">Purchase</a>
	<?php }else{echo '<div style="text-align:center; height:60px; line-height:60px;">Your cart is empty!</div>';} ?>
	<div style="clear:both;"></div>
</div>
<div style="clear:both; height:13px;"></div>
<div id="cart">
	<div id="title">Recent Orders</div>
	<?php if($orderq->num_rows>0){
		while($oq = $orderq->fetch_assoc()){
			$odate = new DateTime($oq['order_date']);
		?>
		<div class="item">
			<div class="name" style="color:#444;"><a style="color:#444;" href="#" onclick="window.open('<?=$site_address; ?>/u/view-order.php?id=<?=$oq['order_id'];?>','POPUP','width=400,height=300,scrollbars=0');return false;"><?=$oq['name'];?></a>

				<?php if($oq['order_date']>$rankdate && $oq['ostatus']==3){?><a href="#" onclick="window.open('<?=$site_address; ?>/u/feedback.php?id=<?=$oq['order_id'];?>','POPUP','width=400,height=500,scrollbars=0');return false;" class="deleteI">💬</a><?php } ?></div>
			<div class="iprice" style="float:left; margin-left:12px; clear:none; color:#999"><span style="font-weight:bold;"><?=$odate->format('d M H:i');?></span></div>
			<div class="iprice" style="float:right; clear:none; color:#666;"><span style="font-weight:bold;"><?=$oq['price'];?> ₺</span></div>
			<div style="clear:both;"></div>
		</div>
	<?php } ?>

	<div style="clear:both;"></div>
	<!--<a class="empty" style="color:#000; text-align:center; width:100%; margin-left:0px; padding:0;" href="#" onclick="window.open('<?=$site_address; ?>/u/cart_process.php?m=empty','POPUP','width=100,height=80,scrollbars=0');return false;">View All</a>-->
	<div style="clear:both; height:5px;"></div>
	<?php }else{echo '<div style="text-align:center; height:60px; line-height:60px;">There is no order in last 30 days!</div>';} ?>
	<div style="clear:both;"></div>
</div>
<div style="clear:both; height:13px;"></div>
<?php }?>
