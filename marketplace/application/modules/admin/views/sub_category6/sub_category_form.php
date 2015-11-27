<div class="modal-dialog segment-model">
	<div class="modal-content">
    	<div class="modal-header modal-header1 segment-header">
        	<button type="button" class="close close-btn" data-dismiss="modal">
				<span aria-hidden="true">
					<img src="<?php echo base_url(); ?>img/close.png">
				</span>
				<span class="sr-only">Close</span>
			</button>
        </div>
		
		<div class="modal-body modal-body-custom">
        	<section class="panel">
            	<header class="panel-heading rform-header">
					<?php					
					if($subCat6ID)
					{
						echo 'Edit ';
					}
					else
					{
						echo 'Add ';
					}
					?>
                	Sub Category6
                </header>
                
				<div class="panel-body">
                	<div class="tab-content">
                    	<div class="tab-pane active" id="home">
						<?php 
							$attr=array('id'=>'addEditSubCategoryForm');
							echo form_open('',$attr);?>
							<input type="hidden" name="subCat6ID" value="<?php echo $subCat6ID; ?>" />
                        	<div class="row">
                            	<div class="col-sm-12  form-div">
									Segment : 
									<div class="col-sm-12">	
							<?php 
							echo $this->segment_cat_m->segment_list_dropdown($segment_id); 
							echo $segERR; 
							?>
									</div>
                                </div>
                                
								<div class="col-sm-12  form-div">
									Category :
									<div class="col-sm-12">										
										<div id="catAjaxId">
										<select class="chosen-select form-control" data-live-search="true" name="category_id" id="category_id" >
											<option value="">Select Category</option>
										</select>
										</div>
										<?php echo $catERR; ?>									
	                                </div>
								</div>
															
								<div class="col-sm-12  form-div">
									Sub Category 1 : 
									<div class="col-sm-12">
										<div id="subCatAjaxId">
											<select class="chosen-select form-control" data-live-search="true" name="sub_category1_id" id="sub_category1_id" >
											
												<option value="">Select Sub Category1</option>
											</select>
										</div>
										<?php echo $subCat1ERR; ?>
									</div>
																												
                                </div>
								
								<div class="col-sm-12  form-div">
									Sub Category 2 : 
									<div class="col-sm-12">
										<div id="subCat2AjaxId">
										<select class="chosen-select form-control" data-live-search="true" id="sub_category2_id" name="sub_category2_id">
												<option value="">Select Sub Category2</option>
											</select>
										</div>
										<?php echo $subCat2ERR; ?>
									</div>
								</div>
								
								<div class="col-sm-12  form-div">
									Sub Category 3 : 
									<div class="col-sm-12">
										<div id="subCat3AjaxId">
										<select class="chosen-select form-control" data-live-search="true" id="sub_category3_id" name="sub_category3_id">
												<option value="">Select Sub Category3</option>
											</select>
										</div>
										<?php echo $subCat3ERR; ?>
									</div>
								</div>
								
								<div class="col-sm-12  form-div">
									Sub Category 4 : 
									<div class="col-sm-12">
										<div id="subCat4AjaxId">
										<select class="chosen-select form-control" data-live-search="true" id="sub_category4_id" name="sub_category4_id">
												<option value="">Select Sub Category4</option>
											</select>
										</div>
										<?php echo $subCat4ERR; ?>
									</div>
								</div>
								
								<div class="col-sm-12  form-div">
									Sub Category 5 : 
									<div class="col-sm-12">
										<div id="subCat5AjaxId">
										<select class="chosen-select form-control" data-live-search="true" id="sub_category5_id" name="sub_category5_id">
												<option value="">Select Sub Category5</option>
											</select>
										</div>
										<?php echo $subCat5ERR; ?>
									</div>
                                
								<div class="col-sm-12  form-div">
									Sub Category 6 : 
                                	<div class="col-sm-12">
                                    	<input type="text" class="form-control model-input" placeholder="SubCategory6 Name" name="sub_category6" id="sub_category6" value="<?php echo $sub_category6; ?>">
										<?php echo $subCat6ERR; ?>
                                    </div>									
								</div>
                                
								<div class="col-sm-12 form-div">
                                	<div class="col-sm-12 text-right">
                                    	<button class="btn btn-success" onclick="return validation();">
											Submit
										</button>
                                    </div>
                                </div>
                            </div>
							</form>
						</div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script type="text/javascript">
function cat_list(segmntID)
{		
	ajax_function('<?php echo base_url(); ?>admin/category/category_list/'+segmntID+'/<?php echo $category_id; ?>','#catAjaxId');
}

function subcat1_list(catId)
{	
	ajax_function('<?php echo base_url(); ?>admin/sub_category/sub_category1_list/'+catId+'/<?php echo $sub_category1_id; ?>','#subCatAjaxId');
}

function subcat2_list(subcatId)
{	
	ajax_function('<?php echo base_url(); ?>admin/sub_category2/sub_category2_list/'+subcatId+'/<?php echo $sub_category2_id; ?>','#subCat2AjaxId');
}

function subcat3_list(subcat2Id)
{	
	ajax_function('<?php echo base_url(); ?>admin/sub_category3/sub_category3_list/'+subcat2Id+'/<?php echo $sub_category3_id; ?>','#subCat3AjaxId');
}

function subcat4_list(subcat3Id)
{	
	ajax_function('<?php echo base_url(); ?>admin/sub_category4/sub_category4_list/'+subcat3Id+'/<?php echo $sub_category4_id; ?>','#subCat4AjaxId');
}

function subcat5_list(subcat4Id)
{	
	ajax_function('<?php echo base_url(); ?>admin/sub_category5/sub_category5_list/'+subcat4Id+'/<?php echo $sub_category5_id; ?>','#subCat5AjaxId');
}
<?php
if(!empty($category_id))
{
?>
cat_list('<?php echo $segment_id; ?>');
<?php
}
if(!empty($sub_category1_id))
{
?>
subcat1_list('<?php echo $category_id; ?>');
<?php
}
if(!empty($sub_category2_id))
{
?>
subcat2_list('<?php echo $sub_category1_id; ?>');
<?php
}
if(!empty($sub_category3_id))
{
?>
subcat3_list('<?php echo $sub_category2_id; ?>');
<?php
}
if(!empty($sub_category4_id))
{
?>
subcat4_list('<?php echo $sub_category3_id; ?>');
<?php
}
if(!empty($sub_category5_id))
{
?>
subcat5_list('<?php echo $sub_category4_id; ?>');
<?php
}
?>
</script>