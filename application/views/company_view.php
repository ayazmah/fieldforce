   <div class="col-xs-12">
                    <div class="page-title">

                        <div class="pull-left">
                            <!-- PAGE HEADING TAG - START -->
                            <h1 class="title">Companies</h1>
                            <!-- PAGE HEADING TAG - END -->
                        </div>

                        <div class="pull-right hidden-xs">
                            <ol class="breadcrumb">
                                <li>
                                    <a href="<? echo base_url("dashboard/home")?>"><i class="fa fa-home"></i>Home</a>
                                </li>
                                <li class="active">
                                    <strong>Companies</strong>
                                </li>
                            </ol>
                        </div>

                    </div>
                </div>
                <div class="clearfix"></div>
                <!-- MAIN CONTENT AREA STARTS -->

                <div class="col-xs-12 ">                	
                    <div class=" bg-w">
                        <div class="col-lg-12">
                        	<div class="panel-heading1">
                                <div class="btn-group" style="margin-left:30px; margin-top:10px;">
                                    <a class="btn btn-success" href="<?php echo base_url("company/add") ?>"> <i class="fa "></i>  <?php echo "Add New" ?> </a>  
                                </div>
                            </div>
                            <section class="box ">
                                <header class="panel_header">
                                    
                                    <div class="actions panel_actions pull-right">
                                        <a class="box_toggle fa fa-chevron-down"></a>
                                        <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                        <a class="box_close fa fa-times"></a>
                                    </div>
                                </header>
                                <div class="content-body">
                                    <div class="row">
                                        <div class="col-xs-12">

                                            <!-- ********************************************** -->

                                            <table id="example" class="display table table-hover table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Per User Rate</th>
                                                        <th>Phone</th>
                                                        <th>Status</th>
                                                        <th>Created On</th>
                                                        <th>Actions</th>
                                                       
                                                    </tr>
                                                </thead>

                                                <tbody>
												<?php if(!empty($rows)) {
													  foreach($rows as $row){
													?>	
                                                    <tr id="<?php echo $row->comp_id;?>">
                                                        <td><?php echo $row->comp_name; ?></td>
                                                        <td><?php echo $row->comp_rateperuser; ?></td>
                                                        <td><?php echo $row->comp_phone; ?></td>
                                                        <td><?php echo $row->comp_status?'In Active':'Active'; ?></td>
                                                        <td><?php echo $row->comp_created_datetime; ?></td>
                                                        <td><a href="<?php echo base_url('company/add/'.$row->comp_id) ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></i></a> / <a class="btn btn-xs btn-danger" data-target="#cmpltadminModal-3" id="<?php echo $row->comp_id; ?>" data-toggle="modal" href="javascript:void(0)" ><i class="fa fa-trash"></i></a>
														
                                                    </tr>
												 <?php } 
                                                     }	
												  ?>	
												</tbody>	
                                            </table>
                                            <!-- ********************************************** -->

                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
 <!-- modal start -->

<div class="modal fade col-xs-12" id="cmpltadminModal-3" tabindex="-1" role="dialog" aria-hidden="true">
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

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<script>
	
function removeCompany(id){
     
	 $('#ajaxDelSucess').hide();
	 var deletePassword= $('#deletePassword').val();
	 
	if(id!=""){
		$.ajax({ 
		url: "<?php echo base_url('company/delete');?>",
		method:"POST",
		data: {cid: id,deletePassword: deletePassword},		
		dataType: "json",		
		success: function(res)  
   {
    
	  if(res == 0){
	   $('#delAjaxRespons').html("<p>You cannot delete root node<p>");
	  }else if(res == 2){
	   $('#delAjaxRespons').html("<p>Your password does not match<p>");  
	  }else{
	   $('#cmpltadminModal-3').modal('hide');
	   $('#ajaxDelSucess').show();
	   $('#'+id).hide();	  
	   
	  }
   }   
  });
} else {
	alert("no company selected");
}
	
   }		
	
$(document).ready(function() {
   	
   var id = ''; 	
   
   $('#cmpltadminModal-3').on('show.bs.modal', function(e) {
	$('#delAjaxRespons').html("");
    $('#deletePassword').val();
    $('#ajaxDelSucess').hide();	   
	$("#myForm").trigger("reset");  
    id = $(e.relatedTarget.id).selector;
	$('#btn_to_delete').on('click', function(){
	//alert(id);
	var deletePassword= $('#deletePassword').val();
		if($('#deletePassword').val() == '')
		{
			document.getElementById("deletePassword").style.borderColor = "red";
			$('#deleteMsg').show();
			return false;
		}else{

			document.getElementById("deletePassword").style.borderColor = "#adadad";
			$('#deleteMsg').hide();
			removeCompany(id);

		}	
		
	//window.location = '<?php echo base_url('company/delete/')?>'+id;	
    });	  
	  
  });
});
</script>	
  