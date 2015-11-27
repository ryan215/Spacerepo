<style>
.popup-label{background-image:none;
}
</style>

<div class="modal-dialog segment-model">
	<div class="modal-content">
    	<div class="modal-header modal-header1 segment-header">
        	<button type="button" class="close close-btn" data-dismiss="modal"><span aria-hidden="true">
				<img src="<?php echo base_url(); ?>img/close.png"></span><span class="sr-only">Close</span>
			</button>
        </div>
        
		<div class="modal-body modal-body-custom">
        	<section class="panel">
            	<header class="panel-heading rform-header">
					<?php					
					if($catID)
					{
						echo 'Edit ';
					}
					else
					{
						echo 'Add ';
					}
					?>
					Category					
                </header>
                    
				<div class="panel-body">
                	<div class="tab-content">
                    	<div class="tab-pane active" id="home">
							<?php 
							$attribute=array('id'=>'addEditCategoryForm');
							echo form_open('',$attribute);
							?>
							<input type="hidden" name="catID" value="<?php echo $catID; ?>" />
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
                                	<div class="col-sm-12" style="">
                                    	<input type="text" class="form-control model-input" placeholder="Category Name" name="category_name" value="<?php echo $category_name; ?>">
										<?php echo $catERR; ?>
                                    </div>
								</div>
                                    
								<div class="col-sm-12 form-div">
                                	<div class="col-sm-12 text-right">
                                    	<button class="btn btn-success">Submit</button>
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