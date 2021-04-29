<?php
$rlrows = $this->db->query('select * from user_roles where ur_status = 1 order by ur_order')->result();
$region_caption = $rlrows[1]->text_caption;
$zone_caption = $rlrows[2]->text_caption;
?>
<div class="col-xs-12">
                    <div class="page-title">

                        <div class="pull-left">
                            <!-- PAGE HEADING TAG - START -->
                            <h1 class="title"><?=$zone_caption ?></h1>
                            <!-- PAGE HEADING TAG - END -->
                        </div>

                        <div class="pull-right hidden-xs">
                            <ol class="breadcrumb">
                                <li>
                                    <a href="<? echo base_url("dashboard/home")?>"><i class="fa fa-home"></i>Home</a>
                                </li>
                                <li class="active">
                                    <strong><?=$zone_caption .' List'?></strong>
                                </li>
                            </ol>
                        </div>

                    </div>
                </div>
                <div class="clearfix"></div>
                <!-- MAIN CONTENT AREA STARTS -->

                <div class="col-xs-12 ">
                    <div class=" bg-w">
                        <div class="col-lg-12">
                            <section class="box ">
                                <header class="panel_header">
                                    
                                    <div class="actions panel_actions pull-right">
                                        <a class="box_toggle fa fa-chevron-down"></a>
                                        <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                        <a class="box_close fa fa-times"></a>
                                    </div>
                                </header>
                                <div class="content-body">
                                    <div class="row">
                                        <div class="col-xs-12">

                                            <!-- ********************************************** -->

                                            <table id="example" class="display table table-hover table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th><?=$region_caption ?></th>
														<th>Company</th>
                                                        <th>Status</th>
                                                        <th>Created On</th>
                                                        <th>Actions</th>
                                                       
                                                    </tr>
                                                </thead>

                                                <tbody>
												<?php if(!empty($rows)) {
													  foreach($rows as $row){
													   $rrow = $this->db->query('select * from regions where re_id ='.$row->zo_re_id)->row();
													  
													  	  
														  
													  $crow = $this->db->query('select us_name from users where us_id ='.$rrow->re_us_id)->row(); 
													?>	
                                                    <tr>
                                                        <td><?php echo $row->zo_name; ?></td>
														 <td><?php echo $rrow->re_name; ?></td>
                                                        <td><?php echo $crow->us_name; ?></td>
                                                        <td><?php echo $row->zo_status?'Active':'In Active'; ?></td>
                                                        <td><?php echo $row->zo_created_on; ?></td>
                                                        <td><a href="<?php echo base_url('zone/add/'.$row->zo_id) ?>" style="color: inherit;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> / <a class="del" style="color: inherit;" data-target="#cmpltadminModal-2" id="<?php echo $row->zo_id; ?>" data-toggle="modal" href="javascript:void()"><i class="fa fa-trash" aria-hidden="true"></i></a>
														
                                                    </tr>
												 <?php } 
                                                     }	
												  ?>	
												</tbody>	
                                            </table>
                                            <!-- ********************************************** -->

                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
 <!-- modal start -->
	<div class="modal fade col-xs-12" id="cmpltadminModal-2" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Delete Actions</h4>
                                                    </div>
                                                    <div class="modal-body">

                                                       Are you sure to delete this ?

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button data-dismiss="modal" class="btn btn-default" type="button" >Close</button>
                                                        <button class="btn btn-warning" id="btn_to_check" type="button"> Yes, Delete</button>
                                                    </div>
                                                </div>
                                            </div>
  </div>
 <!-- modal end -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
	
  $('#cmpltadminModal-2').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget.id).selector;
	$('#btn_to_check').on('click', function(){
	//alert(id);
	window.location = '<?php echo base_url('zone/delete/')?>'+id;	
    });	  
	  
  });
});
	

	
</script>	
  