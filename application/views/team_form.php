<?php
$rlrows = $this->db->query('select * from user_roles where ur_status = 1 order by ur_order')->result();
$region_caption = $rlrows[1]->text_caption;
$zone_caption = $rlrows[2]->text_caption;
print_r($team);
?>
<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group"> 
                    <a class="btn btn-primary" href="<?php echo base_url("team") ?>"> <i class="fa fa-list"></i>  <?php echo "Teams List" ?> </a> 
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-xs-12">
                        <?php echo form_open_multipart('team/add/'.$team->id,'class="form-inner"') ?>

                            <?php echo form_hidden('id', $team->id) ?>

                            <div class="col-xs-4">
                                <label class="form-label" for="team_name">Team Name</label>
                                <span class="desc"></span>
                                <div class="controls">
                                    <input type="text" name="team_name" class="form-control" id="team_name" required="required" value="<?php echo $team->team_name; ?>">
                                </div>
                            </div>
<!--
                            <div class="col-xs-4">
                                <label class="form-label" for="team_id">Team Id</label>
                                <span class="desc"></span>
                                <div class="controls">
                                    <input type="text" name="team_id" required="required" class="form-control" id="team_id" value="<?php echo $team->team_id; ?>">
                                </div>
                            </div>

                            <div class="col-xs-4">
                                <label class="form-label" for="campaign_id">Campaign Name</label>
                                <span class="desc"></span>
                                <select class="form-control" name="campaign_id">
                                    <option></option>
                                    <option value="1">Campaign A</option>
                                    <option value="2">Campaign B</option>
                                </select>
                            </div>-->
						   <div class="col-xs-4">
                                <label class="form-label" for="field-5">Company/Organization</label>
                                <span class="desc"></span>
                                <select class="form-control" name="company_id" id="company_id" required>
									<option value="">Select Option</option>
                                 	<?php 
										 $urows = $this->db->query('select * from users where us_is_admin!=1 and us_status = 1 order by us_name')->result();
									     foreach($urows as $urow){
										 ?>
                                          <option value="<?php echo $urow->us_id;?>" <?php if($urow->us_id==$team->company_id) echo 'selected'; ?>><?php echo $urow->us_name;?></option>
                                         <?php } ?>
									
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="region_id"><?=$region_caption?></label>
                                <span class="desc"></span>
                                <select class="form-control" name="region_id" id="region_id">
                                   <option value="">Select Option</option>
                                        <?php 
										 $rrows = $this->db->query('select * from regions where re_status = 1')->result();
									     foreach($rrows as $rrow){
										 ?>
                                    <option value="<?php echo $rrow->re_id;?>" <?php if($rrow->re_id==$team->mobile_number) echo 'selected'; ?>><?php echo $rrow->re_name;?></option>
                                         <?php } ?>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="area_id"><?=$zone_caption?></label>
                                <span class="desc"></span>
                                 <select class="form-control" name="area_id" id="area_id" required>
                                    <option value="">Select Area</option>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="geofence_id">Geofence</label>
                                <span class="desc"></span>
                                <div class="controls">
                                    <input type="text" name="geofence_id" class="form-control" id="geofence_id" value="<?php echo $team->geofence_id; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="regional_manager_id"><?=$region_caption?> Manager</label>
                                <span class="desc"></span>
                                <select class="form-control" name="regional_manager_id" id="regional_manager_id">
                                    <option value=""> Select Option</option>
									<?php 
										 $mrows = $this->db->query('select * from members where designation=5 and  status = 1 ')->result();
									     foreach($mrows as $mrow){
										 ?>
                                    <option value="<?php echo $mrow->id;?>" <?php if($mrow->id==$team->regional_manager_id) echo 'selected'; ?>><?php echo $mrow->emp_name;?></option>
                                         <?php } ?>
									
									
                                    
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="area_manager_id">Area Manager</label>
                                <span class="desc"></span>
                                <select class="form-control" name="area_manager_id" id="area_manager_id">
                                    <option value=""> Select Zonal Manager</option>
                                    
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="teamlead_id">Team Lead</label>
                                <span class="desc"></span>
                                <select class="form-control" name="teamlead_id" id="teamlead_id">
                                    <option value=""> Select Team Lead</option>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="assigned_members">Assign Member(s)</label>
                                <span class="desc"></span>
                                <select class="form-control" name="assigned_members" id="assigned_members">
                                    <option></option>
                                    <option value="1">Member A</option>
                                    <option value="2">Member B</option>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="assigned_products">Assign Product(s)</label>
                                <span class="desc"></span>
                                <select class="form-control" name="assigned_products" id="assigned_products">
                                    <option></option>
                                    <option value="1">Product A</option>
                                    <option value="2">Product B</option>
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-9 col-md-8 padding-bottom-30">
                            <div class="text-left" style="margin-top:35px;">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn" onClick="w">Cancel</button>
                            </div>
                        </div>

                        <?php echo form_close() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	
	
	$('#company_id').on('change', function(){
		
        var company_id = $(this).val();
		
        if(company_id){
            $.ajax({
                type:'POST',
                url:'<?php echo base_url('member/getRegions');?>',
                data:'company_id='+company_id,
				beforeSend: function() {
                //$("#loaderDiv").show();
                },
                success:function(html){
                    $('#region_id').html(html);
					$('#loaderDiv').html('');
                   
                }
            }); 
        }else{
            $('#area').html('<option value="">Select Company first</option>');
            
        }
    });
	
	$('#company_id').on('change', function(){
		
        var company_id = $(this).val();
		
        if(company_id){
            $.ajax({
                type:'POST',
                url:'<?php echo base_url('member/getMembers');?>',
                data:'company_id='+company_id,
				beforeSend: function() {
                //$("#loaderDiv").show();
                },
                success:function(html){
                    $('#assigned_members').html(html);
					$('#loaderDiv').html('');
                   
                }
            }); 
        }else{
            $('#area').html('<option value="">Select Company first</option>');
            
        }
    });
	
    $('#region_id').on('change', function(){
		console.log("apa");
        var re_id = $(this).val();
        if(re_id){
            $.ajax({
                type:'POST',
                url:'<?php echo base_url('member/getZones');?>',
                data:'re_id='+re_id,
				beforeSend: function() {
                //$("#loaderDiv").show();
                },
                success:function(html){
                    $('#area_id').html(html);
					$('#loaderDiv').html('');
                   
                }
            }); 
        }else{
            $('#area_id').html('<option value="">Select region first</option>');
            
        }
    });
/////////////////////////////////////
	
	$('#region_id').on('change', function(){
		console.log("apa");
        var re_id = $(this).val();
        if(re_id){
            $.ajax({
                type:'POST',
                url:'<?php echo base_url('member/getRegionalManagers');?>',
                data:'re_id='+re_id,
				beforeSend: function() {
                //$("#loaderDiv").show();
                },
                success:function(html){
                    $('#regional_manager_id').html(html);
					//$('#loaderDiv').html('');
                   
                }
            }); 
        }else{
            $('#regional_manager_id').html('<option value="">Select region first</option>');
            
        }
    });
/////////////////////////////////////////
	$('#region_id').on('change', function(){
		console.log("apa");
        var re_id = $(this).val();
        if(re_id){
            $.ajax({
                type:'POST',
                url:'<?php echo base_url('member/getZonalManagers');?>',
                data:'re_id='+re_id,
				beforeSend: function() {
                //$("#loaderDiv").show();
                },
                success:function(html){
                    $('#area_manager_id').html(html);
					//$('#loaderDiv').html('');
                   
                }
            }); 
        }else{
            $('#area_manager_id').html('<option value="">Select region first</option>');
            
        }
    });
/////////////////////////////////////////
	$('#region_id').on('change', function(){
		console.log("apa");
        var re_id = $(this).val();
        if(re_id){
            $.ajax({
                type:'POST',
                url:'<?php echo base_url('member/getTeamLeads');?>',
                data:'re_id='+re_id,
				beforeSend: function() {
                //$("#loaderDiv").show();
                },
                success:function(html){
                    $('#teamlead_id').html(html);
					//$('#loaderDiv').html('');
                   
                }
            }); 
        }else{
            $('#teamlead_id').html('<option value="">Select region first</option>');
            
        }
    });
		
	
	
});	
	
	
	
	
</script>		
 