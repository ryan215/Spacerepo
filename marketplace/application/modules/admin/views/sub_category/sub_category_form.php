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
					if($subCatID)
					{
						echo 'Edit ';
					}
					else
					{
						echo 'Add ';
					}
					?>
                	Sub Category
                </header>
                
				<div class="panel-body">
                	<div class="tab-content">
                    	<div class="tab-pane active" id="home">
							
							<?php 
							$attr=array('id'=>'addEditSubCategoryForm');
							echo form_open('',$attr);?>
							<input type="hidden" name="subCatID" value="<?php echo $subCatID; ?>" />
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
									Sub Category :
                                	<div class="col-sm-12">
                                    	<input type="text" class="form-control model-input" placeholder="SubCategory Name" name="sub_category" id="sub_category" value="<?php echo $sub_category; ?>">
										<?php echo $subCatERR; ?>
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
<?php
if(!empty($category_id))
{
?>
cat_list('<?php echo $segment_id; ?>');
<?php
}
?>
</script>