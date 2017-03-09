<?php
include('../includes/config.php'); include('../includes/database.php'); include('../includes/functions.php'); include('control.php');



if(!$login || $u_type==3 || !isset($_GET['iid'])){echo '<script type="text/javascript">window.opener.window.parent.document.location.reload(true); window.close(); </script>';exit;
}

$itemid = $_GET['iid'];
$count = $_POST['count'];

if($count==0){
  redirectUrl($site_address.'/u/cart_add.php?id='.$itemid.'&warning=Please state how many of this item you want.');exit;
}


$cartq = $mysqli->query("SELECT*FROM cart WHERE customer_id='$u_id'");
$restq = $mysqli->query("SELECT * FROM restaurants natural join menus join menu_items on (menus.menu_id=menu_items.menu_id) WHERE item_id='$itemid'");

$carti = $cartq->fetch_assoc();

$restid = $restq->fetch_assoc()['restaurant_id'];

if($cartq->num_rows>0 && $carti['restaurant_id']!=$restid){
  redirectUrl($site_address.'/u/cart_add.php?id=0&warning=You cannot add this item because you have items from another restaurant in your cart.');exit;
}

if($cartq->num_rows==0){
  $mysqli->query("INSERT INTO cart (customer_id,restaurant_id) VALUES ('$u_id','$restid')");

  $cartid = mysqli_insert_id($mysqli);
}else{
  $cartid = $carti['cart_id'];
}

for($k = 0; $k<$count; $k++){
  $mysqli->query("INSERT INTO cart_items VALUES ('$cartid','$itemid')");
}

$mysqli->close();

?>

<title>Added...</title>

<script type="text/javascript">window.opener.window.parent.document.location.reload(true); window.close(); </script>

