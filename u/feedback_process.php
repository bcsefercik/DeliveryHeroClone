<?php
include('../includes/config.php'); include('../includes/database.php'); include('../includes/functions.php'); include('control.php');



if(!$login || $u_type==3 || !isset($_GET['oid'])){echo '<script type="text/javascript">window.opener.window.parent.document.location.reload(true); window.close(); </script>';exit;
}

$orderid = $_GET['oid'];
$servicerank = $_POST['servicerank'];
$tasterank = $_POST['tasterank'];
$speedrank = $_POST['speedrank'];
$comment = $_POST['comment'];

if($comment=='Comment')
	$comment='';

if($servicerank==0 || $tasterank==0 || $speedrank==0){
  redirectUrl($site_address.'/u/feedback.php?id='.$orderid.'&warning=Please state your rankings');exit;
}



$mysqli->query("INSERT INTO restaurant_feedbacks (user_id,order_id,service_rank,taste_rank,speed_rank,comment) VALUES ('$u_id','$orderid','$servicerank','$tasterank','$speedrank','$comment')");

$mysqli->query("UPDATE orders SET ostatus = 4 WHERE order_id='$orderid'");

$mysqli->close();

?>

<title>Added...</title>

<script type="text/javascript">window.opener.window.parent.document.location.reload(true); window.close(); </script>

