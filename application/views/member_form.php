<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">-->
<link href="<?php echo base_url("src/css/bootstrap-treeview.css") ?>" rel="stylesheet">
<script src="<?php echo base_url("src/js/bootstrap-treeview.js") ?>"></script> 
	
<div class="row">
    <!--  form area -->
	
	
    <div class="col-sm-12">

        <div class="panel panel-default thumbnail">

            <div class="panel-heading1">
                <div class="btn-group" style="margin-left:30px; margin-top:10px;"> 
                    <a class="btn btn-primary" href="<?php echo base_url("member") ?>"> <i class="fa fa-list"></i>  <?php echo "Members List" ?> </a> 
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
					<?php echo form_open_multipart('member/add/'.$member->id,'class="form-inner"') ?>

                            <?php echo form_hidden('id', $member->id); ?>
					<input type="hidden" name="emp_location_id" id="emp_location_id" >
                    <div class="col-xs-12">
						
                        
                        
                        <div class="row">
                            <div class="col-md-9 col-sm-12"  style="margin:20px 0 25px 0px;">
                            <div class="form-group row" >
                                        <label for="parent_subject" class="col-xs-2 form-label"><?php echo 'Select Company' ?>
                                            </label>
                                            <div class="col-xs-6">
                                                <select class="form-control" name="company_id" id="company_id"  required>
                                                <option value="">Select Option</option>
                                                <?php 
                                                     $urows = $this->db->query('select * from companies where comp_status != 1')->result();
                                                     foreach($urows as $urow){
                                                     ?>
                                                      <option value="<?php echo $urow->comp_id;?>" <?php if($urow->comp_id==$member->emp_company_id) echo 'selected'; ?>><?php echo $urow->comp_name;?></option>
                                                     <?php } ?>
                                                
                                            </select>
                                            </div>
                                        </div>
                            
                            </div>
						</div>
		
                            <div class="col-xs-4">
                                <label class="form-label" for="emp_name">Employee Name</label>
                                <i class="text-danger">*</i>
                                <div class="controls">
                                    <input type="text" name="emp_name" class="form-control" id="emp_name" required="required" value="<?php echo $member->emp_name; ?>">
                                </div>
                            </div>
						   <div class="col-xs-4">
                                <label class="form-label" for="emp_id">Employee Id</label>
                                <i class="text-danger">*</i>
                                <div class="controls">
                                    <input type="text" name="emp_id" class="form-control" id="emp_id" required="required" value="<?php echo $member->emp_id; ?>">
                                </div>
                            </div>
						    
                            <div class="col-xs-4">
                                <label class="form-label" for="email">Email Address</label>
                                <i class="text-danger">*</i>
                                <div class="controls">
                                    <input type="email" name="emp_email_address" required="required" class="form-control" id="email" value="<?php echo $member->emp_email_address; ?>" >
                                </div>
                            </div>
						
                            <div class="col-xs-4">
                                <label class="form-label" for="field-5">Designation</label>
                               <input type="text" name="emp_designation" class="form-control" id="emp_designation" value="<?php echo $member->emp_designation; ?>">
                               
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="mobile">Mobile Number</label>
                                <span class="desc"></span>
                                <div class="controls">
                                    <input type="text" name="emp_mobile" class="form-control" id="emp_mobile" value="<?php echo $member->emp_mobile; ?>">
                                </div>
                            </div>

                            
                            <div class="col-xs-4">
                                <label class="form-label" for="area"> Roles</label>
                                <i class="text-danger">*</i>
                                <select class="form-control" name="emp_role_id" id="emp_role_id" required>
                                    <option value="">Select Option</option>
									      <?php 
										 $rrows = $this->db->query('select * from user_roles where ur_status = 1')->result();
									     foreach($rrows as $rrow){
										 ?>
                                          <option value="<?php echo $rrow->ur_id;?>" <?php if($rrow->ur_id==$member->emp_role_id) echo 'selected'; ?>><?php echo $rrow->ur_name;?></option>
                                         <?php } ?>
									
									
                                </select>
                            </div>
                            
                            <div class="col-xs-4">
                                <label class="form-label" for="region"> Hierarchy</label>
                                <span class="desc"></span>
                                <div id="treeview"></div>
                            </div>
                            <!--<div class="col-xs-4">
                                <label class="form-label" for="line_manager">Image</label>
                                <span class="desc"></span>
                                <input type="text" name="emp_image_link" class="form-control" id="emp_image_link" value="<?php echo $member->emp_image_link; ?>">
                            </div>-->
                            <div class="col-xs-12 col-sm-9 col-md-8 padding-bottom-30" style="clear:both;">
                            <div class="text-left" style="margin-top:35px;">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn">Cancel</button>
                            </div>
                        </div>

                        <?php echo form_close() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function(){
	
	var company_id = $('#company_id').val();
	//alert(company_id);
	
	
 $.ajax({ 
   url: "<?php echo base_url('company/hierarchyFetch');?>",
   method:"POST",
   data:{company_id: company_id},	 
   dataType: "json",       
   success: function(data)  
   {
	   if(data){
      $('#treeview').treeview({
	  data: data         // data is not optional
     
      //backColor: 'green'

     });
    }
   }   
 });
	
 var company_id = $('#company_id').val();
 setTimeout(function(){ selectRootNode(company_id); }, 1000);	
 getNode();	
 
});	
function selectRootNode(id){
	if(id!="") {
	var  nodes  = $('#treeview').treeview('search', [ 'Pakistan', {
    ignoreCase: false,     // case insensitive
    exactMatch: true,    // like or equals
    revealResults: false,  // reveal matching nodes
    }]);
	var selectedNode= $('#treeview').treeview('selectNode', nodes);
	getNode();
		

	}
}	

$('#company_id').on('change',function(){
	
	var company_id = $('#company_id').val();
	//alert(company_id);
	
 $.ajax({ 
   url: "<?php echo base_url('company/hierarchyFetch');?>",
   method:"POST",
   data:{company_id: company_id},	 
   dataType: "json",       
   success: function(data)  
   {
	   
  $('#treeview').treeview({
	  data: data,         // data is not optional
      levels: 2,
      //backColor: 'green'

  });
selectRootNode();	   
   }   
 });
 
});	
function getNode(){
	
	var company_id = $('#company_id').val();
	var v= $('#treeview').treeview('getSelected');
	if(v.length > 0) {
	$('#emp_location_id').val(v[0].id);
	$('#companyId').val(company_id);	
	} else {
		
	$('#emp_location_id').val(v[0].id);
	$('#companyId').val(company_id);	
	}
	
	$('#treeview').on('nodeSelected', function(event, node) {
	var v= $('#treeview').treeview('getSelected');
	if(v.length > 0) {
	$('#emp_location_id').val(v[0].id);
	$('#companyId').val(company_id);	
	} else {
		
	$('#emp_location_id').val('');
	$('#companyId').val(company_id);	
		
	}
	});
   }		
	
//$(document).ready(function(){
//	
//	$('#company_id').on('change', function(){
//		
//        var company_id = $(this).val();
//		
//        if(company_id){
//            $.ajax({
//                type:'POST',
//                url:'<?php echo base_url('member/getRegions');?>',
//                data:'company_id='+company_id,
//				beforeSend: function() {
//                //$("#loaderDiv").show();
//                },
//                success:function(html){
//                    $('#region').html(html);
//					$('#loaderDiv').html('');
//                   
//                }
//            }); 
//        }else{
//            $('#area').html('<option value="">Select Company first</option>');
//            
//        }
//    });
//	
//    $('#region').on('change', function(){
//        var re_id = $(this).val();
//        if(re_id){
//            $.ajax({
//                type:'POST',
//                url:'<?php echo base_url('member/getZones');?>',
//                data:'re_id='+re_id,
//				beforeSend: function() {
//                //$("#loaderDiv").show();
//                },
//                success:function(html){
//                    $('#area').html(html);
//					$('#loaderDiv').html('');
//                   
//                }
//            }); 
//        }else{
//            $('#area').html('<option value="">Select Level 2</option>');
//            
//        }
//    });
//	
//	$('#designation').on('change', function(){
//        var role_id = $(this).val();
//		var company_id = $('#company_id').val();
//		if(role_id){
//            $.ajax({
//                type:'POST',
//                url:'<?php echo base_url('member/getLineManager');?>',
//                data:{'role_id':role_id,
//					  'cid':company_id},
//				beforeSend: function() {
//                //$("#loaderDiv").show();
//                },
//                success:function(html){
//                    $('#line_manager').html(html);
//					$('#loaderDiv').html('');
//                   
//                }
//            }); 
//        }else{
//            $('#area').html('<option value="">Select region first</option>');
//            
//        }
//    });
//	
//});	
	
function getClickedNode(){
	console.log("apa");
	//alert("apa");
    $('#treeview').on('nodeSelected', function(event, node) {
    alert("aoa");
	
    });
   }
   $(document).ready(function() {
	//alert("ready");
    getClickedNode();
	   //getRename();
   });			
	
	
</script>	



 