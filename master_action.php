<?php
if(include('include.php')){
}else{
die('##errMASTERofUSErERROR');
}

if((count($_POST) > 0)  or (count($_GET) > 0)){
	if((count($_POST) > 0)){
		if(isset($_SERVER['HTTP_REFERER'])){
		}else{
			die('Refferer Not Found');
		}
		if((strpos($_SERVER['HTTP_REFERER'],'http://stilewell.ddns.net') == '0') or (strpos($_SERVER['HTTP_HOST'],'http://localhost/') == '0') or (strpos($_SERVER['HTTP_REFERER'],'http://192.168.1.') == '0'))
	{
	  //only process operation here
	}else{
		die('Only tld process are allowed');
	}
	}

}else{
	
	die(header('Location: master-action.php'));
	
}

/*
var_dump($_POST);
var_dump($_FILES);

foreach($_POST as $pkey=>$pval){
	echo '
	#---------------------------------------<br>
		if(isset($_POST[\''.$pkey.'\'])){<br>
		&nbsp;&nbsp;if(!is_string($_POST[\''.$pkey.'\'])){<br>
		&nbsp;&nbsp;die(\'Invalid Characters used in '.$pkey.'\');
		&nbsp;&nbsp;}<br>
		&nbsp;&nbsp;else{}<br>
		}else{<br>
		&nbsp;&nbsp;die(\'Enter '.$pkey.'\');<br>
		}<br>
	';
}
*/

if(isset($_POST['from_email']) and isset($_POST['from_name']) and isset($_POST['subj_ml']) and isset($_POST['message_ml'])){
	
	$email = $_POST['from_email'];
	$name = $_POST['from_name'];
	$subject = $_POST['subj_ml'];
	$message = $_POST['message_ml'];
	$hash = md5(sha1($_SERVER['REMOTE_ADDR']));
	$ip = $_SERVER['REMOTE_ADDR'];
	$timest = time();	
	
	
$sql = "INSERT INTO `mun_mails`(`ml_from_email`, `ml_from_name`, `ml_subject`, `ml_body`, `ml_hash`, `ml_from_ip`, `mun_time`) VALUES (
'".$email."',
'".$name."',
'".$subject."',
'".$message."',
'".$hash."',
'".$ip."',
'".$timest."'
)";

if ($conn->query($sql) === TRUE) {
    header('Location: home.php?mailsent');
} else {
  die('#ERRMASTACT1');
}

	
}
#
if(isset($_POST['ok'])){
if(!isset($_POST['usr_nm']) or !isset($_POST['usr_pass']) or !isset($_POST['usr_eml'])){
	die('Please Enter all the data');
}


$ip  = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
if(($ip=='::1') or (strpos($ip,'192.168.1.40') === true)){
	
}


$email = $_POST['usr_eml'];
$name =  $_POST['usr_nm'];
$pw = md5(md5(sha1($_POST['usr_pass'])));

########################################################################################################3
$ui = explode(' ',$name);
$fn = str_split($ui[0]);
$ln = str_split(end($ui));
$fncount = count($fn)-1;
$lncount = count($ln)-1;
$ujl=array();
for($sa=0;$sa<9;$sa++){
	$fr = rand(1,2);
	if($fr==1){
		$sr = rand(0,$fncount);
		$ujl[]=$fn[$sr];
	}else if($fr==2){
		$tr = rand(0,$lncount);
		$ujl[]=$ln[$tr];
	}else{
		die('ERROR#MA3');
	}
	
}
#######################################################################################################3


$usr = strtolower($ujl[0].$ujl[1].$ujl[3].$ujl[4].$ujl[5].$ujl[6].$ujl[7].$ujl[8].rand(1,10));

$iv = 1098541894 .rand(100000,999999);
$regtm = time();
$regip = $_SERVER['REMOTE_ADDR'];
$hash = gen_hash($pw,$email);
#pass and email and secret md5(sha1())


$sqla = "
INSERT INTO `sw_logins`(`lum_rel_tu_id`,`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`) VALUES (
'2',
'".$email."',
'".$usr."',
'".$pw."',
'".$hash."'
)
";


if ($conn->query($sqla) === TRUE) {
	
	$ltid = $conn->insert_id;
	$sqlb = "INSERT INTO `sb_users`(`usr_rel_sch_id`,`usr_name`, `usr_rel_lum_id`,  `usr_iv`, `usr_reg_dnt`, `usr_reg_ip`) VALUES (
'0',
'".$name."',
'".$ltid."',
'".$iv."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."'
)";

	if ($conn->query($sqlb) === TRUE) {
	
    header('Location: login.php');
} else {
    echo $conn->error."Error##ma55";
}
	
    } else {
    die($conn->error."Error###maa4");
}


}
#
if(isset($_POST['lo_eml']) and isset($_POST['lo_pass'])){
	
	$eml=$_POST['lo_eml'];
	$pas=md5(md5(sha1($_POST['lo_pass'])));
	$hash = gen_hash($pas,$eml);
	
	if(ctype_alnum($eml) or is_numeric($eml) or is_email($eml)){
	}else{
		die("Invalid Email");
	}
	 
	
	if(ctype_alnum($hash.$pas)){
	}else{
		die("Credentials Not valid");
	}
	
	
$selectusersfromdbsql = "SELECT * FROM sw_logins where 
lum_email= '".$eml."' and
lum_password = '".$pas."' and
lum_hash_mix= '".$hash."' and
lum_valid = 1

";
$usrres = $conn->query($selectusersfromdbsql);
if ($usrres->num_rows == 1) {
    // output data of each row
    while($usrrw = $usrres->fetch_assoc()) {
        session_regenerate_id();

			$selectusersdatafromdbsql = "
SELECT * FROM sw_users where 
usr_rel_lum_id = '".$usrrw['lum_id']."' and usr_valid =1";
echo $selectusersfromdbsql	;
$dataobbres = $conn->query($selectusersdatafromdbsql);

if ($dataobbres->num_rows == 1) {
    // output data of each row
    while($dataobbrw = $dataobbres->fetch_assoc()) {
		###
        session_regenerate_id();
		
		$_SESSION['TKSYS_SESS_ID'] = md5(sha1(md5(md5(sha1('SecrejtBall')).uniqid().time()).time()).uniqid());
		$_SESSION['TKSYS_LUM_DB_ID'] = $usrrw['lum_id'];
		$_SESSION['TKSYS_LUM_TU_ID'] = $usrrw['lum_rel_tu_id'];
		session_write_close();
		
			header('Location: sw_gateway_admin_decision.php');
		
		###
	}
}else{
	die('User Mapping Not found, Please Ask Administrator for assistance');
}
		
		
		###big en
    }
} else {
	header('Location: login.php?notss');
    die();
}
	
		
}
#

	
	/**//**//**//**/ 
	#$serverdir = 'http://localhost/muncircuit/';
	$serverdir = 'http://stilewell.ddns.net/';
if(isset($_POST['ch_pw'])){
			 if(isset($_SESSION['TKSYS_LUM_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sw_logins where lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and lum_valid = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}


	
	if(!isset($_POST['pw'])){
		die('Enter all fields');
	}

	if(!isset($_POST['npw'])){
		die('Enter all fields');
	}
	
	if($_POST['pw'] == $_POST['npw']){
		$lum = getdatafromsql($conn,'select * from sw_logins where lum_id = '.$_SESSION['TKSYS_LUM_DB_ID']);
		if(is_string($lum)){
			die('#ERRRMA39UET05G8T');
		}
		$pw = md5(md5(sha1($_POST['pw'])));
		$hash = gen_hash($pw,trim($lum['lum_email']));
		
		
		if($pw== $lum['lum_password']){
			die('The new password cant be same as the old one!');
		}else{
			$upsql = "UPDATE `sw_logins` SET `lum_password`='".trim($pw)."',`lum_hash_mix`='".trim($hash)."' WHERE lum_id = ".$_SESSION['TKSYS_LUM_DB_ID'];
			if($conn->query($upsql)){
						##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['TKSYS_LUM_DB_ID'],'sw_logins','update', $upsql ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%wsrhizuTGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




				session_destroy();
				if(count($_SESSION)>0){
					header('Location: login.php');
				}else{
					die('ERRMASESSND');
				}
			}else{
				die("#ERRRKJIOJTOJHB");
			}
			
		}
		
		
		
	}else{
		die('Passwords Dont Match');
	}


}
if(isset($_POST['re_pw'])){
	if(isset($_POST['rec_eml'])){
		if(is_email($_POST['rec_eml'])){
			$validemail = getdatafromsql($conn,"select * from sw_logins where lum_email = '".trim($_POST['rec_eml'])."'");
			
			if(is_array($validemail)){
				$hasho = gen_hash_pw('oi4jg9v 5g858r hgh587rhg85rhgvu85rht9gi vj98rjg984he98t hj4 9v8r hb9uirhbu');
			  $hasht = gen_hash_pw_2($validemail['lum_id'],'984j5t8gj48 g8 5hg085hr988rt09g409rhj 9borjh09oj58r hj094jh 98obh498toeihg');
			  
			  
			  
				$ins_pwrc = "INSERT INTO `sw_recover`(`rv_rel_lum_id`, `rv_hash`, `rv_valid_till`, `rv_hash_2`) VALUES (
'".$validemail['lum_id']."',
'".$hasho."',
'".(time()+10810)."',				
'".$hasht."'
)";
if($conn->query($ins_pwrc)){
			##### Insert Logs ##################################################################VV3###
		if(preplogs($validemail,"0",'sw_recover','insert', $ins_pwrc,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGweafTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	###eml
	$to = $validemail['lum_email'];
$subject = "Gamers Section Password Recovery ";

$message = "
<html>
<head>
<title>Click on the Link below</title>
</head>
<body>
<h2>You have requested an option to recover your account's password</h2>
<p>You can either click on the link below or copy it and paste it in your browser to reset your accounts password</p>
<p>The link is only valid for 5hrs and is one time useable</p>
<a href='http://schoolvault.ddns.net/recover.php?id=".$hasho.$hasht."'>".$serverdir."recover.php?id=".$hasho.$hasht."</a>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <anonymous.code.anonymous@gmail.com>' . "\r\n";

if(mail($to,$subject,$message,$headers)){
header('Location: recover.php?newmade');
}else{
	die('#ERRMAjuigtuj');
}
	###eml
}else{
	die('#ERRMA9309399JG');
}
				
				
				
				
			}else{
				echo 'Dont know';
			}
			
		}else{
			die('Enter a Valid Email');
		}
	}else{
		die('Enter All fields');
	}
}
#
#
if(isset($_POST['rec_action_pw'])){
	if(isset($_POST['recover_npw']) and isset($_POST['rec_pw_u'])){
		if(ctype_alnum(trim(strtolower($_POST['rec_pw_u'])))){
			$usrh = $_POST['rec_pw_u'];
			$newp = $_POST['recover_npw'];
			$user_det = getdatafromsql($conn,"select * from sw_logins where md5(sha1(concat(lum_id,'3oijg9i3u8uh'))) = '".$usrh."' and lum_valid = 1");
			
			if(is_array($user_det)){
				$new_pw=md5(md5(sha1($newp)));
				$new_hash = gen_hash($new_pw,trim($user_det['lum_email']));

	


if($conn->query("update sw_logins set lum_password = '".$new_pw."', lum_hash_mix ='".$new_hash."' where lum_id = ".$user_det['lum_id']."")){




	session_destroy();
	header('Location: login.php');
	
}else{
	die("ERRMAUSRPWCHOI03J4");
}
	
			}else{
				die('Invalid User');
			}
		}else{
			die("Invalid hash");
		}
	}else{
		die("Enter all Values");
	}
}

if(isset($_POST['mod_add'])){
	if(isset($_SESSION['TKSYS_LUM_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sw_logins where lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	############################33333333
	if(isset($_POST['mod_a_long_name'])){
		$nm = $_POST['mod_a_long_name'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['mod_a_href'])){
		$href = $_POST['mod_a_href'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['mod_a_icon'])){
		$ico = $_POST['mod_a_icon'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['mod_a_for'])){
		$mofor = $_POST['mod_a_for'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['mod_a_sub_menu']) and is_numeric($_POST['mod_a_sub_menu'])){
		if(in_range($_POST['mod_a_sub_menu'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 1');
		}
		$subm = $_POST['mod_a_sub_menu'];
	}else{
		die('Enter all Fields Correctly');
	}
	if(isset($_POST['mod_a_valid']) and is_numeric($_POST['mod_a_valid'])){
		if(in_range($_POST['mod_a_valid'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 6');
		}
		$vali_s = $_POST['mod_a_valid'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333

	if($conn->query("INSERT INTO `sw_modules`(`mo_name`, `mo_href`, `mo_for`, `mo_icon`,  `mo_sub_mod`, `mo_valid`) VALUES (
	'".$nm."',
	'".$href."',
	'".$mofor."',
	'".$ico."',
	".$subm.",
	".$vali_s."
	)")){
				##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['TKSYS_LUM_DB_ID'],'sw_modules','insert', "INSERT INTO `sw_modules`(`mo_name`, `mo_href`, `mo_for`, `mo_icon`,  `mo_sub_mod`, `mo_valid`) VALUES (
	'".$nm."',
	'".$href."',
	'".$mofor."',
	'".$ico."',
	".$subm.",
	".$vali_s."
	)",$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




		header('Location: admin_mods.php');
	}else{
		die('ERRMAGRTBRHR%Y$T%HTIEB(FD');
	}
}
if(isset($_POST['add_user'])){
	if(isset($_SESSION['TKSYS_LUM_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sw_logins where lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and lum_valid = 1 and lum_ad = 1 ");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}

	############################33333333
	if(isset($_POST['usr_f_name']) and trim($_POST['usr_f_name']) !== ''){
		$fnm = $_POST['usr_f_name'];
	}else{
		die('Enter usr_f_name Correctly1');
	}
	############################33333333
	if(isset($_POST['usr_l_name']) and trim($_POST['usr_l_name']) !== ''){
		$lnm = $_POST['usr_l_name'];
	}else{
		die('Enter usr_l_name Correctly1');
	}
	if(isset($_POST['usr_email'])){
		if(is_email($_POST['usr_email'])){
		$eml = $_POST['usr_email'];
		}else{
			die('Email not Valid');
		}
	}else{
		die('Enter Email Correctly');
	}
	############################33333333
	############################33333333
	if(isset($_POST['usr_type'])){
		if(is_numeric($_POST['usr_type']) and (($_POST['usr_type'] == 1) or ($_POST['usr_type'] == 2) or ($_POST['usr_type'] == 3))){
		$usr_type = $_POST['usr_type'];
		}else{
			die('User Type not Valid');
		}
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['usr_contact_no'])){
		if(is_numeric($_POST['usr_contact_no'])){
		$number = $_POST['usr_contact_no'];
		}else{
			die('Contact not Valid');
		}
	}else{
		die('Enter Contact Correctly');
	}
	############################33333333
	if(isset($_POST['usr_pw'])){
		$pw = md5(md5(sha1($_POST['usr_pw'])));
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['usr_dob']) and (strtotime($_POST['usr_dob']) == true)){
			$dob = $_POST['usr_dob'];
	}else{
		die('Enter DOB Correctly');
	}
	############################33333333
	if(isset($_POST['usr_validtill']) and is_numeric($_POST['usr_validtill'])){
		$vldtll = $_POST['usr_validtill'];
		if(trim($vldtll) == 0){
			$valid_till = 0;
			$defpw = '-';
		}else{
			$valid_till = (time()+ ($vldtll*60));
			$defpw=base64_encode($_POST['usr_pw']);
		}
	}else{
		die('Enter all Fields Correctly 1');
	}
	############################33333333


$usr = strtolower(rand(1,10).$fnm);
$hash = gen_hash($pw,$eml);

$checkusrnm = getdatafromsql($conn,"select * from sw_logins where lum_username = '".trim($usr)."'");
if(is_array($checkusrnm)){
	die("Please refresh the Page and resend the post values .");
}

#########################
	if($conn->query("INSERT INTO `sw_logins`(`lum_rel_tu_id`,`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`, `lum_ad`, `lum_ad_level`,`lum_pass_def`) VALUES 
	('".trim($usr_type)."','".trim($eml)."', '".trim($usr)."', '".trim($pw)."', '".trim($hash)."', '0', '0'
	,'".$_POST['usr_pw']."')")){





	##
		$ltid = $conn->insert_id;
		
						##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['TKSYS_LUM_DB_ID'],'sw_logins','insert', "INSERT INTO `sw_logins`(`lum_rel_tu_id`,`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`, `lum_ad`, `lum_ad_level`,`lum_pass_def`) VALUES 
	('".trim($usr_type)."','".trim($eml)."', '".trim($usr)."', '".trim($pw)."', '".trim($hash)."', '0', '0'
	,'".$_POST['usr_pw']."')" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###



	$sqlb = "INSERT INTO `sw_users`(`usr_fname`,`usr_lname`, `usr_dob`,`usr_contact_no`,`usr_rel_lum_id` , `usr_reg_dnt`, `usr_reg_ip`,`usr_validtill`) VALUES (
'".$fnm."',
'".$lnm."',
'".strtotime($dob)."',
'".$number."',
'".$ltid."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$valid_till."')";

	if ($conn->query($sqlb) === TRUE) {
				##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['TKSYS_LUM_DB_ID'],'sw_users','insert', $sqlb ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	
    header('Location: admin_users.php');
} else {
    die($conn->error."Error##rujioma");
}
	

	##
	
	}else{
		die($conn->error.'ERRMAIGOTURG');
	}
}
#_______________________________START MODULES_______________________
if(isset($_POST['hash_ac']) and isset($_POST['tab_act'])){
	if(ctype_alnum(trim($_POST['hash_ac']))){
		$checkit = getdatafromsql($conn,"select * from sw_modules where md5(md5(sha1(sha1(md5(md5(concat(mo_id,'njhifverkof2njbivjwj bfurhib2jw'))))))) = '".$_POST['hash_ac']."' and mo_valid =0");
		
		if(is_array($checkit)){
			if($conn->query("update sw_modules set mo_valid =1 where mo_id= ".$checkit['mo_id']."")){
				##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['TKSYS_LUM_DB_ID'],'sw_modules','update', "update sw_modules set mo_valid =1 where mo_id= ".$checkit['mo_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###

								header('Location: admin_mods.php');
			}else{
				die('ERRRMA!JOIrfedNJFO');
			}
		}else{
			die("No Modules\'s Found");
		}
	}else{
		die('Invalid Entries');
	}
}
if(isset($_POST['hash_inc']) and isset($_POST['tab_inact'])){
	if(ctype_alnum(trim($_POST['hash_inc']))){
		$checkit = getdatafromsql($conn,"select * from sw_modules where md5(md5(sha1(sha1(md5(md5(concat(mo_id,'hbujeio03ir94urghnjefr 309i4wef'))))))) = '".$_POST['hash_inc']."' and mo_valid =1");
		
		if(is_array($checkit)){
			if($conn->query("update sw_modules set mo_valid =0 where mo_id= ".$checkit['mo_id']."")){				
##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['TKSYS_LUM_DB_ID'],'sw_modules','update', "update sw_modules set mo_valid =0 where mo_id= ".$checkit['mo_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###


								header('Location: admin_mods.php');
			}else{
				die('ERRRMAjn4rifJOINJFWFEAO');
			}
		}else{
			die("No Modules\'s Found");
		}
	}else{
		die('Invalid Entries');
	}
}
#_______________________________START USER_______________________
if(isset($_POST['yh_com']) and isset($_POST['usr_make_ac'])){
	if(ctype_alnum(trim($_POST['yh_com']))){
		$checkit = getdatafromsql($conn,"select * from sw_logins where 
		md5(md5(sha1(sha1(md5(md5(concat(lum_id,'hir39efnewsfejirjeofkvjrjdnjjenfkvkijonreij3nj'))))))) = '".$_POST['yh_com']."' and lum_valid = 0");
		
		if(is_array($checkit)){
			if($checkit['lum_email'] == 'ayanzcap@hotmail.com'){
				die('Super user can\'t be modified');
			}
			if($conn->query("update sw_logins set lum_valid =1 where lum_id= ".$checkit['lum_id']."")){
								
##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['TKSYS_LUM_DB_ID'],'sw_logins','update', "update sw_logins set lum_valid =1 where lum_id= ".$checkit['lum_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###

								header('Location: admin_users.php');
			}else{
				die('ERRMA3jonkj34oirvfingj');
			}
		}else{
			die("No User Found");
		}
	}else{
		die('Invalid Entries');
	}
}
#
if(isset($_POST['yh_com']) and isset($_POST['usr_make_inac'])){
	if(ctype_alnum(trim($_POST['yh_com']))){
		$checkit = getdatafromsql($conn,"select * from sw_logins where 
		md5(md5(sha1(sha1(md5(md5(concat(lum_id,'hir39efnewsfejirjrjdnjjenfkv ijfkorkvnkorvfk'))))))) = '".$_POST['yh_com']."' and lum_valid = 1");
		
		if(is_array($checkit)){
			if($checkit['lum_email'] == 'ayanzcap@hotmail.com'){
				die('Super user can\'t be deleted');
			}
			if($conn->query("update sw_logins set lum_valid =0 where lum_id= ".$checkit['lum_id']."")){
				
##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['TKSYS_LUM_DB_ID'],'sw_logins','update', "update sw_logins set lum_valid =0 where lum_id= ".$checkit['lum_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




				
								header('Location: admin_users.php');
			}else{
				die('ERRMA3joingj');
			}
		}else{
			die("No User Found");
		}
	}else{
		die('Invalid Entries');
	}
}
#
#_______________________________END USER_______________________
if(isset($_POST['edit_mod'])){
	if(isset($_SESSION['TKSYS_LUM_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sw_logins where lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	if(isset($_POST['hash_emmp__1i'])){
		if(ctype_alnum(trim($_POST['hash_emmp__1i']))){
			$editmun = getdatafromsql($conn,"select * from sw_modules where md5(md5(sha1(sha1(md5(md5(concat(mo_id,'lkoegnuifvh bnn njenjn'))))))) = '".$_POST['hash_emmp__1i']."'");
			#f0b9915082de5819bf562d53aa59b2d2
			
			if(is_string($editmun)){
				die('Hash Not Found');
			}
		}else{
			die('Invalid hash');
		}
	}else{
		die('Hash Not Valid');
	}
	############################33333333
	if(isset($_POST['edit_mod_lngnme'])){
		$nm = $_POST['edit_mod_lngnme'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['edit_mod_shrtnme'])){
		$href = $_POST['edit_mod_shrtnme'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['edit_mod_icon'])){
		$ico = $_POST['edit_mod_icon'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['edit_mod_for'])){
		$mofor = $_POST['edit_mod_for'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['edit_mod_sub']) and is_numeric($_POST['edit_mod_sub'])){
		if(in_range($_POST['edit_mod_sub'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 1');
		}
		$subm = $_POST['edit_mod_sub'];
	}else{
		die('Enter all Fields Correctly');
	}
	
	if(1==0){
		#You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes #
		die("You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes ");
	}else{
		if($conn->query("UPDATE `sw_modules` SET 
`mo_name`= '".$nm."',
`mo_href`='".$href."',
`mo_for` = '".$mofor."',
`mo_icon`='".$ico."',
`mo_sub_mod`='".$subm."'
where mo_id = ".trim($editmun['mo_id'])."")){
	
	
	##### Insert Logs ##################################################################VV3###
		if(preplogs($editmun,$_SESSION['TKSYS_LUM_DB_ID'],'sw_modules','update',"UPDATE `sw_modules` SET 
`mo_name`= '".$nm."',
`mo_href`='".$href."',
`mo_for` = '".$mofor."',
`mo_icon`='".$ico."',
`mo_sub_mod`='".$subm."'
where mo_id = ".trim($editmun['mo_id'])."",$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	header('Location: admin_mods.php');
		}else{
			die('ERRMAerskirore9njr3ei9jinj');
		}
	}

}
if(isset($_POST['edit_user'])){
	if(isset($_SESSION['TKSYS_LUM_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sw_logins where lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	if(isset($_POST['hash_chkr'])){
		if(ctype_alnum(trim($_POST['hash_chkr']))){
			$editmun = getdatafromsql($conn,"select * from sw_logins where md5(md5(sha1(sha1(md5(md5(concat(lum_id,'f2frbgbe 2fgtegrfr3gbter 24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".$_POST['hash_chkr']."'");
			#f0b9915082de5819bf562d53aa59b2d2
			
			if(is_string($editmun)){
				die('Hash Not Found');
			}
		}else{
			die('Invalid hash');
		}
	}else{
		die('Hash Not Valid');
	}
	
	if(isset($_POST['edit_f_nme'])){
		$fnm = trim($_POST['edit_f_nme']);
	}else{
		die('Enter  edit_f_nme');
	}
	if(isset($_POST['edit_l_nme'])){
		$lnm = trim($_POST['edit_l_nme']);
	}else{
		die('Enter  edit_l_nme');
	}
	if(isset($_POST['edit_us_contact']) and is_numeric($_POST['edit_us_contact'])  and (trim($_POST['edit_us_contact']) !=='')){
		$number = trim($_POST['edit_us_contact']);
	}else{
		die('Enter  edit_us_contact');
	}
	if(isset($_POST['edit_us_pw'])){
		$pt = trim($_POST['edit_us_pw']);
		if(trim($pt) == '-'){
			$pw = $editmun['lum_password'];
			$hash = $editmun['lum_hash_mix'];
		}else{
			$pw = md5(md5(sha1(trim($_POST['edit_us_pw']))));
			$hash = gen_hash($pw,trim($editmun['lum_email']));
		}
	}else{
		die('Enter  edit_us_pw');
	}
	
	if(isset($_POST['edit_us_adm']) and is_numeric($_POST['edit_us_adm'])){
		if(in_range($_POST['edit_us_adm'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 1');
		}
		$admer = $_POST['edit_us_adm'];
	}else{
		die('Enter  edit_us_adm');
	}
	
	if(isset($_POST['edit_us_amdlvl']) and is_numeric($_POST['edit_us_amdlvl'])){
		if(in_range($_POST['edit_us_amdlvl'],0,10,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 1');
		}
		$admlvl = $_POST['edit_us_amdlvl'];
	}else{
		die('Enter  edit_us_amdlvl');
	}
	

	
	if(isset($_POST['edit_us_prfpic'])){
		$nprofpic = trim($_POST['edit_us_prfpic']);
	}else{
		die('Enter  edit_us_prfpic');
	}
	
	
	
	if(isset($_POST['edit_us_till'])){
		$startday =trim($_POST['edit_us_till']);
		if(($startday == '0') or ($startday == 0)){
			$usrtill = 0;
		}else{
			$usrtill = time() + (60*$_POST['edit_us_till']);
		}
	}else{
		die('Enter edit_us_till ');
	}
		
	if(1==0){
		#You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes #
		die("You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes ");
	}else{
		$querytobeinserted = "
UPDATE 
	`sw_logins` a,
	`sw_users` b 
SET 
	a.lum_password='".trim($pw)."',
	a.lum_hash_mix='".$hash."',
	a.lum_ad='".$admer."',
	a.lum_ad_level='".$admlvl."',
	b.usr_fname='".$fnm."',
	b.usr_lname='".$lnm."',
	b.usr_contact_no='".$number."',
	b.usr_prof_pic='".$nprofpic."',
	b.usr_back_pic = 'img/circuit_def.jpg',
	b.usr_validtill='".trim($usrtill)."'
WHERE
	a.lum_id = b.usr_rel_lum_id and 
	a.lum_id = ".trim($editmun['lum_id'])."";
		if($conn->query($querytobeinserted)){
		
##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['TKSYS_LUM_DB_ID'],'sw_logins','update',$querytobeinserted,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###

	header('Location: admin_users.php');
		}else{
			die('EmrfuRRMAers');
		}
	}

}
##--------------------------------------------------------------------------------------///------------------------------
if(isset($_POST['add_costing'])){
	if(!isset($_SESSION['TKSYS_LUM_DB_ID'])){
		die("Login to continue");
	}
	#---------------------------------------
if(isset($_POST['costing_head'])){
  if(!is_string($_POST['costing_head'])){
  die('Invalid Characters used in costing_head');   }
  else{}
}else{
  die('Enter costing_head');
}
#---------------------------------------
if(isset($_POST['costing_value'])){
  if(!is_numeric($_POST['costing_value'])){
  die('Invalid Characters used in costing_value');   }
  else{}
}else{
  die('Enter costing_value');
}
#---------------------------------------
if(isset($_POST['costing_hash'])){
  if(!ctype_alnum($_POST['costing_hash'])){
  die('Invalid Characters used in costing_hash');   }
  else{}
}else{
  die('Enter costing_hash');
}

$getpro = getdatafromsql($conn,"select * from sw_proformas where md5(po_id) ='".$_POST['costing_hash']."' and po_valid =1");
if(!is_array($getpro)){
	die("Proforma not found");
}


$insert = "INSERT INTO `sw_costing`( `cost_rel_po_id`, `cost_name`, `cost_val`, `cost_dnt`, `cost_ip`) VALUES (
'".$getpro['po_id']."',
'".$_POST['costing_head']."',
'".$_POST['costing_value']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."'
)";


if($conn->query($insert)){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['TKSYS_LUM_DB_ID']." user added ".$_POST['costing_value']." aed costing to  proforma id".$getpro['po_id'],$_SESSION['TKSYS_LUM_DB_ID'],'sw_costing','INSERT',$insert,$conn)){
}else{
	die("Only log not generated ");
}
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	header("Location: sw_costing.php");
}else{
	die("Could not insert cost");
}

}
if(isset($_POST['payment_add'])){
	if(!isset($_SESSION['TKSYS_LUM_DB_ID'])){
		die("Login to continue");
	}
#---------------------------------------
if(isset($_POST['payment_add_hash'])){
  if(!ctype_alnum($_POST['payment_add_hash'])){
  die('Invalid Characters used in payment_add_hash');   }
  else{}
}else{
  die('Enter payment_add_hash');
}
#---------------------------------------
if(isset($_POST['payment_add_method'])){
  if(!ctype_alnum($_POST['payment_add_method'])){
  die('Invalid Characters used in payment_add_method');   }
  else{}
}else{
  die('Enter payment_add_method');
}
#---------------------------------------
if(isset($_POST['payment_add_c_no'])){
  if(!is_string($_POST['payment_add_c_no'])){
  die('Invalid Characters used in payment_add_c_no');   }
  else{}
}else{
  die('Enter payment_add_c_no');
}
#---------------------------------------
if(isset($_POST['payment_add_date'])){
  if(!is_string($_POST['payment_add_date'])){
  die('Invalid Characters used in payment_add_date');   }
  else{}
}else{
  die('Enter payment_add_date');
}
#---------------------------------------
if(isset($_POST['payment_add_val'])){
  if(!is_numeric($_POST['payment_add_val'])){
  die('Invalid Characters used in payment_add_val');   }
  else{}
}else{
  die('Enter payment_add_val');
}
#---------------------------------------

$getpro = getdatafromsql($conn,"select * from sw_proformas where md5(po_id) ='".$_POST['payment_add_hash']."' and po_valid =1");
if(!is_array($getpro)){
	die("Proforma not found");
}

$getmethod = getdatafromsql($conn,"select * from sw_payments_methods where md5(method_id) ='".$_POST['payment_add_method']."'");
if(!is_array($getmethod)){
	die("Method not found");
}
if($getmethod['method_id'] === '2'){
	$obj_date= '0';
	$_POST['payment_add_c_no'] = '0';
}else{
$obj_date = strtotime($_POST['payment_add_date']);
if($obj_date === false){
	die('Invalid Date');
}
}
$pval = ($_POST['payment_add_val'] * $getpro['po_cur_rate']);
$insert1 = "INSERT INTO `sw_payments`( pt_rel_po_id	, `pt_rel_method_id`, `pt_cheque_number`, `pt_cheque_date`, `pt_val`, `pt_dnt`, `pt_ip`) VALUES (
'".$getpro['po_id']."',
'".$getmethod['method_id']."',
'".$_POST['payment_add_c_no']."',
'".$obj_date."',
'".$pval."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."'
)";

if($conn->query($insert1)){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['TKSYS_LUM_DB_ID']." user addded payment of amount: ".$pval." in favour of ".$getpro['po_id']." proforma",$_SESSION['TKSYS_LUM_DB_ID'],'sw_payments','INSERT',$insert1,$conn)){
}else{
	die("Only log not generated ");
}
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	header("Location: sw_payments.php");
}else{
	die($conn->error."Could not insert Payment");
}

}
/*---------------------------------------------------------------------------*/
if(isset($_POST['add_scr'])){
if(isset($_POST['scr_desc'])){
  if(!is_string($_POST['scr_desc'])){
  die('Invalid Characters used in scr_desc');   }
  else{}
}else{
  die('Enter scr_desc');
}

if(isset($_POST['scr_name'])){
  if(!is_string($_POST['scr_name'])){
  die('Invalid Characters used in scr_name');   }
  else{}
}else{
  die('Enter scr_name');
}

$inssql = "INSERT INTO `sw_screens`( `scr_rel_lum_id`, `scr_name`, `scr_desc`, `scr_dnt`, `scr_ip`) VALUES (
'".$_SESSION['TKSYS_LUM_DB_ID']."',
'".$_POST['scr_name']."',
'".$_POST['scr_desc']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."'
)";

if($conn->query($inssql)){
	header('Location: g_screens.php');
}else{
	die("ERRMASCRINSERR ");
}

}
if(isset($_POST['scr_rem'])){
if(isset($_POST['scr_hash'])){
  if(!ctype_alnum($_POST['scr_hash'])){
  die('Invalid Characters used in scr_hash');   }
  else{}
}else{
  die('Enter scr_hash');
}

$checkscr= getdatafromsql($conn,"SELECT * FROM `sw_screens` where scr_status =1 and scr_valid =1 and scr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and md5(md5(sha1(md5(sha1(scr_id))))) = '".$_POST['scr_hash']."' ");
if(!is_array($checkscr)){
	die('No Screen Found');
}


$remsql = "update sw_screens set scr_status = 0 where scr_id = ".$checkscr['scr_id'];

if($conn->query($remsql)){
	$remsqld = "update sw_lineups_scr_gr set lu_status = 0 where lu_rel_scr_id = ".$checkscr['scr_id'];
	if($conn->query($remsqld)){
		header('Location: g_screens.php');
	}else{
		die('ERRMAREMSCR');
	}

}else{
	die('ERRMAREMSCR');
}

}
/*-------------------------------------------------------------------*/
if(isset($_POST['add_player'])){
	
if(isset($_SESSION['TKSYS_LUM_DB_ID']) and (trim($_SESSION['TKSYS_LUM_DB_ID']) !== '')){
}else{
	die('Login to Continue.');
}
#---------------------------------------
if(isset($_POST['add_player_name'])){
  if(!is_string($_POST['add_player_name'])){
  die('Invalid Characters used in add_player_name');   }
  else{}
}else{
  die('Enter add_player_name');
}
#---------------------------------------
#---------------------------------------
if(isset($_POST['add_player_email'])){
  if(!is_string($_POST['add_player_email'])){
  die('Invalid Characters used in add_player_email');   }
  else{}
}else{
  die('Enter add_player_email');
}
#---------------------------------------
#---------------------------------------
if(isset($_POST['add_player_phone'])){
  if(!is_string($_POST['add_player_phone'])){
  die('Invalid Characters used in add_player_phone');   }
  else{}
}else{
  die('Enter add_player_phone');
}
#---------------------------------------
#---------------------------------------
if(isset($_POST['add_player_desc'])){
  if(!is_string($_POST['add_player_desc'])){
  die('Invalid Characters used in add_player_desc');   }
  else{}
}else{
  die('Enter add_player_desc');
}
#---------------------------------------
if(isset($_FILES['add_product_img']) and ($_FILES['add_product_img']['size'] > 0) ){


					
					$target_dir = "pr_imgs/";
$ext =  extension(basename($_FILES["add_product_img"]["name"]));

$target_file = $target_dir .md5(microtime().uniqid()).'.'.$ext;

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["add_product_img"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["add_product_img"]["size"] > 10000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    die("Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["add_product_img"]["tmp_name"], $target_file)) {

    } else {
        die( "Sorry, there was an error uploading your file.");
    }
}

}else{
	$target_file = 'pr_imgs/default.png';
}


$inssql = "
INSERT INTO `sw_players`(`py_rel_lum_id`, `py_name`, `py_desc`, `py_phone`, `py_email`, `py_img`, `py_ip`, `py_dnt`) VALUES (
'".$_SESSION['TKSYS_LUM_DB_ID']."',
'".$_POST['add_player_name']."',
'".$_POST['add_player_desc']."',
'".$_POST['add_player_phone']."',
'".$_POST['add_player_email']."',
'".$target_file."',
'".$_SERVER['REMOTE_ADDR']."',
'".time()."'
)";
if ($conn->query($inssql) === TRUE) {

			if(isset($_POST['charset'])){
			header('Location: user_reg.php?ok');
				
			}else{
			header('Location: g_players.php');
			}

}else {
	die( "ERRMAINSPLYR");
}

}
if(isset($_POST['edit_product'])){ #product = player
if(isset($_SESSION['TKSYS_LUM_DB_ID']) and (trim($_SESSION['TKSYS_LUM_DB_ID']) !== '')){
}else{
	die('Login to Continue.');
}

#---------------------------------------
if(isset($_POST['edit_product_name'])){
  if(!is_string($_POST['edit_product_name'])){
  die('Invalid Characters used in edit_product_name');   }
  else{}
}else{
  die('Enter edit_product_name');
}
#---------------------------------------
if(isset($_POST['edit_product_desc'])){
  if(!is_string($_POST['edit_product_desc'])){
  die('Invalid Characters used in edit_product_desc');   }
  else{}
}else{
  die('Enter edit_product_desc');
}
#---------------------------------------
if(isset($_POST['edit_product_phone'])){
  if(!is_string($_POST['edit_product_phone'])){
  die('Invalid Characters used in edit_product_phone');   }
  else{}
}else{
  die('Enter edit_product_phone');
}
#---------------------------------------
if(isset($_POST['edit_product_email'])){
  if(!is_string($_POST['edit_product_email'])){
  die('Invalid Characters used in edit_product_email');   }
  else{}
}else{
  die('Enter edit_product_email');
}
#---------------------------------------

$getproduct = getdatafromsql($conn,"SELECT * FROM `sw_players` where py_valid = 1 and py_status =1 and py_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and md5(md5(sha1(sha1(md5(md5(concat(py_id,'f2fkjwiuef0rjigbter 24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".$_POST['edit_product_hash']."'");
if(!is_array($getproduct)){
	die('Player Not Found');
}


$inssql = "update `sw_players`
set `py_name`='".$_POST['edit_product_name']."',
`py_desc`='".$_POST['edit_product_desc']."',
`py_phone`='".$_POST['edit_product_phone']."',
`py_email`='".$_POST['edit_product_email']."'
where py_id = ".$getproduct['py_id']."
";
if ($conn->query($inssql) === TRUE) {
	header('Location: g_players.php');
}else {
	die($conn->error. "ERRMAUPDTPLYRDET");
}

}#players only
if(isset($_POST['py_del'])){
	if(isset($_POST['py_hash_del'])){
		if(!ctype_alnum($_POST['py_hash_del'])){die('Invalid HASH');}
	}else{
		die('Hash not found');
	}

$getpy = getdatafromsql($conn,"SELECT * FROM `sw_players` where py_valid = 1 and py_status =1 and py_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and
 md5(sha1(md5(py_id))) = '".$_POST['py_hash_del']."'");

if(!is_array($getpy)){
	die('Player Not Found');
}

$update = "update sw_players set py_status = 0 where py_id = ".$getpy['py_id']."";
if($conn->query($update)){
	header('Location: g_players.php');
}else{
	die('ERRMADELPLYR');
}
}
/*--------------------------------------------------------------------*/
if(isset($_POST['add_revision_proforma'])){
	if(!isset($_SESSION['TKSYS_LUM_DB_ID'])){
		die('Login');
	}
#---------------------------------------
if(isset($_POST['pro_nos'])){
  if(!is_numeric($_POST['pro_nos']) or ($_POST['pro_nos'] > 1000)){
  die('Invalid Characters used in pro_nos');   }
  else{}
}else{
  die('Enter pro_nos');
}
#---------------------------------------
if(isset($_POST['edit_group_hash'])){
  if(!ctype_alnum($_POST['edit_group_hash'])){
  die('Invalid Characters used in edit_group_hash');   }
  else{}
}else{
  die('Enter edit_group_hash');
}
#---------------------------------------

$getqo = getdatafromsql($conn,"
select * from sw_groups
	where gr_valid =1 and gr_status =1 and gr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']."
	and 
	md5(gr_id) = '".$_POST['edit_group_hash']."'");
if(!is_array($getqo)){
	die('Group not found');
}

$getitems = getdatafromsql($conn,"

select count(grm_id) as nom from sw_group_members 
where grm_status=1 and grm_valid =1 and grm_rel_gr_id = ".$getqo['gr_id']."");
if(!is_array($getqo)){
	die('Players Not found');
}

for($i = 1;$i < ($getitems['nom'] + 1);$i++){
	if(isset($_POST['add_revision_proforma_product_already_'.$i])){
					  if(!ctype_alnum($_POST['add_revision_proforma_product_already_'.$i])){
						  die('Invalid' .'add_revision_proforma_product_already_'.$i);
					  }
						if(is_array(getdatafromsql($conn,"SELECT * FROM `sw_players` WHERE py_status = 1 and py_valid =1 
						and py_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and  md5(py_id)='".$_POST['add_revision_proforma_product_already_'.$i]."'"))){
						}else{
							die('Invalid Player');
						}
					
	}
}


for($c = 1;$c < ($_POST['pro_nos'] + 1);$c++){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
				#---------------------------------------
				if(isset($_POST['add_revision_proforma_product_a'.$numi])){
				  if(ctype_alnum($_POST['add_revision_proforma_product_a'.$numi]) or ($_POST['add_revision_proforma_product_a'.$numi] === '0') ){
					  
if($_POST['add_revision_proforma_product_a'.$numi] === '0'){
	
}else{
						if(is_array(getdatafromsql($conn,"SELECT * FROM `sw_players` WHERE py_status = 1 and py_valid =1 
						and py_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and  md5(py_id) ='".$_POST['add_revision_proforma_product_a'.$numi]."'  "))){
						}else{
							die('Invalid Product');
						}
	
}
						
						
				  }else{
					  				  die('Invalid Characters used in add_revision_proforma_product_a'.$numi);   
				  }
				}else{
				  die('Enter add_revision_proforma_product_a'.$numi);
				}
}

$insertproforma = "update sw_group_members 
set grm_status=0
where grm_status=1 and grm_valid =1 and grm_rel_gr_id = ".$getqo['gr_id']."";
if($conn->query($insertproforma)){
	
for($i = 1;$i < ($getitems['nom'] + 1);$i++){
	if(isset($_POST['add_revision_proforma_product_already_'.$i])){
						$pr = getdatafromsql($conn,"SELECT * FROM `sw_players` WHERE py_status = 1 and py_valid =1 
						and py_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and  md5(py_id) = '".$_POST['add_revision_proforma_product_already_'.$i]."'");
						if(!is_array($pr)){
							die("A big error has occured in product after proforma insert");
						}
$insertqitem = "INSERT INTO `sw_group_members`(`grm_rel_gr_id`, `grm_rel_py_id`, `grm_dnt`) VALUES 
(
'".$getqo['gr_id']."',
'".$pr['py_id']."',
'".time()."'
)";

if($conn->query($insertqitem)){
}else{
	die("Item Insertion Failed");
}
	}
}

for($c = 1;$c < ($_POST['pro_nos'] + 1);$c++){
	if($_POST['add_revision_proforma_product_a'.$numi] !== '0'){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
$pra = getdatafromsql($conn,"SELECT * FROM `sw_players` WHERE py_status = 1 and py_valid =1 
						and py_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and  md5(py_id) = '".$_POST['add_revision_proforma_product_a'.$numi]."'");
if(!is_array($pra)){
die("A big error has occured in product-2  after proforma insert");
}
$insertq2item = "INSERT INTO `sw_group_members`(`grm_rel_gr_id`, `grm_rel_py_id`, `grm_dnt`) VALUES 
(
'".$getqo['gr_id']."',
'".$pra['py_id']."',
'".time()."'
)";


if($conn->query($insertq2item)){
}else{
	die("Item-2 Insertion Failed");
}
				
				
	}
				
}


	
}else{
	die($conn->error.'Could not insert Group');
}

	header('Location: g_groups.php');

}#group edit
if(isset($_POST['add_proforma'])){
	if(!isset($_SESSION['TKSYS_LUM_DB_ID'])){
		die('Login');
	}
#---------------------------------------
if(isset($_POST['add_group_name'])){
  if(!is_string($_POST['add_group_name'])){
  die('Invalid Characters used in add_group_name');   }
  else{}
}else{
  die('Enter add_group_name');
}
#---------------------------------------
if(isset($_POST['per_nos'])){
  if(!is_numeric($_POST['per_nos'])){
  die('Invalid Characters used in per_nos');   }
  else{
	  
if($_POST['per_nos'] > 20){
	die("Max Limit of Players reached");
}

	  }
}else{
  die('Enter per_nos');
}
#---------------------------------------

for($c = 1;$c < ($_POST['per_nos'] + 1);$c++){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
	if(isset($_POST['add_proforma_product'.$numi])){
		#---------------------------------------
				if(isset($_POST['add_proforma_product'.$numi]) and !is_array($_POST['add_proforma_product'.$numi])){
				  if(ctype_alnum($_POST['add_proforma_product'.$numi]) or ($_POST['add_proforma_product'.$numi] === '0') ){
					  
if($_POST['add_proforma_product'.$numi] === '0'){
	die("No Product Selected in round ".$c);
}else{
						if(is_array(getdatafromsql($conn,"
						
						SELECT * FROM `sw_players` WHERE py_status = 1 and py_valid =1 and py_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and 
						md5(py_id)='".$_POST['add_proforma_product'.$numi]."'"))){
						}else{
							die('Invalid Player');
						}
	
}

						
						
				  }else{
					  				  die('Invalid Characters used in add_proforma_product'.$numi);   
				  }
				}else{
				  die('Enter add_proforma_product'.$numi);
				}

				
	}else{
				  die('Enter add_proforma_product'.$numi);
				}
}
$insertproforma = "
INSERT INTO `sw_groups`(`gr_name`, `gr_dnt`, `gr_ip`, `gr_rel_lum_id`) 
 VALUES (
'".$_POST['add_group_name']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['TKSYS_LUM_DB_ID']."'
)";

if($conn->query($insertproforma)){
$proformaid = $conn->insert_id;
for($c = 1;$c < ($_POST['per_nos'] + 1);$c++){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
	if(ctype_alnum($_POST['add_proforma_product'.$numi])){

$pra = getdatafromsql($conn,"SELECT * FROM `sw_players` WHERE py_status = 1 and py_valid =1 and py_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and 
						md5(py_id)='".$_POST['add_proforma_product'.$numi]."'");
if(!is_array($pra)){
die("A fatal error has occured in player  after group insert");
}
$insertq2item = "
INSERT INTO `sw_group_members`(`grm_rel_gr_id`, `grm_rel_py_id`, `grm_dnt`) VALUES 
(
'".$proformaid."',
'".$pra['py_id']."',
'".time()."'
)";


if($conn->query($insertq2item)){

}else{
	die("ERRMAITMINSFLD");
}
				
		
}else{
	die('ERRINSGROUPMEMBERNOCTYPEALNM');
}
}

	
}else{
	die($conn->error."ERRMAINSGROUPMASTER");
}
	header('Location: g_groups.php');

}#group add
if(isset($_POST['del_gr'])){
	#---------------------------------------
if(isset($_POST['del_group_hash'])){
  if(!ctype_alnum($_POST['del_group_hash'])){
  die('Invalid Characters used in del_group_hash');   }
  else{}
}else{
  die('Enter del_group_hash');
}
#---------------------------------------
$getgr  = getdatafromsql($conn, "SELECT * from sw_groups where gr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and gr_status =1 and gr_valid =1 and 
md5(sha1(md5(gr_id))) = '".$_POST['del_group_hash']."'");
if(!is_array($getgr)){
	die('No group Found');
}

$update = "update sw_groups set gr_status = 0  where gr_id = '".$getgr['gr_id']."'";
if($conn->query($update)){
	
	
$update3 = "update sw_group_members set grm_status = 0  where grm_rel_gr_id = '".$getgr['gr_id']."'";
if($conn->query($update3)){
	
	
	header('Location: g_groups.php');
	
}else{
	die('ERRMAUPDTGRMEMPDEL');
}
	
}else{
	die('ERRMAUPDTGRPDEL');
}
}
/*--------------------------------------------------------------------*/
if(isset($_POST['add_lu'])){
	#---------------------------------------
if(isset($_POST['add_lu_scr'])){
  if(!ctype_alnum($_POST['add_lu_scr'])){
  die('Invalid Characters used in add_lu_scr');   }
  else{}
}else{
  die('Enter add_lu_scr');
}
#---------------------------------------
if(isset($_POST['add_lu_gr'])){
  if(!ctype_alnum($_POST['add_lu_gr'])){
  die('Invalid Characters used in add_lu_gr');   }
  else{}
}else{
  die('Enter add_lu_gr');
}
#---------------------------------------

$checkgr = getdatafromsql($conn , "SELECT * from sw_groups where gr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and gr_status =1 and gr_valid =1 and gr_id 
and md5(gr_id) = '".$_POST['add_lu_gr']."'");
$checkscr = getdatafromsql($conn , "SELECT * FROM `sw_screens` where scr_status =1 and scr_valid =1 and scr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." 
and md5(scr_id) = '".$_POST['add_lu_scr']."'");

if(!is_array($checkgr)){
	die('Group Not Found');
}
if(!is_array($checkscr)){
	die('Screen Not Found');
}

$insert = "INSERT INTO `sw_lineups_scr_gr`( `lu_rel_lum_id`, `lu_rel_scr_id`, `lu_rel_gr_id`, `lu_dnt`, `lu_ip`) VALUES (
'".$_SESSION['TKSYS_LUM_DB_ID']."',
'".$checkscr['scr_id']."',
'".$checkgr['gr_id']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."'
)";

if($conn->query($insert)){
	header('Location: g_screens.php');
}else{
	die('ERRMAINSLINEUP');
}
}
if(isset($_POST['py_lu_del'])){
	if(isset($_POST['py_lu_hash'])){
		if(!ctype_alnum($_POST['py_lu_hash'])){die('Invalid HASH');}
	}else{
		die('Hash not found');
	}

$getpy = getdatafromsql($conn,"SELECT * FROM `sw_lineups_scr_gr` 
WHERE 
lu_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and lu_status =1 and lu_valid =1 and
md5(md5(sha1(sha1(md5(md5(concat(lu_id , 'kjafnm sjm n 309i4wef'))))))) = '".$_POST['py_lu_hash']."'");

if(!is_array($getpy)){
	die('Lineup Not Found');
}

$update = "update sw_lineups_scr_gr set lu_status = 0 where lu_id = ".$getpy['lu_id']."";
if($conn->query($update)){
	header('Location: g_screens.php');
}else{
	die('ERRMADELLINEUP');
}
}
/*------------------------------------------------------------------*/
if(isset($_POST['add_sp'])){
	if(!ctype_alnum($_POST['add_sp'])){
		die('No Hash');
	}
	$checkscr = getdatafromsql($conn , "SELECT * FROM `sw_screens` where scr_status =1 and scr_valid =1 and scr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and md5(scr_id) = '".$_POST['add_sp']."'");

if(!is_array($checkscr)){
	die('Invalid Screen');
}

	$getnextlu = getdatafromsql($conn ,"SELECT * FROM `sw_lineups_scr_gr` 
WHERE 
lu_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and lu_rel_scr_id = ".$checkscr['scr_id']." and lu_status =1 and lu_valid =1 and lu_id not in (SELECT sp_rel_lu_id FROM `sw_playing` WHERE `sp_rel_lum_id` = '".$_SESSION['TKSYS_LUM_DB_ID']."' and `sp_rel_scr_id` = '".$checkscr['scr_id']."' and `sp_status` = 1 and `sp_valid` = 1)");
	
	if(is_array($getnextlu)){


$insert = "INSERT INTO `sw_playing`( `sp_rel_lum_id`, `sp_rel_scr_id`, `sp_rel_lu_id` , `sp_dnt`, `sp_ip`) VALUES (
'".$_SESSION['TKSYS_LUM_DB_ID']."',
'".$checkscr['scr_id']."',
'".$getnextlu['lu_id']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."'
)";

if($conn->query($insert)){
	header('Location: home.php');
}else{
	die('ERRMAINPLAYINGTABLE');
}


	}else{
		die($conn->error.'<h1>No Group left, This was the last group</h1>');
	}
}






















?>







