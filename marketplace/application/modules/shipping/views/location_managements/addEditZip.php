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
						<a href="<?php echo base_url().$this->session->userdata('userType').'/location_management/zip_list_view'; ?>">Zip List</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">
							<?php
							if($zipId)
							{
								echo 'Edit Zip';
							}
							else
							{
								echo 'Add Zip';
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
							if($zipId)
							{
								echo 'Edit';
							}
							else
							{
								echo 'Add';
							}
							?> Area</header>
				<div class="panel-body" style="line-height:21px;">
                	<div style="max-width:52%; margin:0 auto; padding-top:20px;">
						<div class="form-group">
							<div class="col-sm-4">
								<label for="countryName" style="float:left; line-height:33px; margin-right:2px;">
									Country
								</label> <span class="error">*</span>
							</div>								
							<div class="col-sm-8 padding_left_zero all-drop-custom">
								<select name="countryId" class="form-control selectpicker show-menu-arrow" onchange="state_list(this.value)" data-live-search="true">
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
						
						<div class="form-group">
							<div class="col-sm-4">
								<label for="countryName" style="float:left; line-height:33px; margin-right:2px;">
									State
								</label> <span class="error">*</span>
							</div>								
							<div class="col-sm-8 padding_left_zero all-drop-custom">
								<div id="stateList">
									<select name="stateId" id="stateId" class="form-control selectpicker show-menu-arrow" data-live-search="true">
										<option value="">Select State</option>
									</select>
								</div>
								<?php echo form_error('stateId'); ?>
							</div>
						</div>
						<div class="clearfix"></div><br />
						<div class="form-group">
							<div class="col-sm-4"><label for="countryName" style="float:left; line-height:33px; margin-right:10px;">
								Area
							</label></div>								
							<div class="col-sm-8 padding_left_zero">
								<div id="areaList">
								<select name="areaId"  class="form-control selectpicker show-menu-arrow" data-live-search="true">
									<option value="">Select Area</option>
								</select>
								</div>
								<?php echo form_error('areaId'); ?>
							</div>
						</div>
						<div class="clearfix"></div><br />
						
						<div class="form-group">
							<div class="col-sm-4"><label for="countryName" style="float:left; line-height:33px; margin-right:2px;">City Name</label> <span class="error">*</span></div>								
                            <div class="col-sm-8 padding_left_zero">													
								<input type="text" name="cityName" class="form-control" value="<?php echo $result['cityName']; ?>" />
								<?php echo form_error('cityName'); ?>
							</div>
									</div>
									<?php /*?><div class="clearfix"></div><br />
									<div class="form-group">
									<div class="col-sm-4"><label for="countryName" style="float:left; line-height:33px; margin-right:10px;">Zip Code</label></div>								
                                	<div class="col-sm-8 padding_left_zero">													
										<input type="text" name="zipCode" class="form-control" value="<?php echo $result['zipCode']; ?>" />
										<?php echo form_error('zipCode'); ?>
                                    </div>
									</div><?php */?>
									</div>
                                    
									</div>
									<div class="col-sm-12 form-div padding_right_zero">
                                    	<div class="col-sm-12 text-right padding_right_zero">
                                        	<a class="btn btn-danger btn-save" href="<?php echo base_url().$this->session->userdata('userType').'/location_management/zip_list_view'; ?>">Cancel</a>
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
<script type="text/javascript">			
function state_list(countryId)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/location_management/stateCountryList'; ?>',
		data:'countryId='+countryId+'&stateId=<?php echo $result['stateId']; ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#stateList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#stateList').html(result);	
			area_list($('#stateId').val());			
		}
	});
}

function area_list(stateId)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/location_management/areaStateList'; ?>',
		data:'stateId='+stateId+'&areaId=<?php echo $result['areaId']; ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#areaList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#areaList').html(result);				
		}
	});
}

<?php
if(!empty($result['countryId']))
{
?>
state_list('<?php echo $result['countryId']; ?>');
<?php
}
?>
</script>

<script>
	$('.selectpicker').selectpicker();
	
</script>