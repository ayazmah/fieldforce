<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading1">
                <div class="btn-group" style="margin-left:30px; margin-top:10px;">
                    <a class="btn btn-success" href="<?php echo base_url("entities/dosage/dosage_form") ?>"> <i class="fa "></i>  <?php echo "Add New" ?> </a>  
                </div>
            </div>

            <div class="panel-body">
                <?php echo form_open('entities/dosage/dosage_list') ?>
                <div class="row">
                    <div class="col-12 col-md-12 " align="center">
                        <div class="col-4 col-md-4">
                            <p><input id="dosage_name" type="text" style="min-width: 110px;" class="form-control" name="dosage_name"
                                      placeholder="Dosage Name"
                                      value="<?php //if ($this->session->userdata('search_dosageform') != null) {
                                         // echo $this->session->userdata('search_dosageform')['dosageform_name'];
                                      //} ?>"></p>                            

                        </div>
                        <div class="col-4" style="float:left;">                            
                            <p class="btn-group"><input type="submit" name="submit" value="Search" class="btn btn-success"></p>
                        </div>
                        <div class="col-4 col-md-4">
                        </div>

                    </div>
                    <div class="col-3 col-md-3"></div>
                    <!--end of col-->
                </div>
                <?php echo form_close() ?>
                <hr>
                <table class="display table table-hover table-condensed" style="width:50%">
                    <thead>
                        <tr>
                            <th><?php echo "Sr#." ?></th>
                            <th><?php echo "Dosage Name" ?></th>
                            <th><?php echo "Action" ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($dosages)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($dosages as $d) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $d->dosage_name; ?></td>
                                    <td class="center">                                         
                                        <a href="<?php echo base_url("entities/dosage/dosage_form/$d->dosage_id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>    
                                        <a href="<?php echo base_url("entities/dosage/delete/$d->dosage_id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>                                     
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
 
 