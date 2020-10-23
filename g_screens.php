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
$checkusereligibility = "SELECT * FROM `sw_modules` WHERE mo_valid =1 and FIND_IN_SET(".$_SESSION['TKSYS_LUM_TU_ID'].", mo_for) > 0 and mo_href = '".trim(basename($_SERVER['PHP_SELF']))."'";
if(is_array(getdatafromsql($conn,$checkusereligibility))){
}else{
	$cue1 = "SELECT * FROM `sw_submod` WHERE sub_valid =1 and sub_href = '".trim(basename($_SERVER['PHP_SELF']))."'";
	$cue1 = getdatafromsql($conn,$cue1);
	if(is_array($cue1)){
		$cue = "SELECT * FROM `sw_modules` WHERE mo_valid =1 and FIND_IN_SET(".$_SESSION['TKSYS_LUM_TU_ID'].", mo_for) > 0 and
		 mo_id = '".$cue1['sub_mo_rel_mo_id']."'";
		if(is_array(getdatafromsql($conn,$cue))){
		}else{
			die('<h1>503</h1><br>
			Access Denied');
		
		}
	}else{
		die('<h1>503</h1><br>
	Access Denied');
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

<?php get_head(); ?>
        <link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />

        <link href="assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        
    </head>


    <body>

        <!-- Aside Start-->
        <aside class="left-panel">

            
        <?php
		give_brand();
		?>
            <?php 
			get_modules($conn,$login,$admin);
			?>
                
        </aside>
        <!-- Aside Ends-->


        <!--Main Content Start -->
        <section class="content">
            
            <!-- Header -->
            <header class="top-head container-fluid">
                <button type="button" class="navbar-toggle pull-left">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <!-- Left navbar -->
                <nav class=" navbar-default" role="navigation">
                    

                    <!-- Right navbar -->
                    <?php
                    if($login==1){
						include('ifloginmodalsection.php');
					}
					?>
                    
                    <!-- End right navbar -->
                </nav>
                
            </header>
            <!-- Header Ends -->


            <!-- Page Content Start -->
            <!-- ================== -->

            <div class="wraper container-fluid">

                <div class="row">
                    

                    <div class="col-lg-12	">

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Manage Screens for <?php echo $_USER['usr_fname'].' '.$_USER['usr_lname'] ?></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                    <table id="datatable1" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Desc</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
<?php

$boxsql = "SELECT * FROM `sw_screens` where scr_status =1 and scr_valid =1 and scr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." ";
$boxres = $conn->query($boxsql);
	$cc =1;
if ($boxres->num_rows > 0) {
    // output data of each row
	$cc =1;
    while($boxrw = $boxres->fetch_assoc()) {
		#firts loop begins
		
$give = '';
		echo '
		<tr>
<td>'.$cc.'</td>
<td>'.$boxrw['scr_name'].'</td>
<td>'.$boxrw['scr_desc'].'</td>
<td><form action="master_action.php" method="post"><input type="hidden" value="'.md5(md5(sha1(md5(sha1($boxrw['scr_id']))))).'" name="scr_hash" /><input type="submit" class="btn btn-danger" value="Remove" name="scr_rem" /></form></td>
</tr>';
	$cc++;
	#first loop ends
	$stus = 'None';
    }
} else {
    echo "0 results";
}
 ?>                                                  
                                            </tbody>
                                        </table>
                                        <!-- -->

                               
 
 
                                        
                                 
                                        <!-- -->
                                    </div>
                                                                        </div></div></div></div></div>

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Add Screen</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                    <form action="master_action.php" method="post">
                                     <div class="col-md-12">
                                     <p><strong>Desc:</strong> <input type="text" name="scr_desc" class="form-control" placeholder="Description about the screen" /></p>
                                     <p><strong>Name: </strong><input type="text" name="scr_name" class="form-control" placeholder="Name of the screen" value="Screen <?php echo $cc ?>" /></p>
<p><input class="btn btn-success " name="add_scr" type="submit" value="Add Screen"/></p> 
</div>

</form>


                                    </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Screen and Group Relation</h3>
                            </div>
                            <div class="panel-body">
<div class="row">
                                        <!-- -->
                                         <?php

$boxsql = "SELECT * FROM `sw_screens` where scr_status =1 and scr_valid =1 and scr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." ";
$boxres = $conn->query($boxsql);

if ($boxres->num_rows > 0) {
    // output data of each row
	$cc =1;
    while($boxrw = $boxres->fetch_assoc()) {
		#firts loop begins
		echo '
<div class="col-md-6 col-xs-12">
	<div  class="panel panel-color panel-inverse">
		<div class="panel-heading"> 
			<h3 class="panel-title">'.$boxrw['scr_name'].'<span style="float:right"></div> 
		<div class="panel-body"> 
			<p>
			';
			?>
            <h5>Players</h5>
             <table id="datatable1" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
											
$gp = "SELECT * FROM `sw_lineups_scr_gr` 
left join sw_groups on lu_rel_gr_id = gr_id 
WHERE 
gr_valid =1 and gr_status =1 and
lu_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and lu_rel_scr_id = ".$boxrw['scr_id']." and lu_status =1 and lu_valid =1";
$gp = $conn->query($gp);

if ($gp->num_rows > 0) {
    // output data of each row
	$ccc = 1;
    while($lusandgrs = $gp->fetch_assoc()) {
		echo '
		
	<tr>
	<td>'.$ccc.'</td>
	<td>'.$lusandgrs['gr_name'].'</td>
	<td><form action="master_action.php" method="post">
		<input name="py_lu_hash" type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($lusandgrs['lu_id'].'kjafnm sjm n 309i4wef')))))).'" />
			<input type="submit" class="btn btn-danger" name="py_lu_del" value="Remove" />
		</form></td>
	</tr>
		
		';
		$ccc++;
    }
} else {
    echo "<tr><td colspan='3'>No Group Fixtures Added Yet</td></tr>";
}

											?><form action="master_action.php" method="post">
		
		
				
                                            	<tr>
                                                <td colspan="2">
                                                <input type="hidden" name="add_lu_scr" value="<?php echo md5($boxrw['scr_id']); ?>" />
                                                <select class="form-control" name="add_lu_gr" required>
                                                    <?php 
$sql = "SELECT * from sw_groups where gr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and gr_status =1 and gr_valid =1 and gr_id not in ( SELECT lu_rel_gr_id  FROM `sw_lineups_scr_gr` 
WHERE 
lu_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and lu_status =1 and lu_valid =1)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// output data of each row
	echo '<option value="0">Select Group </option>';
	while($row = $result->fetch_assoc()) {
		   echo '<option value="'.md5($row['gr_id']).'">'.$row['gr_name'].'</option>';
	}
} else {
	echo "<option>No Groups Found</option>";
}
?>
                                                </select></td>
                                                <td><input type="submit" class="btn btn-success" name="add_lu" value="Add Group to Screen Lineup " /></td>
                                                </tr></form>	
                                            </tbody>
                                            </table>
            
            <?php
			
			echo'
		
		
		</div> 
	</div>
</div>
                                        
	';

	$cc++;
	#first loop ends
    }
} else {
    echo "0 results";
}
 ?> 
                          
                                 
                                        <!-- -->
                                    </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div> <!-- End row -->


            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->

            <!-- Footer Start -->
            
       
         
                  <!-- Footer Start -->
            <footer class="footer">
<?php auto_copyright(); // Current year?>

  Aforty
            </footer>
            <!-- Footer Ends -->



        </section>
        <!-- Main Content Ends -->
  


      <?php  
	  get_end_script();
	  ?>   
    <script src="assets/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/datatables/dataTables.bootstrap.js"></script>
		        <script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
        <script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script>
$(document).ready(function(){
		  $(".wysihtml5").wysihtml5();
});
</script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable1').dataTable();
            } );
        </script>
      
           </body>

</html>
