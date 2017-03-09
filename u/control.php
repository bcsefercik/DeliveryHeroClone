<?php

# uye oturum degiskenleri
  $login = false;
  $user = false;
 
# kontrol ederek bilgileri dogrulayalim
  if( !empty($_SESSION["u_user"]) && !empty($_SESSION["u_username"]) ){
  
    # kulanici bilgisini alalim
      $loginInfoSql = $mysqli->query("SELECT * FROM users WHERE username='".$_SESSION["u_username"]."'");
      if( $loginInfoSql->num_rows == 1 ){
      	$user = $loginInfoSql->fetch_assoc();
        	
        	# anahtar kontrol
          	if( $_SESSION["u_user"]  ==  md5( "user_" . md5(md5( $user["password"] )) . "_ds785667f5e67w423yjgty" ) ){
              $login = true;
          	}
		  
		  else {
            $user = false;
          }
		
      }
  }


if($login)
{
  $u_username = $_SESSION["u_username"];
  $userInfoSql = $mysqli->query("SELECT * FROM users natural join addresses WHERE username='$u_username'");
  
  while($veri = $userInfoSql->fetch_assoc()){
    $u_id = $veri['user_id'];
    $u_email = $veri['email'];
    $u_phone = $veri['phone'];
    $u_type = $veri['type'];
    $u_name = $veri['name'];
    $u_door = $veri['door_number'];
    $u_street = $veri['street'];
    $u_district = $veri['district'];
    $u_city = $veri['city'];
    $u_region = $mysqli->query("SELECT*FROM regions WHERE district='$u_district' AND city='$u_city'");

    if($u_region->num_rows>0)
      $u_region = $u_region->fetch_assoc()['region_id'];
    else
      $u_region = 0;

    $u_notification = $mysqli->query("SELECT*FROM notifications WHERE user_id='$u_id'")->num_rows;
    
  }

  
}

else{$u_username=''; $u_rank = 100;}
 ?>
