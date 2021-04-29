<script>
function isNumberKey(evt) 
          {
            var charCode = (evt.which) ? evt.which : event.keyCode
             if (((charCode > 47) && (charCode < 58 ) ) || (charCode == 8))
                   return true;

              return false;            
}
</script>


<link href="<?php echo base_url("assets/css/style.css") ?>" rel="stylesheet" type="text/css" media="screen" />
<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
		
		
		
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print">
                <div class="btn-group"> 
                    <a class="btn btn-primary" href="<?php echo base_url("visit") ?>"> <i class="fa fa-list"></i>  <?php echo "Visit List" ?> </a>  
                </div>
            </div> 

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php echo form_open_multipart('visit/target/'.$row->vt_id,'class="form-inner"') ?> 

                            <?php $user_id = $this->session->userdata('user_id'); 
	                            echo form_hidden('user_id',$row->us_id) ;
								echo form_hidden('vt_id',$row->vt_id) ;
						    if($row->us_id > 0)
							 $readonly = 'readonly';
	                        else
	                         $readonly = '';
	    
						    ?>

                            
                            <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 form-label"><?php echo 'Company' ?>
                                <i class="text-danger">*</i></label>
                                <div class="col-xs-5">
                                    <select name="vt_comp_id" id="vt_comp_id" class="form-control">
                                       <?php 
										   $crows = $this->db->query('select * from companies where comp_status=1')->result();
									       foreach($crows as $crow){
										 ?>
                                          <option value="<?php echo $crow->comp_id ;?>" <?php if($crow->comp_id ==$row->visit_company_id ) echo 'selected'; ?>><?php echo $crow->comp_name;?></option>
                                         <?php } ?>
                                       
                                    </select>
                                </div>
                        	</div>
						    <div class="form-group row">
                                <label for="comp_description" class="col-xs-3 form-label"><?php echo "Employees"; ?></label>
                                <div class="col-xs-5">
                                   <select name="vt_emp_id" class="form-control" id="vt_emp_id" required>
									   
										  <option value="">Please Select Option</option>
                                          
                                    </select>
                                </div>
                            </div> 
						
						   <div class="form-group row">
                                <label for="comp_rateperuser" class="col-xs-3 form-label"><?php echo "Month"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-5">
									<?
									$a = explode('-',$row->vt_month);
									$month =$a[1];
									?>
                                  <select name="vt_month" id="vt_month" class="form-control">
                                       <option value="01" <?php if('01' == $month) echo 'selected'; ?>>January</option>
									  <option value="02" <?php if('02' == $month) echo 'selected'; ?>>February</option>
									  <option value="03" <?php if('03' == $month) echo 'selected'; ?>>March</option>
									  <option value="04" <?php if('04' == $month) echo 'selected'; ?>>April</option>
									  <option value="05" <?php if('05' == $month) echo 'selected'; ?>>May</option>
									  <option value="06" <?php if('06' == $month) echo 'selected'; ?>>June</option>
									  <option value="07" <?php if('07' == $month) echo 'selected'; ?>>July</option>
									  <option value="08" <?php if('08' == $month) echo 'selected'; ?>>August</option>
									  <option value="09" <?php if('09' == $month) echo 'selected'; ?>>September</option>
									  <option value="10" <?php if('10' == $month) echo 'selected'; ?>>October</option>
									  <option value="11" <?php if('11' == $month) echo 'selected'; ?>>November</option>
									  <option value="12" <?php if('12' == $month) echo 'selected'; ?>>December</option>
									</select>
                                </div>
                               
                            </div>
						   
                            <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 form-label"><?php echo 'Assigned Dcotors Target' ?>
                                <i class="text-danger"></i></label>
                                <div class="col-xs-5">
                                    <input name="vt_doctor_target" type="text" class="form-control" id="vt_doctor_target" placeholder="<?php echo "Assigned Dcotors Target"?>" value="<?php echo $row->vt_doctor_target; ?>" required >
                                </div>
                        	</div>
						    <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 form-label"><?php echo 'Assigned Pharmacy Target' ?>
                                <i class="text-danger"></i></label>
                                <div class="col-xs-5">
                                    <input name="vt_phamacy_target" type="text" class="form-control" id="vt_phamacy_target" placeholder="<?php echo "Assigned Pharmacy Target"?>" value="<?php echo $row->vt_phamacy_target; ?>" required >
                                </div>
                        	</div>
						    <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 form-label"><?php echo 'Assigned Whole Seller Target' ?>
                                <i class="text-danger"></i></label>
                                <div class="col-xs-5">
                                    <input name="vt_whole_seller_target" type="text" class="form-control" id="vt_whole_seller_target" placeholder="<?php echo "Assigned Whole Seller Target"?>" value="<?php echo $row->vt_whole_seller_target;?>" required >
                                </div>
                        	</div>
						   <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 form-label"><?php echo 'Assigned Revnue Target' ?>
                                <i class="text-danger"></i></label>
                                <div class="col-xs-5">
                                    <input name="vt_revnue_target" type="text" class="form-control" id="vt_revnue_target" placeholder="<?php echo "Assigned Revnue Target"?>" value="<?php echo $row->vt_revnue_target;?>" required >
                                </div>
                        	</div>
<!--
                             <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 form-label"><?php echo 'Status' ?>
                                <i class="text-danger"></i></label>
                                <div class="col-xs-5">
                                    <select name="vt_status" class="form-control">
                                        <option value="0" <?php if($row->vt_status==0) echo 'selected'; ?>>Pending </option>
                                         <option value="1" <?php if($row->vt_status==1) echo 'selected'; ?>>Completed</option>
                                       
                                    </select>
                                </div>
                        	</div>
-->
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="btn btn-primary"><?php echo display('cancel') ?></button>
                                        
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
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link rel="stylesheet" href="<?php echo base_url()?>assets/css/wickedpicker.min.css">

<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<!-- Timepicker Js -->
<script src="<?php echo base_url()?>assets/js/wickedpicker.min.js"></script>

<script>
  $('.timepicker-24-hr').wickedpicker({twentyFour: true});
  $( function() {
    //$( "#datepicker" ).datepicker();
	  $("#datepicker").datepicker({ dateFormat: "yy-mm-dd" }).val()
  } );
$( document ).ready(function() {
	
	var company_id = $('#vt_comp_id').val();
	$.ajax({ 
		url: "<?php echo base_url('visit/getMemebrs');?>",
		method:"POST",
		data:{cid: company_id},	 
		success: function(data)  
		{
		
		$('#vt_emp_id').html(data);
		}   
	});
 
});	
 
$('#vt_comp_id').on('change',function(){
	
	var company_id = $('#vt_comp_id').val();
	
	$.ajax({ 
		url: "<?php echo base_url('visit/getMemebrs');?>",
		method:"POST",
		data:{cid: company_id},	 
		success: function(data)  
		{
		
		$('#vt_emp_id').html(data);
		}   
	});
 
});	
	
	
</script>

