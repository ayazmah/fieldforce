<style>
          /*html,* { font-family: 'Inter'; }
body { background-color: #fafafa; line-height:1.2;}
.lead { font-size: 12px; font-weight: normal; }*/
.container { margin: 150px auto; max-width: 960px; }
            .dropdown-advanced,.dropdown-advanced1 {
                display: block;
                margin: 0 auto;
            }
            .dropdown-advanced ul,.dropdown-advanced1 ul {
                padding: 0px;
                margin: 0;
            }
            .dropdown-advanced .container-elements.closed,.dropdown-advanced1 .container-elements1.closed {
                display: none;
            }
            .dropdown-advanced .container-buttons.closed,.dropdown-advanced1 .container-buttons1.closed {
                display: none;
            }
            .dropdown-advanced button,.dropdown-advanced1 button {
                margin: 5px auto;
                padding: 5px;
                cursor: pointer;
            }
            .dropdown-advanced button.cancel {

            }
            .dropdown-advanced button.accept {

            }
            .dropdown-advanced label ,.dropdown-advanced1 label{
                cursor: pointer;
				font-weight:normal !important;
            }
            .dropdown-advanced li ,.dropdown-advanced1 li {
                list-style: none;
                padding: 0px;
                padding: 5px;
                margin: 0;
            }
            .dropdown-advanced .select-all-option-container,.dropdown-advanced1 .select-all-option-container1 {
                /*font-weight: bold;
                text-align: center;
                width: 100%;
                display: block;*/
            }
            .dropdown-advanced li:nth-child(even),.dropdown-advanced1 li:nth-child(even) {
                background-color: #e1e1e1;
                
            }
            .dropdown-advanced li:nth-child(odd),.dropdown-advanced1 li:nth-child(odd) {
                background-color: #fff;
                
            }
            .dropdown-advanced .opened , .dropdown-advanced1 .opened{
                border: 1px solid #e1e1e1;
            }
            .dropdown-advanced .options-selected ,.dropdown-advanced1 .options-selected1 {
                padding: 7px;
                border: 1px solid #e1e1e1;
                cursor: pointer;
            }
            .options-selected span {
                font-size: 12px;
            }
            .dropdown-advanced .search-button,.dropdown-advanced1 .search-button1 {
                width: 100%;
                padding: 5px;
                border: 1px solid #e1e1e1;
            }
            .dropdown-advanced .order-option ,.dropdown-advanced1 .order-option1{
                padding: 5px;
                border-bottom: 1px solid #e1e1e1;
                cursor: pointer;
            }
        </style>
<?php
$session = $this->session->userdata('dataArr');
$dr_company_id = $session['dr_company_id']?$session['dr_company_id']:$doctor->dr_company_id;
$dr_doctor_name = $session['dr_doctor_name']?$session['dr_doctor_name']:$doctor->dr_doctor_name;
$dr_doctor_id = $session['dr_doctor_id']?$session['dr_doctor_id']:$doctor->dr_doctor_id;
$dr_working_hours = $session['dr_working_hours']?$session['dr_working_hours']:$doctor->dr_working_hours;
$dr_email_address = $session['dr_email_address']?$session['dr_email_address']:$doctor->dr_email_address;
$dr_clinic_name = $session['comp_rateperuser']?$session['dr_clinic_name']:$doctor->dr_clinic_name;
$dr_speciality = $session['dr_speciality']?$session['dr_speciality']:$doctor->dr_speciality;
$dr_class = $session['dr_class']?$session['dr_class']:$doctor->dr_class;

$dr_segment = $session['dr_segment']?$session['dr_segment']:$doctor->dr_segment;
//$dr_associated_products = $session['dr_associated_products']?$session['dr_associated_products']:$doctor->dr_associated_products;
$dr_contact_person = $session['dr_contact_person']?$session['dr_contact_person']:$doctor->dr_contact_person;
$dr_primary_contact = $session['dr_primary_contact']?$session['dr_primary_contact']:$doctor->dr_primary_contact;
$dr_secondary_contact = $session['dr_secondary_contact']?$session['dr_secondary_contact']:$doctor->dr_secondary_contact;

$dr_address = $session['dr_address']?$session['dr_address']:$doctor->dr_address;
$dr_city = $session['dr_city']?$session['dr_city']:$doctor->dr_city;
$dr_longitude = $session['dr_longitude']?$session['dr_longitude']:$doctor->dr_longitude;
$dr_latitude = $session['dr_latitude']?$session['dr_latitude']:$doctor->dr_latitude;

?>

<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading1">
                <div class="btn-group" style="margin-left:30px; margin-top:10px;"> 
                    <a class="btn btn-primary" href="<?php echo base_url("client/doctor/doctor_list") ?>"> <i class="fa fa-list"></i>  <?php echo "Doctors List" ?> </a> 
                </div>
            </div>

            <div class="panel-body panel-form">
				
				
                <div class="row">
                    <div class="col-xs-12">
                        <?php echo form_open_multipart('client/doctor/doctor_form/'.$doctor->id,'class="form-inner"') ?>

                            <?php echo form_hidden('id', $doctor->id) ?>
						<input type="hidden" name="id" id="did" value="<?=$doctor->id?>" >
						   <div class="col-xs-4">
                                <label class="form-label" for="product_dosage_form">Company Name</label>
                                <i class="text-danger">*</i>
                                <select class="form-control" name="dr_company_id" id="dr_company_id">
								<option value="0">Please Select</option>		
                                <? $crows = $this->db->query("select * from companies where comp_status!=1 order by comp_name asc")->result();
								foreach($crows as $crow):
								?>
								
								<option value="<?php echo $crow->comp_id;?>" <? if($dr_company_id==$crow->comp_id) echo "selected";?>><?php echo $crow->comp_name;?></option>
								<? endforeach;?>
                                </select>
                            </div>
                            
                            
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_doctor_name">Doctor Name</label>
                                <i class="text-danger">*</i>
                                <div class="controls">
                                    <input type="text" name="dr_doctor_name" required="required" class="form-control" id="dr_doctor_name" value="<?php echo $dr_doctor_name; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_doctor_id">Doctor ID</label>
                                <i class="text-danger">*</i>
                                <div class="controls">
                                    <input type="text" name="dr_doctor_id" required="required" class="form-control" id="dr_doctor_id" value="<?php echo $dr_doctor_id; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_working_hours">Working Hours</label>
                                <i class="text-danger">*</i>
                                <select class="form-control" name="dr_working_hours">
                                    <option></option>
								<? $crows = $this->db->query("select * from working_hours order by wh_name asc")->result();
								foreach($crows as $crow):
								?>
								<option value="<?php echo $crow->wh_id;?>" <? if($dr_working_hours==$crow->wh_id) echo "selected";?>><?php echo $crow->wh_name;?></option>
								<? endforeach;?>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_email_address">Email Address</label>
                                <i class="text-danger">*</i>
                                <div class="controls">
                                    <input type="text" name="dr_email_address" required="required" class="form-control" id="dr_email_address" value="<?php echo $dr_email_address; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_clinic_name">Clinic / Hospital</label>
                                <i class="text-danger">*</i>
                                <div class="controls">
                                    <input type="text" name="dr_clinic_name" required="required" class="form-control" id="dr_clinic_name" value="<?php echo $dr_clinic_name; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_speciality">Speciality</label>
                                <span class="desc"></span>
                                <select class="form-control" name="dr_speciality">
                                   <option></option>
								<? $crows = $this->db->query("select * from speciality order by sp_name asc")->result();
								foreach($crows as $crow):
								?>
								<option value="<?php echo $crow->sp_id;?>" <? if($dr_speciality==$crow->sp_id) echo "selected";?>><?php echo $crow->sp_name;?></option>
								<? endforeach;?>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_class">Class</label>
                                <span class="desc"></span>
                                <select class="form-control" name="dr_class" id="dr_class">
                                    <option></option>
								<? $crows = $this->db->query("select * from classes order by cl_name asc")->result();
								foreach($crows as $crow):
								?>
								<option value="<?php echo $crow->cl_id;?>" <? if($dr_class==$crow->cl_id) echo "selected";?>><?php echo $crow->cl_name;?></option>
								<? endforeach;?>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_segment">Segment</label>
                                <span class="desc"></span>
                                <select class="form-control" name="dr_segment" id="dr_segment">
                                    <option></option>
								<? $crows = $this->db->query("select * from segment order by seg_name asc")->result();
								foreach($crows as $crow):
								?>
								<option value="<?php echo $crow->seg_id;?>" <? if($dr_segment==$crow->seg_id) echo "selected";?>><?php echo $crow->seg_name;?></option>
								<? endforeach;?>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_associated_products">Associated Products</label>
                               <div class="dropdown-advanced controls">
                                    <div class="options-selected dropdown-advanced-fire-action">
                                        Select Products <img style="width:10px; height:12px; float:right; padding-top:8px;" src="https://i.imgur.com/WiiLexh.png" alt=""> <span class=""></span>
                                    </div>
                                    <div class="closed container-elements" style="max-height:200px; overflow:scroll;">
                                        <input type="text" value="" placeholder="Search" class="search-button">
                                        <div class="order-option select-all-option-container">
                                            <input class="select-all-option" type="checkbox"> Select/Deselect All 
                                        </div>                
                                        <ul id="gap">
                                            
                                        </ul>
                                    </div>
                                    <div class="container-buttons closed" align="center">
                                        <button type="button" class="accept" id="apro">OK</button>
                                    </div>
        						</div>
                            </div>
                            <div class="col-xs-4">
                            	<label class="form-label" for="dr_assigned_members">Assign Members</label>
                                <div class="dropdown-advanced1 controls">
                                    <div class="options-selected1 dropdown-advanced-fire-action1">
                                        Select Members <img style="width:10px; height:12px; float:right; padding-top:8px;" src="https://i.imgur.com/WiiLexh.png" alt=""> <span class=""></span>
                                    </div>
                                    <div class="closed container-elements1" style="max-height:200px; overflow:scroll;">
                                        <input type="text" value="" placeholder="Search" class="search-button1">
                                        <div class="order-option1 select-all-option-container1">
                                            <input class="select-all-option1" type="checkbox"> Select/Deselect All 
                                        </div>                
                                        <ul id="gam">
                                           
                                        </ul>
                                    </div>
                                    <div class="container-buttons1 closed" align="center">
                                        <button type="button" class="accept" id="amem">Ok</button>
                                    </div>
        						</div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_contact_person">Contact Person</label>
                                <span class="desc"></span>
                                <div class="controls">
                                    <input type="text" name="dr_contact_person" class="form-control" id="dr_contact_person" value="<?php echo $dr_contact_person; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_primary_contact">Primary Contact Number</label>
                                <span class="desc"></span>
                                <div class="controls">
                                    <input type="text" name="dr_primary_contact" class="form-control" id="dr_primary_contact" value="<?php echo $dr_primary_contact; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_secondary_contact">Secondary Contact Number</label>
                                <span class="desc"></span>
                                <div class="controls">
                                    <input type="text" name="dr_secondary_contact" class="form-control" id="dr_secondary_contact" value="<?php echo $dr_secondary_contact; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_address">Address</label>
                                <span class="desc"></span>
                                    <textarea name="dr_address" id="dr_address" class="form-control"  rows="3"><?php echo $dr_address; ?></textarea>                                
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_city">City</label>
                                <span class="desc"></span>
                                <select name="dr_city" class="form-control" >
                                <option></option>
								<? $crows = $this->db->query("select * from cities order by city_name asc")->result();
								foreach($crows as $crow):
								?>
								<option value="<?php echo $crow->city_id;?>" <? if($dr_city==$crow->city_id) echo "selected";?>><?php echo $crow->city_name;?></option>
								<? endforeach;?>
								</select>
                            </div>
                            <div class="col-xs-4" style="clear:both;">
                                <label class="form-label" for="dr_longitude">Longitude</label>
                                <span class="desc"></span>
                                <div class="controls">
                                    <input type="text" name="dr_longitude" class="form-control" id="dr_longitude" value="<?php echo $dr_longitude; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_latitude">Latitude</label>
                                <span class="desc"></span>
                                <div class="controls">
                                    <input type="text" name="dr_latitude" class="form-control" id="dr_latitude" value="<?php echo $dr_latitude; ?>">
                                </div>
                            </div>
                            <!--<div class="col-xs-4">
                                <label class="form-label" for="dr_location_url">Location URL</label>
                                <i class="text-danger">*</i>
                                <div class="controls">
                                    <input type="text" name="dr_location_url" class="form-control" id="dr_location_url" value="<?php echo $dr_location_url; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_region">Region</label>
                                <span class="desc"></span>
                                <select class="form-control" name="dr_region" id="dr_region">
                                    <option></option>
                                    <option value="1">Region A</option>
                                    <option value="2">Islamabad</option>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_area">Area</label>
                                <i class="text-danger">*</i>
                                <div class="controls">
                                    <input type="text" name="dr_area" class="form-control" id="dr_area" value="<?php echo $area; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_team_id">Team</label>
                                <span class="desc"></span>
                                <select class="form-control" name="dr_team_id" id="dr_team_id">
                                    <option></option>
                                    <option value="1">Team A</option>
                                    <option value="2">Team B</option>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="dr_historical_data">Historical Data</label>
                                <i class="text-danger">*</i>
                                <div class="controls">
                                    <input type="text" name="dr_historical_data" class="form-control" id="dr_historical_data" value="<?php echo $dr_historical_data; ?>">
                                </div>
                            </div>-->
                            
                            <div class="col-xs-12 col-sm-9 col-md-8 padding-bottom-30">
                            <div class="text-left" style="margin-top:35px;">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-primary">Save & New</button>
                                <button type="reset" class="btn">Cancel</button>
                            </div>
                        </div>

                        <?php echo form_close() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <script>

			
			
 $(document).ready(function() {
				
				
				
                $("body").on("click", ".re-order-filter", function() {
                   $('.select-all-option').prop('checked', false);
                   let action = $(this).attr('data-action'),
                        list_elements = [];
                   $('.item-option').each(function(index) {
                        list_elements.push({
                            name : $(this).val(),
                            id : $(this).attr('data-id'),
                        });
                   });
                   if ( action == "asc" ) {
                       list_elements = list_elements.sort((a, b) => {
                           if (a.name < b.name) return -1
                           return a.name > b.name ? 1 : 0
                       });
                   }
                   else {
                       list_elements = list_elements.sort((a, b) => {
                           if (a.name < b.name) return -1
                           return a.name > b.name ? 1 : 0
                       }).reverse();
                   }
                   $('.container-elements ul').html('');
                   for ( let item = 0; item < list_elements.length; item++ ) {
                       $('.container-elements ul').append(function() {
                           let html = '';
                           html = '<li><label><input data-id="'+(list_elements[item].id)+'" class="item-option" value="'+(list_elements[item].name)+'" type="checkbox">'+(list_elements[item].name)+'</label></li>';
                           return html;
                       });
                   }
                });
                $("body").on("keyup", ".search-button", function() {
                    let search_content = $('.search-button').val().trim().toLowerCase();
                    if ( search_content.length > 0 ) {
                        $('.item-option').each(function(index) {
                            let content = $(this).attr("id").toLowerCase(),
                                element = $(this);
                            element.parent('label').parent('li').hide();
                            if ( content.indexOf(search_content) >= 0 ) {
                                element.parent('label').parent('li').show();
                            }
                        });
                    }
                    else {
                        $('.item-option').parent('label').parent('li').show();
                    }
                });

                $("body").on("click", ".container-buttons .accept", function() {
                    $('.dropdown-advanced .container-elements').removeClass('opened');
                    $('.dropdown-advanced .container-buttons').removeClass('opened');

                    $('.dropdown-advanced .container-elements').addClass('closed');
                    $('.dropdown-advanced .container-buttons').addClass('closed');

                    $('.options-selected span').html('('+($('.item-option:checked').length)+') ');
                    $('.search-button').val("");
                    $('.item-option').parent('label').parent('li').show();
                });

                $("body").on("click", ".container-buttons .cancel", function() {
                    $('.dropdown-advanced .container-elements').removeClass('opened');
                    $('.dropdown-advanced .container-buttons').removeClass('opened');

                    $('.dropdown-advanced .container-elements').addClass('closed');
                    $('.dropdown-advanced .container-buttons').addClass('closed');
                    $('.search-button').val("");
                    $('.item-option').parent('label').parent('li').show();
                });

               $("body").on("change", ".select-all-option", function() {
                    if ( $(this).is(':checked') ) {
                        $('.item-option').prop('checked', true);
                    }
                    else {
                        $('.item-option').prop('checked', false);
                    }
               });
               $("body").on("click", ".dropdown-advanced-fire-action", function() {
                   if ( $('.dropdown-advanced .container-elements').hasClass('opened') ) {
                       $('.dropdown-advanced .container-elements').removeClass('opened');
                       $('.dropdown-advanced .container-buttons').removeClass('opened');

                       $('.dropdown-advanced .container-elements').addClass('closed');
                       $('.dropdown-advanced .container-buttons').addClass('closed');
                   }
                   else {
                       $('.dropdown-advanced .container-elements').addClass('opened');
                       $('.dropdown-advanced .container-buttons').addClass('opened');

                       $('.dropdown-advanced .container-elements').removeClass('closed');
                       $('.dropdown-advanced .container-buttons').removeClass('closed');
                   }

               });
			   
               //for 2nd drop-down i.e Members
			   $("body").on("click", ".re-order-filter1", function() {
                   $('.select-all-option1').prop('checked', false);
                   let action = $(this).attr('data-action'),
                        list_elements = [];
                   $('.item-option1').each(function(index) {
                        list_elements.push({
                            name : $(this).val(),
                            id : $(this).attr('data-id'),
                        });
                   });
                   if ( action == "asc" ) {
                       list_elements = list_elements.sort((a, b) => {
                           if (a.name < b.name) return -1
                           return a.name > b.name ? 1 : 0
                       });
                   }
                   else {
                       list_elements = list_elements.sort((a, b) => {
                           if (a.name < b.name) return -1
                           return a.name > b.name ? 1 : 0
                       }).reverse();
                   }
                   $('.container-elements1 ul').html('');
                   for ( let item = 0; item < list_elements.length; item++ ) {
                       $('.container-elements1 ul').append(function() {
                           let html = '';
                           html = '<li><label><input data-id="'+(list_elements[item].id)+'" class="item-option1" value="'+(list_elements[item].name)+'" type="checkbox">'+(list_elements[item].name)+'</label></li>';
                           return html;
                       });
                   }
                });
			   $("body").on("keyup", ".search-button1", function() {
                    let search_content = $('.search-button1').val().trim().toLowerCase();
                    if ( search_content.length > 0 ) {
                        $('.item-option1').each(function(index) {
                            let content = $(this).attr("id").toLowerCase(),
                                element = $(this);
                            element.parent('label').parent('li').hide();
                            if ( content.indexOf(search_content) >= 0 ) {
                                element.parent('label').parent('li').show();
                            }
                        });
                    }
                    else {
                        $('.item-option1').parent('label').parent('li').show();
                    }
                });

                $("body").on("click", ".container-buttons1 .accept", function() {
                    $('.dropdown-advanced1 .container-elements1').removeClass('opened');
                    $('.dropdown-advanced1 .container-buttons1').removeClass('opened');

                    $('.dropdown-advanced1 .container-elements1').addClass('closed');
                    $('.dropdown-advanced1 .container-buttons1').addClass('closed');

                    $('.options-selected1 span').html('('+($('.item-option1:checked').length)+') ');
                    $('.search-button1').val("");
                    $('.item-option1').parent('label').parent('li').show();
                });
                

              $("body").on("change", ".select-all-option1", function() {
                    if ( $(this).is(':checked') ) {
                        $('.item-option1').prop('checked', true);
                    }
                    else {
                        $('.item-option1').prop('checked', false);
                    }
               });
               $("body").on("click", ".dropdown-advanced-fire-action1", function() {
                   if ( $('.dropdown-advanced1 .container-elements1').hasClass('opened') ) {
                       $('.dropdown-advanced1 .container-elements1').removeClass('opened');
                       $('.dropdown-advanced1 .container-buttons1').removeClass('opened');

                       $('.dropdown-advanced1 .container-elements1').addClass('closed');
                       $('.dropdown-advanced1 .container-buttons1').addClass('closed');
                   }
                   else {
                       $('.dropdown-advanced1 .container-elements1').addClass('opened');
                       $('.dropdown-advanced1 .container-buttons1').addClass('opened');

                       $('.dropdown-advanced1 .container-elements1').removeClass('closed');
                       $('.dropdown-advanced1 .container-buttons1').removeClass('closed');
                   }

               });
            });
/////////////////////////////rizwan//////////////
				
$(document).ready(function() {
	var company_id = $('#dr_company_id').val();
	var did = $('#did').val();
				
	$.ajax({ 
		url: "<?php echo base_url('client/doctor/getAssociatedProducts');?>",
		method:"POST",
		data:{cid: company_id,did: did},	 
		success: function(data)  
		{
		
		$('#gap').empty();
		$('#gap').html(data);
		$('#apro').click();	
			
		}   
	});
  $.ajax({ 
		url: "<?php echo base_url('client/doctor/getAssociatedMembers');?>",
		method:"POST",
		data:{cid: company_id,did: did},	 
		success: function(data)  
		{
		$('#gam').empty();
		$('#gam').html(data);
		$('#amem').click();	
			
		}   
	});	
 
});		
			
			
	$('#dr_company_id').on('change',function(){
	var company_id = $('#dr_company_id').val();
	var did = $('#did').val();	
	$.ajax({ 
		url: "<?php echo base_url('client/doctor/getAssociatedProducts');?>",
		method:"POST",
		data:{cid: company_id,did: did},	 
		success: function(data)  
		{
		
		$('#gap').empty();
		$('#gap').html(data);
		$('#apro').click();	
		}   
	});
 
});
	
    $('#dr_company_id').on('change',function(){
	var company_id = $('#dr_company_id').val();
	var did = $('#did').val();	
		
	$.ajax({ 
		url: "<?php echo base_url('client/doctor/getAssociatedMembers');?>",
		method:"POST",
		data:{cid: company_id,did: did}, 
		success: function(data)  
		{
		
		$('#gam').empty();
		$('#gam').html(data);
		$('#amem').click();		
		}   
	});
 
});			
        </script>