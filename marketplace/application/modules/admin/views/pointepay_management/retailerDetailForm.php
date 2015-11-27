<link href="<?php echo base_url(); ?>css/retailer/intlTelInput.css" / rel="stylesheet">
<link href="<?php echo base_url();?>css/admin/pp_custom.css" rel="stylesheet">
<section id="main-content">
 <section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url();?>admin/pointepay_management/retailerList">
							Retailer List
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">Add</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
				<section class="panel">
						<header class="panel-heading panel-heading1">Add Details</header>
					    <div class="panel-body">
							 <?php echo form_open();?>
							 <?php	$data = array(
              'phoneno'  => $result['phoneno']
            
            );

echo form_hidden($data); ?>
									<center><div class="pp_retailer_sec">
									<h2>User Details</h2>
									<img src="<?php echo base_url();?>images/frontend/user_icon.png" class="img-responsive"><br><br>
									<div class="col-lg-6">
										  <label class="signup-labels pull-left" for="business_name" >BUSINESS NAME</label> <span class="error pull-left">*</span>
										  <div class="clearfix"></div>
										  <div class="form-group">
											  <input type="text" name="businessName" id="organizationName" class="form-control" placeholder="Enter  business name" value="<?php echo $result['businessName'];?>">
										   <?php echo form_error('businessName'); ?>
										   </div>
									</div>
									<div class="col-lg-6">
										  <label class="signup-labels pull-left" for="FirstName" >First Name</label> <span class="error pull-left">*</span>
										  <div class="clearfix"></div>
										  <div class="form-group">
											  <input type="text" name="firstName" id="firstName" class="form-control" placeholder="Enter  first name" value="<?php echo $result['firstName'];?>">
										   <?php echo form_error('firstName'); ?>
										   </div>
									</div>
									<div class="col-lg-6">
										  <label class="signup-labels pull-left" for="MiddleName" >Middle Name</label>
										  <div class="clearfix"></div>
										  <div class="form-group">
											  <input type="text" name="middleName" id="middleName" class="form-control" placeholder="Enter  middle name" value="<?php echo $result['middleName'];?>">
										   <?php echo form_error('middleName'); ?>
										   </div>
									</div>
									<div class="col-lg-6">
										  <label class="signup-labels pull-left" for="LastName" >Last Name</label> <span class="error pull-left">*</span>
										  <div class="clearfix"></div>
										  <div class="form-group">
											  <input type="text" name="lastName" id="LastName" class="form-control" placeholder="Enter  last name" value="<?php echo $result['lastName'];?>">
										   <?php echo form_error('lastName'); ?>
										   </div>
									</div>
									<div class="col-lg-6">
										  <label class="signup-labels pull-left" for="Email" >Email</label>
										  <div class="clearfix"></div>
										  <div class="form-group">
											  <input type="text" name="email" id="Email" class="form-control" placeholder="Enter  email id" value="<?php echo $result['email'];?>">
											<?php echo form_error('email'); ?>
										</div>
									</div>
									
									<div class="col-lg-6">
									
										  <label class="signup-labels pull-left" for="state" >State NAME</label> <span class="error pull-left">*</span>
										  <div class="clearfix"></div>
										<div class="form-group">										     
											 <div class="iconic-input right">
											  <div id="stateList">
												<select name="stateId" id="stateId" class="form-control form-control1 selectpicker show-menu-arrow" data-live-search="true">
													<option value="">Select State</option>
												</select>
											</div>
						
											<?php echo form_error('stateId'); ?>
											</div>
											
										</div>
									</div>
									
									<div class="col-lg-6">
										  <label class="signup-labels pull-left" for="area" >AREA NAME</label> <span class="error pull-left">*</span>
										  <div class="clearfix"></div>
										  <div class="form-group">
										  <div class="iconic-input right">
											<div id="areaList">
											  <select name="areaId" class="form-control form-control1 selectpicker show-menu-arrow" style="width:100%;">
												<option value="">Select Area</option>
											  </select>
											</div>
											<?php echo form_error('areaId'); ?>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										  <label class="signup-labels pull-left" for="city" >City NAME</label> <span class="error pull-left">*</span>
										  <div class="clearfix"></div>
										   <div class="form-group">
											  <div class="iconic-input right">
												<div id="cityList">
												  <select name="cityId" class="form-control form-control1 selectpicker show-menu-arrow" style="width:100%;">
													<option value="">Select City</option>
												  </select>
												</div>
												<?php echo form_error('cityId'); ?> </div>
											</div>
									</div>
									<div class="col-lg-12">
										  <label class="signup-labels pull-left" for="streetaddress" >Street Address</label> <span class="error pull-left">*</span>
										  <div class="clearfix"></div>
										  <div class="form-group">
											  	<textarea class="form-control" name="street" id="streetaddress"><?php echo $result['street'];?></textarea>
												<?php echo form_error('street');?>
										   </div>
									</div>
									</div>
									
									<div class="col-sm-12" style="padding-bottom:20px;">
									  <center>
										<a class="btn btn-danger btn-save" href="<?php echo base_url();?>admin/pointepay_management/searchRetailer"> Cancel </a>&nbsp;&nbsp;
										<button type="submit" class="btn btn-success btn-save">Submit</button>
									  </center>
									</div>
									</center>
							  </form>
						</div>
				</section>
			</div>
						 
					  
					</section>				
        </div>
    	<!--contant end-->
	</section>
</section>
<!--main content end--> 
<?php $this->load->view('location_in_js'); ?>
<script>
$('.selectpicker').selectpicker({  style: 'btn-default' });
</script>
<script src="<?php echo base_url(); ?>js/retailer/intlTelInput.js"></script>
