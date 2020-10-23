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

<!DOCTYPE html>
<html lang="en">

<head>

<?php get_head(); ?>
        <link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />

        <link href="assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        
    </head>


    <body>

        <!-- Aside Ends-->


        <!--Main Content Start -->
        <section>
            

            <!-- Header Ends -->


            <!-- Page Content Start -->
            <!-- ================== -->

            <div class="wraper container-fluid">

                <div class="row">
                    

                    <div class="col-lg-12	">

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Open Screen for <?php echo $_USER['usr_fname'].' '.$_USER['usr_lname'] ?></h3>
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
<td><form action="g_screen_instance.php" method="get"><input type="hidden" value="'.md5(md5(sha1(md5(sha1($boxrw['scr_id'].'0932uqrheufineejfrh9uwinfjor02hurwnfjf20hurwn esofinvj2jpwironj'))))).'" name="scr_id" /><button type="submit" class="btn btn-info">Open</button></form></td>
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
                                <h3 class="panel-title">Admin Panel</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                	<p><a href="home.php"><button class="btn btn-success">Click Here to Contine to Admin Panel</button></a></p>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                         <!-- end col -->

                    
                </div> <!-- End row -->


            </div> <!-- End row -->


            </div>
            <!-- Page Content Ends -->


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
