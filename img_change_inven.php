<?php 
include('include.php');
if(!isset($_POST['updt_img']) and !isset($_POST['inven_id'])){
	die();
}
$mdi = $_POST['inven_id'];
if(isset($_FILES['filer'])){
$k = 'filer'; 

if(!ctype_alnum($mdi)){
	die('Invalid Player hash');
}

$chechprod = getdatafromsql($conn,"SELECT * FROM `sw_players` where py_valid = 1 and py_status =1 and py_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and md5(md5(sha1(md5(sha1(py_id))))) = '".$mdi."'");		
		######
	
	if(!is_array($chechprod)){
		die('Player not found');
	}
	$target_dir = "pr_imgs/";
$ext =  extension(basename($_FILES[$k]["name"]));

$target_file = $target_dir .md5(microtime().uniqid().'hashsiefjoewifwoij'). '.'.$ext;

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES[$k]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES[$k]["size"] > 5000000) {
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
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES[$k]["tmp_name"], $target_file) ) {
		

    } else {
        die( "Sorry, there was an error uploading your file.");
    }
}
					
					
			 $inssql = "UPDATE `sw_players` SET 
			 `py_img`='".$target_file."' 
			 where py_id = '".$chechprod['py_id']."'
								";
                    if ($conn->query($inssql) === TRUE) {
header('Location: g_players.php');                    }
            else {
              die( "Error: " . $inssql . "<br>" . $conn->error);
            }
			
			
			
			
			
			#####
		

}else{
		echo '<img src="pr_imgs/default.png" class="img-responsive" />';
}
?>