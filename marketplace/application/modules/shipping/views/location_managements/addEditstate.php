	<style>
label{
	background-image:none;
}

.chosen-container-single .chosen-single{
	background:none !important;
	border:1px solid #CCC !important;
	border-radius:4px !important; 
}
.r-activity{margin-top:0;
	font-size:10px;
}

.r-activity1{
	display:inline-block;
	height: 32px;
	font-size: 14px;
	padding: 5px;
	margin-top:1px;
	float:right;
}

.ftrBoxID{
	margin: 12px 0 0 0px;
	display:flex;
}

.ftrBoxID input{width:100%;
}

.ftrAjaxID
{
	text-align:right !important;
	
}
.edit-btns{float:right;
	  float: right;
	  height: 32px;
	  padding: 5px;
	  font-size: 14px;
	  margin: 1px 2px;
}

.block-element label{float:left;
	margin-right:18px;
}

</style>
<link href="<?php echo base_url(); ?>css/color_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/new_css/category.css" rel="stylesheet" type="text/css" />
<section id="main-content">
	<section class="wrapper">
    	<div class="row">
        	<div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/location_management/state_list_view'; ?>">State List</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">
							<?php
							if($stateId)
							{
								echo 'Edit State';
							}
							else
							{
								echo 'Add State';
							}
							?>
						</a>
					</li>
				</ul>
			</div>
        </div>
<?php 
echo form_open();
?>
		<div class="row">
			<div class="col-md-12" style="padding:0;">
            	<div class="col-lg-12">
                	<section class="panel" style="">
                    	<header class="panel-heading panel-heading1"><?php
							if($stateId)
							{
								echo 'Edit State';
							}
							else
							{
								echo 'Add State';
							}
							?></header>
						<div class="panel-body" style="line-height:21px;">
                        	<div style="max-width:55%; margin:0 auto; padding-top:20px;">
									<div class="form-group">
										<div class="col-sm-4">
											<label for="countryName" style="float:left; line-height:33px;">Country </label>&nbsp;<span class="error">*</span>
										</div>								
										<div class="col-sm-8 padding_left_zero all-drop-custom">
												<select name="countryId" class="form-control selectpicker show-menu-arrow" data-live-search="true">
														<option value="">Select Country</option>
														<?php 
														if(!empty($result['countryList']))
														{
															foreach($result['countryList'] as $row)
															{
														?>
														<option value="<?php echo $row->countryId; ?>" <?php if($result['countryId']==$row->countryId){ ?> selected="selected" <?php } ?>>
															<?php echo $row->name; ?>
														</option>
														<?php	
															}
														}
														?>
													</select>
												<?php echo form_error('countryId'); ?>
										</div>
									</div>
									<div class="clearfix"></div><br />
									<?php /*?><div class="form-group">
										<div class="col-sm-4"><label for="countryName" style="float:left; line-height:33px;">
											Zone 
										</label>&nbsp;<span class="error">*</span></div>								
										<div class="col-sm-8 padding_left_zero">		
												
												<select name="zoneId" class="form-control">
														<option value="">Select Zone</option>
														<?php 
														if(!empty($result['zoneList']))
														{
															foreach($result['zoneList'] as $row)
															{
														?>
														<option value="<?php echo $row->zoneId; ?>" <?php if((!empty($result['zoneId']))&&($result['zoneId']==$row->zoneId)){ ?> selected="selected" <?php } ?>>
															<?php echo $row->zoneId; ?>
														</option>
														<?php	
															}
														}
														?>
													</select>
													<?php echo form_error('zoneId'); ?>
											</div>
									</div><div class="clearfix"></div><br /><?php */?>
									
									<div class="form-group">
									<div class="col-sm-4"><label for="countryName" style="float:left; line-height:33px;">State Name</label>&nbsp;<span class="error">*</span></div>								
                                	<div class="col-sm-8 padding_left_zero">													
										<input type="text" name="stateName" class="form-control" value="<?php echo $result['stateName']; ?>" />
										<?php echo form_error('stateName'); ?>
                                    </div>
									</div>
									</div>
                                    
									</div>
									<div class="col-sm-12 form-div padding_right_zero">
                                    	<div class="col-sm-12 text-right padding_right_zero">
                                        	<a class="btn btn-danger btn-save" href="<?php echo base_url().$this->session->userdata('userType').'/location_management/state_list_view'; ?>">Cancel</a>
											<input type="submit" class="btn btn-success btn-save" name="submit" value="Save" />
											
                                        </div>
                                    </div>
								</div>
                                
                </section>
				</div>
			</div>
		</div>
		</form>
       </section>
</section>	

<script>
$('.selectpicker').selectpicker();
</script>   
			
