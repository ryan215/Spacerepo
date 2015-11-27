<section id="main-content">
<section class="wrapper">
	<!--contant start-->
	<div class="row">
	<div class="col-md-12">
		<ul class="breadcrumbs-alt animated fadeInLeft">
			
			<li class="">
				<a href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/product_list" class="">Product Management</a>
			</li>
			<li class="">
				<a href="javascript:void(0);" class="current">Add</a>
			</li>
		</ul>
	</div>
	<div class="col-lg-12">
	<section class="panel">
		<section class="panel custom-panel">
			
		   <div class="col-lg-12 padding_left_zero padding_right_zero">
		  <!--widget start-->
<?php 
echo form_open();
?>                                                                                           			  <section class="panel">
			  
			  <header class="panel-heading panel-heading1">Add Product</header>
				 <div class="panel-body">   
				
					   <center>
					   <div class="details_main">
							<h2>Product Details</h2>
							<!--<img src="<?php //echo base_url(); ?>images/frontend/user_icon.png" class="img-responsive">-->  <br>         
							<div class="col-sm-12">
								<div class="img_box">
								<div class="right">
									<input name="image_name" id="hideImage" value="" type="hidden">
                                  
									<div class="ajax-upload-dragdrop" style="vertical-align:top;"><div style="position: relative; overflow: hidden; cursor: default;">
										<span id="imgname">
											<img class="img-circle" src="<?php echo base_url(); ?>img/on-img.png">											<!--Upload your display image-->
										</span>
										<?php 
$attributes = array('style' => 'margin: 0px; padding: 0px;');
echo form_open_multipart(base_url().'superadmin/staff_management/upload_admin_image/',$attributes);
?>

									<input style="position: absolute; cursor: pointer; top: 0px; width: 110px; height: 110px; left: 0px; z-index: 100; opacity: 0;" class="uImg" id="ajax-upload-id-1434203846417" name="myfile" type="file"></form></div></div><div style="display: none;" id="uploadImage">
										<span id="imgname">
											<img class="img-circle" src="<?php echo base_url(); ?>img/on-img.png">											<!--Upload your display image-->
										</span>
									</div><div></div>
								</div>
								</div>
							</div>
							<div class="col-lg-12 pd">
                            	<div class="col-lg-6">
								<div class="panel-body" style="line-height:21px;">                               
									<div class="form-group text-left">
										<label for="Category" class="">Category</label> <span class="error">*</span>
										<div class="iconic-input right">
											<select class="form-control  selectpicker show-menu-arrow" data-live-search="true"><option>Demo</option><option>Demo1</option></select>
										</div>
									</div>
								</div>	
								</div>
                                <div class="col-lg-6">
								<div class="panel-body" style="line-height:21px;">                               
									<div class="form-group text-left">
                                    <label for="ProductName" class="">Product Name</label><span class="error">*</span>
									<div class="iconic-input right">
										<input id="ProductName" placeholder="Product Name" name="ProductName" class="form-control" value="" type="text"> 
										</div>
									</div>
								</div>																
							</div>
                            </div>							
							<div class="col-lg-6">
								<div class="panel-body" style="line-height:21px;">                               
									<div class="form-group text-left">
                                    <label for="upc" class="">UPC</label><span class="error">*</span>
									<div class="iconic-input right">										
										<input id="upc" placeholder="UPC" name="upc" class="form-control" value="" type="text">
										</div>
									</div>
								</div>	
																	
							</div>
							<div class="col-lg-6">
								<div class="panel-body" style="line-height:21px;">                               
									<div class="form-group text-left">
                                    <label for="CostPrice" class="">Cost Price</label><span class="error">*</span>
									<div class="input-group">
									 <span class="input-group-addon">&#x20A6;</span>
									<input id="CostPrice" placeholder="Cost Price" name="" class="form-control" value="" type="text">
      								</div>
									</div>
								</div>	
																	
							</div>
							<div class="col-lg-6">
								<div class="panel-body" style="line-height:21px;">                               
									<div class="form-group text-left">
                                    <label for="SalePrice" class="">Sale Price</label><span class="error">*</span>
									<div class="input-group">
									 <span class="input-group-addon">&#x20A6;</span>
									<input id="SalePrice" placeholder="Sale Price" name="" class="form-control" value="" type="text">
      								</div>
									</div>
								</div>	
																	
							</div>
							<div class="col-lg-6">
								<div class="panel-body" style="line-height:21px;">                               
									<div class="form-group text-left">
                                    <label for="Description" class="">Description</label><span class="error">*</span>
									<textarea class="form-control" placeholder="Description"></textarea>
									</div>
								</div>	
																	
							</div>
							
							
							
							<div class="clearfix"></div>
							
							</div>
						  </center></div>
						  <br><br>
						  <div class="col-sm-12 ">
							<center><a class="btn btn-danger btn-save" href="#">Cancel</a>&nbsp;&nbsp;
							<button class="btn btn-success btn-save">Save</button></center>
						</div>
							
				 </section></form></div>
			  </section>
		  <!--widget end-->                             
			</section></div>
		</div></section>
	</section>
<link href="<?php echo base_url(); ?>css/admin/custom_admin.css" type="text/css" rel="stylesheet" />	
<script>
$('.selectpicker').selectpicker();	
</script>