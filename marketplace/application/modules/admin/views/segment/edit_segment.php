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
					if(!empty($segmentID))
					{
						echo 'Edit';
					}
					else
					{
						echo 'Add';
					}
					?>
                	 Segment
                </header>
				<div class="panel-body">
					<div class="tab-content">
						<div class="tab-pane active" id="home">
							<div class="row">
								<?php echo form_open();?>
									<div class="col-sm-12  form-div">
                    					<div class="col-sm-12" style="margin-top:15px;">
											<input type="hidden" name="segment_id" value="<?php echo $segmentID; ?>" />
                                            <input type="text" class="form-control model-input" placeholder="Segment Name" name="segment" value="<?php echo $segment_name ?>">
											<?php echo $segERR; ?>
                                    	</div>
                                    </div>
                                    <div class="col-sm-12 form-div">
										<div class="col-sm-12 text-right">
                                            <button class="btn btn-success">Submit</button>
                                    	</div>
                                	</div>
								</form>
                        	</div>
                    	</div>
                	</div>
            	</div>
        	</section>
    	</div>
	</div>
</div>