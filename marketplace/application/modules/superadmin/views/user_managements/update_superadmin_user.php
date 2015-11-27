<link href="<?php echo base_url() ?>css/admin/custom_admin.css" type="text/css" rel="stylesheet" />
<?php echo $this->load->view('upload_image_in_js'); ?>
<section id="main-content">
<section class="wrapper">
	<!--contant start-->
	<div class="row">
	<div class="col-md-12">
		<ul class="breadcrumbs-alt animated fadeInLeft">
					<li class="">
				<a href="<?php echo base_url(); ?>superadmin/user_management/" class="">User Managment</a>
			</li>
			<li class="">
				<a href="<?php echo base_url(); ?>superadmin/user_management/user_detail/<?php echo id_encrypt($employeeId); ?>" class="">User Detail</a>
			</li>
			<li class="">
				<a href="javascript:void(0);" class="current">Update Superadmin</a>
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
?>                                                                                           		  
			  <section class="panel">
			  
			  <header class="panel-heading panel-heading1">Update Detail</header>
				 <div class="panel-body" >   
				
					   <center>
					   <div class="details_main">
							<h2>User Details</h2>
							<img src="<?php echo base_url(); ?>images/frontend/user_icon.png" class="img-responsive">  <br />         					<input type="hidden" name="image_name" id="hideImage" value="<?php echo $result['imageName']; ?>" />
							<div class="col-sm-12">
								<div class="img_box">
								<div class="right">
									
									<input type="hidden" name="image_name" id="hideImage" value="<?php echo set_value('image_name'); ?>" />
                                  
									<div id="uploadImage">
										<span id="imgname">
											<?php
											$image = '<img class="img-circle" src="'.base_url().'img/on-img.png" >';		
											echo $image;
											?>
											<!--Upload your display image-->
										</span>
									</div>
								</div>
								</div>
								<?php echo form_error('image_name');?>
							</div>
							<div class="col-lg-12 pd">
                            	<div class="col-lg-6">
								<div class="panel-body" style="line-height:21px;">                               
									<div class="form-group text-left">
                                    	
										<label for="FirstName" class="">First Name</label> <span class="error">*</span>
										<div class="iconic-input right">
										
										<input type="text" id="FirstName" placeholder="First Name" name="first_name" class="form-control" value="<?php echo $result['firstName']; ?>">
										</div>
									</div>
								</div>	
									<?php echo form_error('first_name');?>
                                </div>
                                <div class="col-lg-6">
                                    <div class="panel-body" style="line-height:21px;">                            
                                        <div class="form-group text-left">
                                        <label for="MiddleName" class="">Middle Name</label>   
										<div class="iconic-input right">
										<input type="text" id="MiddleName" placeholder="Middle Name" name="middle_name" class="form-control" value="<?php echo $result['middleName']; ?>">
                                        </div>
                                        </div>
                                    </div>		
                                    <?php echo form_error('middle_name');?>								
                                </div>
                            </div>
							<div class="col-lg-6">
								<div class="panel-body" style="line-height:21px;">                               
									<div class="form-group text-left">
                                    <label for="LastName" class="">Last Name</label><span class="error">*</span>
									<div class="iconic-input right">
										<input type="text" id="LastName" placeholder="Last Name" name="last_name" class="form-control" value="<?php echo $result['lastName']; ?>"> 
										</div>
									</div>
								</div>	
							<?php echo form_error('last_name');
							$date = explode('-',$result['birthDay']);
							?>									
							</div>
							<div class="clearfix"></div>
							<h2>DOB Details</h2>
							<img src="<?php echo base_url(); ?>images/dob_icon.png" class="img-responsive"> 
							<div class="col-lg-6">
								<div class="panel-body" style="line-height:21px;">    
								<div class="form-group">                           
									<div class="form-group">
										
										<div class="iconic-input right">
										<label for="Date" class="pull-left">Date</label>
										<select class="form-control form-control1 selectpicker show-menu-arrow" data-live-search="true" id="date" name="date">
										
										<option value="" >
														Date</option><?php 
										for($i=1;$i<=31;$i++)
												{
												?>
													<option value="<?php echo $i; ?>"  <?php if($date[2]==$i){ echo 'selected="selected"';} ?> >
														<?php echo $i; ?>
													</option>	
												<?php
												}													
												?>
										</select>
										</div>
										</div>
								</div>
								</div>
							</div>			
							<div class="col-lg-6">
								<div class="panel-body" style="line-height:21px;">  
										<div class="iconic-input right">
										<?php $calender   = cal_info(0);
											$month_list = $calender['months'];?>
										<label for="Month" class="pull-left">Month</label>
										<select class="form-control form-control1 selectpicker show-menu-arrow" name="month" id="Month" data-live-search="true">
											<option value="" >
														Month</option>
											<?php
											for($i=1;$i<=12;$i++)
											{
											?>
												<option value="<?php echo $i; ?>" <?php if($date[1]==$i){ echo 'selected="selected"';} ?>>
													<?php echo $month_list[$i]; ?>
												</option>
											<?php
											}
											?>
										</select>
										</div>
										</div>
										
									</div>
										<h2>Address Details</h2>
										<img src="<?php echo base_url(); ?>images/frontend/location_icon.png" class="img-responsive">                                      					
										<div class="col-lg-6">
											<div class="panel-body" style="line-height:21px;">                               
												<div class="form-group text-left">
                                                <label for="country" class="">State</label>
												<div class="iconic-input right">
													
													<select class="form-control selectpicker" data-live-search="true" name="stateId" onchange="area_list(this.value);">
														<option value="">State</option>
														<?php 
														if(!empty($result['stateList']))
														{
															foreach($result['stateList'] as $row)
															{
														?>
														<option value="<?php echo $row->stateId; ?>" <?php if($result['stateId']==$row->stateId){ ?> selected="selected" <?php } ?>>
															<?php echo $row->stateName; ?>
														</option>
														<?php	
															}
														}
														?>
													</select>
												</div>
											</div>
										</div>													
									</div>
										
										<div class="col-lg-6">
											<div class="panel-body" style="line-height:21px;">                               
												<div class="form-group text-left">
												<label for="State" class="">Area</label>
												<div id="areaList">
													  <select name="areaId" class="form-control form-control1 selectpicker show-menu-arrow" style="width:100%;">
														<option value="">Select Area</option>
													  </select>
													</div>
													<?php echo form_error('areaId'); ?>
												</div>
											</div>													
										</div>
									<div class="clearfix"></div>
                                          
	</div>
	</div>
	</center><br /><br />
	<div class="col-sm-12 ">
		<center>
		<a class="btn btn-danger btn-save" href="<?php echo base_url().'superadmin/user_management/user_detail/'.id_encrypt($employeeId); ?>">Cancel</a>
		&nbsp;&nbsp;
		<button class="btn btn-success btn-save">Save</button></center>
	</div>
	</form>
	</div>
	</section>
		  <!--widget end-->                             
			</div>
		</section>
	</section>
	</div>
	</div>
	<!--contant end-->
</section>
</section>
<script>
$('.selectpicker').selectpicker();

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
			city_list($('#areaId').val());		
		}
	});
}

<?php
if($result['stateId'])
{
?>
area_list('<?php echo $result['stateId']; ?>');
<?php
}
?>
$( document ).ajaxComplete(function() {
	$('.selectpicker').selectpicker();
});
</script>
<style>
.ajax-upload-dragdrop{/* width:78% !Important;*/ padding:0px !Important; width:100px !important; text-align:center;}

.upload-statusbar{border:0; 
}

.upload-red {font-size:12px; padding:3px 15px;
}

.ajax-upload-dragdrop input{padding-left:0 !important;
	padding-right:0 !important;
	height:100px !important;
}

.ajax-upload-dragdrop  .upload-statusbar{margin-left:-120px !important;
}

.browse-star{ color: #ff6c60;
    font-size: 6px;
    line-height: 18px;
	margin-bottom: -8px;
    margin-right: -80px;
}
input[type=radio] { display:block !Important;}

</style>