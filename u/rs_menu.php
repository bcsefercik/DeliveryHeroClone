<?php
if($restid==0){redirectUrl($site_address); exit;}
	$menuid = $mysqli->query("SELECT*FROM menus WHERE restaurant_id='$restid'")->fetch_assoc()['menu_id'];
?>
<form method="post" action="<?=$site_address;?>/u/restaurant-settings_process.php?m=newmenuitem&restid=<?=$restid;?>&menuid=<?=$menuid;?>">
<div class="settingsForm">
	<div class="formLine">
		<div class="lineTitle">Name:</div>
		<input type="text" name="namee" class="lineText">
	</div>
	<div class="formLine">
		<div class="lineTitle">Type:</div>
		<select class="lineText" name="type">
			<option value="Appetizer">Appetizer</option>
			<option value="Main">Main</option>
			<option value="Dessert">Dessert</option>
			<option value="Drink">Drink</option>
			<option value="Soup">Soup</option>
		</select>
	</div>
	<div class="formLine">
		<div class="lineTitle">Price:</div>
		<input type="text" name="price" class="lineText" value="0.0">
	</div>

	<div class="formLine">
		<div class="lineTitle"></div>
		<div class="lineText" style="line-height: 32px; border:none;"><input type="submit" value="Add" style="width: 150px; height: 32px; line-height: -9999px; text-align: center; float: left; font-weight: bold;" /></div>
	</div>

</div>
<div class="restaurantRegions">
<div style="height: 15px; clear: both;"></div>
<div class="settingsTitle">Menu Items</div>
<div style="height: 15px; clear: both;"></div>

	<?php 
		$q = $mysqli->query("SELECT * FROM menu_items  WHERE menu_id='$menuid' ORDER BY type,name");
		$j = 0;
		while($i = $q->fetch_assoc()){
			if($j%2==0)
				$bg = '';
			else
				$bg = 'id="dark"';

			echo '<div class="regionLine" '.$bg.'>'.$i['name'].' - '.$i['price'].' <span style="color: #aaa; font-weight:normal;">('.$i['type'].')</span>';
			if($i['istatus']==1)
				echo '<a href="'.$site_address.'/u/restaurant-settings_process.php?m=unmenuitem&restid='.$restid.'&itemid='.$i['item_id'].'&restname='.$restname.'" class="regionDelete">UN</a>';
			else
				echo '<a href="'.$site_address.'/u/restaurant-settings_process.php?m=amenuitem&restid='.$restid.'&itemid='.$i['item_id'].'&restname='.$restname.'" class="regionDelete" style="background:rgb(0,255,0);">AV</a>';

			echo '<a href="'.$site_address.'/u/restaurant-settings_process.php?m=delmenuitem&restid='.$restid.'&itemid='.$i['item_id'].'&restname='.$restname.'" class="regionDelete">DELETE</a></div>';
			
			$j++;
		}?>
	

</div>
	</div>

</form>
