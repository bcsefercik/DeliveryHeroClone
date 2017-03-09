<?php include('../includes/config.php'); include('../includes/database.php'); include('../includes/functions.php'); include('control.php');

if($login){echo '<script type="text/javascript"> window.close(); </script>'; exit;}
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login - <?=$site_titleExtension; ?></title>
<?php include('../includes/meta.php'); ?>

<link rel="stylesheet" type="text/css" href="<?php echo $site_address; ?>/styles/reset-min.css" />
<style type="text/css">
<style>
  .loginForm{text-align: center; width: 350px; margin: 0 auto;}
    .loginForm .formLine{clear: both; height:36px; margin-top: 10px;}
    .loginForm .textLine{width: 350px; height: 32px; line-height: -9999px; text-indent: 9px; text-align: left; margin-top:2px; border:1px solid #aaa; border-radius: 8px; outline:none; font-size: 14px; font-weight: bold;}
      .loginForm .textLine #active{border-color: #f1bc1f;}
  .warning{min-height: 24px; line-height: 24px; font-size:14px; font-weight: bold; clear:both; margin: 0 auto; background: rgba(150,0,0,0.8); color: #fff; border-radius: 8px; text-align: center;width:334px; padding: 8px;}
</style>
</style>

</head>

<body style="margin:0 auto; min-height: 380px; overflow: none;">
<div style="margin: 0 auto; width: %100;">
<div style="width:%100; height: 60px;background:#ab0012;  clear: both;">
<div style="width:350px;text-align: left; clear: both; margin: 0 auto;"><img src="<?=$site_address; ?>/images/logo.png" alt="aba" style="margin: 4px 0 0 0; height: 52px;" /></div>
</div>
<?php if(isset($_GET['warning'])){ ?>
    <div style="clear: both; height: 12px;"></div>
    <div class="warning"><?=$_GET['warning'];?></div>
  <?php } ?>
<div class="loginForm">
    <form action="<?=$site_address; ?>/u/popup_login_process.php" method="post">
    <div class="formLine"><input type="text" name="username" class="textLine" onfocus="selectTextbox(this,'950918'); if(this.value=='Username') this.value='';" value="Username" onblur="outTextbox(this); if(this.value=='') this.value='Username';" />
    </div>
    <div class="formLine"><input type="password" name="password" class="textLine" 
    onfocus="selectTextbox(this,'950918'); if(this.value=='password') this.value='';" value="password" onblur="outTextbox(this);if(this.value=='') this.value='password';" autocomplete="off" />
    </div>
    <div class="formLine"><input type="submit" value="LOGIN" class="textLine" style=" text-align: center;" />
    </div>
  </form>
</div>

</div>
<div style="clear: both;"></div>
</body>
</html>
<?php $mysqli->close(); ?>