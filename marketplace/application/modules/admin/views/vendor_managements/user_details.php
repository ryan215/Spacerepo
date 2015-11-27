<style>
/*view user detail*/
.page-header{font-size: 20px;
    margin-top: 15px;
 }
 
.bio-graph-info{font-size:15px;
}

.bio-row{width:80%;
 padding:0;
}


</style>


<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management'; ?>">
							Shipping Vendor List
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">View</a>
					</li>
				</ul>
			</div>
			<div class="clearfix"></div>
        	<div class="col-lg-12">
            	<section class="panel">
					<?php $this->load->view('success_error_message'); ?>    
                	<div class="col-sm-12 panel-heading panel-heading1">Shipping Vendor Detail
					</div><div class="clearfix"></div>
					<div class="row">							
                            <aside class="profile-info col-lg-12"><br />
								<?php
								$imageUrl = base_url().'images/default_user_image.jpg';
								if((!empty($result['imageName']))&&(file_exists('uploads/shipping/thumb50/'.$result['imageName'])))
								{
									$imageUrl = base_url().'uploads/shipping/thumb50/'.$result['imageName'];
								}	
								?>
								
								<aside class="profile-nav col-lg-3">
                            	<section class="panel">
                                	<div class="user-heading round" style="margin-left:10px;">
										<a class="example-image-link" href="javascript:void(0);">
                        					<img src="<?php echo $imageUrl; ?>" class="example-image" />
										</a>
										<h1><?php echo ucwords($result['businessName']); ?></h1>
                                      </div>
                                  </section>
                              </aside>
								<aside class="profile-info col-lg-9">
								
                            	<section class="panel">
                                	<div class="col-sm-12">
										<div class="col-sm-12" style="padding:0 5px;">
                                    		<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/editVendor/'.id_encrypt($organizationId); ?>" class="btn btn-primary pull-right" type="button" style="margin-left:20px;">
												<i class="fa fa-pencil"></i> Edit
											</a>										  
											<?php
											//echo "<pre>"; print_r($result); exit;
											if(!empty($result['shippingRateList']))
											{
												if($result['blockUnblock'])
												{
												?>
													<a href="javascript:void(0);" class="btn btn-success pull-right" type="button" style="margin-left:20px;" onclick="unblock_block(0);">
														UnBlocked
													</a>
												<?php
												}
												else
												{
												?>
													<a href="javascript:void(0);" class="btn btn-danger pull-right" type="button" style="margin-left:20px;" onclick="unblock_block(1);">
														Blocked
													</a>			
												<?php
												}	
											}
											else
											{
											?>
												<a href="javascript:void(0);" class="btn btn-success pull-right" type="button" style="margin-left:20px;" onclick="return first_add_shipp();">
													Activate
												</a>			
											<?php
											}											
											?>
											<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/shipping_rate_list/'.id_encrypt($organizationId); ?>" class="btn btn-warning pull-right" type="button" style="margin-left:20px;">
												Shipping Rates List
											</a>
										</div>
                                      </div>
								</section>
								
								<section class="panel">
                                	<div class="col-sm-12" style="padding:0 20px 0 0;">
                                    	
                                    </div>
						        	<div class="panel-body bio-graph-info">
                                    	
										<table class="table table-invoice table-custom" style="margin-top:12px;">
						                	<thead>
						                    	<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
													Business Information
												</th>
						                    </thead>                    
											<tbody>
 							                   	<tr>
						                        	<td width="35%">Business Name: </td>
						                            <td>
													<?php 
														echo ucwords($result['businessName']); 
													?>
													</td>
                        						</tr>
                        						<tr>
                        							<td width="35%">Business Phone Number: </td>
						                            <td>
														<?php 
															echo $result['businessPhoneCode'].$result['businessPhone']; 
														?>
													</td>
                         						</tr> 												 
											</tbody>
                    					</table>
						            	
										<table class="table table-invoice table-custom" style="margin-top:15px;">
						                	<thead>
						                    	<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
													Personal Information
												</th>
						                    </thead>
                    
											<tbody>
												<tr>
						                        	<td width="35%">First Name: </td>
						                            <td>
													<?php 
														echo $result['firstName']; 	
													?>
													</td>
                        						</tr>
												<tr>
						                        	<td width="35%">Middle Name: </td>
						                            <td>
													<?php 
														echo $result['middleName']; 
													?>
													</td>
                        						</tr>
												<tr>
						                        	<td width="35%">Last Name: </td>
						                            <td>
													<?php 
														echo $result['lastName']; 
													?>
													</td>
                        						</tr>
                        						<tr>
                        							<td width="35%">Email: </td>
						                            <td>
														<?php 
															echo $result['email']; 
														?>
													</td>
                         						</tr> 
											</tbody>
										</table>
									  
										<table class="table table-invoice table-custom" style="margin-top:15px;">
						                	<thead>
						                    	<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
													Address
												</th>
						                    </thead>
                    
											<tbody>
 							                	<tr>
						                        	<td width="35%">Country Name: </td>
						                            <td>
														<?php 
															echo $result['countryName']; 
														?>
													</td>
						                         </tr>
												 
												 <tr>
						                         	<td width="35%">State Name: </td>
						                            <td>
														<?php 
															echo $result['stateName']; 
														?>
													</td>
						                         </tr>
												 
												 <tr>
						                         	<td width="35%">Area Name: </td>
						                            <td>
														<?php 
															echo $result['areaName']; 
														?>
													</td>
						                         </tr>
												 <tr>
						                         	<td width="35%">City Name: </td>
						                            <td>
														<?php 
															echo $result['cityName']; 
														?>
													</td>
						                         </tr>
												 <tr>
						                         	<td width="35%">Street: </td>
						                        <td>
													<?php 
														echo $result['street']; 
													?>
												</td>
						                	</tr>
                      					</tbody>
                    				</table>
									
                            	</div>
                                
                        	</section>
                        </aside>
                     </aside>
                	</div>
            	</section>
        	</div>
        </div>
    	<!--contant end-->
	</section>
</section>
<!--main content end-->
<script language="javascript" type="application/javascript">
function unblock_block(status)
{
	msg = 'Are you sure that you want to block this user?';
	
	if(status)
	{
		msg = 'Are you sure that you want to unblock this user?';
	}
	redirect = "<?php echo base_url().$this->session->userdata('userType').'/vendor_management/unblock_block/'.id_encrypt($organizationId).'/'.id_encrypt($result['employeeId']); ?>/"+status	
	confirm_box(redirect,msg);	
}

function delete_rate(shippRateId)
{
	msg = 'Are you sure that you want to delete this rate?';
	redirect = "<?php echo base_url().$this->session->userdata('userType').'/vendor_management/delete_rate/'.id_encrypt($organizationId); ?>/"+shippRateId;
	confirm_box(redirect,msg);	
}

function first_add_shipp()
{
	swal({title: 'Kindly add atleast one shipping rate',});	
}

function alert_activate()
{
	msg = 'Are you sure that you want to Activated this user?';
	redirect = "<?php echo base_url().$this->session->userdata('userType').'/vendor_management/activate_user/'.id_encrypt($organizationId); ?>";
	confirm_box(redirect,msg);	
}
</script>