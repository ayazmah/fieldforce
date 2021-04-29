<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading1">
                <div class="btn-group" style="margin-left:30px; margin-top:10px;"> 
                    <a class="btn btn-primary" href="<?php echo base_url("entities/dosage/dosage_list") ?>"> <i class="fa fa-list"></i>  <?php echo "Dosage List" ?> </a> 
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-xs-12">
                        <?php echo form_open_multipart('entities/dosage/dosage_form/'.$dosage->dosage_id,'class="form-inner"') ?>

                            <?php echo form_hidden('id', $dosage->dosage_id) ?>
                            
                            <div class="col-xs-4">
                                <label class="form-label" for="dosage_name">Dosage Name</label>
                                <span class="desc">*</span>
                                <div class="controls">
                                    <input type="text" name="dosage_name" required="required" class="form-control" id="dosage_name" value="<?php echo $dosage->dosage_name; ?>">
                                </div>
                            </div>
                            
                            <br style="clear:both;"/>
                            <div class="col-xs-12 col-sm-9 col-md-8 padding-bottom-30">
                            <div class="text-left" style="margin-top:35px;">
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
 