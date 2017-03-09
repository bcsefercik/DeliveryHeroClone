<?php if($restid==0){redirectUrl($site_address); exit;}?>


<div class="restaurantRegions">

<div style="height: 15px; clear: both;"></div>

	<?php 


		$oodate = new DateTime($serverDate);
		$interval = new DateInterval('P30D');
		$oodate = $oodate->sub($interval);
		$oodate =  $oodate->format('Y-m-d H:i:s');
		$orderq = $mysqli->query("SELECT order_id,users.name as cname,order_date, ostatus,price FROM orders join users on (orders.customer_id = users.user_id)  join restaurants on (orders.restaurant_id=restaurants.restaurant_id) WHERE orders.restaurant_id='$restid' AND order_date>'$oodate' ORDER BY order_date DESC LIMIT 3");

		$j = 0;
		while($i = $orderq->fetch_assoc()){

			$odate = new DateTime($i['order_date']);
			if($j%2==0)
				$bg = '';
			else
				$bg = 'id="dark"';

			echo '<div class="regionLine" '.$bg.'><a href="#" onclick="window.open(\''.$site_address.'/u/view-order.php?id='.$i['order_id'].'\',\'POPUP\',\'width=400,height=300,scrollbars=0\');return false;" style="color:#000;" class="deleteI">'.$i['cname'].'</a><span style="font-weight:normal; color:#aaa; font-style:italic;"> '.$odate->format('d M H:i').'</span>';
				
			if($i['ostatus']==1 || $i['ostatus']==2){
				echo '<a href="'.$site_address.'/u/restaurant-settings_process.php?m=cancelorder&restid='.$restid.'&orderid='.$i['order_id'].'" class="orderDelete">CANCEL</a>';}

			if($i['ostatus']==1){
				echo '<a href="'.$site_address.'/u/restaurant-settings_process.php?m=approveorder&restid='.$restid.'&orderid='.$i['order_id'].'" class="orderDelete" style="background:#0000a9;">APPROVE</a>';}
			
			if($i['ostatus']==1 || $i['ostatus']==2){
				echo '<a href="'.$site_address.'/u/restaurant-settings_process.php?m=deliverorder&restid='.$restid.'&orderid='.$i['order_id'].'" class="orderDelete" style="background:#00a900;">DELIVER</a>';}
			echo '</div>';
			
			$j++;
		}?>
	

</div>
	</div>

</form>
