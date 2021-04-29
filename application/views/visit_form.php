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
 
            <div class="panel-heading1 no-print">
                <div class="btn-group" style="margin-left:15px; margin-top:10px;"> 
                    <a class="btn btn-primary" href="<?php echo base_url("visit") ?>"> <i class="fa fa-list"></i>  <?php echo "Visit List" ?> </a>  
                </div>
            </div> 

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php echo form_open_multipart('visit/add/'.$row->visit_id,'class="form-inner"') ?> 

                            <?php $user_id = $this->session->userdata('user_id'); 
	                            echo form_hidden('user_id',$row->us_id) ;
								echo form_hidden('visit_id',$row->visit_id) ;
						    if($row->us_id > 0)
							 $readonly = 'readonly';
	                        else
	                         $readonly = '';	    
						    ?>

                            
                            <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 form-label"><?php echo 'Company' ?>
                                <i class="text-danger">*</i></label>
                                <div class="col-xs-5">
                                    <select name="visit_company_id" id="visit_company_id" class="form-control">
                                       <?php 
										   $crows = $this->db->query('select * from companies where comp_status=0 AND comp_is_deleted=0')->result();
									       foreach($crows as $crow){
										 ?>
                                          <option value="<?php echo $crow->comp_id ;?>" <?php if($crow->comp_id ==$row->visit_company_id ) echo 'selected'; ?>><?php echo $crow->comp_name;?></option>
                                         <?php } ?>
                                       
                                    </select>
                                </div>
                        	</div>
						    <div class="form-group row">
                                <label for="name" class="col-xs-3 form-label"><?php echo "Client Type"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-5">
                                    <select name="visit_client_type" id="visit_client_type" class="form-control" required>
										  <option value="">Please Select Option</option>
                                          <option value="doctors" <?php if($row->visit_client_type == 'doctors' ) echo 'selected'; ?>>Doctor</option>
										  <option value="pharmacy" <?php if($row->visit_client_type == 'pharmacy' ) echo 'selected'; ?>>Pharmacy</option>
										  <option value="wholesaler" <?php if($row->visit_client_type == 'wholesaler' ) echo 'selected'; ?>>Wholesaler</option>
                                    </select>
                                </div>
                            </div> 
						    <div class="form-group row">
                                <label for="comp_description" class="col-xs-3 form-label"><?php echo "Client"; ?></label>
                                <div class="col-xs-5">
                                   <select name="visit_client_id" class="form-control" id="visit_client_id" required>
									     
									   
										  <option value="">Please Select Option</option>
                                    </select>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label for="comp_description" class="col-xs-3 form-label"><?php echo "Employees"; ?></label>
                                <div class="col-xs-5">
                                   <select name="visit_member_id" class="form-control" id="visit_member_id" required>
									   
										  <option value="">Please Select Option</option>
                                          
                                    </select>
                                </div>
                            </div> 
						<?php $h= explode(' ',$row->visit_datetime);
						      $date = $h[0]?$h[0]:'';
						      $time = $h[1]?$h[1]:'';
						
						?>
						   <div class="form-group row">
                                <label for="comp_rateperuser" class="col-xs-3 form-label"><?php echo "Date"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-5">
                                  <input type="date"  name="visit_date" id="visit_date" class="form-control" value="<?php echo $date;?>">
                                </div>
                               
                            </div>
						   <div class="form-group row">
                                <label for="comp_rateperuser" class="col-xs-3 form-label"><?php echo "Time"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-5" id="demo">
                                  <input type="text" id="timepicker-24-hr" name="timepicker-24-hr" class="timepicker-24-hr" value="<?php echo $time;?>">
                                </div>
                               
                            </div>
                            <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 form-label"><?php echo 'Status' ?>
                                <i class="text-danger"></i></label>
                                <div class="col-xs-5">
                                    <select name="visit_status" class="form-control">
                                        <option value="0" <?php if($row->visit_status==0) echo 'selected'; ?>>Active </option>
                                         <option value="1" <?php if($row->visit_status==1) echo 'selected'; ?>>In Active</option>
                                       
                                    </select>
                                </div>
                        	</div>

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
 <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->

<link rel="stylesheet" href="<?php echo base_url()?>assets/css/wickedpicker.min.css">

<!--<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>-->
<!-- Timepicker Js -->
<script src="<?php echo base_url()?>assets/js/wickedpicker.min.js"></script>

<script>
  $('.timepicker-24-hr').wickedpicker({twentyFour: true});
  $( function() {
    //$( "#datepicker" ).datepicker();
	  $("#datepicker").datepicker({ dateFormat: "yy-mm-dd" }).val()
  } );
$( document ).ready(function() {
	
	var company_id = $('#visit_company_id').val();
	var ctype = $('#visit_client_type').val();
	 $.ajax({ 
	   url: "<?php echo base_url('visit/getClients');?>",
	   method:"POST",
	   data:{cid: company_id, ctype: ctype},	 
	   success: function(data)  
	   {
		  
		$('#visit_client_id').html(data);
	   }   
	 });
	$.ajax({ 
		url: "<?php echo base_url('visit/getMemebrs');?>",
		method:"POST",
		data:{cid: company_id},	 
		success: function(data)  
		{
		
		$('#visit_member_id').html(data);
		}   
	});
 
});	
 
$('#visit_client_type').on('change',function(){
	
	var company_id = $('#visit_company_id').val();
	var ctype = $('#visit_client_type').val();
	 $.ajax({ 
	   url: "<?php echo base_url('visit/getClients');?>",
	   method:"POST",
	   data:{cid: company_id, ctype: ctype},	 
	   success: function(data)  
	   {
		  
		$('#visit_client_id').html(data);
	   }   
	 });
	$.ajax({ 
		url: "<?php echo base_url('visit/getMemebrs');?>",
		method:"POST",
		data:{cid: company_id},	 
		success: function(data)  
		{
		// alert(data);
		$('#visit_member_id').html(data);
		}   
	});
 
});	
$('#visit_client_id').on('change',function(){
	
	var company_id = $('#visit_company_id').val();
	var ctype = $('#visit_client_type').val();
	$.ajax({ 
		url: "<?php echo base_url('visit/getMemebrsByClientType');?>",
		method:"POST",
		data:{cid: company_id, ctype: ctype},	 
		success: function(data)  
		{
		 alert(data);
		$('#visit_member_id').html(data);
		}   
	});
 
});		
	
</script>

