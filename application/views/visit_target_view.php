<?

?>
<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("visit/target") ?>"> <i class="fa fa-plus"></i>  <?php echo "Add Visit" ?> </a>  
                </div>
            </div>

            <div class="panel-body">
                <table class="display table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo 'SR #.' ?></th>
                            <th><?php echo 'Employee'; ?></th>
                            <th><?php echo  'Compnay' ?></th>
							<th><?php echo  'Month' ?></th>
                            <th><?php echo "Planned" ?></th>
                            <th><?php echo "Completed" ?></th>
							<th><?php echo "Revenue" ?></th>
                            <th><?php echo "Action" ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($visits)) {
	                          

						?>
                            <?php $sl = 1; ?>
                            <?php foreach ($visits as $visit) { 
							  
							
							 $month = date("F", strtotime($visit->vt_month));
							
							
								
							
							  $vprows = $this->db->query("SELECT visit_id FROM visit_planner WHERE YEAR(visit_datetime) = YEAR($visit->vt_month) AND MONTH(visit_datetime) = MONTH($visit->vt_month) and visit_member_id =$visit->vt_emp_id and visit_company_id = $visit->vt_comp_id")->result();
							
//					          $role = $this->db->query('select ur_name from user_roles where ur_id ='.$mem->emp_role_id)->row();
	                          $mrow = $this->db->query('select emp_name from members where id ='.$visit->vt_emp_id)->row();
                              $crow = $this->db->query('select comp_name from companies where comp_id  ='.$visit->vt_comp_id)->row();
							  $sum = $visit->vt_whole_seller_target + $visit->vt_phamacy_target +$visit->vt_whole_seller_target + $visit->vt_doctor_target;
	                           ?>
                               <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>" id="<?php echo $visit->vt_id ; ?>">
                                    <td><?php echo $sl; ?></td>
								    <td><?php echo $mrow->emp_name; ?></td>
									<td><?php echo $crow->comp_name; ?></td>
                                   <td><?php echo $month; ?></td> 
								   <td><?php echo $sum; ?></td>
                                    <td><?php echo count($vprows); ?></td> 
                                    <td><?php echo $visit->vt_revnue_target; ?></td> 
                                    
									<td class="center" width="80">                                         
                                        <a href="<?php echo base_url("visit/target/$visit->vt_id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a> <a class="del" style="color: inherit;" data-target="#cmpltadminModal-2" id="<?php echo $visit->vt_id; ?>" data-toggle="modal" href="javascript:void(0)"><i class="fa fa-trash" aria-hidden="true"></i></a>                                        
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
		url: "<?php echo base_url('visit/deleteTarget');?>",
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
	//window.location = '<?php echo base_url('member/deleteTarget/')?>'+id;	
    });	  
	  
  });
});
</script>	