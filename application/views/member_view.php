<?php
$rlrows = $this->db->query('select * from user_roles where ur_status = 1')->result();
//echo random();
//$ac = getCategoryTreeIDs(32);
//print_r($ac);
//die;
?>
<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading1">
                <div class="btn-group" style="margin-left:30px; margin-top:10px;">
                    <a class="btn btn-success" href="<?php echo base_url("member/add") ?>"> <i class="fa fa-plus"></i>  <?php echo "Add Member" ?> </a>  
                </div>
            </div>

            <div class="panel-body">
             <?php echo form_open('member/view') ?>
                <div class="row">
                    <div class="col-12 col-md-12 " align="center">
                        <div class="col-4 col-md-4">
                            <p><input id="emp_name" type="text" style="min-width: 110px;" class="form-control" name="emp_name"
                                      placeholder="Employee Name"
                                      value="<?php if ($this->session->userdata('search_member') != null) {
                                          echo $this->session->userdata('search_member')['emp_name'];
                                      } ?>"></p>                            

                        </div>
                        <div class="col-xs-3">
                            <select name="company_id" id="company_id" class="form-control">
                                  <option>--Select company--</option>
                               <?php 
                                   $crows = $this->db->query('select * from companies where comp_status!=1 AND comp_is_deleted!=1')->result();
                                   foreach($crows as $crow){
                                 ?>
                                  <option value="<?php echo $crow->comp_id;?>" ><?php echo $crow->comp_name;?></option>
                                 <?php } ?>
                               
                            </select>
                        </div>
                        <div class="col-4" style="float:left;">                            
                            <p class="btn-group"><input type="submit" name="submit" value="Search" class="btn btn-success"></p>
                            <p class="btn-group"><input type="button" name="reset" value="Reset" class="btn btn-success reset"></p>
                        </div>
                        <div class="col-4 col-md-4">
                        </div>

                    </div>
                    <div class="col-3 col-md-3"></div>
                    <!--end of col-->
                </div>
                <?php echo form_close() ?>
                <hr>
                <table class="display table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo 'Sr#.' ?></th>
                            <th><?php echo 'Employee Name'; ?></th>
                            <th><?php echo  'Role' ?></th>                            
                            <th><?php echo "Company" ?></th>
                            <th><?php echo "Designation" ?></th>
                            <th><?php echo "Hierarchy" ?></th> 
                            <th><?php echo "Action" ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($members)) {
	                          

						?>
                            <?php $sl = 1; ?>
                            <?php foreach ($members as $mem) { 
							
							
					          $role = $this->db->query('select ur_name from user_roles where ur_id ='.$mem->emp_role_id)->row();
	                          //$group = $this->db->query('select group_name from groups where id ='.$mem->emp_group_id)->row();
                              $company = $this->db->query('select comp_name from companies where comp_id  ='.$mem->emp_company_id)->row();	
	                          
	                          $idsArray = getCategoryTreeIDs($mem->emp_location_id);
							
							  if(!empty($idsArray)){
								  $h = '';
							   foreach($idsArray as $id){
									$name = getCategoryTitle($id);
									if(end($idsArray) == $id)
									$slash ='';
									else
									$slash = ' /';	
								    $h .=$name.$slash;
                                } 
						      }
						       ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>" id="<?php echo $mem->id; ?>">
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $mem->emp_name; ?></td>
                                    <td><?php echo $role->ur_name; ?></td>
                                    <td><?php echo $company->comp_name; ?></td> 
                                    <td><?php echo $mem->emp_designation; ?></td> 
									<td><?php echo $h; ?></td> 
                                    <td class="center">                                         
                                        <a href="<?php echo base_url("member/add/$mem->id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a> <a class="del btn btn-xs btn-danger" data-target="#cmpltadminModal-2" id="<?php echo $mem->id; ?>" data-toggle="modal" href="javascript:void(0)"><i class="fa fa-trash" aria-hidden="true"></i></a>                                        
                                    </td>
                                </tr>
                                <?php $sl++; ?>
                            <?php } ?> 
                        <?php } ?> 
                    </tbody>
                </table>  <!-- /.table-responsive -->
                <div class="text-right"><?php echo $links ?></div>
            </div>
        </div>
    </div>
</div>
<!-- modal start -->
	<div class="modal fade col-xs-12" id="cmpltadminModal-2" tabindex="-1" role="dialog" aria-hidden="true">
		<form id="myForm" method="post">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Delete Actions</h4>
                                                    </div>
                                                    <div class="modal-body">
														<h4 style="margin: 0px; padding: 0px;">Are you sure to delete this ?</h4>
														<div id="delAjaxRespons" style="color: red;"></div>
														<p>&nbsp;</p>
														<span id="deleteMsg" style=" display: none; color: red;">Please Enter Password</span>
											<input type="hidden" name="renameSelectedId" id="renameSelectedId" />	
											
											<input type="hidden" name="companyId" id="companyId" />			
                           <br clear="all" />
                           <div class="form-group row">
                                <label for="name" class="col-xs-3 form-label"><?php echo "Password"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-5">
									
                                    <input name="deletePassword" type="password" class="form-control" id="deletePassword" placeholder="Password"  required >
                                </div>
                            </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                                                        <button class="btn btn-warning" id="btn_to_delete" type="button"> Yes, Delete</button>
                                                    </div>
                                                </div>
                                            </div>
		</form>
  </div>
 <!-- modal end -->
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
 <script>
function removeEntity(id){
     
	 $('#ajaxDelSucess').hide();
	 var deletePassword= $('#deletePassword').val();
	 
	if(id!=""){
		$.ajax({ 
		url: "<?php echo base_url('member/delete');?>",
		method:"POST",
		data: {cid: id,deletePassword: deletePassword},		
		dataType: "json",		
		success: function(res)  
   {
       console.log(id);
	  if(res == 0){
	   $('#delAjaxRespons').html("<p>You cannot delete root node<p>");
	  }else if(res == 2){
	   $('#delAjaxRespons').html("<p>Your password does not match<p>");  
	  }else{
	   $('#cmpltadminModal-2').modal('hide');
	   $('#ajaxDelSucess').show();	  
	   $('#'+id).hide();
	    
	   
	  }
   }   
  });
} else {
	alert("no member selected");
}
	
}	 
$(document).ready(function() {

$("body").on("click", ".reset", function() {
	   $('#emp_name').val('');
	   <?php $this->session->unset_userdata('search_member');?>
	  window.location='<?php base_url('member/view')?>';
  });	
  $('#cmpltadminModal-2').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget.id).selector;
	$('#btn_to_delete').on('click', function(){
	
	var deletePassword= $('#deletePassword').val();
		if($('#deletePassword').val() == '')
		{
			document.getElementById("deletePassword").style.borderColor = "red";
			$('#deleteMsg').show();
			return false;
		}else{

			document.getElementById("deletePassword").style.borderColor = "#adadad";
			$('#deleteMsg').hide();
			removeEntity(id);

		}		
	//window.location = '<?php echo base_url('member/delete/')?>'+id;	
    });	  
	  
  });
});
</script>	