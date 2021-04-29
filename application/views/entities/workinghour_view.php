<div class="row"> 
  <!--  table area -->
  <div class="col-sm-12">
    <div class="panel panel-default thumbnail">
      <div class="panel-heading1">
        <div class="btn-group" style="margin-left:30px; margin-top:10px;"> <a class="btn btn-success" href="<?php echo base_url("entities/workinghour/workinghour_form") ?>"> <i class="fa "></i> <?php echo "Add New" ?> </a> </div>
      </div>
      <div class="panel-body"> <?php echo form_open('entities/workinghour/workinghour_list') ?>
        <div class="row">
          <div class="col-12 col-md-12 " align="center">
            <div class="col-4 col-md-4">
              <p>
                <input id="wh_name" type="text" style="min-width: 110px;" class="form-control" name="wh_name"
                                      placeholder="Working Hour Name"
                                      value="<?php //if ($this->session->userdata('search_dosageform') != null) {
                                         // echo $this->session->userdata('search_dosageform')['dosageform_name'];
                                      //} ?>">
              </p>
            </div>
            <div class="col-4" style="float:left;">
              <p class="btn-group">
                <input type="submit" name="submit" value="Search" class="btn btn-success">
              </p>
            </div>
            <div class="col-4 col-md-4"> </div>
          </div>
          <div class="col-3 col-md-3"></div>
          <!--end of col--> 
        </div>
        <?php echo form_close() ?>
        <hr>
        <table class="display table table-hover table-condensed" style="width:50%">
          <thead>
            <tr>
              <th><?php echo "Sr#." ?></th>
              <th><?php echo "Working Hour Name" ?></th>
              <th><?php echo "Action" ?></th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($workinghours)) { ?>
            <?php $sl = 1; ?>
            <?php foreach ($workinghours as $wh) { ?>
            <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
              <td><?php echo $sl; ?></td>
              <td><?php echo $wh->wh_name; ?></td>
              <td class="center"><a href="<?php echo base_url("entities/workinghour/workinghour_form/$wh->wh_id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a> <a  data-target="#cmpltadminModal-2" id="<?php echo $wh->wh_id; ?>" data-toggle="modal" href="javascript:void()" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td>
            </tr>
            <?php $sl++; ?>
            <?php } ?>
            <?php } ?>
          </tbody>
        </table>
        <!-- /.table-responsive -->
        <div class="text-right"><?php echo $links ?></div>
      </div>
    </div>
  </div>
</div>
<!-- modal start -->
<div class="modal fade col-xs-12" id="cmpltadminModal-2" tabindex="-1" role="dialog" aria-hidden="true">
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
<!-- modal end --> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<script>
$(document).ready(function() {
	
  $('#cmpltadminModal-2').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget.id).selector;
	$('#btn_to_check').on('click', function(){
	//alert(id);
	window.location = '<?php echo base_url('entities/workinghour/delete/')?>'+id;	
    });	  
	  
  });
});
</script> 
