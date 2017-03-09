<?php
//Include files
include('../includes/config.php'); include('../includes/database.php'); include('../includes/functions.php'); include('control.php');

if($login){redirectUrl($site_address); exit;}
?>

<!doctype html>
<html lang="tr">

<head>
<meta charset="utf-8">
<meta name="language" content="turkish">
<title>Register - <?=$site_titleExtension;?></title>
<?php include('../includes/meta.php'); ?>


<style>
	.registerForm{text-align: center; width: 480px; margin: 0 auto;}
		.registerForm .formLine{clear: both; height:36px; margin-top: 10px;}
		.registerForm .textLine{width: 480px; height: 32px; line-height: -9999px; text-indent: 9px; text-align: left; margin-top:2px; border:1px solid #aaa; border-radius: 8px; outline:none; font-size: 14px; font-weight: bold;}
			.registerForm .textLine #active{border-color: #f1bc1f;}
	.warning{min-height: 50px; line-height: 50px; font-size:18px; font-weight: bold; clear:both; margin-top: 15px; background: rgba(150,0,0,0.8); color: #fff; border-radius: 8px; text-align: center;}
</style>


</head>

<body>

<?php include('../header.php'); ?>
<div class="main">

<div style="clear:both; height:2px; border-top:2px solid #a71c34;"></div>




<div class="content">
	<div class="contentTitle">REGISTER</div>


	<?php if(isset($_GET['warning'])){ ?>
		<div class="warning"><?=$_GET['warning'];?></div>
	<?php } ?>

	<div style="clear: both; height: 5px;"></div>
	<div class="registerForm">
	  <form action="<?=$site_address; ?>/u/register_process.php" method="post">
		<div class="formLine"><input type="text" name="username" class="textLine" onfocus="selectTextbox(this,'950918'); if(this.value=='Username') this.value='';" value="<?php  echo isset($_SESSION['u_regusername']) ? $_SESSION['u_regusername'] : 'Username'; ?>" onblur="outTextbox(this); if(this.value=='') this.value='Username';" />
		</div>
		<div class="formLine"><input type="password" name="password" class="textLine" 
		onfocus="selectTextbox(this,'950918'); if(this.value=='password') this.value='';" value="<?php  echo isset($_SESSION['u_regpassword']) ? '' : 'password'; ?>" onblur="outTextbox(this);" autocomplete="off" />
		</div>
		<div class="formLine"><input type="text" name="email" class="textLine" onfocus="selectTextbox(this,'950918'); if(this.value=='Email') this.value='';" value="<?php  echo isset($_SESSION['u_regemail']) ? $_SESSION['u_regemail'] : 'Email'; ?>" onblur="outTextbox(this); if(this.value=='') this.value='Email';"  />
		</div>
		<div class="formLine"><input type="text" name="name" class="textLine" onfocus="selectTextbox(this,'950918'); if(this.value=='Name Surname') this.value='';" value="<?php  echo (isset($_SESSION['u_regname']) && $_SESSION['u_regname']!='') ? $_SESSION['u_regname'] : 'Name Surname'; ?>" onblur="outTextbox(this); if(this.value=='') this.value='Name Surname';" />
		</div>
		<div cl
		<div class="formLine"><input type="text" name="phone" id="phone" class="textLine" onfocus="selectTextbox(this,'950918'); if(this.value=='Phone') this.value='';" value="<?php  echo isset($_SESSION['u_regphone']) ? $_SESSION['u_regphone'] : 'Phone: 5XXXXXXXXX'; ?>" onblur="outTextbox(this); if(this.value=='') this.value='Phone';" />
		</div>
		<div class="formLine"><input type="text" name="door_number" class="textLine" onfocus="selectTextbox(this,'950918'); if(this.value=='Door #') this.value='';" value="<?php  echo isset($_SESSION['u_regdoornumber']) ? $_SESSION['u_regdoornumber'] : 'Door #'; ?>" onblur="outTextbox(this); if(this.value=='') this.value='Door #';" style="width: 232px; float: left;" />
			<input type="text" name="street" class="textLine" onfocus="selectTextbox(this,'950918'); if(this.value=='Street') this.value='';" value="<?php  echo isset($_SESSION['u_regstreet']) ? $_SESSION['u_regstreet'] : 'Street'; ?>" onblur="outTextbox(this); if(this.value=='') this.value='Street';" style="width: 232px; margin-left: 12px; float: left;" />
		</div>
		<div class="formLine"><input type="text" name="district" class="textLine" onfocus="selectTextbox(this,'950918'); if(this.value=='District') this.value='';" value="<?php  echo isset($_SESSION['u_regdistrict']) ? $_SESSION['u_regdistrict'] : 'District'; ?>" onblur="outTextbox(this); if(this.value=='') this.value='District';" style="width: 232px; float: left;" />
			<input type="text" name="city" class="textLine" onfocus="selectTextbox(this,'950918'); if(this.value=='City') this.value='';" value="<?php  echo isset($_SESSION['u_regcity']) ? $_SESSION['u_regcity'] : 'City'; ?>" onblur="outTextbox(this); if(this.value=='') this.value='City';" style="width: 232px; margin-left: 12px; float: left;" />
		</div>
		<div class="formLine" style="text-align: left; float: left; font-weight: bold;"><label><input type="checkbox" name="owner" style="margin: 3px 3px 0 8px; width: 18px; height: 18px; float: left;" <?php  echo (isset($_SESSION['u_regtype'])) ? 'checked="checked"':'asdasd'; ?> /> I am a restaurant owner.</label>
		</div>
		<div class="formLine"><input type="submit" value="Register" style="width: 234px; height: 32px; line-height: -9999px; text-align: center; float: right; font-weight: bold;" />
		</div>
	  </form>
	</div>

<div style="clear:both;"></div>   
</div>


<div style="clear:both; height:13px;"></div>

<?php include('../footer.php'); ?>
</body>
</html>
<?php $mysqli->close();
ob_end_flush(); ?>