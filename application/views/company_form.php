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

$session = $this->session->userdata('dataArr');

$comp_name = $session['comp_name']?$session['comp_name']:$row->comp_name;
$comp_address = $session['comp_address']?$session['comp_address']:$row->comp_address;
$comp_country_id = $session['comp_country_id']?$session['comp_country_id']:$row->comp_country_id;
$comp_phone = $session['comp_phone']?$session['comp_phone']:$row->comp_phone;
$comp_description = $session['comp_description']?$session['comp_description']:$row->comp_description;
$comp_rateperuser = $session['comp_rateperuser']?$session['comp_rateperuser']:$row->comp_rateperuser;
$comp_ratepermanager = $session['comp_ratepermanager']?$session['comp_ratepermanager']:$row->comp_ratepermanager;
$comp_discount = $session['comp_discount']?$session['comp_discount']:$row->comp_discount;


//die;

?>

<link href="<?php echo base_url("assets/css/style.css") ?>" rel="stylesheet" type="text/css" media="screen" />
<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading1">
                <div class="btn-group" style="margin-left:10px; margin-top:10px;"> 
                    <a class="btn btn-primary" href="<?php echo base_url("company") ?>"> <i class="fa fa-list"></i>  <?php echo "Companies List" ?> </a>  
                </div>
            </div> 

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php echo form_open_multipart('company/add/'.$row->comp_id,'class="form-inner"') ?> 

                            <?php $user_id = $this->session->userdata('user_id'); 
	                            echo form_hidden('user_id',$row->us_id) ;
								echo form_hidden('comp_id',$row->comp_id) ;
						    if($row->us_id > 0)
							 $readonly = 'readonly';
	                        else
	                         $readonly = '';
	    
						    ?>

                            <div class="form-group row">
                                <label for="name" class="col-xs-3 form-label"><?php echo "Name"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-5">
                                    <input name="comp_name" type="text" class="form-control" id="comp_name" placeholder="<?php echo "Name"?>" value="<?php echo $comp_name ?>" required >
                                </div>
                            </div>
						    <div class="form-group row">
                                <label for="name" class="col-xs-3 form-label"><?php echo "Address"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-5">
                                    <textarea name="comp_address" class="tinymce form-control" placeholder="Address" id="comp_address" maxlength="140" rows="4"><?php echo $row->comp_address ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 form-label"><?php echo 'Country' ?>
                                <i class="text-danger">*</i></label>
                                <div class="col-xs-5">
                                    <select name="comp_country_id" class="form-control">
                                       <?php 
										   $crows = $this->db->query('select * from countries where status=1')->result();
									       foreach($crows as $crow){
										 ?>
                                          <option value="<?php echo $crow->id;?>" <?php if($crow->id==$row->comp_country_id) echo 'selected'; ?>><?php echo $crow->name;?></option>
                                         <?php } ?>
                                       
                                    </select>
                                </div>
                        	</div>
                            <div class="form-group row">
                                <label class="col-xs-3 form-label" for="dr_city">City<i class="text-danger">*</i></label>
                                <div class="col-xs-5">
                                <select name="comp_city_id" class="form-control" >
                                <option></option>
								<? $crows = $this->db->query("select * from cities order by city_name asc")->result();
								foreach($crows as $crow):
								?>
								<option value="<?php echo $crow->city_id;?>" <? if($row->comp_city_id==$crow->city_id) echo "selected";?>><?php echo $crow->city_name;?></option>
								<? endforeach;?>
								</select>
                                </div>
                            </div>
						    <div class="form-group row">
                                <label for="name" class="col-xs-3 form-label"><?php echo "Phone"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-5">
                                    <input name="comp_phone" type="text" class="form-control" id="comp_phone" placeholder="<?php echo "Phone"?>" value="<?php echo $comp_phone ?>" required >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comp_description" class="col-xs-3 form-label"><?php echo "Description"; ?></label>
                                <div class="col-xs-5">
                                    <textarea name="comp_description" class="tinymce form-control" placeholder="Description" id="comp_description" maxlength="140" rows="4"><?php echo $comp_description ?></textarea>
                                </div>
                            </div> 
						   <?php /*?><div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label"><?php echo "Company Email"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="us_email" type="email" class="form-control" id="us_email" placeholder="<?php echo "Company Email"?>" <?php echo $readonly;?> value="<?php echo $row->us_email ?>" required >
                                </div>
                            </div>
						    <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label"><?php echo "Company Password"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="us_password" type="password" class="form-control" id="us_password" placeholder="<?php echo "Company Password"?>" value="<?php echo $row->us_password ?>" required >
                                </div>
                            </div><?php */?>
                            
                            <div class="form-group row" style="margin:30px 0 30px 0px;">
                                <label for="comp_rateperuser" class="form-label"><b><u><?php echo "Subscription Setup"?></u></b> <i class="text-danger"></i></label>
                                
                            </div>
                            
                            <div class="form-group row">
                                <label for="comp_rateperuser" class="col-xs-3 form-label"><?php echo "Rate Per User/Month"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-5">
                                    <input name="comp_rateperuser" type="text" class="form-control" id="comp_rateperuser" placeholder="<?php echo "Rate Per User/Month"?>" value="<?php echo $comp_rateperuser; ?>" required >
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="comp_ratepermanager" class="col-xs-3 form-label"><?php echo "Rate Per Manager/Month"?> <i class="text-danger">*</i></label>
                                <div class="col-xs-5">
                                    <input name="comp_ratepermanager" type="text" class="form-control" id="comp_ratepermanager" placeholder="<?php echo "Rate Per Manager/Month"?>" value="<?php echo $comp_ratepermanager; ?>" required >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comp_discount" class="col-xs-3 form-label"><?php echo "Discount(%)"?> <i class="text-danger"></i></label>
                                <div class="col-xs-5">
                                    <input name="comp_discount" type="text" class="form-control" id="comp_discount" placeholder="<?php echo "Discount(%)"?>" value="<?php echo $comp_discount; ?>" >
                                </div>
                            </div>
                            <div class="form-group row">
                            <label for="parent_subject" class="col-xs-3 form-label"><?php echo 'Status' ?>
                                <i class="text-danger"></i></label>
                                <div class="col-xs-5">
                                    <select name="comp_status" class="form-control">
                                        <option value="0" <?php if($comp_status==0) echo 'selected'; ?>>Active </option>
                                         <option value="1" <?php if($comp_status==1) echo 'selected'; ?>>In Active</option>
                                    </select>
                                </div>
                        	</div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="btn btn-primary"><?php echo display('cancel') ?></button>
                                        
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

