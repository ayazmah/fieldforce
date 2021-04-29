<link href="<?php echo base_url("assets/css/style.css") ?>" rel="stylesheet" type="text/css" media="screen" />
<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print">
                <div class="btn-group"> 
                    <a class="btn btn-primary" href="<?php echo base_url("invoice") ?>"> <i class="fa fa-list"></i>  <?php echo "Invoice" ?> </a>  
                </div>
            </div> 

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php echo form_open_multipart('invoice/add/'.$row->inv_id,'class="form-inner"') ?> 

                            <?php $user_id = $this->session->userdata('user_id'); 
	                            echo form_hidden('inv_id',$row->inv_id) ;
						
						   
	    
						    ?>

                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label"><?php echo "Invoice Title"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="inv_name" type="text" class="form-control" id="inv_name" placeholder="<?php echo "Invoice Title"?>" value="<?php echo $row->inv_name ?>" required >
                                </div>
                            </div>
						   
						    <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 col-form-label"><?php echo 'Company' ?>
                                <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <select name="inv_us_id" class="form-control">
										<?php 
										   $crows = $this->db->query('select * from users where us_id!=1 and us_status=1')->result();
									       foreach($crows as $crow){
										 ?>
                                          <option value="<?php echo $crow->us_id;?>" <?php if($crow->id==$row->inv_us_id) echo 'selected'; ?>><?php echo $crow->us_name;?></option>
                                         <?php } ?>
                                    </select>
                                </div>
                        	</div>
						    <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label"><?php echo "Price for Single User"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="inv_unit_price" type="text" class="form-control" id="inv_unit_price" placeholder="<?php echo "Price for Single Use"?>" value="<?php echo $row->inv_unit_price ?>" required  >
                                </div>
                            </div>
						   <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label"><?php echo "Total Users"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="inv_total_users" type="text" class="form-control" id="inv_total_users" placeholder="<?php echo "Total Users"?>" value="<?php echo $row->inv_total_users ?>" required >
                                </div>
                            </div>
						
						   <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label"><?php echo "Total Price"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="inv_total_price" type="text" class="form-control" id="inv_total_price" placeholder="<?php echo "Total Price"?>" readonly value="<?php echo $row->inv_total_price ?>"  >
                                </div>
                            </div>
                            <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 col-form-label"><?php echo 'Status' ?>
                                <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <select name="inv_status" class="form-control">
                                        <option value="1" <?php if($row->inv_status==1) echo 'selected'; ?>>Active </option>
                                         <option value="0" <?php if($row->inv_status==0) echo 'selected'; ?>>In Active</option>
                                       
                                    </select>
                                </div>
                        	</div>


                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="btn btn-primary" onClick="window.location='<?php echo base_url("dashboard/home")?>'"><?php echo display('cancel') ?></button>
                                        
                                        <button class="ui positive button btn btn-primary"><?php echo display('save') ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $("#inv_unit_price").keydown(function(event) {
        if ( event.keyCode == 46 || event.keyCode == 8 ) {
        }
        else {
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }   
        }
    });
   $("#inv_total_users").keydown(function(event) {
        if ( event.keyCode == 46 || event.keyCode == 8 ) {
        }
        else {
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }   
        }
    });	
	
	
})
$('#inv_unit_price').on('keyup',function() {
	var users = $('#inv_total_users').val();
	var price = $('#inv_unit_price').val();
	var total = parseInt(price) * parseInt(users);
	if(isNaN(total)) {
    var total = '';
    }
	$('#inv_total_price').val(total);
	
	
	$('#inv_total_price').val(total);
});
$('#inv_total_users').on('keyup',function() {
	var users = $('#inv_total_users').val();
	var price = $('#inv_unit_price').val();
	var total = parseInt(price) * parseInt(users);
	if(isNaN(total)) {
    var total = '';
    }
	$('#inv_total_price').val(total);
});
	
</script>