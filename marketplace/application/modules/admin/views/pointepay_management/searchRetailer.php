	<link href="<?php echo base_url();?>css/admin/pp_custom.css" rel="stylesheet">
<section id="main-content">
 <section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().'admin/pointepay_management/retailerList';?>">
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
									<center><div class="pp_retailer_sec">
									<h2>User Details</h2>
									<img src="<?php echo base_url();?>images/frontend/user_icon.png" class="img-responsive"><br><br>
									<div class="col-lg-12">
										  <label class="signup-labels pull-left" for="phoneno" >Phone No.</label> <span class="error pull-left">*</span>
										  <div class="clearfix"></div>
										  <div class="form-group">
											  <input type="text"   name="phoneno" id="phoneno" class="form-control" placeholder="Enter your phone number">
										   <?php echo form_error('phoneno');?>
										   </div>
									</div>
									</div>
									
									<div class="col-sm-12" style="padding-bottom:20px;">
									  <center>
										<a class="btn btn-danger btn-save" href="<?php echo base_url();?>admin/pointepay_management/retailerList"> Cancel </a>&nbsp;&nbsp;
										<button type="submit" class="btn btn-success btn-save">Next</button>
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