<link rel="stylesheet" href="<?php echo base_url(); ?>css/lightbox/lightbox.css">
<script src="<?php echo base_url(); ?>js/lightbox/lightbox.js"></script>
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
						<a href="<?php echo base_url().$this->session->userdata('userType').'/employee_management'; ?>">
							Shipping Employee List
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">View</a>
					</li>
				</ul>
			</div><div class="clearfix"></div>
        	<div class="col-lg-12">
            	<section class="panel">
					<?php $this->load->view('success_error_message'); ?>    
                	<div class="col-sm-12 panel-heading panel-heading1">Shipping Employee Detail
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
										<a class="example-image-link" data-lightbox="example-1" href="<?php echo $imageUrl; ?>">
                        					<img src="<?php echo $imageUrl; ?>" class="example-image" />
										</a>
										
                                      </div>
                                  </section>
                              </aside>
								<aside class="profile-info col-lg-9">
								
                            	<section class="panel">
                                	<div class="col-sm-12">
										<div class="col-sm-12" style="padding:0 5px;">
                                    		<a href="<?php echo base_url().$this->session->userdata('userType').'/employee_management/editVendor/'.id_encrypt($organizationId); ?>" class="btn btn-primary pull-right" type="button" style="margin-left:20px;">
												<i class="fa fa-pencil"></i> Edit
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
						                        	<td width="35%"> Name: </td>
						                            <td>
													<?php 
														echo ucwords($result['firstName'].' '.$result['middleName']. ' '.$result['lastName']); 
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
												<tr>
                        							<td width="35%">Drop ship Center: </td>
						                            <td>
														<?php 
														//print_r($result['dropshipCentre']);
														if(isset($result['dropshipCentre']) && (!empty($result['dropshipCentre'])))
														{
															
															foreach($result['dropshipCentre'] as $dropshipCentre)
															{
																echo $dropshipCentre->dropCenterName .',';
															}
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
                             <?php
									if(!empty($result['shippingRateList']))
									{
									?>
<table class="table table-invoice table-customm" style="margin-top:5px;">
	<thead>
		<tr>
			<th width="1%">S. No</th>
			<th width="3%">Dropship centre</th>
			<th width="5%">States Covered</th>
			<th width="5%">Areas Covered</th>
			<th width="5%">Cities Covered</th>
			<th width="5%">Weight From (in KG)</th>
			<th width="5%">Weight To (in KG)</th>
			<th width="4%">Price</th>
			<th width="5%">ETA (in Days)</th>
			<!--<th width="1%">Edit</th>-->
			<th width="1%">Delete</th>
		</tr>
	</thead>
	<?php
	$i = 1;
	foreach($result['shippingRateList'] as $row)
	{
	?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><?php 
		if($row->fromZip==1)
		{
			echo 'NEW BENIN1';
		}
		elseif($row->fromZip==2)
		{
			echo 'IKOTA1';
		}
		elseif($row->fromZip==3)
		{
			echo 'IKEJA1';
		}
		elseif($row->fromZip==4)
		{
			echo 'OJUELEGBA1';
		}
		elseif($row->fromZip==5)
		{
			echo 'OREGUN';
		}
		elseif($row->fromZip==6)
		{
			echo 'ADESUWA1';
		}
		
		?></td>
		<td>
			<?php echo $row->stateName; ?>
		</td>
		<td>
			<?php echo $row->areaName; ?>
		</td>
		<td>
			<?php echo $row->cityName; ?>
		</td>
		<td>
			<?php echo $row->fromWeight; ?>
		</td>
		<td>
			<?php echo $row->toWeight; ?>
		</td>
		<td>
			&#x20A6;<?php echo number_format($row->amount,2); ?>
		</td>
		<td><?php echo $row->ETA; ?></td>
		<td>
		<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/edit_rate/'.id_encrypt($row->shippingRateId); ?>" class="btn btn-info btn-xs" type="button">
			<I class="fa fa-pencil"></I>
		</a>	
		<a href="javascript:void(0);" class="btn btn-danger btn-xs" type="button" onclick="return delete_rate('<?php echo id_encrypt($row->shippingRateId); ?>');">
			<i class="fa fa-trash-o"></i>
		</a>
	</td>
	</tr>									
	<?php	
		$i++;
	}
	?>
	<tbody>
	</tbody>
</table>
									<?php
									}
									?>
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