<?php
//Include files
include('../includes/config.php'); include('../includes/database.php');
include('../includes/functions.php'); include('control.php');

if(!$login){redirectUrl($site_address); exit;}


if(isset($_GET['m']))
	$m = $_GET['m'];
else
	$m = '';




switch ($m) {
	case 'select':
		$restid = $mysqli->real_escape_string(strip_tags(trim($_POST['restid'])));

		if(!isset($_POST['restid'])){redirectUrl($site_address.'/u/o-settings.php?warning=You can only create a new restaurant, right now.');
			exit;}
		

		redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid);
		exit;
		break;
	case 'newregion':
		$restid = $mysqli->real_escape_string(strip_tags(trim($_GET['restid'])));
		$rregion = $mysqli->real_escape_string(strip_tags(trim($_POST['rdistrict'])));
		$delivery = $mysqli->real_escape_string(strip_tags(trim($_POST['delivery']))); 

		$match = $mysqli->query("SELECT * FROM restaurant_regions WHERE restaurant_id='$restid' AND region_id='$rregion'");

		if ($delivery =='' || !is_numeric($delivery) || $delivery<=0 || $delivery>120){
			redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&warning=Please enter a valid average delivery time. Max 120 minutes.&p=regions');
			exit;
		}

		//echo 'sdfa';exit;
		if ($match->num_rows!=0){
			redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&warning=This region was already added.&p=regions');
			exit;
		}

		$mysqli->query("INSERT INTO restaurant_regions VALUES ('$restid','$rregion','$delivery')");		

		redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&smsg=The region has been added successfully.&p=regions');
		exit;
		break;
	case 'delregion':
		$restid = $mysqli->real_escape_string(strip_tags(trim($_GET['restid'])));
		$regid = $mysqli->real_escape_string(strip_tags(trim($_GET['regid'])));
		
		$mysqli->query("DELETE FROM restaurant_regions WHERE restaurant_id='$restid' AND region_id='$regid'");

		redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&smsg=The region has been deleted successfully.&p=regions');
		exit;
		break;
	
	case 'newmenuitem':
		$restid = $mysqli->real_escape_string(strip_tags(trim($_GET['restid'])));
		$menuid = $mysqli->real_escape_string(strip_tags(trim($_GET['menuid'])));
		$name = $mysqli->real_escape_string(strip_tags(trim($_POST['namee'])));
		$type = $mysqli->real_escape_string(strip_tags(trim($_POST['type'])));
		$price = $mysqli->real_escape_string(strip_tags(trim($_POST['price'])));

		if($price<=0.0){
		redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&warning=The price has to be bigger than zero.&p=menu');exit;}
	

		$mysqli->query("INSERT INTO menu_items (menu_id,name,type,istatus,price) VALUES ('$menuid','$name','$type',1,'$price')");		

		$mysqli->query("UPDATE restaurants SET item_count=item_count+1 WHERE restaurant_id='$restid'");

		redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&smsg=The item has been added successfully.&p=menu');
		exit;
		break;
	
	case 'unmenuitem':
		$restid = $mysqli->real_escape_string(strip_tags(trim($_GET['restid'])));
		$itemid = $mysqli->real_escape_string(strip_tags(trim($_GET['itemid'])));
	

		$mysqli->query("UPDATE menu_items SET istatus = 0 WHERE item_id='$itemid'");		
		$mysqli->query("UPDATE restaurants SET item_count=item_count-1 WHERE restaurant_id='$restid'");

		redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&smsg=The item is unavailable now.&p=menu');
		exit;
		break;
	
	case 'amenuitem':
		$restid = $mysqli->real_escape_string(strip_tags(trim($_GET['restid'])));
		$restname = $mysqli->real_escape_string(strip_tags(trim($_GET['restname'])));
		$itemid = $mysqli->real_escape_string(strip_tags(trim($_GET['itemid'])));

		$oq = $mysqli->query("SELECT menu_items.item_id as iid, order_id,order_date,customer_id FROM orders natural join order_items join menu_items on (menu_items.item_id = order_items.item_id) WHERE (ostatus=1 or ostatus=2) and menu_items.item_id = '$itemid'");

		if($oq->num_rows>0){

			$oqc = $mysqli->query("SELECT menu_items.item_id as iid, order_id,customer_id,name,order_date FROM orders natural join order_items join menu_items on (menu_items.item_id = order_items.item_id) WHERE (ostatus=1 or ostatus=2) and menu_items.item_id = '$itemid' GROUP BY menu_items.item_id");
			while($k = $oqc->fetch_assoc()){
				$cid = $k['customer_id'];
				$odate = new DateTime($k['order_date']);
				$odate = $odate->format('d M Y H:i');
				$msg = '<strong>'.$k['name'].'</strong> in your order from <strong>'.$restname.'</strong> at <strong>'.$odate.'</strong> has been made unavailable and deleted from your order.';
				$mysqli->query("INSERT INTO notifications (user_id,message) VALUES ('$cid','$msg')");
			}

			$oqc = $mysqli->query("SELECT menu_items.item_id as iid, order_id, menu_items.price as pri FROM orders natural join order_items join menu_items on (menu_items.item_id = order_items.item_id) WHERE (ostatus=1 or ostatus=2) and menu_items.item_id = '$itemid'");
			while($k = $oqc->fetch_assoc()){
				$ipri = $k['pri'];
				$oid = $k['order_id'];
				$iid = $k['iid'];
				$mysqli->query("UPDATE orders SET price=price-'$ipri' WHERE (ostatus=1 or ostatus=2) and order_id='$oid'");
				$mysqli->query("DELETE FROM order_items where item_id='$iid' AND order_id='$oid'");

			}
		}

		$cqc = $mysqli->query("SELECT cart_id,customer_id,name FROM cart natural join cart_items join menu_items on (menu_items.item_id = cart_items.item_id) WHERE menu_items.item_id = '$itemid' GROUP BY menu_items.item_id");
		
		while($k = $cqc->fetch_assoc()){
			$cid = $k['customer_id'];
			$oid = $k['cart_id'];
			$msg = '<strong>'.$k['name'].'</strong> from <strong>'.$restname.'</strong> has been made unavailable and deleted from your cart.';
			$mysqli->query("INSERT INTO notifications (user_id,message) VALUES ('$cid','$msg')");
			$mysqli->query("DELETE FROM cart_items where item_id='$itemid'");
		}
		

	

		$mysqli->query("UPDATE menu_items SET istatus = 1 WHERE item_id='$itemid'");		
		$mysqli->query("UPDATE restaurants SET item_count=item_count+1 WHERE restaurant_id='$restid'");
		redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&smsg=The item is available now.&p=menu');
		exit;
		break;
	
	case 'delmenuitem':
		$restid = $mysqli->real_escape_string(strip_tags(trim($_GET['restid'])));
		$restname = $mysqli->real_escape_string(strip_tags(trim($_GET['restname'])));
		$itemid = $mysqli->real_escape_string(strip_tags(trim($_GET['itemid'])));
		

		$oq = $mysqli->query("SELECT menu_items.item_id as iid, order_id,order_date,customer_id FROM orders natural join order_items join menu_items on (menu_items.item_id = order_items.item_id) WHERE (ostatus=1 or ostatus=2) and menu_items.item_id = '$itemid'");

		if($oq->num_rows>0){
			$oqc = $mysqli->query("SELECT menu_items.item_id as iid, order_id,customer_id,name,order_date FROM orders natural join order_items join menu_items on (menu_items.item_id = order_items.item_id) WHERE (ostatus=1 or ostatus=2) and menu_items.item_id = '$itemid' GROUP BY menu_items.item_id");
			while($k = $oqc->fetch_assoc()){
				$cid = $k['customer_id'];
				$odate = new DateTime($k['order_date']);
				$odate = $odate->format('d M Y H:i');
				$msg = '<strong>'.$k['name'].'</strong> in your order from <strong>'.$restname.'</strong> at <strong>'.$odate.'</strong> has been made unavailable and deleted from your order.';
				$mysqli->query("INSERT INTO notifications (user_id,message) VALUES ('$cid','$msg')");
			}

			$oqc = $mysqli->query("SELECT menu_items.item_id as iid, order_id, menu_items.price as pri FROM orders natural join order_items join menu_items on (menu_items.item_id = order_items.item_id) WHERE (ostatus=1 or ostatus=2) and menu_items.item_id = '$itemid'");
			while($k = $oqc->fetch_assoc()){
				$ipri = $k['pri'];
				$oid = $k['order_id'];
				$iid = $k['iid'];
				$mysqli->query("UPDATE orders SET price=price-'$ipri' WHERE (ostatus=1 or ostatus=2) and order_id='$oid'");
				$mysqli->query("DELETE FROM order_items where item_id='$iid' AND order_id='$oid'");

			}
		}

		$cqc = $mysqli->query("SELECT cart_id,customer_id,name FROM cart natural join cart_items join menu_items on (menu_items.item_id = cart_items.item_id) WHERE menu_items.item_id = '$itemid' GROUP BY menu_items.item_id");
		
		while($k = $cqc->fetch_assoc()){
			$cid = $k['customer_id'];
			$oid = $k['cart_id'];
			$msg = '<strong>'.$k['name'].'</strong> from <strong>'.$restname.'</strong> has been made unavailable and deleted from your cart.';
			$mysqli->query("INSERT INTO notifications (user_id,message) VALUES ('$cid','$msg')");
			$mysqli->query("DELETE FROM cart_items where item_id='$itemid'");
		}


		$mysqli->query("DELETE FROM menu_items WHERE item_id='$itemid'");		
		$mysqli->query("UPDATE restaurants SET item_count=item_count-1 WHERE restaurant_id='$restid'");
		redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&smsg=The item is deleted.&p=menu');
		exit;
		break;
	case 'general':

		$restid = $mysqli->real_escape_string(strip_tags(trim($_GET['restid'])));
		$shour = $mysqli->real_escape_string(strip_tags(trim($_POST['shour'])));
		$sminute = $mysqli->real_escape_string(strip_tags(trim($_POST['sminute'])));
		$ehour = $mysqli->real_escape_string(strip_tags(trim($_POST['ehour'])));
		$eminute = $mysqli->real_escape_string(strip_tags(trim($_POST['eminute'])));
		$rname = $mysqli->real_escape_string(strip_tags(trim($_POST['name'])));

		
		if($shour=='' || $sminute=='' || $ehour=='' || $eminute=='' || $rname==''){redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&warning=Please do not leave any empty area.'); exit;}

		if(!is_numeric($shour) || !is_numeric($sminute) || !is_numeric($ehour) || !is_numeric($eminute) || $shour>23 || $shour<0 || $sminute>59 || $sminute<0 || $ehour>23 || $ehour<0 || $eminute>59 || $eminute<0){redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&warning=Please enter valid time values.'); exit;}


		$mysqli->query("UPDATE restaurants SET name = '$rname', start_hr='$shour', start_min='$sminute', end_hr='$ehour', end_min='$eminute' WHERE restaurant_id='$restid'");

		redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&smsg=The restaurant has been updated successfully.'); exit;
		break;
	case 'new':

		$shour = $mysqli->real_escape_string(strip_tags(trim($_POST['shour'])));
		$sminute = $mysqli->real_escape_string(strip_tags(trim($_POST['sminute'])));
		$ehour = $mysqli->real_escape_string(strip_tags(trim($_POST['ehour'])));
		$eminute = $mysqli->real_escape_string(strip_tags(trim($_POST['eminute'])));
		$rname = $mysqli->real_escape_string(strip_tags(trim($_POST['name'])));
		$door = $mysqli->real_escape_string(strip_tags(trim($_POST['door'])));
		$district = $mysqli->real_escape_string(strip_tags(trim($_POST['district'])));
		$street = $mysqli->real_escape_string(strip_tags(trim($_POST['street'])));
		$city = $mysqli->real_escape_string(strip_tags(trim($_POST['city'])));

		
		if($shour=='' || $sminute=='' || $ehour=='' || $eminute=='' || $rname=='' || $district=='' || $door=='' || $street=='' || $city==''){redirectUrl($site_address.'/u/restaurant-settings.php?p=new&id=0&warning=Please do not leave any empty area.'); exit;}

		if(!is_numeric($shour) || !is_numeric($sminute) || !is_numeric($door) || !is_numeric($ehour) || !is_numeric($eminute) || $shour>23 || $shour<0 || $sminute>59 || $sminute<0 || $ehour>23 || $ehour<0 || $eminute>59 || $eminute<0){redirectUrl($site_address.'/u/restaurant-settings.php?p=new&id=0&warning=Please enter valid time values.'); exit;}


		$mysqli->query("INSERT INTO restaurants (owner_id,name,start_hr,start_min,end_hr,end_min) VALUES ('$u_id','$rname','$shour','$sminute','$ehour','$eminute')");

		$restid = mysqli_insert_id($mysqli);

		$mysqli->query("INSERT INTO menus VALUES ('$restid','$restid')");

		$mysqli->query("INSERT INTO restaurant_addresses (restaurant_id,door_number,street,district,city) VALUES ('$restid','$door','$street','$district','$city')");

		redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&smsg=The restaurant has been created successfully.'); exit;
		break;

	case 'approveorder':

		$restid = $mysqli->real_escape_string(strip_tags(trim($_GET['restid'])));

		$orderid = $_GET['orderid'];

		$rq = $mysqli->query("SELECT*FROM orders natural join restaurants WHERE restaurant_id ='$restid' AND order_id='$orderid'")->fetch_assoc();
		
		$cid = $rq['customer_id'];
		$mysqli->query("UPDATE orders SET ostatus=2 WHERE order_id = '$orderid'");

		$odate = new DateTime($rq['order_date']);
		$odate = $odate->format('d M Y H:i');
		$msg = 'Your order from <strong>'.$rq['name'].'</strong> at <strong>'.$odate.'</strong> has been approved.';
		$mysqli->query("INSERT INTO notifications (user_id,message) VALUES ('$cid','$msg')");


		redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&p=orders&smsg=The order has been approved. The customer has been notified.');
		exit;
		break;

	case 'deliverorder':

		$restid = $mysqli->real_escape_string(strip_tags(trim($_GET['restid'])));

		$orderid = $_GET['orderid'];

		$rq = $mysqli->query("SELECT*FROM orders natural join restaurants WHERE restaurant_id ='$restid' AND order_id='$orderid'")->fetch_assoc();
		
		$cid = $rq['customer_id'];
		$mysqli->query("UPDATE orders SET ostatus=3 WHERE order_id = '$orderid'");

		$odate = new DateTime($rq['order_date']);
		$odate = $odate->format('d M Y H:i');
		$msg = 'Your order from <strong>'.$rq['name'].'</strong> at <strong>'.$odate.'</strong> has been delivered.';
		$mysqli->query("INSERT INTO notifications (user_id,message) VALUES ('$cid','$msg')");


		redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&p=orders&smsg=The order has been delivered. The customer has been notified.');
		exit;
		break;

	case 'cancelorder':

		$restid = $mysqli->real_escape_string(strip_tags(trim($_GET['restid'])));

		$orderid = $_GET['orderid'];

		$rq = $mysqli->query("SELECT*FROM orders natural join restaurants WHERE restaurant_id ='$restid' AND order_id='$orderid'")->fetch_assoc();
		
		$cid = $rq['customer_id'];
		$mysqli->query("UPDATE orders SET ostatus=0 WHERE order_id = '$orderid'");

		$odate = new DateTime($rq['order_date']);
		$odate = $odate->format('d M Y H:i');
		$msg = 'Your order from <strong>'.$rq['name'].'</strong> at <strong>'.$odate.'</strong> has been canceled.';
		$mysqli->query("INSERT INTO notifications (user_id,message) VALUES ('$cid','$msg')");


		redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&p=orders&smsg=The order has been canceled. The customer has been notified.');
		exit;
		break;

	case 'delete':
		$restid = $mysqli->real_escape_string(strip_tags(trim($_GET['restid'])));
		$qq = $mysqli->query("SELECT*FROM orders WHERE (ostatus=1 or ostatus=2) AND restaurant_id='$restid'");

		if($qq->num_rows>0){
			redirectUrl($site_address.'/u/restaurant-settings.php?id='.$restid.'&p=orders&warning=You cannot delete this restaurant <br>since you have unprocessed orders belonging to this restaurant.');
			exit;
		}

		$cqc = $mysqli->query("SELECT cart_id,customer_id,name FROM cart natural join cart_items join menu_items on (menu_items.item_id = cart_items.item_id) WHERE restaurant_id = '$restid' GROUP BY cart_id");
		
		while($k = $cqc->fetch_assoc()){
			$cid = $k['customer_id'];
			$oid = $k['cart_id'];
			$msg = 'Your cart has been emptied. Because related restaurant is out of service.';
			$mysqli->query("INSERT INTO notifications (user_id,message) VALUES ('$cid','$msg')");
			$mysqli->query("DELETE FROM cart_items where cart_id='$oid'");
			$mysqli->query("DELETE FROM cart where cart_id='$oid'");
		}

		$oqc = $mysqli->query("SELECT * FROM orders natural join order_items WHERE restaurant_id = '$restid' GROUP BY order_id");
		
		while($k = $oqc->fetch_assoc()){
			$oid = $k['order_id'];
			$mysqli->query("DELETE FROM order_items where order_id='$oid'");
		}

		$mysqli->query("DELETE FROM orders where restaurant_id='$restid'");
		$mysqli->query("DELETE FROM menus where restaurant_id='$restid'");
		$mysqli->query("DELETE FROM menu_items where menu_id='$restid'");

		$mysqli->query("DELETE FROM restaurants where restaurant_id='$restid'");
		$mysqli->query("DELETE FROM restaurant_addresses where restaurant_id='$restid'");
		$mysqli->query("DELETE FROM restaurant_feedbacks where restaurant_id='$restid'");
		$mysqli->query("DELETE FROM restaurant_regions where restaurant_id='$restid'");

		redirectUrl($site_address.'/u/o-settings.php?warning=The restaurant has ben deleted successfully.');
		exit;
		break;
	default:
		redirectUrl($site_address);
		exit;
		break;
}


$mysqli->close();

echo 'Redirecting...';



ob_end_flush();
?>