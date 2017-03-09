


<form method="post" action="<?=$site_address;?>/u/settings_process.php?m=changeemail">
<div class="settingsForm">
	<div class="formLine">
		<div class="lineTitle">Current Email:</div>
		<div class="lineText" style="line-height: 32px;"><?=$u_email;?></div>
	</div>
	<div class="formLine">
		<div class="lineTitle">New Email:</div>
		<input type="text" class="lineText" name="semail"></input>
	</div>

	<div class="formLine">
		<div class="lineTitle"></div>
		<div class="lineText" style="line-height: 32px; border:none;"><input type="submit" value="Save" style="width: 150px; height: 32px; line-height: -9999px; text-align: center; float: right; font-weight: bold;" /></div>
	</div>

</div>

</form>