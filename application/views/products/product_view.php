<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading1">
                <div class="btn-group" style="margin-left:30px; margin-top:10px;">
                    <a class="btn btn-success" href="<?php echo base_url("products/product/product_form") ?>"> <i class="fa fa-plus"></i>  <?php echo "Add Product" ?> </a>  
                </div>
            </div>

            <div class="panel-body">
                <?php echo form_open('products/product/products_list') ?>
                <div class="row">
                    <div class="col-12 col-md-12 " align="center">
                        <div class="col-4 col-md-4">
                            <p><input id="product_name" type="text" style="min-width: 110px;" class="form-control" name="product_name"
                                      placeholder="Product Name"
                                      value="<?php if ($this->session->userdata('search_product') != null) {
                                          echo $this->session->userdata('search_product')['product_name'];
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
                            <th><?php echo "Sr#." ?></th>
                            <th><?php echo "Company Name" ?></th>
                            <th><?php echo "Product Name" ?></th>
                            <th><?php echo "Generic Name" ?></th>
                            <th><?php echo "Brand Name" ?></th>
                            <th><?php echo "Dosage Form" ?></th>
                            <th><?php echo "Dosage" ?></th> 
                            <th><?php echo "Action" ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($products as $prod) { 
							$comp_datail = $this->db->select('comp_name')->from('companies')->where('comp_id', $prod->product_company_id)->limit(1)->get()->row();
							$dosage_form = $this->db->select('df_name')->from('dosage_form')->where('df_id', $prod->product_dosage_form)->order_by('df_id', "desc")->limit(1)->get()->row();
							$dosage = $this->db->select('dosage_name')->from('dosage')->where('dosage_id', $prod->product_dosage)->order_by('dosage_id', "desc")->limit(1)->get()->row();?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>" id="<?php echo $prod->id;?>">
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $comp_datail->comp_name; ?></td>
                                    <td><?php echo $prod->product_name; ?></td>
                                    <td><?php echo $prod->product_generic_name; ?></td> 
                                    <td><?php echo $prod->product_brand_name; ?></td> 
                                    <td><?php echo $dosage_form->df_name; ?></td> 
                                    <td><?php echo $dosage->dosage_name; ?></td>
                                    <td class="center">                                         
                                        <a href="<?php echo base_url("products/product/product_form/$prod->id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
										<a class="btn btn-xs btn-danger" data-target="#cmpltadminModal-2" id="<?php echo $prod->id; ?>" data-toggle="modal" href="javascript:void()"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
		url: "<?php echo base_url('products/product/delete');?>",
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
	   $('#cmpltadminModal-2').modal('hide');
	   $('#ajaxDelSucess').show();
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
	//window.location = '<?php echo base_url('member/delete/')?>'+id;	
    });	  
	  
  });
  $("body").on("click", ".reset", function() {
	   $('#product_name').val('');
	   <?php $this->session->unset_userdata('search_product');?>
	  window.location='<?php base_url('products/product/products_list')?>';
  });
});
</script>	
 
 