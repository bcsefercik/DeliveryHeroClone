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
	case 'empty':
		$carttid = $mysqli->query("SELECT*FROM cart where customer_id='$u_id'")->fetch_assoc()['cart_id'];
		$mysqli->query("DELETE FROM cart_items where cart_id='$carttid'");
		$mysqli->query("DELETE FROM cart where customer_id='$u_id'");

		echo '<script type="text/javascript">window.opener.window.parent.document.location.reload(true); window.close(); </script>';
		exit;
		break;
	case 'delitem':
		if(!isset($_GET['iid']))exit;

		$itemid = $_GET['iid'];

		$carttid = $mysqli->query("SELECT*FROM cart where customer_id='$u_id'")->fetch_assoc()['cart_id'];

		$mysqli->query("DELETE FROM cart_items where cart_id='$carttid' AND item_id='$itemid'");

		echo '<script type="text/javascript">window.opener.window.parent.document.location.reload(true); window.close(); </script>';
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
<script type="text/javascript">window.opener.window.parent.document.location.reload(true); window.close(); </script>
