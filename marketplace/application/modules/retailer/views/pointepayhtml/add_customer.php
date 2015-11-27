<section id="main-content">
<section class="wrapper">
	<!--contant start-->
	<div class="row">
	<div class="col-md-12">
		<ul class="breadcrumbs-alt animated fadeInLeft">
			
			<li class="">
				<a href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/customer_list" class="">Customer Management</a>
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
			  
			  <header class="panel-heading panel-heading1">Add Customer</header>
				 <div class="panel-body">   
				
					   <center>
					   <div class="details_main">
							<h2>Customer Details</h2>
							<img src="http://10.10.10.9/livemarketplace/images/frontend/user_icon.png" class="img-responsive">  <br>         
							<div class="col-sm-12">
								<div class="img_box">
								<div class="right">
									<input name="image_name" id="hideImage" value="" type="hidden">
                                  
									<div class="ajax-upload-dragdrop" style="vertical-align:top;"><div style="position: relative; overflow: hidden; cursor: default;">
										<span id="imgname">
											<img class="img-circle" src="http://10.10.10.9/livemarketplace/img/on-img.png">											<!--Upload your display image-->
										</span>
									<?php 
$attributes = array('style' => 'margin: 0px; padding: 0px;','enctype' => 'multipart/form-data');
echo form_open('http://10.10.10.9/livemarketplace/superadmin/staff_management/upload_admin_image/',$attributes);
?>
<input style="position: absolute; cursor: pointer; top: 0px; width: 110px; height: 110px; left: 0px; z-index: 100; opacity: 0;" class="uImg" id="ajax-upload-id-1434203846417" name="myfile" type="file"></form></div></div><div style="display: none;" id="uploadImage">
										<span id="imgname">
											<img class="img-circle" src="http://10.10.10.9/livemarketplace/img/on-img.png">											<!--Upload your display image-->
										</span>
									</div><div></div>
								</div>
								</div>
							</div>
							<div class="col-lg-12 pd">
                            	<div class="col-lg-6">
								<div class="panel-body" style="line-height:21px;">                               
									<div class="form-group text-left">
                                    	
										<label for="FirstName" class="">First Name</label> <span class="error">*</span>
										<div class="iconic-input right">
										
										<input id="FirstName" placeholder="First Name" name="first_name" class="form-control" value="" type="text">
										</div>
									</div>
								</div>	
									                                </div>
                                <div class="col-lg-6">
								<div class="panel-body" style="line-height:21px;">                               
									<div class="form-group text-left">
                                    <label for="LastName" class="">Last Name</label><span class="error">*</span>
									<div class="iconic-input right">
										
										<input id="LastName" placeholder="Last Name" name="last_name" class="form-control" value="" type="text"> 
										</div>
									</div>
								</div>	
																
							</div>
                            </div>							
							<div class="col-lg-6">
								<div class="panel-body" style="line-height:21px;">                               
									<div class="form-group text-left">
                                    <label for="email" class="">Email</label><span class="error">*</span>
									<div class="iconic-input right">
										
										<input id="email" placeholder="Email" name="email" class="form-control" value="" type="text">
										</div>
									</div>
								</div>	
																	
							</div>
							<div class="col-lg-6">
								<div class="panel-body" style="line-height:21px;">                               
									<div class="form-group text-left">
                                    <label for="PhoneNo" class="">Phone No.</label><span class="error">*</span>
									<div class="iconic-input right">
										
										<input id="PhoneNo" placeholder="Phone No." name="" class="form-control" value="" type="text">
										</div>
									</div>
								</div>	
																	
							</div>
							
							
							<div class="clearfix"></div>
							<h2>Address Details</h2>
							<img src="http://10.10.10.9/livemarketplace/images/frontend/location_icon.png" class="img-responsive">                                      					
							<div class="col-lg-6">
											<div class="panel-body" style="line-height:21px;">                               
												<div class="form-group text-left">
												<label for="State" class="">State</label><span class="error">*</span>
												<div class="iconic-input right all-drop-custom" id="stateAjaxID">
													
													<select class="form-control  selectpicker show-menu-arrow" data-live-search="true"><option>State</option></select> 
												</div>
												</div>
											</div>													
										</div>
							<div class="col-lg-6">
											<div class="panel-body" style="line-height:21px;">                               
												<div class="form-group text-left">
                                                <label for="country" class="">Area</label><span class="error">*</span>
												<div class="iconic-input right all-drop-custom">
													
													<select  class="form-control selectpicker show-menu-arrow" id="Area" name="Area" data-live-search="true" onchange="search_state(this.value)">
													<option value="">Select Area</option>
													</select> 
												</div>
												</div>
											</div>													
										</div>
							<div class="col-lg-6">
											<div class="panel-body" style="line-height:21px;">                               
												<div class="form-group text-left">
                                                <label for="country" class="">City</label><span class="error">*</span>
												<div class="iconic-input right all-drop-custom">
													
													<select  class="form-control form-control1 selectpicker show-menu-arrow" id="City" name="City" data-live-search="true" onchange="search_state(this.value)">
													<option value="">Select City</option>
													</select> 
												</div>
												</div>
											</div>													
										</div>
							<div class="col-lg-6">
											<div class="panel-body" style="line-height:21px;">                               
												<div class="form-group text-left">
                                                <label for="country" class="">Street</label>
												<div class="iconic-input right all-drop-custom">
													<input id="street" placeholder="Street" name="street" class="form-control" value="" type="text">
													
												</div>
												</div>
											</div>													
										</div>
							<div class="clearfix"></div>
							
							</div>
						  </center></div>
						  <br><br>
						  <div class="col-sm-12 ">
							<center><a class="btn btn-danger btn-save" href="">Cancel</a>&nbsp;&nbsp;
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