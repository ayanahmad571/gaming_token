<?php
include('include.php');
if(!isset($_SERVER['HTTP_REFERER'])){
	header('Location: page_that_gives_model_popups_to_pages.php');
}
?>
<?php

if(isset($_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID']) and trim($_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID']) != ''){
}else{
	die('Login to continue <a href="login.php">Login	</a>');
}

?><?php
if(isset($_POST['admin_prod_get'])){
	$msql = "
	SELECT * FROM `sw_players` where py_valid = 1 and py_status =1 and py_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and md5(py_id) = '".$_POST['admin_prod_get']."'
	
";

$mres = $conn->query($msql );

if ($mres->num_rows > 0) {
    // output data of each row

    while($mrw = $mres->fetch_assoc()) {
		#firts loop begins
		foreach($mrw as $me=>$m){
			$mrw[$me] = trim($m);
		}
		echo '
<form action="master_action.php" method="post">
<div class="row">
	<div class="col-xs-2 col-xs-offset-5"><img class="img-responsive" src="'.$mrw['py_img'].'" /></div>
</div><br>
<p>
'.$mrw['py_name'].'
</p>
<br>
<div class="col-sm-6">
<div class="form-group">
	<label>Player Name: </label>
	<input required  name="edit_product_name" type="text" class="form-control" value="'.$mrw['py_name'].'"/>
</div>

</div>
<div class="col-sm-6">
<div class="form-group">
	<label>Player Preference: </label>
	<input required  name="edit_product_desc" type="text" class="form-control" value="'.$mrw['py_desc'].'"/>
</div>

</div>
<div class="col-sm-6">
<div class="form-group">
	<label>Player Mobile: </label>
	<input required  name="edit_product_phone" type="text" class="form-control" value="'.$mrw['py_phone'].'"/>
</div>

</div>
<div class="col-sm-6">
<div class="form-group">
	<label>Player Email: </label>
	<input required  name="edit_product_email" type="text" class="form-control" value="'.$mrw['py_email'].'"/>
</div>

</div>


<div class="row">
	<div class="col-xs-6">
	<input required  type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($mrw['py_id'].'f2fkjwiuef0rjigbter 24rfgr324frgtr3f 3gr32fgr32f4gr')))))).'" name="edit_product_hash" />
		<input required  style="float:right" type="submit" class="btn btn-success" name="edit_product" value="Save">
	</div>
	<div class="col-xs-6">
		<button type="reset" class="btn btn-danger">Reset</button>
	</div>
</div>
	</form>
		        <script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
        <script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script>
$(document).ready(function(){
		  $(".wysihtml5").wysihtml5();
});
</script>
	';
	
	#first loop ends
    }
} else {
    echo "0 results";
}
}
if(isset($_POST['admin_prod_img_get'])){
	if(ctype_alnum(trim($_POST['admin_prod_img_get']))){
	}
$modalsql = "SELECT * FROM `sw_players` where py_valid = 1 and py_status =1 and py_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']." and md5(py_id) = '".$_POST['admin_prod_img_get']."'";
$modalres = $conn->query($modalsql);

if ($modalres->num_rows > 0) {
    // output data of each row
    while($modalrw = $modalres->fetch_assoc()) {
		#firts loop begins
		echo '
<div class="row">
<div class="col-xs-4 col-xs-offset-4">
	<img class="img-resposive" width="100%" src="'.$modalrw['py_img'].'"/>
</div>
</div>

<div class="row">
	<form action="img_change_inven.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="inven_id" value="'.md5(md5(sha1(md5(sha1($modalrw['py_id']))))).'"/>
		<input type="file" name="filer" onChange="" accept="image/*"/>
		<input type="submit" value="Update" name="updt_img" class="btn btn-danger" />
	</form>
	<div class="row">
		<div class="col-xs-offset-4 col-xs-4">
			<img class="img-responsive" id="output"/>
		</div>
	</div>
</div>


	';
	
	#first loop ends
    }
} else {
    echo "0 results";
}
}
/*--------------------------------------------------*/
if(isset($_POST['proforma_detailed_view'])){
	if(ctype_alnum($_POST['proforma_detailed_view'])){
	}else{
		die('Invalid Hash Is Being Passed');
	}
	$getqoid  = getdatafromsql($conn, "select * from sw_proformas
	left join sw_currency on po_rel_cur_id = cur_id
	left join sw_clients on po_rel_cli_id = cli_id
	 where md5(po_id)= '".$_POST['proforma_detailed_view']."' and po_valid =1");
	if(is_array($getqoid)){
	}else{
		die('No proforma Found for this hash');
	}
	?>
	<div class="row">
    <div class="col-xs-4">
        <p><div class="text-muted">Proforma Ref:</div><?php echo $getqoid['po_ref']; ?></p>
        <p><div class="text-muted">Date:</div><?php echo date('d-m-Y',$getqoid['po_dnt']); ?></p>
        <p><div class="text-muted">Currency:</div><?php echo $getqoid['cur_name']; ?></p>
    </div>
    <div class="col-xs-4">
        <p><div class="text-muted">Project:</div><?php echo $getqoid['po_proj_name']; ?></p>
        <p><div class="text-muted">Sub:</div><?php echo $getqoid['po_subj']; ?></p>
	    </div>
    
    <div class="col-xs-4">
        <p><div class="text-muted">Billing Address:</div><br><?php echo '<strong>'.$getqoid['cli_name'].'</strong><br>'.$getqoid['cli_bill_addr']; ?></p>
    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div  class="row">
                                        <hr>

                                    <table id="datatable_in" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <?php if($_SESSION['TKSYS_LUM_TU_ID'] ==1){ ?><th>Cost AED <br>per Unit</th><?php }?>                                                   <?php if($_SESSION['TKSYS_LUM_TU_ID'] ==1){ ?> <th>Markup</th><?php }?>
                                                    <th>Sale Price AED<br>per Unit </th>
                                                    <th>Qty</th>
                                                    <th>Total</th>
                                                    <th>-</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
<?php

$boxsql = "SELECT * FROM `sw_proformas_items` q 
left join sw_products_list p on q.pi_rel_pr_id = p.pr_id
left join sw_prod_types t on p.pr_rel_prty_id = t.prty_id
where q.pi_rel_po_id =".$getqoid['po_id']."  and pi_valid =1 and p.pr_valid =1
and t.prty_valid =1

";
$boxres = $conn->query($boxsql);
$total = 0;
if ($boxres->num_rows > 0) {
    // output data of each row
	$cc =1;
    while($boxrw = $boxres->fetch_assoc()) {
		#firts loop begins
		$init = round(($boxrw['pi_qty'] * $boxrw['pi_price'] * $getqoid['po_cur_rate']),2);
		echo '
		<tr>
<td>'.$cc.'</td>
<td>'.$boxrw['pr_code'].'</td>
<td>'.$boxrw['pr_name'].'<br>
'.convert_desc($boxrw['pi_desc']).'</td>
'; if($_SESSION['TKSYS_LUM_TU_ID'] ==1){ echo '<td>AED '.$boxrw['pi_cost'].'</td>'; }echo'
'; if($_SESSION['TKSYS_LUM_TU_ID'] ==1){ echo '<td>'.round((($boxrw['pi_price']/$boxrw['pi_cost'])),3).'</td>'; }echo'
<td>AED '.$boxrw['pi_price'].'</td>
<td>'.$boxrw['pi_qty'].' '.$boxrw['prty_unit'].'</td>
<td>'.$getqoid['cur_name'].' '.number_format($init,2).'</td>
<td>'.($boxrw['prty_pr_hidden'] == '1' ? '<i style="color:red">This product will not be visible in the print view. <br> And total will not be added in the Sub-Total</i>' : '').'</td>

</tr>';
	$cc++;
	#first loop ends
	if($boxrw['prty_pr_hidden'] == '0'){
	$total = $total + ($init);
	}
    }
} else {
    echo "0 results";
}
 ?>                       

 						                          
                                            </tbody>
                                        </table>
                                        
                                        <?php 
							echo '<h4 align="right"> '.$getqoid['cur_name'].' '.number_format(($total),2).' </h4>'; 
							echo '<h4 align="right"> '.$getqoid['cur_name'].' '.strtoupper(convert_number_to_words(($total))).' </h4>'; 
							
							?>
                                        <!-- -->

                               
 
 
                                        
                                 
                                        <!-- -->
                                    </div>
                                    <hr>
                                     </div>
                                </div>
                                <script type="text/javascript">
    $(document).ready(function() {
        $('#datatable_in').dataTable();
    } );
</script>
                                <?php
}
if(isset($_POST['proforma_edit'])){
	if(ctype_alnum($_POST['proforma_edit'])){
	}else{
		die('Invalid Hash Is Being Passed');
	}
	$getqoid  = getdatafromsql($conn, "
	select * from sw_groups
	where gr_valid =1 and gr_status =1 and gr_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']."
	and md5(gr_id)= '".$_POST['proforma_edit']."'");
	if(is_array($getqoid)){
	}else{
		die('No proforma Found for this hash');
	}
	?>
<form action="master_action.php" method="post" >
	<div class="row">

<input type="hidden" name="edit_group_hash" value="<?php echo md5($getqoid['gr_id']); ?>" />

<div class="col-md-12 col-sm-12 col-xs-12">
	<div  class="row">
<hr>
<table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Player</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
                                                
<?php

$boxsql = "select * from sw_group_members 
where grm_status=1 and grm_valid =1 and grm_rel_gr_id = ".$getqoid['gr_id']."";
$boxres = $conn->query($boxsql);
$total = 0;
if ($boxres->num_rows > 0) {
    // output data of each row
	$cc =1;
    while($boxrw = $boxres->fetch_assoc()) {
		
		#firts loop begins
		echo '


<tr>
	<td><select id="selold'.$cc.'" class="form-control " name="add_revision_proforma_product_already_'.$cc.'">';
$sql = "SELECT * FROM `sw_players` WHERE py_status = 1 and py_valid =1 and py_rel_lum_id = ".$_SESSION['TKSYS_LUM_DB_ID']."";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
	   if($row['py_id'] == $boxrw['grm_rel_py_id']){
		   echo '<option selected value="'.md5($row['py_id']).'">'.$row['py_name'].'</option>';
	   }else{
		   echo '<option value="'.md5($row['py_id']).'">'.$row['py_name'].'</option>';
	   }
	}
} else {
	echo "0 results";
}
echo '</select></td>
	
	
	';
	?>
    


	<td><button type="button" class="btn btn-danger" onClick="$(this).closest('tr').remove();">Delete</button></td>
	<?php echo'
</tr>
';
	$cc++;
	#first loop ends
    }
} else {
    echo "0 results";
}
 ?>
        <tr id="addrevpro1" class="PoFclonedInput">
            <td><select class="form-control add_revision_proforma_product_a" id="add_revision_proforma_product_a" name="add_revision_proforma_product_a">
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
            
<td></td>
	    </tr>
        
        
	</tbody>
</table>

<div class="row">
    <div align="center" class=" col-xs-12 ">
        <div id="addDelButtons">
          <input style="border-radius:10px" type="button" id="btnAdd7" value="Add More" class="btn btn-info" >
          <input style="border-radius:10px" type="button" id="btnDel7" value="Remove" class="btn btn-danger">
        </div> 
    </div><br>

    <div class="col-xs-12">
    	<input align="" type="submit" class="btn btn-success" value="Save Changes" name="add_revision_proforma"  />
        <input required  value="1" id="pro_nos" class="form-control" type="hidden" name="pro_nos"  />

    </div>
</div> 
                                        
                                        <!-- -->

                               
 
 
                                        
                                 
                                        <!-- -->
		</div>
	</div>
</div>
</form>


<?php /*
<script>
$(document).ready(function(){
		  $(".1wysihtml5").wysihtml5();
});
</script>

*/ ?>
<script type="text/javascript">
    $(document).ready(function() {
    } );
</script>
<script>
function myFunct(val) {
	if(val ==2){
		y = '';
	}else{
		y =(val-1);
	}
}

</script>



<script type="text/javascript"  src="assets/clone/clone-form-td.js"></script>

                                <?php
}
if(isset($_POST['proformas_print_view'])){
		if(ctype_alnum($_POST['proformas_print_view'])){
	}else{
		die('Invalid Hash Is Being Passed');
	}
	$getqoid  = getdatafromsql($conn, "select * from sw_proformas
	left join sw_currency on po_rel_cur_id = cur_id
	left join sw_clients on po_rel_cli_id = cli_id
	 where md5(po_id)= '".$_POST['proformas_print_view']."' and po_valid =1");
	if(is_array($getqoid)){
	}else{
		die('No proforma Found for this hash');
	}

$login=1;
$_USER = array();
$_USER = make_user_ar($conn,$_SESSION['TKSYS_LUM_DB_ID'],$login);

	?>
    
    
    <div class="row">
<table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Discount</th>
                    <th>Vat</th>
                    <th>Extra Price <br>(Will be added to total)</th>
                    <th>Footer</th>
                    <th>Extra</th>
                    <th>Before Total</th>
                    <th>After Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
$sql = "SELECT * FROM sw_proformas_gen where pog_rel_po_id = ".$getqoid['po_id'];
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       echo '
	   <tr>
	   	<td>'.$row['pog_discount'].'</td>
	   	<td>'.$row['pog_vat'].'%</td>
	   	<td>'.$row['pog_extra_price'].'</td>
	   	<td>'.$row['pog_footer'].'</td>
	   	<td>'.$row['pog_extra'].'</td>
	   	<td>'.str_replace('|=|=|=|=|=|','=',str_replace('||||||||||.||||||||||','<br>',$row['pog_before_total'])).'</td>
	   	<td>'.str_replace('|=|=|=|=|=|','=',str_replace('||||||||||.||||||||||','<br>',$row['pog_after_total'])).'</td>
		<td><a href="sw_proforma_print.php?id='.md5($row['pog_id']).'"><button class="btn btn-md btn-info">View</button></a></td>
	   </tr>
	   
	   
	   ';
    }
} else {
    echo "<tr><td colspan='7'> None Generated</td></tr>";
}
			
			?>
            </tbody>
</table>

    </div>

<hr><br>    
    
<form action="master_action.php" method="post" enctype="multipart/form-data">
<h3>Generate New</h3>
<input type="hidden" name="add_proforma_gen_hash" value="<?php echo md5($_POST['proformas_print_view']); ?>" />

<div class="col-xs-2">
    <div class="form-group">
        <label>Discount: </label>
        <input required  name="add_proforma_gen_discount"  type="number" step="0.01" class="form-control" value="0" placeholder="10"/>
    </div>
</div>

<div class="col-xs-2">
    <div class="form-group">
        <label>VAT: </label>
        <input required  name="add_proforma_gen_vat"  type="number" step="0.01" class="form-control" value="0" placeholder="5"/>
    </div>
</div>
<div class="col-xs-2">
    <div class="form-group">
        <label>Extra Price (Will be added to subtotal): </label>
        <input required  name="add_proforma_extra_price"  type="number" step="0.01" class="form-control" value="0" placeholder="5"/>
    </div>
</div>
<div class="col-xs-3">
    <div class="form-group">
        <label>LPO Reference:</label>
        <input required  name="add_proforma_gen_lpo" type="text" class="form-control" placeholder="35488"/>
    </div>
</div>
<div class="col-xs-3">
    <div class="form-group">
        <label>Payment Terms: </label>
        <input required  name="add_proforma_gen_payment_t" type="text" class="form-control" value="<?php echo $getqoid['cli_pay_terms'] ?>" placeholder="5"/>
    </div>
</div>
<div class="col-xs-4">
    <div class="form-group">
        <label>Address to be shown: </label>
        <textarea style="height:200px" name="add_proforma_address" required class="wysihtml54 form-control"><?php echo $getqoid['cli_bill_addr'] ?></textarea>
    </div>
</div>

<div class="col-xs-4">
    <div class="form-group">
        <label>Extra(Before Proforma Starts): </label>
        <textarea style="height:200px" name="add_proforma_gen_extra" required class="wysihtml54 form-control">-</textarea>
    </div>
</div>

<div class="col-xs-4">
    <div class="form-group">
        <label>Footer(After Proforma ends): </label>
        <textarea style="height:200px" name="add_proforma_gen_footer" required class="wysihtml54 form-control">-</textarea>
    </div>
</div>



<div class="col-xs-12">
<div class="form-group">
	<label>Before Total Heads: </label>
</div>    <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Header</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
    <tr id="proformagen1" class="eleclonedInput">
<td><input name="add_proforma_gen_bf_head" type="text" class="form-control add_proforma_gen_bf_head" id="add_proforma_gen_bf_head" required value="-" placeholder="Advance 14%"  /></td>
<td><input name="add_proforma_gen_bf_head_val" type="number" step="0.01" class="form-control add_proforma_gen_bf_head_val" id="add_proforma_gen_bf_head_val" required value="0" placeholder="10000"  /></td>
    
            </tr>
            
            </tbody>
    </table>
    <hr>
    <div class="row">
        <div align="left" class=" col-xs-12 ">
            <div id="addDelButtons11">
              <input style="border-radius:10px" type="button" id="btnAdd11" value="Add More" class="btn btn-info" >
              <input style="border-radius:10px" type="button" id="btnDel11" value="Remove" class="btn btn-danger">
            </div> 
        </div>
            <input required  value="1" id="before_head_pro_nos" class="form-control" type="hidden" name="before_head_pro_nos"  />
    </div> 
    
    <hr>
    
</div>
    
<div class="col-xs-12">
<div class="form-group">
	<label>After Total Heads: </label>
</div>
    <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Header</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
    <tr id="proformapen1" class="tenclonedInput">
<td><input name="add_proforma_gen_af_head" type="text" class="form-control add_proforma_gen_af_head" id="add_proforma_gen_af_head" required value="-" placeholder="Excess Duty"  /></td>
<td><input name="add_proforma_gen_af_head_val" type="text" class="form-control add_proforma_gen_af_head_val" id="add_proforma_gen_af_head_val" required value="-" placeholder="15000"  /></td>
    
            </tr>
            
            </tbody>
    </table>
    <hr>
    <div class="row">
        <div align="left" class=" col-xs-12 ">
            <div id="addDelButtons10">
              <input style="border-radius:10px" type="button" id="btnAdd10" value="Add More" class="btn btn-info" >
              <input style="border-radius:10px" type="button" id="btnDel10" value="Remove" class="btn btn-danger">
            </div> 
        </div>
            <input required  value="1" id="after_head_pro_nos" class="form-control" type="hidden" name="after_head_pro_nos"  />
    </div> 
    
    <hr>
    
</div>
    
    
    <div class="row">
        <div class="col-xs-6">
            <input required  style="float:right" type="submit" class="btn btn-success" name="add_proforma_gen" value="Generate Proforma">
        </div>
        <div class="col-xs-6">
            <button type="reset" class="btn btn-danger">Reset</button>
        </div>
    </div>
    
	</form>
<script type="text/javascript"  src="assets/clone/clone-form-td.js"></script>
<script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script>
$(document).ready(function(){
		  $(".wysihtml54").wysihtml5();
});
</script>
    <?php
}
/*-----------------------------------------------*/
if(isset($_POST['costing_add'])){
	$getpo  = getdatafromsql($conn,"select * from sw_proformas where po_valid =1 and md5(po_id) = '".$_POST['costing_add']."'");
	if(!is_array($getpo)){
		die('No Purchase Order Found');
	}
	?>

<form action="master_action.php" method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-xs-6">
        <label>Cost Reason</label>
        <input type="text"  name="costing_head" value="-" class="form-control" placeholder="Labour Food"/>
    </div>
    <div class="col-xs-6">                
        <label>Cost Value(AED)</label>
        <input  type="number" step="0.01"  name="costing_value" min="1" value="0" class="form-control" placeholder="Enter AED"/>
    </div>
</div>
<div class="row"><br>

    <input type="hidden"  name="costing_hash" class="form-control" value="<?php echo md5($getpo['po_id']) ?>"/>
    <input type="submit"  name="add_costing" class="btn btn-success" value="Add Addition Cost"/>

</div>
</form>



    <?php
}
if(isset($_POST['costing_view'])){
		$getpro  = getdatafromsql($conn,"select * from sw_proformas where po_valid =1 and md5(po_id) = '".$_POST['costing_view']."'");
	if(!is_array($getpro)){
		die('No Proforma Found');
	}

	?>
<p>Costing Tracking</p>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Cost Name</th>
                    <th>Cost Value</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
            <?php
			
			
			
$gsql = "SELECT * FROM `sw_costing` 
WHERE cost_valid =1 and `cost_rel_po_id` = ".$getpro['po_id']." order by cost_dnt desc";
$gsql = $conn->query($gsql);

if ($gsql->num_rows > 0) {
    // output data of each row
    while($grow = $gsql->fetch_assoc()) {
       echo '
	   <tr>
	   	<td>'.$grow['cost_name'].'</td>
	   	<td>'.$grow['cost_val'].'</td>
	   	<td>'.date('D, j/n/y @ H:i:s',$grow['cost_dnt']).'</td>
	   </tr>
	   
	   
	   ';
    }
} else {
    echo "<tr><td colspan='3'> None Added</td></tr>";
}
			
			?>
            </tbody>
</table>

    <?php
}
/*-----------------------------------------------*/
if(isset($_POST['payment_add'])){
	$getpo  = getdatafromsql($conn,"select * from sw_proformas left join sw_currency on po_rel_cur_id = cur_id
 where po_valid =1 and md5(po_id) = '".$_POST['payment_add']."'");
	if(!is_array($getpo)){
		die('No Proforma Found');
	}
	?>
<table id="datatable1" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Total Price <br>
                            (Including Vat and Discout)</th>
                          <th>Amount Paid</th>
                          <th>Amount Left</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
$productsql = "SELECT * FROM `sw_proformas` 
WHERE po_id = '".$getpo['po_revision_id']."'
";
$productres = $conn->query($productsql);

/*
select * from sw_purchaseorders where pco_valid =1 and pco_revision_id = '".$_POST['add_salesinvoice_proforma_hash']."' order by pco_revision desc limit 1 
*/
if ($productres->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row
	$con = 1;
	while($productrw = $productres->fetch_assoc()) {
	$getmax = getdatafromsql($conn,"
select * from sw_proformas p
left join sw_clients c on p.po_rel_cli_id = c.cli_id
left join sw_currency cy on p.po_rel_cur_id = cy.cur_id
where po_valid =1 and cli_valid =1 and po_revision_id = '".$productrw['po_id']."' order by po_revision desc limit 1");
$getsales = getdatafromsql($conn, "
select * from `sw_salesinvoices` s
left join sw_proformas pk on s.so_rel_po_id = pk.po_id
 where po_valid=1 and so_valid =1 and po_revision_id = ".$productrw['po_id']." order by so_revision desc limit 1");
 
			if(is_array($getsales)){
				$salesref = $getsales['so_ref'];

$gettotalprice = getdatafromsql($conn,"select sum(si_qty * si_price) as total from sw_salesinvoices_items left join sw_products_list on si_rel_pr_id = pr_id left join sw_prod_types on pr_rel_prty_id = prty_id where si_rel_so_id = ".$getsales['so_id']." and si_valid =1 and prty_pr_hidden = 0");
			$gettotalpricegen = getdatafromsql($conn,"select sog_discount as sog_discount,
			((sog_vat * ".$gettotalprice['total'].")/100) as sog_vat,
			(sog_extra_price) from sw_salesinvoices_gen where sog_rel_so_id = ".$getsales['so_id']." and sog_valid =1 order by sog_dnt desc limit 1");
			
			$getamountpaid = getdatafromsql($conn,"select sum(pt_val) as total from sw_payments where pt_rel_po_id = ".$productrw['po_id']." and pt_valid =1");
			$getinstallments = getdatafromsql($conn,"select count(pt_id) as total from sw_payments where pt_rel_po_id = ".$productrw['po_id']." and pt_valid =1");
			
			
			$checkgen = getdatafromsql($conn,"select * from sw_salesinvoices_gen where sog_rel_so_id = ".$getsales['so_id']." and sog_valid =1 ");				
			}else{

				$salesref = '-';

$gettotalprice = getdatafromsql($conn,"select sum(pi_qty * pi_price) as total from sw_proformas_items left join sw_products_list on pi_rel_pr_id = pr_id left join sw_prod_types on pr_rel_prty_id = prty_id where pi_rel_po_id = ".$getmax['po_id']." and pi_valid =1 and prty_pr_hidden = 0");
			$gettotalpricegen = getdatafromsql($conn,"select pog_discount as pog_discount,
			((pog_vat * ".$gettotalprice['total'].")/100) as pog_vat,
			(pog_extra_price) from sw_proformas_gen where pog_rel_po_id = ".$getmax['po_id']." and pog_valid =1 order by pog_dnt desc limit 1");
			
			$getamountpaid = getdatafromsql($conn,"select sum(pt_val) as total from sw_payments where pt_rel_po_id = ".$productrw['po_id']." and pt_valid =1");
			$getinstallments = getdatafromsql($conn,"select count(pt_id) as total from sw_payments where pt_rel_po_id = ".$productrw['po_id']." and pt_valid =1");
			
			
			$checkgen = getdatafromsql($conn,"select * from sw_proformas_gen where pog_rel_po_id = ".$getmax['po_id']." and pog_valid =1 ");
			}
			

			
			
			
			if(is_array($checkgen)){
	if(trim($salesref) !== '-'){
				$total = (($gettotalprice['total'] - $gettotalpricegen['sog_discount'] + $gettotalpricegen['sog_extra_price']+ $gettotalpricegen['sog_vat']));
echo '<tr>
	<td>'.$con.'</td>
	<td>'.$getmax['cur_name'].' '.number_format($total ,2).'</td>
	<td>'.$getmax['cur_name'].' '.number_format((($getamountpaid['total']  * $getsales['so_cur_rate'])) ,2).'</td>
	<td>'.$getmax['cur_name'].' '.number_format(($total - ($getamountpaid['total']) * $getsales['so_cur_rate'] ),2).'</td>
	</tr>';

				
				}else{
				$total = (($gettotalprice['total'] - $gettotalpricegen['pog_discount'] + $gettotalpricegen['pog_extra_price']+ $gettotalpricegen['pog_vat']));
echo '<tr>
	<td>'.$con.'</td>
	<td>'.$getmax['cur_name'].' '.number_format($total ,2).'</td>
	<td>'.$getmax['cur_name'].' '.number_format((($getamountpaid['total']  * $getmax['po_cur_rate'])) ,2).'</td>
	<td>'.$getmax['cur_name'].' '.number_format(($total - ($getamountpaid['total']) * $getmax['po_cur_rate'] ),2).'</td>
	</tr>';

				

				}
			}else{
				
	if(trim($salesref) == '-'){
			echo('<tr>
	<td>	'.$con.'</td>
<td style="border-right-width: 0px;">Generate Print View for Proforma Ref:<strong>'.$getmax['po_ref'].' </strong>to Manage Payments</td>
	<td style="border-right-width: 0px;">	</td>
	<td style="border-right-width: 0px;">	</td>
	<td>	</td>
	</tr>');
	}else{
			echo('<tr>
	<td>	'.$con.'</td>
<td style="border-right-width: 0px;">Generate Print View for SalesInvoice Ref:<strong>'.$getsales['so_ref'].' </strong>to Manage Payments</td>
	<td style="border-right-width: 0px;">	</td>
	<td style="border-right-width: 0px;">	</td>
	<td>	</td>
	</tr>');
		}
	
	
			}
				$con++;

	}

} else {
}?>
                      </tbody>
                    </table>
                    <hr><br>
<form action="master_action.php" method="post" enctype="multipart/form-data">
<input type="hidden" value="<?php echo $_POST['payment_add'] ?>" name="payment_add_hash"/>  
<div class="row">
    <div class="col-xs-6">
        <label>Method</label>
        <select name="payment_add_method" class="form-control" onchange="getval(this);">
<?php
$sql = "SELECT * from sw_payments_methods";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<option value="'.md5($row['method_id']).'">'.$row['method_name'].'</option>';
    }
} else {
}


?>
        </select>
    </div>
    <div class="col-xs-6 tohide">                
        <label>Cheque Number</label>
        <input type="text"  name="payment_add_c_no"  value="0" class="form-control" placeholder="Enter Cheque Number"/>
    </div>
    <div class="col-xs-6 tohide">                
        <label>Cheque Date(Enter 0 if not cheque)</label>
        <input type="text"  name="payment_add_date" placeholder="" value="0" class="form-control">
        <span class="help-inline">dd-mm-yyyy</span>
    </div>
    <div class="col-xs-6">                
        <label>Payment Value(<?php echo $getpo['cur_name'] ?>)</label>
        <input  type="number" step="0.01"  name="payment_add_val" min="1" value="0" max="<?php echo round(($total - ($getamountpaid['total']) * $getmax['po_cur_rate'] ),2); ?>" class="form-control" placeholder="Enter AED"/>
    </div>
</div>
<div class="row"><br>

    <input type="submit"  name="payment_add" class="btn btn-success" value="Add Payment"/>

</div>
</form>
<script>
function getval(sel)
{
    if((sel.value) == 'c81e728d9d4c2f636f067f89cc14862c'){
		$(".tohide").hide();
	}else{
		$(".tohide").show();
	}
}
</script>
        <script src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>


    <?php
}
if(isset($_POST['payment_view'])){
	if(!ctype_alnum($_POST['payment_view'])){
		die('Proforma Not Found');
	}
		$getpro  = getdatafromsql($conn,"select * from sw_proformas
		left join sw_currency on po_rel_cur_id = cur_id
 where po_valid =1 and md5(po_id) = '".$_POST['payment_view']."' ");
	if(!is_array($getpro)){
		die('No Proforma Found');
	}

	?>
<p>Currency and Rate: <strong><?php echo $getpro['cur_name'] ?> @ <?php echo $getpro['po_cur_rate'] ?></strong></p>
                                    <table id="datatable9" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Client </th>
                                                    <th>Method</th>
                                                    <th>Cheque Number</th>
                                                    <th>Cheque Dated</th>
                                                    <th>Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$bproductsql = "SELECT * FROM `sw_payments`
left join sw_payments_methods on pt_rel_method_id = method_id 
left join sw_proformas on pt_rel_po_id = po_id
left join sw_clients on po_rel_cli_id = cli_id
WHERE po_valid=1 and pt_rel_po_id = ".$getpro['po_id']."
order by pt_dnt desc
";
$bproductsql = $conn->query($bproductsql);

/*
select * from sw_purchaseorders where pco_valid =1 and pco_revision_id = '".$_POST['add_salesinvoice_proforma_hash']."' order by pco_revision desc limit 1 
*/
if ($bproductsql->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row
	$con = 1;
	while($prodrow = $bproductsql->fetch_assoc()) {
		echo '<tr>
	<td>'.$con.'</td>
	<td>'.$prodrow['cli_name'].'</td>
	<td>'.$prodrow['method_name'].'</td>
	<td>'.($prodrow['method_id'] =='2' ? '-': $prodrow['pt_cheque_number']).'</td>
	<td>'.($prodrow['method_id'] =='2' ? '-': date('j-n-Y',$prodrow['pt_cheque_date'])).'</td>
	<td>'.$getpro['cur_name'].' '.number_format(($prodrow['pt_val'] * $getpro['po_cur_rate']),2).'</td>
	</tr>';
	$con++;
	}

} else {
}?>
                        </tbody>
                                        </table>
                                        <script type="text/javascript">
    $(document).ready(function() {
        $('#datatable9').dataTable();
    } );
</script>


    <?php
}
/*-------------------------------*/







































?>