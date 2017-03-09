<?php include('../includes/config.php'); include('../includes/database.php'); include('../includes/functions.php'); include('control.php');

if(!$login || !isset($_GET['id'])){echo '<script type="text/javascript"> window.close(); </script>'; exit;}

$oid = $_GET['id'];

$iq = $mysqli->query("SELECT*FROM restaurants natural join orders WHERE order_id='$oid' and ostatus=3");
if($oid!=0 && $iq->num_rows<1){echo '<script type="text/javascript"> window.close(); </script>'; exit;}


$iq = $iq->fetch_assoc();

$odate = new DateTime($iq['order_date']);
$odate = $odate->format('d M H:i');

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Give Feedback - <?=$site_titleExtension; ?></title>
<?php include('../includes/meta.php'); ?>

<link rel="stylesheet" type="text/css" href="<?php echo $site_address; ?>/styles/reset-min.css" />
<style type="text/css">
  .addtoCart{text-align: center; width: 350px; margin: 0 auto;}
    .addtoCart .formLine{clear: both; height:36px; margin-top: 10px;}
    .addtoCart .textLine{width: 350px; height: 32px; line-height: -9999px; text-indent: 9px; text-align: left; margin-top:2px; border:1px solid #aaa; border-radius: 8px; outline:none; font-size: 14px; font-weight: bold;}
      .addtoCart .textLine #active{border-color: #f1bc1f;}
      .addtoCart .title{height: 40px; line-height: 42px; font-weight: bold; clear: both; font-size: 22px; color:#ab0012; border-bottom:1px dashed #444;}
      .addtoCart .price{height: 40px; line-height: 42px; font-weight: bold; clear: both; font-size: 16px; font-style: italic; color: #444; border-bottom:2px solid #444;}
  .warning{min-height: 24px; line-height: 24px; font-size:14px; font-weight: bold; clear:both; margin: 0 auto; background: rgba(150,0,0,0.8); color: #fff; border-radius: 8px; text-align: center;width:334px; padding: 8px;}
</style>

</head>

<body style="margin:0 auto; min-height: 500px; overflow: none;">
<div style="margin: 0 auto; width: %100;">
<div style="width:%100; height: 60px;background:#ab0012;  clear: both;">
<div style="width:350px;text-align: left; clear: both; margin: 0 auto;"><img src="<?=$site_address; ?>/images/logo.png" alt="aba" style="margin: 4px 0 0 0; height: 52px;" /></div>
</div>
<?php if(isset($_GET['warning'])){ ?>
    <div style="clear: both; height: 12px;"></div>
    <div class="warning"><?=$_GET['warning'];?></div>
  <?php }if($oid!=0){ ?>

<div class="addtoCart">
    <div class="title"><?=$iq['name'];?></div>
    <div class="price"><?=$odate.' - '.$iq['price'];?> ₺</div>
    <form action="<?=$site_address; ?>/u/feedback_process.php?oid=<?=$oid;?>" method="post">
    <div class="formLine">
      <select type="text" name="servicerank" class="textLine">
        <option value="0">Service Rank</option>
        <?php for($k = 1; $k<11; $k++)
          echo '<option value="'.$k.'">'.$k.'</option>';
        ?>
      </select>
    </div>
    <div class="formLine">
      <select type="text" name="tasterank" class="textLine">
        <option value="0">Taste Rank</option>
        <?php for($k = 1; $k<11; $k++)
          echo '<option value="'.$k.'">'.$k.'</option>';
        ?>
      </select>
    </div>
    <div class="formLine">
      <select type="text" name="speedrank" class="textLine">
        <option value="0">Speed Rank</option>
        <?php for($k = 1; $k<11; $k++)
          echo '<option value="'.$k.'">'.$k.'</option>';
        ?>
      </select>
    </div>
    <div class="formLine" style="height:67px;">
      <textarea name="comment" class="textLine" style="height:65px; padding:5px; width:337px;">Comment</textarea>
    </div>
  <div style="clear: both; height:15px;"></div>
    <div class="formLine"><input type="submit" value="Send Feedback" class="textLine" style=" text-align: center; background:#00a900; color:#fff;" />
    </div>
  </form>
</div>
<?php } ?>
</div>
<div style="clear: both;"></div>
</body>
</html>
<?php $mysqli->close(); ?>