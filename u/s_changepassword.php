



<form method="post" action="<?=$site_address;?>/u/settings_process.php?m=changepassword">
<div class="settingsForm">
	<div class="formLine">
		<div class="lineTitle">Old Password:</div>
		<input type="password" class="lineText" name="scpassword" style="border-color:#850715; color:#850715;background-color: #ccc;"></input>
	</div>
	<div class="formLine">
		<div class="lineTitle">New Password:</div>
		<input type="password" class="lineText" name="spassword"></input>
	</div>
	<div class="formLine">
		<div class="lineTitle">New Password Again:</div>
		<input type="password" class="lineText" name="sapassword"></input>
	</div>

	<div class="formLine">
		<div class="lineTitle"></div>
		<div class="lineText" style="line-height: 32px; border:none;"><input type="submit" value="Save" style="width: 150px; height: 32px; line-height: -9999px; text-align: center; float: right; font-weight: bold;" /></div>
	</div>

</div>

</form>