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

            <div class="row">
                    

                    <div class="col-lg-12	">

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Tokens for <?php echo $_USER['usr_fname'].' '.$_USER['usr_lname'] ?></h3>
                            </div>
                            <div class="panel-body">
                            <div class="row" >
	Note: Only give tokens once groups have been made and assigned to screens.
    <hr>
                            </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div style=" overflow:auto;
 position:relative;" class="row">
                                    <table id="datatable1" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Img</th>
                                                    <th>Group</th>
                                                    <th>Screen</th>
                                                    <th>Should Print</th>
                                                    <th>Token</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$productsql = "SELECT * FROM `sw_players` WHERE py_status = 1 and py_valid =1 and py_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']."";
$productres = $conn->query($productsql);

if ($productres->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row

	
	$con = 1;
	while($productrw = $productres->fetch_assoc()) {
	$should = 0;
	$groupnm = '<strong style="color:red"><em>None</em></strong>';
	$scrnm = '<strong style="color:red"><em>None</em></strong>';
	$getgrouplink = getdatafromsql($conn, "select * from sw_group_members
left join sw_groups on grm_rel_gr_id = gr_id 
 where grm_rel_py_id = ".$productrw['py_id']." and gr_valid =1 and gr_status =1 and gr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and grm_valid =1 and grm_status =1
 
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
	 $shouldi = '<strong style="color:red"><em>No</em></strong>';
 }else{
	 $shouldi = '<strong style="color:green"><em>Yes</em></strong>';
 }

		echo '<tr>
	<td>'.$con.'</td>
	<td>'.$productrw['py_name'].'</td>
	<td>
		<img  width="200px" src="'.$productrw['py_img'].'" class="img-responsive" />
		
	</td>
	<td>'.$groupnm.'</td>
	<td>'.$scrnm.'</td>
	<td>'.$shouldi.'</td>
								<td>'.($should == 2 ? '
<div class="row m-b-5">
<form action="g_tokens_view.php" method="post">
	<input type="hidden" name="py_id" value="'.md5(sha1(md5($productrw['py_id']))).'" />
	<input type="submit" class="btn btn-success" value="View" />
</form>
</div>' : 'Criteria Missing').'</td>
					</tr>';

	$con++;
	}

} else {
}?>
                        </tbody>
                                        </table>
                                        <!-- -->

                               
 
 
                                        
                                 
                                        <!-- -->
                                    </div>
                                    <hr>
<?php
/* 
<div class="row">
    <form action="master_action.php" method="post">
    <h4>&nbsp; Add Client</h4>
    <div class="col-md-12">
        <div class="panel panel-color panel-inverse">
            <div class="panel-heading"> 
            </div>
            <div class="panel-body"> 
                <p>Name:<input required class="form-control "  name="add_client_name" type="text" placeholder="Alpha Beta" /></p>
                <p>Code:<input required class="form-control "  name="add_client_code" type="text" placeholder="AB" /></p>
                <p>Email: <input required  class="form-control" name="add_client_email" type="email" placeholder="abc@example.com"  /></p> 
                <p>Billing Address: <textarea name="add_client_bill_addr" class="wysihtml5 form-control" rows="9"></textarea></p> 
                <p>Shipping Address:<textarea name="add_client_ship_addr" class="wysihtml5 form-control" rows="9"></textarea></p>
                <p>Phone:<input required class="form-control "  name="add_client_phone" type="text" placeholder="With International Code and seperated with comma ," /></p>
                <p>Desc: <textarea name="add_client_desc" class="form-control" rows="9"></textarea></p> 
                <p>Payment Terms: <input required  class="form-control" name="add_client_pyt" type="text" placeholder='50,40,10' value="50,50" /></p> 
                <p><input class="btn btn-success " name="add_client" type="submit" value="Add Client"/></p> 
            </div> 
        </div>
    </div>
    </form>
</div>

*/  ?>                                   </div>
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
            
<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-full modal-dialog"> 
     <div class="modal-content">  
   
        <div class="modal-header"> 
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
           <h4 class="modal-title">
           <i class="glyphicon glyphicon-user"></i>Players</h4> 
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable1').dataTable();
    } );
</script>
<script>
$(document).ready(function(){

$(document).on('click', '#AddPr', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'add_prod_give_modal='+uid,
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

$(document).on('click', '#getProd', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'admin_prod_get='+uid,
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

$(document).on('click', '#getProdQty', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'admin_prod_get_qty='+uid,
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

$(document).on('click', '#getImg', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'admin_prod_img_get='+uid,
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
           </body>

</html>
