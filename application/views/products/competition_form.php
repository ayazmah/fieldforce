<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading1">
                <div class="btn-group" style="margin-left:30px; margin-top:10px;"> 
                    <a class="btn btn-primary" href="<?php echo base_url("products/competition/competition_list") ?>"> <i class="fa fa-list"></i>  <?php echo "Competition List" ?> </a> 
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-xs-12">
                        <?php echo form_open_multipart('products/competition/competition_form/'.$competition->competition_id,'class="form-inner"') ?>

                            <?php echo form_hidden('id', $competition->competition_id) ?>
                            <div class="col-xs-4">
                                <label class="form-label" for="competition_company_id">Company Name</label>
                                <i class="text-danger">*</i>
                                <select class="form-control" name="competition_company_id" id="competition_company_id">
                                <? $crows = $this->db->query("select * from companies where comp_status!=1 order by comp_name asc")->result();
								foreach($crows as $crow):
								?>
								<option value="<?php echo $crow->comp_id;?>" <? if($competition->competition_company_id==$crow->comp_id) echo "selected";?>><?php echo $crow->comp_name;?></option>
								<? endforeach;?>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="competition_product_name">Product Name</label>
                                <i class="text-danger">*</i>
                                <div class="controls">
                                    <input type="text" name="competition_product_name" required="required" class="form-control" id="competition_product_name" value="<?php echo $competition->competition_product_name; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="competition_productID">Product ID</label>
                                <i class="text-danger">*</i>
                                <div class="controls">
                                    <input type="text" name="competition_productID" required="required" class="form-control" id="competition_productID" value="<?php echo $competition->competition_productID; ?>">
                                </div>
                            </div>                            
                            <div class="col-xs-4">
                                <label class="form-label" for="competition_generic_name">Generic Name</label>
                                <i class="text-danger">*</i>
                                <div class="controls">
                                    <input type="text" name="competition_generic_name" required="required" class="form-control" id="competition_generic_name" value="<?php echo $competition->competition_generic_name; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="competition_brand_name">Brand Name</label>
                                <span class="desc"></span>
                                <div class="controls">
                                    <input type="text" name="competition_brand_name" class="form-control" id="competition_brand_name" value="<?php echo $competition->competition_brand_name; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="competition_dosage_form">Dosage Form</label>
                                <span class="desc"></span>
                                <select class="form-control" name="competition_dosage_form" id="competition_dosage_form">
                                    <option></option>
								<? $crows = $this->db->query("select * from dosage_form order by df_name asc")->result();
								foreach($crows as $crow):
								?>
								<option value="<?php echo $crow->df_id;?>" <? if($competition->competition_dosage_form==$crow->df_id) echo "selected";?>><?php echo $crow->df_name;?></option>
								<? endforeach;?>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="competition_dosage">Dosage</label>
                                <span class="desc"></span>
                                <select class="form-control" name="competition_dosage" id="competition_dosage">
                                    <option></option>
								<? $crows = $this->db->query("select * from dosage order by dosage_name asc")->result();
								foreach($crows as $crow):
								?>
								<option value="<?php echo $crow->dosage_id;?>" <? if($competition->competition_dosage==$crow->dosage_id) echo "selected";?>><?php echo $crow->dosage_name;?></option>
								<? endforeach;?>
                                </select>
                            </div>
                            
                            <div class="col-xs-4">
                                <label class="form-label" for="competition_product_id">Competes with</label>
                                <span class="desc"></span>
                                <select class="form-control" name="competition_product_id" id="competition_product_id">
                                    <option></option>
								<? $crows = $this->db->query("select * from products where product_status!=1 AND product_is_deleted!=1 order by product_name asc")->result();
								foreach($crows as $crow):
								?>
								<option value="<?php echo $crow->id;?>" <? if($competition->competition_product_id==$crow->id) echo "selected";?>><?php echo $crow->product_name;?></option>
								<? endforeach;?>
                                </select>
                            </div>
                            
                            <div class="col-xs-4">
                                <label class="form-label" for="competition_price">Price</label>
                                <span class="desc"></span>
                                <div class="controls">
                                    <input type="text" name="competition_price" class="form-control" id="competition_price" value="<?php echo $competition->competition_price; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="competition_url">Product URL</label>
                                <span class="desc"></span>
                                <div class="controls">
                                    <input type="text" name="competition_url" class="form-control" id="competition_url" value="<?php echo $competition->competition_url; ?>">
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-sm-9 col-md-8 padding-bottom-30" style=" clear:both;">
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
 