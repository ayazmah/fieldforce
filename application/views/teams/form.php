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

<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading1">
                <div class="btn-group" style="margin-left:30px; margin-top:10px;"> 
                    <a class="btn btn-primary" href="<?php echo base_url("teams/groups/groups_list") ?>"> <i class="fa fa-list"></i>  <?php echo "Groups List" ?> </a> 
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-xs-12">
                        <?php echo form_open_multipart('teams/groups/form/'.$group->id,'class="form-inner"') ?>

                            <?php echo form_hidden('id', $group->id) ?>
							<div class="row">
                                <div class="col-md-9 col-sm-12"  style="margin:20px 0 10px 0px;">
                                <div class="form-group row" >
                                    <label for="parent_subject" class="col-xs-3 form-label" style="margin-left:15px;"><?php echo 'Select Company' ?>
                                        </label>
                                        <div class="col-xs-6">
                                            <select name="company_id" id="company_id" class="form-control">
                                               <?php echo $group->group_company_id;
                                                   $crows = $this->db->query('select * from companies where comp_status!=1')->result();
                                                   foreach($crows as $crow){
                                                 ?>
                                                  <option value="<?php echo $crow->comp_id;?>" <?php if($group->group_company_id == $crow->comp_id) { ?> selected="selected" <?php }?>><?php echo $crow->comp_name;?></option>
                                                 <?php } ?>
                                               
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="group_name">Group Name</label>
                                <span class="desc"></span>
                                <div class="controls">
                                    <input type="text" name="group_name" class="form-control" id="group_name" required="required" value="<?php echo $group->group_name; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                            	<label class="form-label" for="group_assigned_members">Assign Products</label>
                                <div class="dropdown-advanced controls">
                                    <div class="options-selected dropdown-advanced-fire-action">
                                        Select Members <img style="width:10px; height:12px; float:right; padding-top:8px;" src="https://i.imgur.com/WiiLexh.png" alt=""> <span class=""></span>
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
                                        <button type="button" class="accept">Ok</button>
                                    </div>
        						</div>
                            </div>
                            <div class="col-xs-4">
                            	<label class="form-label" for="group_assigned_products">Assign Members</label>
                                <div class="dropdown-advanced1 controls">
                                    <div class="options-selected1 dropdown-advanced-fire-action1">
                                        Select Products <img style="width:10px; height:12px; float:right; padding-top:8px;" src="https://i.imgur.com/WiiLexh.png" alt=""> <span class=""></span>
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
                                        <button type="button" class="accept">Go</button>
                                    </div>
        						</div>
                            </div>
                            <div class="col-xs-12 col-sm-9 col-md-8 padding-bottom-30">
                            <div class="text-left" style="margin-top:135px;">
                                <button type="submit" class="btn btn-primary">Save</button>
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
			   
			   //for 2nd drop-down i.e Product
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
////////////////////////////////////////			
	$('#company_id').on('change',function(){
	var company_id = $('#company_id').val();
	$.ajax({ 
		url: "<?php echo base_url('client/doctor/getAssociatedProducts');?>",
		method:"POST",
		data:{cid: company_id},	 
		success: function(data)  
		{
		
		$('#gap').empty();
		$('#gap').html(data);
		}   
	});
 
});
	
    $('#company_id').on('change',function(){
	var company_id = $('#company_id').val();
	$.ajax({ 
		url: "<?php echo base_url('client/doctor/getAssociatedMembers');?>",
		method:"POST",
		data:{cid: company_id},	 
		success: function(data)  
		{
		
		$('#gam').empty();
		$('#gam').html(data);
		}   
	});
 
});				
        </script>