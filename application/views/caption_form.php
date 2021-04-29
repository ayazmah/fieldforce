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
 
            <div class="panel-heading no-print">
                <div class="btn-group"> 
                    <a class="btn btn-primary" href="<?php echo base_url("setting") ?>"> <i class="fa fa-list"></i>  <?php echo "Setting" ?> </a>  
                </div>
            </div> 

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php echo form_open_multipart('setting/actions/4','class="form-inner"') ?> 

                            <?php $user_id = $this->session->userdata('user_id'); 
	                            echo form_hidden('user_id',$row->us_id) ;
						
						    if($row->us_id > 0)
							 $readonly = 'readonly';
	                        else
	                         $readonly = '';
	                         $i = 1;
	  
	                        $rows = $this->db->query("select * from user_roles where ur_id not in(2,3) order by ur_order")->result();
	                        foreach($rows as $role){
								
						    ?>
                            <input type="hidden" name="id[]" value="<?php echo $role->ur_id;?>" />
                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label"><?php echo 'Level '.$i;?></label>
                                <div class="col-xs-3">
									
                                    <input name="us_name[]" type="text" class="form-control" id="us_name" placeholder="<?php echo $role->text_caption;?>" value="<?php echo $role->text_caption;?>" required >
                                </div>
                            </div>
						    <?php 
							$i++;
							} ?>
						    

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

