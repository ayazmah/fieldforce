<script>
function isNumberKey(evt) 
          {
            var charCode = (evt.which) ? evt.which : event.keyCode
             if (((charCode > 47) && (charCode < 58 ) ) || (charCode == 8))
                   return true;

              return false;            
}
</script>
<?php
 $rlrows = $this->db->query('select * from user_roles where ur_status = 1 order by ur_order')->result();
 $region_caption = $rlrows[1]->text_caption;
 $zone_caption = $rlrows[2]->text_caption;

?>
<link href="<?php echo base_url("assets/css/style.css") ?>" rel="stylesheet" type="text/css" media="screen" />
<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print">
                <div class="btn-group"> 
                    <a class="btn btn-primary" href="<?php echo base_url("zone") ?>"> <i class="fa fa-list"></i>  <?php echo  $zone_caption .' List'; ?> </a>  
                </div>
            </div> 

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php echo form_open_multipart('zone/add/'.$row->zo_id,'class="form-inner"') ?> 

                            <?php $user_id = $this->session->userdata('user_id'); 
	                            echo form_hidden('zo_id',$row->zo_id);
						
						   
	    
						    ?>
                            <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 col-form-label"><?php echo $region_caption; ?>
                                <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <select name="zo_re_id" class="form-control" required>
										<option value="">Please Select <?=$region_caption?></option>
										<?php 
										   $rrows = $this->db->query('select * from regions where re_status = 1')->result();
									       foreach($rrows as $rrow){
										 ?>
                                          <option value="<?php echo $rrow->re_id;?>" <?php if($rrow->re_id==$row->zo_re_id) echo 'selected'; ?>><?php echo $rrow->re_name;?></option>
                                         <?php } ?>
                                    </select>
                                </div>
                        	</div>
                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label"><?php echo $zone_caption." Name"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="zo_name" type="text" class="form-control" id="zo_name" placeholder="<?php echo "Zone Name"?>" value="<?php echo $row->zo_name ?>" required >
                                </div>
                            </div>
						   
						    
						
                            <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 col-form-label"><?php echo 'Status' ?>
                                <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <select name="zo_status" class="form-control">
                                        <option value="1" <?php if($row->zo_status==1) echo 'selected'; ?>>Active </option>
                                         <option value="0" <?php if($row->zo_status==0) echo 'selected'; ?>>In Active</option>
                                       
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

