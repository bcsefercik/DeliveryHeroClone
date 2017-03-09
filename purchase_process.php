<?php
//Include files
include('includes/config.php'); include('includes/database.php');
include('includes/functions.php'); include('u/control.php');

if(!$login){redirectUrl($site_address); exit;}

$cartq = $mysqli->query("SELECT sum(price) as total, restaurant_id,cart_id FROM cart natural join cart_items natural join menu_items WHERE customer_id='$u_id'")->fetch_assoc();
$tPrice = $cartq['total'];
$restid = $cartq['restaurant_id'];
$cartid = $cartq['cart_id'];

$ri = $mysqli->query("SELECT * FROM restaurants natural left join restaurant_regions where  restaurant_id='$restid'")->fetch_assoc();


$date = new DateTime($serverDate);

$deltype = $_POST['ddate'];



$starttime = date($ri['start_hr'].':'.$ri['start_min']);
$endtime = date($ri['end_hr'].':'.$ri['end_min']);

if($deltype=='later'){
	$deldate = $_POST['deldate'];
	$deltime = $_POST['deltime'];

	if(date($deldate.' '.$deltime.':00')>date($date->add(new DateInterval('PT48H'))->format('Y-m-d H:i:s'))){
		redirectUrl($site_address.'/purchase.php?warning=Delivery date can be advanced at most 2 days.'); exit;
	}
	if($deltime>$endtime && $deltime<$starttime){
		redirectUrl($site_address.'/purchase.php?warning=Time should be between service hours.'); exit;
	}

	$delivery = date($deldate.' '.$deltime.':00');

}else{

	$deltime = date('H:i');
	$deldate = new DateTime(date('Y-m-d'));


	if($deltime>$endtime && $deltime<$starttime)
		$deltime = $starttime;


	if($deltime>$endtime)
		$deldate->add(new DateInterval('PT24H'));


	$delivery = date($deldate->format('Y-m-d').' '.$deltime.':00'); 
}

$mysqli->query("INSERT INTO orders (customer_id,restaurant_id,price,ostatus,order_date,delivery_date) VALUES ('$u_id','$restid','$tPrice',1,'$serverDate','$delivery')");

$orderid = mysqli_insert_id($mysqli);


$cartq = $mysqli->query("SELECT * FROM cart_items WHERE cart_id='$cartid'");

while($ii = $cartq->fetch_assoc()){
	$itemid = $ii['item_id'];
	$mysqli->query("INSERT INTO order_items VALUES ('$orderid','$itemid')");
	$mysqli->query("UPDATE menu_items SET hit = hit+1 WHERE item_id='$itemid'");
}

$mysqli->query("DELETE FROM cart_items WHERE cart_id='$cartid'");
$mysqli->query("DELETE FROM cart WHERE cart_id='$cartid'");


redirectUrl($site_address.'/purchase.php?smsg=Items have been successfully ordered.');
exit;


$mysqli->close();

echo 'Redirecting...';



ob_end_flush();
?>-