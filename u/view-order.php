<?php include('../includes/config.php'); include('../includes/database.php'); include('../includes/functions.php'); include('control.php');

if(!$login || !isset($_GET['id'])){echo '<script type="text/javascript"> window.close(); </script>'; exit;}

$orderid = $_GET['id'];

$iq = $mysqli->query("SELECT orders.price as total, menu_items.name,menu_items.price as iprice, count(*) as C , menu_items.item_id as iid FROM orders natural join order_items join menu_items on (order_items.item_id = menu_items.item_id) WHERE order_id='$orderid' GROUP BY iid");
if($orderid!=0 && $iq->num_rows<1){echo '<script type="text/javascript"> window.close(); </script>'; exit;}

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Order - <?=$site_titleExtension; ?></title>
<?php include('../includes/meta.php'); ?>

<link rel="stylesheet" type="text/css" href="<?php echo $site_address; ?>/styles/reset-min.css" />
<style type="text/css">
  #cart{border-bottom: 2px solid #ab0012;}
      #cart .item{clear:both; border-bottom: 1px solid #ccc; background: rgba(255,255,255,0.6); text-align: left;}
        #cart .item .name{clear:both; text-indent: 12px; font-weight: bold; font-size:14px; height: 26px; line-height: 28px; color: #ab0012;}
        #cart .item .iprice {color:#444; clear: both; text-align: right; padding-right:12px; font-size: 12px; height: 20px; line-height: 20px;}
      #cart .total{margin-top:5px;color:#000; clear: both; text-align: right; padding-right:12px; font-size: 14px; height: 30px; line-height: 32px;}
      #cart .empty{height: 22px; line-height: 22px; float: left; margin: 5px 0 0 12px; color: #ab0012; font-size: 14px; text-indent: 0px; text-align: center; border-radius: 4px; opacity: 0.6; transition: 0.4 ease all; font-weight: bold; text-decoration: underline;}
      #cart .finish{height: 22px; line-height: 22px; float: right; margin: 5px 12px; color: #00ab12; font-size: 14px; text-indent: 0px; text-align: center; border-radius: 4px; opacity: 0.6; transition: 0.4 ease all; font-weight: bold; text-decoration: underline;}
        #cart .finish:hover, #cart .empty:hover{opacity:1;}
  .warning{min-height: 24px; line-height: 24px; font-size:14px; font-weight: bold; clear:both; margin: 0 auto; background: rgba(150,0,0,0.8); color: #fff; border-radius: 8px; text-align: center;width:334px; padding: 8px;}
</style>

</head>

<body style="margin:0 auto; min-height: 380px; overflow: none;">
<div style="margin: 0 auto; width: %100;">
<div style="width:%100; height: 60px;background:#ab0012;  clear: both;">
<div style="width:350px;text-align: left; clear: both; margin: 0 auto;"><img src="<?=$site_address; ?>/images/logo.png" alt="aba" style="margin: 4px 0 0 0; height: 52px;" /></div>
</div>
<div id="cart">
<?php 
    while($cq = $iq->fetch_assoc()){
      $price = $cq['iprice']*$cq['C'];
      $tPrice = $cq['total'];
    ?>
    <div class="item">
      <div class="name"><?=$cq['name'];?></div>
      <div class="iprice"><?=$cq['C'];?> x <?=$cq['iprice'];?> = <span style="font-weight:bold;"><?=$price;?> ₺</span></div>

    </div>
  <?php } ?>
  <div class="total">Total: <span style="font-weight:bold;"><?=$tPrice;?> ₺</span></div>
  <div style="clear:both;"></div>
</div>
</div>
<div style="clear: both;"></div>
</body>
</html>
<?php $mysqli->close(); ?>