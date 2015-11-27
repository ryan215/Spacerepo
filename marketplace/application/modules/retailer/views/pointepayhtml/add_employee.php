<section id="main-content">
<section class="wrapper">
	<!--contant start-->
	<div class="row">
	<div class="col-md-12">
		<ul class="breadcrumbs-alt animated fadeInLeft">
			
			<li class="">
				<a href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/employee_list" class="">Employee Management</a>
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
			  
			  <header class="panel-heading panel-heading1">Add Employee</header>
				 <div class="panel-body">   
				
					   <center>
					   <div class="details_main">
							<h2>Employee Details</h2>
							<img src="http://10.10.10.9/livemarketplace/images/frontend/user_icon.png" class="img-responsive">  <br>         
							<div class="col-sm-12">
								<div class="img_box">
								<div class="right">
									<input name="image_name" id="hideImage" value="" type="hidden">
                                  
									<div class="ajax-upload-dragdrop" style="vertical-align:top;"><div style="position: relative; overflow: hidden; cursor: default;">
										<span id="imgname">
											<img class="img-circle" src="http://10.10.10.9/livemarketplace/img/on-img.png">											<!--Upload your display image-->
										</span>
									<form style="margin: 0px; padding: 0px;" method="POST" action="http://10.10.10.9/livemarketplace/superadmin/staff_management/upload_admin_image/" enctype="multipart/form-data"><input style="position: absolute; cursor: pointer; top: 0px; width: 110px; height: 110px; left: 0px; z-index: 100; opacity: 0;" class="uImg" id="ajax-upload-id-1434203846417" name="myfile" type="file"></form></div></div><div style="display: none;" id="uploadImage">
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
							<div class="col-lg-6">
								<div class="panel-body" style="line-height:21px;">                               
									<div class="form-group text-left">
                                    <label for="Username" class="">Username</label><span class="error">*</span>
									<div class="iconic-input right">
										
										<input id="Username" placeholder="Username" name="Username" class="form-control" value="" type="text">
										</div>
									</div>
								</div>	
																	
							</div>
							<div class="col-lg-6">
								<div class="panel-body" style="line-height:21px;">                               
									<div class="form-group text-left">
                                    <label for="Salary" class="">Salary</label><span class="error">*</span>
									<div class="input-group">
									 <span class="input-group-addon">&#x20A6;</span>
									<input id="Salary" placeholder="Salary" name="" class="form-control" value="" type="text">
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
							<div style="max-width:95%; margin:0 auto; padding-bottom:40px;" id="user_role">
										<h2>Roles</h2>
											<img src="http://10.10.10.9/livemarketplace/images/role_icon.png" class="img-responsive"><br>
												<div class="col-sm-6" style="margin-bottom:10px;">
													<div class="checkbox c-checkbox pull-left" style="padding-bottom:10px;"><label class=""><input name="roles[]" id="checkbox1" class="check1" value="8" type="checkbox"><span class="fa fa-check"></span> Make A Sale</label>
													</div>
												</div>
												<div class="col-sm-6" style="margin-bottom:10px;">
													<div class="checkbox c-checkbox pull-left" style="padding-bottom:10px;"><label class=""><input name="roles[]" id="checkbox2" class="check1" value="9" type="checkbox"><span class="fa fa-check"></span> Manage Product</label>
													</div>
												</div>
												<div class="col-sm-6" style="margin-bottom:10px;">
													<div class="checkbox c-checkbox pull-left" style="padding-bottom:10px;"><label class=""><input name="roles[]" id="checkbox3" class="check1" value="10" type="checkbox"><span class="fa fa-check"></span> Manage Inventory </label>
													</div>
												</div>
												<div class="col-sm-6" style="margin-bottom:10px;">
													<div class="checkbox c-checkbox pull-left" style="padding-bottom:10px;"><label class=""><input name="roles[]" id="checkbox4" class="check1" value="11" type="checkbox"><span class="fa fa-check"></span> Manage Category</label>
													</div>
												</div>
												<div class="col-sm-6" style="margin-bottom:10px;">
													<div class="checkbox c-checkbox pull-left" style="padding-bottom:10px;"><label class=""><input name="roles[]" id="checkbox5" class="check1" value="12" type="checkbox"><span class="fa fa-check"> </span> Manage Customers </label>
													</div>
												</div>
												<div class="col-sm-6" style="margin-bottom:10px;">
													<div class="checkbox c-checkbox pull-left" style="padding-bottom:10px;"><label class=""><input name="roles[]" id="checkbox6" class="check1" value="17" type="checkbox"><span class="fa fa-check"></span> Manage Discounts </label>
													</div>
												</div>
																								
																						
										
										</div>
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