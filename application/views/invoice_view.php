   <div class="col-xs-12">
                    <div class="page-title">

                        <div class="pull-left">
                            <!-- PAGE HEADING TAG - START -->
                            <h1 class="title">Invoices</h1>
                            <!-- PAGE HEADING TAG - END -->
                        </div>

                        <div class="pull-right hidden-xs">
                            <ol class="breadcrumb">
                                <li>
                                    <a href="<? echo base_url("dashboard/home")?>"><i class="fa fa-home"></i>Home</a>
                                </li>
                                <li class="active">
                                    <strong>Invoices</strong>
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
                                                        <th>Invoice</th>
                                                        <th>Company</th>
														<th>Users</th>
														<th>Price</th>
                                                        <th>Status</th>
                                                        <th>Created On</th>
                                                        <th>Actions</th>
                                                       
                                                    </tr>
                                                </thead>

                                                <tbody>
												<?php if(!empty($rows)) {
													  foreach($rows as $row){
														  
													  $crow = $this->db->query('select us_name from users where us_id ='.$row->inv_us_id)->row();	  
													?>	
                                                    <tr>
                                                        <td><?php echo $row->inv_name; ?></td>
                                                        <td><?php echo $crow->us_name; ?></td>
														<td><?php echo $row->inv_total_users; ?></td>
														<td><?php echo $row->inv_total_price; ?></td>
                                                        <td><?php echo $row->inv_status?'Active':'In Active'; ?></td>
                                                        <td><?php echo $row->inv_created_on; ?></td>
                                                        <td><a href="<?php echo base_url('invoice/add/'.$row->inv_id) ?>" style="color: inherit;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> / <a class="del" style="color: inherit;" data-target="#cmpltadminModal-2" id="<?php echo $row->inv_id; ?>" data-toggle="modal" href="javascript:void()"><i class="fa fa-trash" aria-hidden="true"></i></a>
														
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
	window.location = '<?php echo base_url('invoice/delete/')?>'+id;	
    });	  
	  
  });
});
	

	
</script>	
  