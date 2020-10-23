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
        <script src="js/jquery.js"></script>
   
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
                                <h3 class="panel-title">Group Manager (Delete / Edit)</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div style=" overflow:auto;
 position:relative;" class="row">
                                    <table id="datatable1" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Players</th>
                                                    <th>Creation Date</th>                                                    
													<th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$productsql = "SELECT * from sw_groups where gr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and gr_status =1 and gr_valid =1";
$productres = $conn->query($productsql);
	$con = 1;

if ($productres->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row
	while($productrw = $productres->fetch_assoc()) {

		echo '<tr>
	<td>'.$con.'</td>
	<td>'.$productrw['gr_name'].'</td>
	<td>
                                <ul class="list-group list-group-lg">
	';
	$getsd = "select * from sw_group_members 
	left join sw_players on grm_rel_py_id = py_id
where grm_status=1 and grm_valid =1 and grm_rel_gr_id = ".$productrw['gr_id']." and py_valid =1 and py_status= 1";
$getsd = $conn->query($getsd);

if ($getsd->num_rows > 0) {
    // output data of each row
    while($pys = $getsd->fetch_assoc()) {
		echo 
		'
<li class="list-group-item b-0">
	<a href="#" class=" m-r-10">
	  <img src="'.$pys['py_img'].'" class="thumb-sm br-radius" alt="'.$pys['py_name'].'">
	</a>
	<a href="#">'.$pys['py_name'].'</a>
</li>
';
    }
} else {
    echo "0 results";
}

	echo '
	</ul>						
	</td>
	<td>'.date('d-M-Y',$productrw['gr_dnt']).'</td>
	<td>
<button id="getPoEdit" data-toggle="modal" data-target="#view-modal" data-id="'.md5($productrw['gr_id']).'" class="btn btn-sm btn-warning">Edit Group</button>
<hr>
<form action="master_action.php" method="post">
<input type="hidden" name="del_group_hash" value="'.md5(sha1(md5($productrw['gr_id']))).'" />
<input type="submit" name="del_gr" value="Delete" class="btn btn-danger" />
</form>
	</td>
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
                                    
                                    </div></div></div></div></div>

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Add New Group</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
<div class="row">
	<div class="col-xs-12">
    	<form action="master_action.php" method="post">

<div class="form-group">
	<label>Group Name: </label>
	<input required  name="add_group_name" type="text" class="form-control"  value="Group <?php echo $con ; ?>"/>
</div>


<table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Players</th>
            </tr>
        </thead>
        <tbody>
<tr id="proformaadd1" class="PerfclonedInput">
            <td><select required class="form-control add_proforma_product" id="add_proforma_product" name="add_proforma_product">
<?php 
$sql = "SELECT * FROM `sw_players` WHERE py_status = 1 and py_valid =1 and py_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']."";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// output data of each row
	echo '<option value="0">Select Player </option>';
	while($row = $result->fetch_assoc()) {
		   echo '<option value="'.md5($row['py_id']).'">'.$row['py_name'].'</option>';
	}
} else {
	echo "0 results";
}
?>
            </select></td>
            


	    </tr>
        
        </tbody>
</table>
<hr>
<div class="row">
    <div align="left" class=" col-xs-12 ">
        <div id="addDelButtons6">
          <input style="border-radius:10px" type="button" id="btnAdd6" value="Add More" class="btn btn-info" >
          <input style="border-radius:10px" type="button" id="btnDel6" value="Remove" class="btn btn-danger">
        </div> 
    </div>
        <input required  value="1" id="per_nos" class="form-control" type="hidden" name="per_nos"  />
</div> 

<hr>




<div class="row">
	<div class="col-xs-6">
		<input required  style="float:right" type="submit" class="btn btn-success" name="add_proforma" value="Add Group">
	</div>
</div>
	</form>
<script type="text/javascript"  src="assets/clone/clone-form-td.js"></script>

    </div>
</div>
                                  </div>
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
           <h4 class="modal-title">Group Management</h4> 
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
	  get_end_script_nojs();
	  ?>   

<script src="assets/datatables/jquery.dataTables.min.js"></script>
<script src="assets/datatables/dataTables.bootstrap.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
		$('.mobileSelectSpecial').mobileSelect({
			onClose: function(){
				var txt = $(this).val();
				$.post("master_action.php", {prname: txt}, function(result){
					result = $.parseJSON( result );
					$("#chageqty").html(result.qty);
					$("#chageprname").html(result.prname);
				});
			}
		});
    } );
</script>
<script type="text/javascript">
    $(document).ready(function() {
		$('.mobileSelect').mobileSelect();
    } );
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable1').dataTable();
    } );
</script>
<script>
$(document).ready(function(){

$(document).on('click', '#getModalForWarehouse', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'add_proforma_warehouse='+uid,
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

$(document).on('click', '#getModalForQuoteProAdd', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'add_proforma_quotation='+uid,
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

$(document).on('click', '#getModalForProPro', function(e){  
     e.preventDefault();
  
     var uid = $('#transferval').val(); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'add_proforma_proforma='+uid,
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

$(document).on('click', '#getPoEditSup', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'edit_proforma_supplier='+uid,
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

$(document).on('click', '#getPoEdit', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'proforma_edit='+uid,
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

$(document).on('click', '#getPrintView', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'proformas_print_view='+uid,
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

$(document).on('click', '#getDetailedView', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'proforma_detailed_view='+uid,
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
$(document).ready(function(e) {
    $('.thistoh').addClass('hidden');
	var iddf =$('#select_can').val();
	var pela =document.getElementById(iddf);
	$(pela).removeClass('hidden');
});
$('#select_can').change(function(e) {

	$('.thistoh').addClass('hidden');
	var ider = $(this).val();
	var pel =document.getElementById(ider);
	$(pel).removeClass('hidden');

});
</script>
<script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script>
$(document).ready(function(){
		  $(".wysihtml5").wysihtml5();
});
</script>
           </body>

</html>
