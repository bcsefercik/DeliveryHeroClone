<div class="header">
  <div class="headerContainer">
  
    <div class="logo">
	  <h1><a href="<?php echo $site_address; ?>">aba foor delivery</a></h1>
	  <p>aba</p>
    </div>
    
    <div id="userbuttons">
      <?php if($login){?>
        <a href="<?=$site_address;?>/u/logout.php" class="lubutton">Logout</a>
        <a href="<?=$site_address;?>/u/settings.php" class="lubutton">Settings</a>
        <?php if($u_type==3){?>
        <a href="<?=$site_address;?>/u/o-settings.php" class="lubutton">Restaurant Settings</a>
        <?php }else{?>
          <a href="#" onclick="window.open('<?=$site_address; ?>/u/view-notifications.php','POPUP','width=400,height=380,scrollbars=0');return false;" class="lubutton" <?php if($u_notification>0){ echo 'style="color:#fff;background: #c10217; border:2px solid #fff; margin-top:3px;"';}?>>Notifications</a>
        <?php } ?>

      <?php }else{ ?>
          <a href="#" onclick="window.open('<?=$site_address; ?>/u/popup_login.php','POPUP','width=400,height=380,scrollbars=0');return false;" class="ubutton">LOGIN</a>
          <a href="<?= $site_address; ?>/u/register.php" class="ubutton">REGISTER</a>
      <?php } ?>
    </div>

  
  </div>
</div>


<div class="navbar" id="focusContent">
  <div class="navbarContainer">
    	<a href="<?php echo $site_address; ?>" style="float:left; width:90px; text-align:center; padding:0 !important; margin-right:5px;" class="aCurrent"><img src="<?=$site_address; ?>/images/navbar_home.png" class="mainn" style="width:90px; height:44px;"><img src="<?php echo $site_address; ?>/images/navbar_logo.png" class="image" style="width:0px; height:0px; transition: height 0.4s; -moz-transition: height 0.4s; -webkit-transition: height 0.4s; z-index:200;"></a>
      <?php if($login && $u_type!=3){?>
    	<form method="get" action="<?php echo $site_address; ?>/search.php" id="searchBAR">
        <label id="searchType" style="font-weight:normal; font-size:12px;"><input type="checkbox" value="avg_delivery" name="sort" style="margin: 12px 2px 0 0; float: left;" <?php if(isset($_GET['sort']) &&$_GET['sort']=='avg_delivery')echo' checked="checked"';?>>Order By Delivery Time</label>
        <label id="searchType"><input type="radio" value="cuisine" name="type" style="margin: 12px 2px 0 0; float: left;" <?php if(isset($_GET['type']) &&$_GET['type']=='cuisine')echo' checked="checked"';?>>Cuisine</label>    	  
    	  <label id="searchType"><input type="radio" value="restaurant" name="type" style="margin: 12px 2px 0 0; float: left;" <?php if(!isset($_GET['type']) ||$_GET['type']!='cuisine')echo' checked="checked"';?>> Restaurant</label>
	      <input type="text" id="searchTEXT" name="s" onkeyup="lookup(this.value);" onfocus="selectTextbox(this,'950918'); selectTextbox('#searchBUTTON','950918');" onblur="outTextbox(this); outTextbox('#searchBUTTON');" autocomplete="off" <?php if(isset($_GET['s'])){echo 'value="'.$_GET['s'].'"';} ?> />
	      <input type="submit" id="searchBUTTON" value="Search" />
		  </form>
      <?php }?>
    	<?php if(isset($_GET['s'])){echo "<script>selectTextbox('#searchTEXT','950918'); selectTextbox('#searchBUTTON','950918');</script>";} ?>
  </div>
</div>