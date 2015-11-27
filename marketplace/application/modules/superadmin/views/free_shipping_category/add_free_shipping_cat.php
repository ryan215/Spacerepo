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
						<a href="<?php echo base_url().'superadmin/free_shipping_category'; ?>">
							Free Shipping Category Management
						</a>
					</li>
                    <li><a href="javascript:void(0);" class="current">Add</a></li>
				</ul>
			</div>
        </div>
<?php 
echo form_open();
?>                                                                                           			<div class="row">
				<div class="col-md-12" style="padding:0;">
            		<div class="col-lg-12">
                		<section class="panel" style="">
								<?php $this->load->view('success_error_message'); ?> 
                    		<header class="panel-heading panel-heading1">Add Free Shipping Category</header>
							<div class="panel-body" style="line-height:21px;">
                        		<div style="" class="all-form-with">
									<div class="form-group">
                            			<div class="col-sm-5 col-lg-5 pd">
											<label for="countryName" style="float:left; line-height:33px;">
												Select Category Level1
											</label>
										</div>	
                                		<div class="col-sm-7 col-sm-7 padding_left_zero pd">
											<select class="form-control" name="level1" onchange="cat_list(this.value,2);">
												<option value="">Select Category</option>
												<?php
												if(!empty($result['catList']))
												{
													foreach($result['catList'] as $row)
													{
												?>
												<option value="<?php echo $row->categoryId; ?>">
													<?php echo $row->categoryCode; ?>
												</option>
												<?php													
													}
												}
												else
												{
												?>
												<option value="">
													No Data Found
												</option>	
												<?php
												}
												?>												
											</select>
											<?php echo form_error('level1'); ?>
                                        </div>
										
										<div id="level2">
											
                                        </div>
									</div>
								</div>
                            </div>
							<div class="col-sm-12 form-div padding_right_zero">
                            	<div class="col-sm-12 text-right padding_right_zero">
                                	<a class="btn btn-danger btn-save" href="<?php echo base_url().'superadmin/free_shipping_category'; ?>">
										Cancel
									</a>
									<button class="btn btn-success btn-save">Save</button>
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
function cat_list(catId,nextLevel) 
{
	$.ajax({
    	type: "POST",
        url: '<?php echo base_url().$this->session->userdata('userType'); ?>/category_management/level_category_list/'+catId+'/'+nextLevel,
        beforeSend: function () {
        	$('#level'+nextLevel).html('<?php echo $this->loader; ?>');
        },
        success: function(result) {
        	$('#level'+nextLevel).html(result);
        }
	});
}
</script>