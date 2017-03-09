



<form method="post" action="<?=$site_address;?>/u/settings_process.php?m=personalinfo">
<div class="settingsForm">
	<div class="formLine">
		<div class="lineTitle">Name:</div>
		<input type="text" class="lineText" value="<?=$u_name;?>" name="sname"></input>
	</div>
	<div class="formLine">
		<div class="lineTitle">Phone:</div>
		<input type="text" class="lineText" value="<?=$u_phone;?>" name="sphone"></input>
	</div>
	<div class="formLine">
		<div class="lineTitle">Door Number:</div>
		<div class="lineText" style="line-height: 32px;"><?=$u_door;?></div>
	</div>
	<div class="formLine">
		<div class="lineTitle">Street:</div>
		<div class="lineText" style="line-height: 32px;"><?=$u_street;?></div>
	</div>
	<div class="formLine">
		<div class="lineTitle">District:</div>
		<div class="lineText" style="line-height: 32px;"><?=$u_district;?></div>
	</div>
	<div class="formLine">
		<div class="lineTitle">City:</div>
		<div class="lineText" style="line-height: 32px;"><?=$u_city;?></div>
	</div>

	<div class="formLine">
		<div class="lineTitle"></div>
		<div class="lineText" style="line-height: 32px; border:none;"><input type="submit" value="Save" style="width: 150px; height: 32px; line-height: -9999px; text-align: center; float: right; font-weight: bold;" /></div>
	</div>

</div>

</form>