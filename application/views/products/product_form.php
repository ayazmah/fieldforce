<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading1">
                <div class="btn-group" style="margin-left:30px; margin-top:10px;"> 
                    <a class="btn btn-primary" href="<?php echo base_url("products/product/products_list") ?>"> <i class="fa fa-list"></i>  <?php echo "Products List" ?> </a> 
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-xs-12">
                        <?php echo form_open_multipart('products/product/product_form/'.$product->id,'class="form-inner"') ?>

                            <?php echo form_hidden('id', $product->id) ?>
						  <div class="col-xs-4">
                                <label class="form-label" for="product_company_id">Company Name</label>
                                <i class="text-danger">*</i>
                                <select class="form-control" name="product_company_id" id="product_company_id">
                                <? $crows = $this->db->query("select * from companies where comp_status!=1 order by comp_name asc")->result();
								foreach($crows as $crow):
								?>
								<option value="<?php echo $crow->comp_id;?>" <? if($product->product_company_id==$crow->comp_id) echo "selected";?>><?php echo $crow->comp_name;?></option>
								<? endforeach;?>
                                </select>
                            </div>
                            
                            <div class="col-xs-4">
                                <label class="form-label" for="product_name">Product Name</label>
                                <i class="text-danger">*</i>
                                <div class="controls">
                                    <input type="text" name="product_name" required="required" class="form-control" id="product_name" value="<?php echo $product->product_name; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="product_productID">Product ID</label>
                                <i class="text-danger">*</i>
                                <div class="controls">
                                    <input type="text" name="product_productID" required="required" class="form-control" id="product_productID" value="<?php echo $product->product_productID; ?>">
                                </div>
                            </div>                            
                            <div class="col-xs-4">
                                <label class="form-label" for="product_generic_name">Generic Name</label>
                                <i class="text-danger">*</i>
                                <div class="controls">
                                    <input type="text" name="product_generic_name" required="required" class="form-control" id="product_generic_name" value="<?php echo $product->product_generic_name; ?>">
                                </div>
                            </div>
						    
                            <div class="col-xs-4">
                                <label class="form-label" for="product_brand_name">Brand Name</label>
                                <span class="desc"></span>
                                <div class="controls">
                                    <input type="text" name="product_brand_name" class="form-control" id="product_brand_name" value="<?php echo $product->product_brand_name; ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="product_dosage_form">Dosage Form</label>
                                <span class="desc"></span>
                                <select class="form-control" name="product_dosage_form" id="product_dosage_form">
                                    <option></option>
								<? $crows = $this->db->query("select * from dosage_form order by df_name asc")->result();
								foreach($crows as $crow):
								?>
								<option value="<?php echo $crow->df_id;?>" <? if($product->product_dosage_form==$crow->df_id) echo "selected";?>><?php echo $crow->df_name;?></option>
								<? endforeach;?>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="form-label" for="product_dosage">Dosage</label>
                                <span class="desc"></span>
                                <select class="form-control" name="product_dosage" id="product_dosage">
                                    <option></option>
								<? $crows = $this->db->query("select * from dosage order by dosage_name asc")->result();
								foreach($crows as $crow):
								?>
								<option value="<?php echo $crow->dosage_id;?>" <? if($product->product_dosage==$crow->dosage_id) echo "selected";?>><?php echo $crow->dosage_name;?></option>
								<? endforeach;?>
                                </select>
                            </div>
                            
                            <div class="col-xs-4">
                                <label class="form-label" for="product_url">Product URL</label>
                                <span class="desc"></span>
                                <div class="controls">
                                    <input type="text" name="product_url" class="form-control" id="product_url" value="<?php echo $product->product_url; ?>">
                                </div>
                            </div>
                            
                            <div class="col-xs-4">
                                <label for="product_description" class="form-label">Description</label>
                                <span class="desc"></span>
                                
                                    <textarea name="product_description" id="product_description" class="form-control"  rows="3"><?php echo $product->product_description; ?></textarea>
                                
                            </div>
                            
                            <div class="col-xs-4">
                                <label for="product_side_effects" class="form-label">Side Effects</label>
                                <span class="desc"></span>
                                    <textarea name="product_side_effects" id="product_side_effects" class="form-control"  rows="3"><?php echo $product->product_side_effects; ?></textarea>
                                
                            </div>
                            
                            
                            <div class="col-xs-12 col-sm-9 col-md-8 padding-bottom-30" style=" clear:both;">
                            <div class="text-left" style="margin-top:35px; clear:both;">
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
 