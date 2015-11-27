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
						<a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management'; ?>">
							Retailer List
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">View</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel" style="width:100%;  display: inline-block;">
					<?php $this->load->view('success_error_message'); ?>    
                	<div class="col-sm-12 panel-heading panel-heading1" style="height:48px;">Retailer Detail
					</div>
					<div class="row">							
                            <aside class="profile-info col-lg-12" style="  display: inline-flex;  padding-top: 20px;"><br />
								<?php
								//echo "<pre>"; print_r($result); exit;
								$imageUrl = base_url().'images/default_user_image.jpg';
								if((!empty($result['imageName']))&&(file_exists('uploads/retailer/thumb50/'.$result['imageName'])))
								{
									$imageUrl = base_url().'uploads/retailer/thumb50/'.$result['imageName'];
								}	
								?>
								
								<aside class="profile-nav col-lg-3 col-md-3">
                            	<section class="panel">
                                	<div class="user-heading round" style="margin-left:10px;">
										<?php 
										if(($result['isPointeMart'])&&($result['isPointePay']))
										{
										?>
											<img class="tag-img-pp-pm" src="<?php echo base_url();?>images/pp-pm-both.png" />
										<?php
										}
										elseif($result['isPointeMart'])
										{
										?>
											<img class="tag-img-pp-pm" src="<?php echo base_url();?>images/pointmart-tag.png" />	
										<?php
										}
										elseif($result['isPointePay'])
										{
										?>
											<img class="tag-img-pp-pm" src="<?php echo base_url();?>images/pointepay-tag.png" />
										<?php
										}
										?>
										<a class="example-image-link" data-lightbox="example-1" href="<?php echo $imageUrl; ?>">
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
											<?php
											//echo "<pre>"; print_r($result); exit;
										/*if(($result['requestStatus']==0)||($result['requestStatus']==2)||($result['requestStatus']==3))
										{
											if(($this->session->userdata('userType')=='cse')||($this->session->userdata('userType')=='superadmin')||($this->session->userdata('userType')=='admin'))
											{	
												if(($result['blockUnblock'])&&(($result['dropshipCentre']==1)||($result['dropshipCentre']==2)||($result['dropshipCentre']==3)||($result['dropshipCentre']==4)||($result['dropshipCentre']==5)||($result['dropshipCentre']==6)))
												{
												?>												
												<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/check_stocks/'.id_encrypt($organizationId); ?>" class="btn btn-info pull-left">
													Inventory
												</a> &nbsp;   &nbsp;                                      
												<?php
												}																							
											}
											?>
                                    		<a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management/editRetailer/'.id_encrypt($organizationId); ?>" class="btn btn-primary pull-right" type="button" style="margin-left:20px;">
												<i class="fa fa-pencil"></i> Edit
											</a>										  
											<?php
											if(($result['blockUnblock'])&&(($result['dropshipCentre']==1)||($result['dropshipCentre']==2)||($result['dropshipCentre']==3)||($result['dropshipCentre']==4)||($result['dropshipCentre']==5)||($result['dropshipCentre']==6)))
											{
												
											?>
												<a href="javascript:void(0);" class="btn btn-success pull-right" type="button" style="margin-left:20px;" onclick="unblock_block(0);">
													UnBlocked
												</a>
											<?php
											}
											else
											{
												if(($result['dropshipCentre']==1)||($result['dropshipCentre']==2)||($result['dropshipCentre']==3)||($result['dropshipCentre']==4)||($result['dropshipCentre']==5)||($result['dropshipCentre']==6))
												{
											?>
												<a href="javascript:void(0);" class="btn btn-danger pull-right" type="button" style="margin-left:20px;" onclick="unblock_block(1);">
													Blocked
												</a>			
											<?php
												}
												else
												{
												?>
												<a href="javascript:void(0);" class="btn btn-danger pull-right" type="button" style="margin-left:20px;" onclick="dropship();">
													Blocked
												</a>			
											<?php	
												}
											}			
											
											if($this->session->userdata('userType')=='admin')
											{
												
												?>
													<a class="btn btn-warning" type="button" href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management/assign_cse/'.id_encrypt($organizationId); ?>">
													Account Owner
												 </a>
												
												<?php											
											}
										}*/
										if(($result['requestStatus']==0)||($result['requestStatus']==2)||($result['requestStatus']==3))
										{
											if(($this->session->userdata('userType')=='cse')||($this->session->userdata('userType')=='superadmin')||($this->session->userdata('userType')=='admin'))
											{
												if((!empty($result['blockUnblock']))&&($result['blockUnblock'])&&(!empty($result['dropshipCentre']))&&($result['dropshipCentre']))
												{
												?>												
												<a href="<?php echo base_url().$this->session->userdata('userType').'/check_stock_management/check_stock_list/'.id_encrypt($organizationId); ?>" class="btn btn-info pull-left">
													Inventory
												</a> &nbsp;   &nbsp;                                      
												<?php
												}																							
											}
											?>
                                    		<a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management/editRetailer/'.id_encrypt($organizationId); ?>" class="btn btn-primary pull-right" type="button" style="margin-left:20px;">
												<i class="fa fa-pencil"></i> Edit
											</a>										  
											<?php
											if((!empty($result['blockUnblock']))&&($result['blockUnblock'])&&(!empty($result['dropshipCentre']))&&($result['dropshipCentre']))
											{
												
											?>
												<a href="javascript:void(0);" class="btn btn-success pull-right" type="button" style="margin-left:20px;" onclick="unblock_block(0);">
													UnBlocked
												</a>
											<?php
											}
											else
											{
												if((!empty($result['dropshipCentre']))&&($result['dropshipCentre']))
												{
											?>
												<a href="javascript:void(0);" class="btn btn-danger pull-right" type="button" style="margin-left:20px;" onclick="unblock_block(1);">
													Blocked
												</a>			
											<?php
												}
												else
												{
												?>
												<a href="javascript:void(0);" class="btn btn-danger pull-right" type="button" style="margin-left:20px;" onclick="dropship();">
													Blocked
												</a>			
											<?php	
												}
											}			
											
											if($this->session->userdata('userType')=='admin')
											{
												
												?>
													<a class="btn btn-warning" type="button" href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management/assign_cse/'.id_encrypt($organizationId); ?>">
													Account Owner
												 </a>
												
												<?php											
											}
										}
											?>
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
						                        	<td width="35%">Business Name : </td>
						                            <td>
													<?php 
														echo ucwords($result['businessName']); 
													?>
													</td>
                        						</tr>
                        						<tr>
                        							<td width="35%">Business Phone Number : </td>
						                            <td>
														<?php 
															echo $result['businessPhone']; 
														?>
													</td>
                         						</tr> 
												<?php 
												if(($result['isPointeMart'])&&($result['isPointePay']))
												{
												?>
												<tr>
                        							<td width="35%">Account Owner : </td>
						                            <td>
														<?php 
															echo $result['cseName'];
														?>
													</td>
                         						</tr>
												<?php
												}
												elseif($result['isPointeMart'])
												{
												?>
												<tr>
                        							<td width="35%">Account Owner : </td>
						                            <td>
														<?php 
															echo $result['cseName'];
														?>
													</td>
                         						</tr>
												<?php
												}
												?>
												 
												<tr>
                        							<td width="35%">Organization Type : </td>
						                            <td>
														<?php 
															echo $result['organizationType'];
														?>
													</td>
                         						</tr>   
												<tr>
                        							<td width="35%">Dropship Centre : </td>
						                            <td>
														<?php 
														if($result['dropshipCentre']==1)
														{
															echo 'NEW BENIN1';
														}
														elseif($result['dropshipCentre']==2)
														{
															echo 'IKOTA1';
														}
														elseif($result['dropshipCentre']==3)
														{
															echo 'IKEJA1';
														}
														elseif($result['dropshipCentre']==4)
														{
															echo 'OJUELEGBA1';
														}
														elseif($result['dropshipCentre']==5)
														{
															echo 'OREGUN';
														}
														elseif($result['dropshipCentre']==6)
														{
															echo 'ADESUWA1';
														}
														elseif($result['dropshipCentre']==7)
														{
															echo 'ABUJA';
														}
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
						                        	<td width="35%">User Name : </td>
						                            <td>
													<?php 
														echo $result['userName']; 	
													?>
													</td>
                        						</tr>
 							                   	<tr>
						                        	<td width="35%">First Name : </td>
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
                        							<td width="35%">Email : </td>
						                            <td>
														<?php 
															echo $result['email']; 
														?>
													</td>
                         						</tr> 
												<tr>
                        							<td width="35%">Platform : </td>
						                            <td>
														<?php 
														if(($result['isPointeMart'])&&($result['isPointePay']))
														{
															echo 'PointeMart & PointePay';
														}
														elseif($result['isPointeMart'])
														{
															echo 'PointeMart';
														}
														elseif($result['isPointePay'])
														{
															echo 'PointePay';	
														}
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
						                        	<td width="35%">Country Name : </td>
						                            <td>
														<?php 
															echo $result['countryName']; 
														?>
													</td>
						                         </tr>
												 
												 <tr>
						                         	<td width="35%">State Name : </td>
						                            <td>
														<?php 
															echo $result['stateName']; 
														?>
													</td>
						                         </tr>
												 
												 <tr>
						                         	<td width="35%">Area Name : </td>
						                            <td>
														<?php 
															echo $result['areaName']; 
														?>
													</td>
						                         </tr>
												 <tr>
						                         	<td width="35%">City Name : </td>
						                            <td>
														<?php 
															echo $result['cityName']; 
														?>
													</td>
						                         </tr>
												 <tr>
						                         	<td width="35%">Street : </td>
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
function dropship()
{
	swal({title: 'Pleas first allocate Dropship Center',});	
}

function unblock_block(status)
{
	msg = 'Are you sure that you want to block this user?';
	
	if(status)
	{
		msg = 'Are you sure that you want to unblock this user?';
	}
	redirect = "<?php echo base_url().$this->session->userdata('userType').'/retailer_management/unblock_block/'.id_encrypt($organizationId).'/'.id_encrypt($result['employeeId']); ?>/"+status	
	confirm_box(redirect,msg);	
}
</script>