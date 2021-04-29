<?php
$rlrows = $this->db->query('select * from user_roles where ur_status = 1 order by ur_order')->result();

$region_caption = $rlrows[1]->text_caption;
$zone_caption = $rlrows[2]->text_caption;
$teamload_caption = $rlrows[3]->text_caption;
?>
<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("team/add") ?>"> <i class="fa fa-plus"></i>  <?php echo "Add Team" ?> </a>  
                </div>
            </div>

            <div class="panel-body">
                <table class="display table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo display('serial') ?></th>
                            <th><?php echo $region_caption ?></th>
                            <th><?php echo $region_caption ." Manager" ?></th>
                            <th><?php echo "Team Name" ?></th>
                            <th><?php echo $teamload_caption; ?></th> 
                            <th><?php echo $zone_caption; ?></th> 
                            <th><?php echo "Action" ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($teams)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($teams as $mem) { 
						          $rrow = $this->db->query('select re_name from regions where re_id ='.$mem->region_id)->row();
	                        if(!empty($mem->area_id)){
							$arow = $this->db->query('select zo_name from zones where zo_id ='.$mem->area_id)->row();
							$area= $arow->zo_name;
							}
					 	    $rmrow = $this->db->query('select emp_name from members where designation =5 and region ='.$mem->region_id)->row();
	                        $tmrow = $this->db->query('select emp_name from members where designation =1 and id ='.$mem->teamlead_id)->row();
	                        //$amrow = $this->db->query('select ur_name from user_roles where ur_id = '.$mem->designation)->row();
	                         $mem_id =$mem->assigned_members?$mem->assigned_members:0;
						     $mrow = $this->db->query('select emp_name from members where id ='.$mem_id)->row();
						   
						 ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $rrow->re_name; ?></td>
                                    <td><?php echo $rmrow->emp_name; ?></td>
                                    <td><?php echo $mem->team_name; ?></td> 
                                    <td><?php echo $tmrow->emp_name; ?></td> 
                                    <td><?php echo $area; ?></td>
                                    <td class="center" width="80">                                         
                                        <a href="<?php echo base_url("team/add/$mem->id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>                                         
                                    </td>
                                </tr>
                                <?php $sl++; ?>
                            <?php } ?> 
                        <?php } ?> 
                    </tbody>
                </table>  <!-- /.table-responsive -->
                <div class="text-right"><?php echo $links ?></div>
            </div>
        </div>
    </div>
</div>
 
 