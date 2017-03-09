<?php
	$in = $mysqli->query("SELECT*FROM restaurants, restaurant_addresses where restaurants.restaurant_id=restaurant_addresses.restaurant_id AND restaurants.restaurant_id='$restid'")->fetch_assoc();
?>
<form method="post" action="<?=$site_address;?>/u/restaurant-settings_process.php?m=new">
<div class="settingsForm">
	<div class="formLine">
		<div class="lineTitle">Name:</div>
		<input type="text" name="name" class="lineText" >
	</div>
	
	<div class="formLine">
		<div class="lineTitle">Start Hour:</div>
		<input type="number" name="shour" class="lineText">
	</div>
	<div class="formLine">
		<div class="lineTitle">Start Minute:</div>
		<input type="number" name="sminute" class="lineText">
	</div>
	<div class="formLine">
		<div class="lineTitle">End Hour:</div>
		<input type="number" name="ehour" class="lineText">
	</div>
	<div class="formLine">
		<div class="lineTitle">End Minute:</div>
		<input type="number" name="eminute" class="lineText">
	</div>
	<div class="formLine">
		<div class="lineTitle">Door Number:</div>
		<input type="number" name="door" class="lineText">
	</div>
	<div class="formLine">
		<div class="lineTitle">Street:</div>
		<input type="text" name="street" class="lineText">
	</div>
	<div class="formLine">
		<div class="lineTitle">District:</div>
		<input type="text" name="district" class="lineText">
	</div>
	<div class="formLine">
		<div class="lineTitle">City:</div>
		<input type="text" name="city" class="lineText">
	</div>

	<div class="formLine">
		<div class="lineTitle"></div>
		<div class="lineText" style="line-height: 32px; border:none;"><input type="submit" value="Add" style="width: 150px; height: 32px; line-height: -9999px; text-align: center; float: left; font-weight: bold;" /></div>
	</div>

</div>

	</div>

</form>
