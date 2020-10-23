<?php
if(include('include.php')){
}else{
die('##errMASTERofUSErERROR');
}


if(isset($_POST['py_id']) and ctype_alnum($_POST['py_id'])){
	$sql = "
	SELECT * FROM `sw_players` WHERE py_status = 1 and py_valid =1 and py_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']."
	and md5(sha1(md5(py_id)))= '".$_POST['py_id']."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		

		$should = 0;
	$groupnm = '<strong style="color:red"><em>None</em></strong>';
	$scrnm = '<strong style="color:red"><em>None</em></strong>';
	$getgrouplink = getdatafromsql($conn, "select * from sw_group_members
left join sw_groups on grm_rel_gr_id = gr_id 
 where grm_rel_py_id = ".$row['py_id']." and gr_valid =1 and gr_status =1 and gr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and grm_valid =1 and grm_status =1
 
 order by gr_id asc limit 1  ");
 
 if(is_array($getgrouplink)){
	$getscreenlink = getdatafromsql($conn, "select * from `sw_lineups_scr_gr`
	left join sw_screens on lu_rel_scr_id = scr_id
	where scr_valid = 1 and scr_status =1 and scr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and lu_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and lu_status =1 and lu_valid =1 and lu_rel_gr_id = ".$getgrouplink['gr_id']."");
		 	$groupnm = $getgrouplink['gr_name'];
	$should++;
	 if(is_array($getscreenlink)){
		 	$scrnm = $getscreenlink['scr_name'];
			$should++;
	 }
 }
 if($should < 2){
	die('Player not Associated with Group or Group not linked with screen');
	 }

		?>




<!DOCTYPE html>
<html lang="en">
    
<!-- the maninvoice.htmlby ayan ahmad 07:31:27 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="img/logo.jpg">

        <title><?php echo $row['py_name'].' - '.$getgrouplink['gr_name'].' - '.$getscreenlink['scr_name'] ?></title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">

        <!--Animation css-->
        <link href="css/animate.css" rel="stylesheet">

        <!--Icon-fonts css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/ionicon/css/ionicons.min.css" rel="stylesheet" />


        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/helper.css" rel="stylesheet">
        

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
      <style>
   

   hr {
	   color:#000;
	   border-color:#000;
   }
   td {
	   padding:3px !important;
   }
   </style>



    </head>


    <body>

            <div >

                <div class="">
                    <div class="">
                        <div style="padding:0" class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <h4>Invoice</h4>
                            </div> -->
                            <div class="profile-widget text-center">
  <div class="bg-danger bg-profile"></div>
  <img src="<?php echo $row['py_img']; ?>" class="thumb-lg  img-thumbnail" alt="<?php echo $row['py_name']; ?>">
  <h3><?php echo $row['py_name']; ?></h3>
  <p><?php echo $row['py_desc']; ?></p>
  <p><?php echo date('j, M Y @ H:i:s', time()); ?></p>
  <div class="hidden-print">
                                    <div align="center">
                                        <a onClick="window.print()" href="#" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                    </div>
                                </div>
  <ul class="list-inline widget-list clearfix">
  <?php 
	$membersingroup = getdatafromsql($conn, "select count(*) as noss from sw_group_members where grm_rel_gr_id = ".$getgrouplink['gr_id']." and 
	grm_status =1 and grm_valid =1");
	
	$groupbefore = "SELECT * FROM `sw_lineups_scr_gr` 
	left join sw_groups on lu_rel_gr_id = gr_id 
	WHERE 
	gr_valid =1 and gr_status =1 and
	lu_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and lu_rel_scr_id = ".$getscreenlink['scr_id']." and lu_status =1 and lu_valid =1";

$groupbefore = $conn->query($groupbefore);
$gbf = 0;
$loop = 1;
if ($groupbefore->num_rows > 0) {
    // output data of each row
    while($groupbeforerow = $groupbefore->fetch_assoc()) {
	if($loop == 1){
		if($groupbeforerow['lu_rel_gr_id'] == $getgrouplink['gr_id']){
			$loop = 0;
		}else{
			$gbf++;
		}
	}
    }
} 
  ?>
    <li class="col-md-3"><span><?php echo ($gbf ); ?></span>Groups Before</li>
    <li class="col-md-3"><span><?php echo $membersingroup['noss']; ?></span>Members in Group</li>
    <li class="col-md-3"><span><?php echo $getgrouplink['gr_name']; ?></span>Group</li>
    <li class="col-md-3"><span><?php echo $getscreenlink['scr_name']; ?></span>Screen</li>
  </ul>
</div>


<h4 align="center">You are in <strong style="color:green"><?php echo $getgrouplink['gr_name']; ?></strong>.<br>
 Watch your group on <strong style="color:green"><?php echo $getscreenlink['scr_name']; ?></strong>. <br>

There <?php echo ''.($gbf === '1' ? 'is' : 'are').' <strong style="color:green">'.$gbf.'</strong>';?> group<?php echo ($gbf === '1' ? '' : 's') ?> before your group.</h4>
<div class="row">
	<div class="col-md-6">
    	<h4>Fixture</h4><br>
		<?php 
											
$gp = "SELECT * FROM `sw_lineups_scr_gr` 
left join sw_groups on lu_rel_gr_id = gr_id 
WHERE 
gr_valid =1 and gr_status =1 and
lu_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and lu_rel_scr_id = ".$getscreenlink['scr_id']." and lu_status =1 and lu_valid =1";
$gp = $conn->query($gp);

if ($gp->num_rows > 0) {
    // output data of each row
	$ccc = 1;
echo '<ul>';
    while($lusandgrs = $gp->fetch_assoc()) {
		if($getgrouplink['gr_id'] == $lusandgrs['gr_id']){
			echo '
		
	<li><strong style="color:green">'.$ccc.'. '.$lusandgrs['gr_name'].'</strong></li>

		';
		}else{
		echo '
		
	<li>'.$ccc.'. '.$lusandgrs['gr_name'].'</li>

		';
		}
		$ccc++;
    }
	echo '</ul>';
} else {
    echo "<tr><td colspan='3'>No Group Fixtures Added Yet</td></tr>";
}

											?>
    </div>
	<div class="col-md-6">
    	<h4>Group Members</h4><br>
<?php 
	$getsd = "select * from sw_group_members 
	left join sw_players on grm_rel_py_id = py_id
where grm_status=1 and grm_valid =1 and grm_rel_gr_id = ".$getgrouplink['gr_id']." and py_valid =1 and py_status= 1";
$getsd = $conn->query($getsd);

if ($getsd->num_rows > 0) {
    // output data of each row
    while($pys = $getsd->fetch_assoc()) {
		if($pys['py_id'] == $row['py_id']){
			
		echo 
		'
		<div class="col-xs-3" style="margin-bottom:20px">
	<a href="#" class=" m-r-10">
	  <img src="'.$pys['py_img'].'" class="thumb-sm br-radius" alt="'.$pys['py_name'].'">
	</a>
	<a href="#"><strong style="color:green">'.$pys['py_name'].'</strong></a>
	</div>
';

		}else{
		echo 
		'
		<div class="col-xs-3" style="margin-bottom:20px">
	<a href="#" class=" m-r-10">
	  <img src="'.$pys['py_img'].'" class="thumb-sm br-radius" alt="'.$pys['py_name'].'">
	</a>
	<a href="#">'.$pys['py_name'].'</a>
	</div>
';
		}
		
		
    }
} else {
    echo "0 results";
}

?>
    </div>
</div>
                        </div>

                    </div>

                </div>

            </div>


    </body>

<!-- the maninvoice.htmlby ayan ahmad 07:31:28 GMT -->
</html>
        <?php
    }
} else {
    echo "0 results";
}
}else{
	die('Give Id');
}

?>