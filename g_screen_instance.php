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
if(!isset($_GET['scr_id'])){
	header('Location: sw_gateway_admin_decision.php');
	die;
}


$checkscr = getdatafromsql($conn,"SELECT * FROM `sw_screens` where scr_status =1 and scr_valid =1 and scr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and 
md5(md5(sha1(md5(sha1(concat( scr_id ,'0932uqrheufineejfrh9uwinfjor02hurwnfjf20hurwn esofinvj2jpwironj')))))) = '".$_GET['scr_id']."'
");
if(!is_array($checkscr)){
	header('Location: sw_gateway_admin_decision.php');
	die;
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
            




            <!-- Header Ends -->


            <!-- Page Content Start -->
            <!-- ================== -->

            <div id="12312" class=" ">

                 <!-- End row -->

<div align="center"><img class="img-responsive" src="img/loader.gif" /></div>


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
      <script>
	  

setInterval(function()
{ 
    $.ajax({
      type:"post",
      url:"scr_ins_get.php",
	  data:{scr_id : '<?php echo $_GET['scr_id']; ?>'},
      datatype:"html",
      success:function(data)
      {
         $("#12312").html(data); //do something with response data
      }
    });
}, 5000);//time in milliseconds 


	  </script>
           </body>

</html>
