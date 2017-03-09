<?php include('../includes/config.php'); include('../includes/database.php'); include('../includes/functions.php'); include('control.php');

if(!$login){echo '<script type="text/javascript"> window.close(); </script>'; exit;}


$iq = $mysqli->query("SELECT * FROM notifications WHERE user_id='$u_id' ORDER BY n_id DESC");

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script type="text/javascript">window.opener.window.parent.document.location.reload(true);</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Order - <?=$site_titleExtension; ?></title>
<?php include('../includes/meta.php'); ?>

<link rel="stylesheet" type="text/css" href="<?php echo $site_address; ?>/styles/reset-min.css" />
<style type="text/css">
  #cart{border-bottom: 2px solid #ab0012;}
    #cart strong{font-weight: bold; text-decoration: underline;}
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
    ?>
    <div style="clear:both; border: 1px solid #ccc; background: rgba(255,255,255,0.6); text-align: left; text-indent: 12px; font-size:14px;  line-height: 28px; color: #ab0012; padding:6px; margin:6px; border-radius:6px;">
      
        <?=$cq['message'];?>

    </div>
  <?php } ?>

  <?php if($u_notification==0){echo '<div style="clear:both; border: 1px solid #ccc; background: rgba(255,255,255,0.6); text-align: left; text-indent: 12px; font-size:14px;  line-height: 28px; color: #ab0012; padding:6px; margin:6px; border-radius:6px;">There is no new notification!</div>';} ?>
  <div style="clear:both;"></div>
</div>
</div>
<div style="clear: both;"></div>
</body>
</html>
<?php 
  $mysqli->query("DELETE FROM notifications WHERE user_id='$u_id'");
$mysqli->close(); ?>

