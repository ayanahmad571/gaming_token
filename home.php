<?php 

if(include('include.php')){
}else{
	die('ERrIN');
}
?>
<?php 

if(include('page_that_has_to_be_included_for_every_user_visible_page.php')){
}else{
	die('ERrPH');
}
?>

<?php

if($login == 1){
	if(trim($_USER['lum_ad']) == 1){
		$admin = 1;
	}else{
		$admin = 0;
	}
}else{
	header('Location: login.php');
	
}



?>
<!DOCTYPE html>
<html lang="en">

<head>

<?php get_head(); ?>
  <link href="assets/sweet-alert/sweet-alert.min.css" rel="stylesheet">
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
                <div class="page-title"> 
                    <h3 class="title">Welcome <?php echo ucwords($_USER['usr_fname']).' '.ucwords($_USER['usr_lname']); ?> !</h3> 
                </div>



                <div class="row">
                    

                    <div class="col-lg-12	">

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Fixture Administration</h3>
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
            <form action="master_action.php" method="post">
            <input type="hidden" name="add_sp" value="<?php echo md5($boxrw['scr_id']); ?>" />
            	<button type="submit" class="btn btn-lg btn-success">Next</button>
            </form>
            <hr>
            <h3>Fixture</h3>
             <table id="datatable1" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Status</th>
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
	<td>
	';
	$getlatestfixturelu = getdatafromsql($conn,"SELECT * FROM `sw_playing` 
	WHERE `sp_rel_lum_id` = '".$_SESSION['TKSYS_LUM_DB_ID']."' and `sp_rel_scr_id` = '".$boxrw['scr_id']."' and `sp_status` = 1 and `sp_valid` = 1 order by sp_id desc limit 1");

	$getallfixturelu = getdatafromsql_all($conn, "SELECT * FROM `sw_playing` 
	WHERE `sp_rel_lum_id` = '".$_SESSION['TKSYS_LUM_DB_ID']."' and `sp_rel_scr_id` = '".$boxrw['scr_id']."' and `sp_status` = 1 and `sp_valid` = 1 and sp_rel_lu_id = ".$lusandgrs['lu_id']."");

	if(!is_array($getallfixturelu)){
		echo '<em style="color:red">Not Played</em>';
	}else{
			if($getlatestfixturelu['sp_rel_lu_id'] !== $lusandgrs['lu_id']){	echo '<em style="color:green">Played</em>';}else{
			
				echo '<em style="color:#B88F00"><strong>Now Playing</strong></em>';}
	
	}
	echo'</td>
	</tr>
		
		';
		$ccc++;
    }
} else {
    echo "<tr><td colspan='3'>No Group Fixtures Added Yet</td></tr>";
}

											?>
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


            </div>
            </div>

 
            <!-- Page Content Ends -->
            <!-- ================== -->

            <!-- Footer Start -->
            <footer class="footer">
<?php auto_copyright(); // Current year?>

  Aforty.
            </footer>
            <!-- Footer Ends -->



        </section>
        <!-- Main Content Ends -->
  

<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-full modal-dialog"> 
     <div class="modal-content">  
   
        <div class="modal-header"> 
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
           <h4 class="modal-title">Product Analysis</h4> 
        </div> 
            
        <div class="modal-body">                     
           <div id="modal-loader-b" style="display: none; text-align: center;">
           <!-- ajax loader -->
           <img width="100px" src="img/ajax-loader.gif">
           </div>
                            
           <!-- mysql data will be load here -->                          
           <div id="dynamic-content-b"></div>
        </div> 
                        
        <div class="modal-footer"> 
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
        </div> 
                        
    </div> 
  </div>
</div>

      <?php  
	  get_end_script();
	  ?>
      
            
         <script src="assets/fullcalendar/moment.min.js"></script>
        <!--dragging calendar event-->
<script>
!function($) {
    "use strict";

    var SweetAlert = function() {};

    //examples 
    SweetAlert.prototype.init = function() {
        
<?php 

if(isset($_GET['mailsent'])){
	echo ' $(document).ready(function(){
        swal("Mail Sent!", "An Email regarding the issue has been sent . You will get a reply to the specified email within a few days", "success")
    });';
}
?>
    //Success Message
   


    },
    //init
    $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.SweetAlert.init()
}(window.jQuery);
</script>
       <script src="assets/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/datatables/dataTables.bootstrap.js"></script>


 <script>
$(document).ready(function(){

$(document).on('click', '#getStored', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'home_qty_stored='+uid,
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content-b').html(''); // blank before load.
          $('#dynamic-content-b').html(data); // load here
          $('#modal-loader-b').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content-b').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader-b').hide();
     });

    });
});
</script>
 <script>
$(document).ready(function(){

$(document).on('click', '#getStoredSP', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'home_qty_stored_sp='+uid,
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content-b').html(''); // blank before load.
          $('#dynamic-content-b').html(data); // load here
          $('#modal-loader-b').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content-b').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader-b').hide();
     });

    });
});
</script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable').dataTable();
            } );
        </script>



    </body>

</html>
