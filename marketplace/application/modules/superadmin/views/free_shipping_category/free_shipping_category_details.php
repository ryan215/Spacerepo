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
                    <li><a href="javascript:void(0);" class="current">Details</a></li>
				</ul>
			</div>
        </div>
			<div class="row">
				<div class="col-md-12" style="padding:0;">
            		<div class="col-lg-12">
                		<section class="panel" style="">
                    		<header class="panel-heading panel-heading1">Free Shipping Category Details</header>
							<div class="panel-body" style="line-height:21px;">
                        		<div style="" class="all-form-with">
									<div class="form-group">
										<?php
										if($result['catList'])
										{											
											foreach($result['catList'] as $key=>$value)
											{
										?>
										<div class="col-sm-5 col-lg-5 pd">
											<label for="countryName" style="float:left; line-height:33px;">
												Category Level<?php echo $key; ?> =>
											</label>
										</div>
										<div class="col-sm-7 col-sm-7 padding_left_zero pd">
											<p style="line-height: 30px;"><?php echo $value['categoryCode']; ?></p>
										</div><div class="clearfix"></div>
										<?php
											}
										}
										?>                           				
									</div>
								</div>
                            </div>
						</div>
                    </section>
				</div>
			</div>
		</div>
	</section>
</section>	   