<?php 

include('include.php');
?>
<?php 
include('page_that_has_to_be_included_for_every_user_visible_page.php');
?>

<?php

if($login == 1){
	if(trim($_USER['lum_ad']) == 1){
		$admin = 1;
	}else{
		$admin = 0;
	}
}else{
	$admin = 0;
	die('Login to View this page <a href="login.php"><button>Login</button></a>');
}

?>
<?php 
if(!isset($_POST['scr_id'])){
	header('Location: sw_gateway_admin_decision.php');
	die;
}


$checkscr = getdatafromsql($conn,"SELECT * FROM `sw_screens` where scr_status =1 and scr_valid =1 and scr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and 
md5(md5(sha1(md5(sha1(concat( scr_id ,'0932uqrheufineejfrh9uwinfjor02hurwnfjf20hurwn esofinvj2jpwironj')))))) = '".$_POST['scr_id']."'
");
if(!is_array($checkscr)){
	header('Location: sw_gateway_admin_decision.php');
	die;
}
?>
<?php
#nowplaying gr_id
$nowplaying = getdatafromsql($conn,"SELECT * FROM `sw_playing` 
left join sw_lineups_scr_gr on sp_rel_lu_id = lu_id
left join sw_groups on lu_rel_gr_id = gr_id 
	WHERE 
lu_valid = 1 and lu_status =1 and 
gr_valid =1 and gr_status =1 and
lu_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and lu_rel_scr_id = ".$checkscr['scr_id']." 
and gr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and 
`sp_rel_lum_id` = '".$_SESSION['TKSYS_LUM_DB_ID']."' and `sp_rel_scr_id` = '".$checkscr['scr_id']."' and `sp_status` = 1 and `sp_valid` = 1 order by sp_id desc limit 1");
if(!is_array($checkscr)){
	die('Awaiting Group Confirmation');
}

?>

<?php	

#nextplaying gr_id
$nextplaying = getdatafromsql($conn ,"SELECT * FROM `sw_lineups_scr_gr` 
left join sw_groups on lu_rel_gr_id = gr_id 

WHERE  gr_valid =1 and gr_status =1 and gr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and
lu_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and lu_rel_scr_id = ".$checkscr['scr_id']." and lu_status =1 and lu_valid =1 and lu_id not in (SELECT sp_rel_lu_id FROM `sw_playing` WHERE `sp_rel_lum_id` = '".$_SESSION['TKSYS_LUM_DB_ID']."' and `sp_rel_scr_id` = '".$checkscr['scr_id']."' and `sp_status` = 1 and `sp_valid` = 1)");

if(!is_array($checkscr)){
	die('Awaiting Group Confirmation');
}

?>


<header class="top-head container-fluid">
                <h3 class="pull-left">
                    <?php echo $checkscr['scr_name']; ?>
                </h3>
                <h3 class="pull-right">
                    <?php echo date('j M, Y',time()); ?>
                </h3>
                
                
</header>

<?php 

if(is_array($nowplaying)){
?>
<div  style="margin-bottom:0; " class="panel panel-color panel-warning">
    <div class="panel-heading"> 
        <h3 class="panel-title">Now Playing - <?php
 echo $nowplaying['gr_name']; ?></h3> 
    </div> 
    <div class="panel-body"> 
    <?php 
	$sql = "select * from sw_group_members 
	left join sw_players on grm_rel_py_id = py_id
where grm_status=1 and grm_valid =1 and grm_rel_gr_id = ".$nowplaying['gr_id']." and py_valid =1 and py_status= 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
if(time() < $nowplaying['sp_dnt']  + 16){
	?>
        <audio loop autoplay>
  
  <source src="assets/alert.mp3" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
    <style>
#overlaaay {
    position: fixed; /* Sit on top of the page content */
    display: block; /* Hidden by default */
    width: 100%; /* Full width (cover the whole page) */
    height: 100%; /* Full height (cover the whole page) */
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
	opacity:0.5;
    background-color: rgba(0,0,0,0.5); /* Black background with opacity */
    z-index: 854; /* Specify a stack order in case you're using a different order for other elements */
    cursor: pointer; /* Add a pointer on hover */
}
#wnjskdmqeijpon {
        width: 200px;
    height: 200px;

    position:absolute;
    top:50%;
    left:50%;
    margin-left:-100px;/* half width*/
    margin-top:-100px;/* half height*/
}
</style>
 <div id="overlaaay">
 	<p style="color:white" id="wnjskdmqeijpon"><img src="img/new-purple-animation.gif" class="img-responsive" /></p>
 </div> 
	<?php
	
}
	echo '
	 <div class="col-sm-2">
    <div class="panel">
        <div class="panel-body p-t-10">
            <div class="media-main">
                <a class="pull-left" href="#">
                    <img class="thumb-lg img-thumbnail" src="'.$row['py_img'].'" alt="'.$row['py_name'].'">
                </a>
                <div class="info">
                    <h4>'.$row['py_name'].'</h4>
                </div>
            </div>
        </div> <!-- panel-body -->
    </div> <!-- panel -->
</div> <!-- end col -->


';

	
    }
}
	?>

    </div> 
</div>
<?php
}else{
	
	?>

	<div class="panel panel-color panel-warning">

    <div class="panel-body">
    	<h1 align="center">Awaiting Fixture Confirmation<i class="blink">...</i></h1> 
        </div> 
</div>

<script>

function blinker() {
    $('.blink').fadeOut(1000).fadeIn(1000);
}
 
setInterval(blinker, 2000);
</script>
	<?php
	die;
}
?>


<?php 
if(is_array($nextplaying)){
?>
<div  class="panel panel-color panel-success">
    <div class="panel-heading"> 
        <h3 class="panel-title">Up Next - <?php
 echo $nextplaying['gr_name']; ?></h3> 
    </div> 
    <div class="panel-body"> 
<?php
if(is_array($nextplaying)){
	 ?>
    <?php 
	$sql = "select * from sw_group_members 
	left join sw_players on grm_rel_py_id = py_id
where grm_status=1 and grm_valid =1 and grm_rel_gr_id = ".$nextplaying['gr_id']." and py_valid =1 and py_status= 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

	echo '
		 <div class="col-sm-2">
    <div class="panel">
        <div class="panel-body p-t-10">
            <div class="media-main">
                <a class="pull-left" href="#">
                    <img class="thumb-lg img-thumbnail" src="'.$row['py_img'].'" alt="'.$row['py_name'].'">
                </a>
                <div class="info">
                    <h4>'.$row['py_name'].'</h4>
                </div>
            </div>
        </div> <!-- panel-body -->
    </div> <!-- panel -->
</div> <!-- end col -->';

	
    }
} else {
    echo "0 results";
}

}
	?>
    </div> 
</div>
<?php 
}else{
	
	?>
    	<div class="panel panel-color panel-warning">

    <div class="panel-body">
    	<h1 align="center">Hope You Had A Great Time!!</h1> 
        </div> 
</div>
    <?php 
}
?>



