<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link href="<?php echo base_url("src/css/bootstrap-treeview.css") ?>" rel="stylesheet">

<!-- Required Javascript -->

<?php
$furl = base_url(uri_string());
$urlarray=explode("/",$furl);
$companyId=$urlarray[count($urlarray)-1];
//echo $logged_user	= $this->session->userdata('user_id');
//echo "<pre>";
//print_r($this->session->all_userdata());
//echo "</pre>";
	  
	
?>

<script src="<?php echo base_url("src/js/bootstrap-treeview.js") ?>"></script> 
<link href="<?php echo base_url("assets/css/style.css") ?>" rel="stylesheet" type="text/css" media="screen" />
<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
		
		
		
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print">
                <div class="btn-group"> 
                    <a class="btn btn-primary" href="<?php echo base_url("company") ?>"> <i class="fa fa-list"></i>  <?php echo "Companies List" ?> </a>  
                </div>
            </div> 
		 <div class="panel-body panel-form">	
			<div class="row">
				<div class="col-md-9 col-sm-12"  style="margin:20px 0 25px 0px;">
				<div class="form-group row" >
                            <label for="parent_subject" class="col-xs-2 form-label"><?php echo 'Select Company' ?>
                                </label>
                                <div class="col-xs-6">
                                    <select name="company_id" id="company_id" class="form-control">
                                       <?php 
										   $crows = $this->db->query('select * from companies where comp_status!=1')->result();
									       foreach($crows as $crow){
										 ?>
                                          <option value="<?php echo $crow->comp_id;?>" <?php if($companyId == $crow->comp_id) echo 'selected';?>><?php echo $crow->comp_name;?></option>
                                         <?php } ?>
                                       
                                    </select>
                                </div>
                        	</div>
				
				</div>
			</div>
			 
			 <div class="row">
				<div class="col-md-12 col-sm-12">
				<div class="form-group row">
                           <div class="col-xs-6">
                                    <div id="treeview"></div>
                                </div>
				           <div class="col-xs-6">
                             <div class="form-group row">
								 <label for="parent_subject" class="col-xs-2 form-label"><?php echo 'Name' ?></label>
                                <div class="col-xs-10">
                                    <input name="name" type="text" class="form-control" id="name" placeholder="<?php echo "Name"?>" value="<?php echo $row->us_password ?>" required >
									<br >
									<p><button class="ui positive button btn btn-primary" onClick="addNewNode()"><?php echo display('Add') ?></button></p>
                                </div>
                            </div>
							<div class="form-group row">
								 <label for="parent_subject" class="col-xs-2 form-label"><?php echo 'Line Manager' ?></label>
                                <div class="col-xs-10">
									 <input type="text" name="lineManager" id="lineManager" class="form-control" />
									<br >
									<p><button class="ui positive button btn btn-primary" onClick="sss()"><?php echo display('Add') ?></button></p>
                                </div>
                            </div>   
                        </div>	
                </div>
				
				
				</div>
			</div>
			 
			 <div class="row">
				<div class="col-md-12 col-sm-12">
				<div class="form-group row">
                    <div class="col-xs-9" style="float: left;">
									&nbsp;
                                </div>            
					<div class="col-xs-2" style="float: right;">
						<a class="ui positive button btn btn-primarydel" style="color: inherit; float: left;" data-target="#cmpltadminModal-2" id="<?php echo '11'; ?>" data-toggle="modal" href="javascript:void(0)">Rename</a>
						
						<a class="ui positive button btn btn-primarydel" style="background:red; color: white; float: left; margin-left:10px;" data-target="#cmpltadminModal-3" id="<?php echo '11'; ?>" data-toggle="modal" href="javascript:void(0)">Delete</a>
						
<!--
									<button class="ui positive button btn btn-primary" 
											style="background:red; float: left; margin-left:10px;"
											onClick="removeNode()"><?php echo display('Delete') ?></button>
-->
                                    
                                </div>
                        	</div>
				
				
				</div>
			</div>
		 </div>				
                

<!--
            
-->
        </div>
    </div>

</div>
<!-- modal start -->
	<div class="modal fade col-xs-12" id="cmpltadminModal-2" tabindex="-1" role="dialog" aria-hidden="true">
        <?php echo form_open_multipart('company/renameNode/','class="form-inner"') ?>                                  
	 	  <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Rename Actions</h4>
                                                    </div>
                                                    <div class="modal-body">
											<input type="hidden" name="renameSelectedId" id="renameSelectedId" />	
											
											<input type="hidden" name="companyId" id="companyId" />			

                           <div class="form-group row">
                                <label for="name" class="col-xs-2 form-label"><?php echo "Node"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-5">
                                    <input name="renameSelectedName" type="text" class="form-control" id="renameSelectedName" placeholder="Node Name"  required >
                                </div>
                            </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                                                        <button class="btn btn-warning" id="btn_to_check" type="submit"> Yes, Rename</button>
                                                    </div>
                                                </div>
                                            </div>
		<?php echo form_close();?>
  </div>
 <!-- modal end -->

<div class="modal fade col-xs-12" id="cmpltadminModal-4" tabindex="-1" role="dialog" aria-hidden="true">
                                         
	 	  <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Add Actions</h4>
                                                    </div>
                                                    <div class="modal-body">
														<h4>You can add only up to 5 level</h4>
													 </div>
                                                    <div class="modal-footer">
                                                        <button data-dismiss="modal" class="btn btn-default" type="button">OK</button>
                                                       
                                                    </div>
                                                </div>
                                            </div>
		
  </div>

<div class="modal fade col-xs-12" id="cmpltadminModal-3" tabindex="-1" role="dialog" aria-hidden="true">
        <?php // echo form_open_multipart('company/renameNode/','class="form-inner"') ?>                                  
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
									
                                    <input name="deletePassword" type="text" class="form-control" id="deletePassword" placeholder="Password"  required >
                                </div>
                            </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                                                        <button class="btn btn-warning" id="btn_to_delete" type="button"> Yes, Delete</button>
                                                    </div>
                                                </div>
                                            </div>
		<?php // echo form_close();?>
  </div>

<script>
	
	
$(document).ready(function(){
	
	var company_id = $('#company_id').val();
	//alert(company_id);
	
	//getParents(nodes)
	
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
	
 
});
function selectRootNode(id){
	if(id!="") {
	var  nodes  = $('#treeview').treeview('search', [ 'Pakistan', {
    ignoreCase: false,     // case insensitive
    exactMatch: true,    // like or equals
    revealResults: false,  // reveal matching nodes
    }]);
	var selectedNode= $('#treeview').treeview('selectNode', nodes);
	getRename();
		

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
   }   
 });
 
});	
	
function test(){
	//alert("test");
	var v= $('#treeview').treeview('getSelected');
	console.log(v);
	//$('#treeview').treeview('addNode', [ {text: "rizwan"}, v, { silent: true } ]);
}
	
function removeNode(){
     
	 $('#ajaxDelSucess').hide();
	 var deletePassword= $('#deletePassword').val();
	 var company_id= $('#company_id').val();
     var v= $('#treeview').treeview('getSelected');
	 
	if(v[0]['id']!=""){
		$.ajax({ 
		url: "<?php echo base_url('company/hierarchyDelete');?>",
		method:"POST",
		data: {cid: v[0]['id'],deletePassword: deletePassword},		
		dataType: "json",		
		success: function(res)  
   {
    
	  if(res == 0){
	   $('#delAjaxRespons').html("<p>You cannot delete root node<p>");
	  }else if(res == 2){
	   $('#delAjaxRespons').html("<p>Your password does not match<p>");  
	  }else{
	   $('#treeview').treeview('removeNode', [ v, { silent: true } ]);
	   $('#cmpltadminModal-3').modal('hide');
	   $('#ajaxDelSucess').show();	  
	   //setTimeout(function(){ selectRootNode(company_id); }, 1000);
	   selectRootNode(company_id);	  
	  }
   }   
  });
} else {
	alert("no node selected");
}
	
   }	
	
function addNewNode(){
	
//	alert("testing");
    
	var name = $('#name').val();
	
	var company_id = $('#company_id').val();
	var company_id = $('#company_id').val();
	
	var v= $('#treeview').treeview('getSelected');
	var cid;
	console.log(v.length);
	if(v.length > 0) {
	 cid = v[0]['id'];
		
	} else {
	  cid = 'root' ;	
	}
	console.log(cid);
	$('#name').val('');
	if(name!=""){
	 if(cid == 'root')
		cid =0;
//		alert("sss");
		
	$.ajax({ 
    url: "<?php echo base_url('company/hierarchyAdd');?>",
    method:"POST",
    data: {cid: cid,name: name,company_id: company_id},		
    dataType: "json",		
    success: function(res)  
   {
    // alert(id);
	if(res != 0){ 
	   
	$('#treeview').treeview('addNode', [ {text: name,id: res}, v, { silent: true } ]);
	if(cid == 0)
	{	
	
		var company_id = $('#company_id').val();
//	alert(company_id);
	
 $.ajax({ 
   url: "<?php echo base_url('company/hierarchyFetch');?>",
   method:"POST",
   data:{company_id: company_id},	 
   dataType: "json",       
   success: function(data)  
   {
	   if(data){
      $('#treeview').treeview({
	  data: data,         // data is not optional

  });
	   }
   }   
 });
	
	}
	} else {
	 $('#cmpltadminModal-4').modal('show');	
	//alert("you can only up to 5 levels");
		
	}
   }   
  });
} else {
	alert("enter name for location");
	document.getElementById("name").style.borderColor = "red"; 
	
	
}
}	
	

	
function getClickedNode(nodeType){
    $('#treeview').on('nodeSelected', function(event, node) {
    alert("pal");
	if(nodeType == 'new'){	
	$('#treeview').treeview('addNodeAfter', [ {text: "New"}, node, { silent: true } ]);	
	}
    });
   }
   $(document).ready(function() {
	//alert("ready");
    getClickedNode();
	   getRename();
   });		
function sss(){
	
	alert("this portion is dependent on members module we need to complete members module first to make this portion work");
	
}
function getRename(){
	
	var company_id = $('#company_id').val();
	var v= $('#treeview').treeview('getSelected');
	if(v.length > 0) {
	$('#renameSelectedId').val(v[0].id);
	$('#renameSelectedName').val(v[0].name);
	$('#companyId').val(company_id);	
	} else {
		
	$('#renameSelectedId').val('');
	$('#renameSelectedName').val('');
	$('#companyId').val(company_id);	
		
	}
	$('#treeview').on('nodeSelected', function(event, node) {
	var v= $('#treeview').treeview('getSelected');
	if(v.length > 0) {
	$('#renameSelectedId').val(v[0].id);
	$('#renameSelectedName').val(v[0].name);
	$('#companyId').val(company_id);	
	} else {
		
	$('#renameSelectedId').val('');
	$('#renameSelectedName').val('');
	$('#companyId').val(company_id);	
		
	}
	});
   }	
</script>


<script>
	

$(document).ready(function() {
	
	 getRename();
	
  $('#cmpltadminModal-2').on('show.bs.modal', function(e) {
	  
	  
	  
    
	$('#btn_to_check').on('click', function(){
		
	 $ ('#formRename').submit();	
		
    });	  
	  
  });
	
 $('#cmpltadminModal-3').on('show.bs.modal', function(e) {
	 
	 $('#delAjaxRespons').html("");
	 $('#deletePassword').val();
	 $('#ajaxDelSucess').hide();
    
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


		}	
		removeNode();
		
		
	// $ ('#formRename').submit();	
		
    });	  
	  
  });	
	
  $('#cmpltadminModal-4').on('show.bs.modal', function(e) {
	  
	  
	  
    
	$('#btn_to_check').on('click', function(){
		
	 //$ ('#formRename').submit();	
		
    });	  
	  
  });	
	
});
</script>