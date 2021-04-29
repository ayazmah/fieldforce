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


?>
<link href="<?php echo base_url("assets/css/style.css") ?>" rel="stylesheet" type="text/css" media="screen" />
<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print">
                <div class="btn-group"> 
                    <a class="btn btn-primary" href="<?php echo base_url("region") ?>"> <i class="fa fa-list"></i>  <?php echo  $region_caption .' List'; ?> </a>  
                </div>
            </div> 

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php echo form_open_multipart('region/add/'.$row->re_id,'class="form-inner"') ?> 

                            <?php $user_id = $this->session->userdata('user_id'); 
	                            echo form_hidden('re_id',$row->re_id) ;
						    
					            //$zone_caption = $rlrows[2]->text_caption;
						   
	    
						    ?>

                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label"><?=$region_caption?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="re_name" type="text" class="form-control" id="re_name" placeholder="<?php echo $region_caption ." Name"?>" value="<?php echo $row->re_name ?>" required >
                                </div>
                            </div>
<!--
						   <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 col-form-label"><?php echo 'Country' ?>
                                <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <select name="re_ct_id" class="form-control">
										<?php 
										   $crows = $this->db->query('select * from countries')->result();
									       foreach($crows as $crow){
										 ?>
                                          <option value="<?php echo $crow->id;?>" <?php if($crow->id==$row->re_ct_id) echo 'selected'; ?>><?php echo $crow->name;?></option>
                                         <?php } ?>
                                    </select>
                                </div>
                        	</div>
-->
						    <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 col-form-label"><?php echo 'Company' ?>
                                <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <select name="re_us_id" class="form-control" required>
										<option value="">Select Option</option>
										<?php 
										 $urows = $this->db->query('select * from users where us_is_admin!=1 and us_status = 1 order by us_name')->result();
									     foreach($urows as $urow){
										 ?>
                                          <option value="<?php echo $urow->us_id;?>" <?php if($urow->us_id==$row->re_us_id) echo 'selected'; ?>><?php echo $urow->us_name;?></option>
                                         <?php } ?>
                                    </select>
                                </div>
                        	</div>
						
                            <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 col-form-label"><?php echo 'Status' ?>
                                <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <select name="re_status" class="form-control">
                                        <option value="1" <?php if($row->re_status==1) echo 'selected'; ?>>Active </option>
                                         <option value="0" <?php if($row->re_status==0) echo 'selected'; ?>>In Active</option>
                                       
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

