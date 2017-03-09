<?php 
//URL redirecting
function redirectUrl($url){ 
    if (!headers_sent()){  
        header('Location: '.$url); exit; 
    }else{ 
        echo '<script type="text/javascript">'; 
        echo 'window.location.href="'.$url.'";'; 
        echo '</script>'; 
        echo '<noscript>'; 
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />'; 
        echo '</noscript>'; exit; 
    } 
}  

//Get and Compare URL 
function compareURL($extension){
	$result = false;
	global $site_address;
	
	$gottenURL = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
	$gottenExtension = str_replace($site_address,'',$gottenURL);
	
	if ($gottenExtension == '/'.$extension.'.php'){
		$result = true;
	}
	
	return $result;
}



function checkPassword($password){
    $firstletter = substr($password, 0, 1);
    if(strlen($password)<6){return 'You need a longer password';
    }elseif(!preg_match("#[A-Z]+#",$password)) {return 'Your password has to contain at least one capital letter.';
    }elseif(!preg_match("#[a-z]+#",$password)) {return 'Your password has to contain at least one lowercase letter.';
    }elseif(!preg_match("#[a-z]+#",$firstletter) && !preg_match("#[A-Z]+#",$firstletter)){return 'Your password has to start with an alphabetic character.';}
    else{return 'ok';}
}

function checkName($password){
    $names = explode(" ", $password);
    if(count($names)==1) {return 'Please enter your full name.';}
    else{return 'ok';}
}

function checkEmail($email){
   return @eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}
?>