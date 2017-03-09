<?php if($restid==0){redirectUrl($site_address); exit;}?>


<form method="post" action="<?=$site_address;?>/u/restaurant-settings_process.php?m=newregion&restid=<?=$restid;?>">
<div class="settingsForm">
	<?php if(isset($_GET['city'])){
		$city = $_GET['city'];
	 ?>
	<div class="formLine">
		<div class="lineTitle">City:</div>
		<input type="text" name="rcity" class="lineText" value="<?=$city;?>" readonly>
	</div>
	<div class="formLine">
		<div class="lineTitle">New District:</div>
		<select class="lineText" name="rdistrict">
		<?php 
		$q = $mysqli->query("SELECT * FROM regions WHERE city='$city'");
		while($i = $q->fetch_assoc()){
			echo '<option value="'.$i['region_id'].'">'.$i['district'].'</option>';
		}?>
		</select>
	</div>

	<div class="formLine">
		<div class="lineTitle">Average Delivery (min):</div>
		<input type="number" name="delivery" class="lineText" />
	</div>

	<div class="formLine">
		<div class="lineTitle"></div>
		<div class="lineText" style="line-height: 32px; border:none;"><input type="submit" value="Add" style="width: 150px; height: 32px; line-height: -9999px; text-align: center; float: left; font-weight: bold;" /></div>
	</div>
	<?php } else{
		$q = $mysqli->query("SELECT distinct city FROM regions ");

		?>
	<div class="formLine">
		<div class="lineTitle">New City:</div>
		<select ONCHANGE="window.location='<?=$site_address.'/u/restaurant-settings.php?id='.$restid.'&p=regions&city=';?>'+this.value" class="lineText" name="semail"><option>Select a City to Add New Region</option>
		<?php while($i = $q->fetch_assoc()){
			echo '<option value="'.$i['city'].'">'.$i['city'].'</option>';
			}?>
			</select>
		</div>
<?php } ?>
<div class="restaurantRegions">
<div style="height: 15px; clear: both;"></div>
<div class="settingsTitle">Served Regions</div>
<div style="height: 15px; clear: both;"></div>

	<?php 
		$q = $mysqli->query("SELECT * FROM restaurant_regions natural join regions WHERE restaurant_id='$restid'");
		$j = 0;
		while($i = $q->fetch_assoc()){
			if($j%2==0)
				$bg = '';
			else
				$bg = 'id="dark"';

			echo '<div class="regionLine" '.$bg.'>'.$i['district'].' - '.$i['city'].' <span style="font-weight:normal; color:#aaa;">('.$i['avg_delivery'].'min)</span><a href="'.$site_address.'/u/restaurant-settings_process.php?m=delregion&restid='.$restid.'&regid='.$i['region_id'].'" class="regionDelete">DELETE</a></div>';
			
			$j++;
		}?>
	

</div>
	</div>

</form>
