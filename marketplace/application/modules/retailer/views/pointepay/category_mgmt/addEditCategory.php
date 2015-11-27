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
<link href="<?php echo base_url() ?>css/admin/custom_admin.css" type="text/css" rel="stylesheet" />
<?php echo $this->load->view('upload_image_in_js'); ?>
<section id="main-content">
	<section class="wrapper">
    	<div class="row">
        	<div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/category_Mgmt/category_listing'; ?>">
							Category List
						</a>
					</li>
                    <li><a href="javascript:void(0);" class="current">
					<?php
					if($catId)
					{
						echo 'Edit ';
					}
					else
					{
						echo 'Add ';
					}
					?>
					Category
					</a></li>
				</ul>
			</div>
        </div>
		<?php 
echo form_open();
?>                                                                                           
		<div class="row">
			<div class="col-md-12" style="padding:0;">
            	<div class="col-lg-12">
                	<section class="panel">
                    	<header class="panel-heading panel-heading1">Add  Category</header>
						<div class="panel-body" style="line-height:21px;">
                        	<div  class="all-form-with">
									<div class="form-group">
									<div id="uploadImage">
														<span id="imgname">
															<?php
															$image = '<img class="img-circle" src="'.base_url().'img/on-img.png" >';		
															echo $image;
															?>
															<!--Upload your display image-->
														</span>
									</div>
									<input type="hidden" id="hideImage" name="categoryimage" value="<?php echo $imageName; ?>">
									</div>
									<div class="form-group">
										<div class="col-sm-5 col-lg-4 pd">
											<label for="countryName" style="float:left; line-height:33px;">Category</label>&nbsp;<span class="error">*</span>
										</div>	
										<div class="col-sm-8 col-sm-7 padding_left_zero pd">
											  <input type="text" class="form-control model-input" placeholder="Category Name" name="categoryCode" value="<?php echo $categoryCode;?>">
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-5 col-lg-4 pd">
											<label for="countryName" style="float:left; line-height:33px;">Description</label>
										</div>	
                                	<div class="col-sm-8 col-sm-7 padding_left_zero pd">
                                        	<textarea class="form-control" name="categoryDescription" placeholder="Description"><?php echo $categoryDescription; ?></textarea>
									</div>
									</div>
							</div>
                            </div>
									<div class="col-sm-12 form-div padding_right_zero">
                                    	<div class="col-sm-12 text-right padding_right_zero">
                                        	<a class="btn btn-danger btn-save" href="">Cancel</a>
											<button class="btn btn-success btn-save">Save</button>
                                        </div>
                                    </div>
								</section></div>
                                
                </div></div></form>
		
       </section>
</section>	   
			
			<style>
	   label{ background-image:none !Important}
	   .form-group {
		  margin-bottom: 15px;
		  display: inline-block;
		  width: 100%;
		}
	   </style>
