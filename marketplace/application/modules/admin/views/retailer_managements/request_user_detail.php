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

.decline-reason-text{margin-left:5px;
	margin-top:5px;
	width:70%;
	margin-bottom:4px;
}
.accept_dropdown{
	  margin-left: 5px;
  margin-top: 5px;
  width: 70%;
  margin-bottom: 4px;
}
</style>


<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li> <a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management'; ?>">Retailer List</a> </li>
		    		<li> <a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management/request_list'; ?>">Request List</a> </li>
		 		
					<li>
						<a href="javascript:void(0);" class="current">View</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
					<?php $this->load->view('success_error_message'); ?>    
                	<div class="col-sm-12 panel-heading panel-heading1">Retailer Detail
					</div>
					<div class="row">							
                            <aside class="profile-info col-lg-12"><br />
								<?php
								$imageUrl = base_url().'images/default_user_image.jpg';
								if((!empty($result['imageName']))&&(file_exists('uploads/retailer/thumb50/'.$result['imageName'])))
								{
									$imageUrl = base_url().'uploads/retailer/thumb50/'.$result['imageName'];
								}	
								?>
								
								<aside class="profile-nav col-lg-3">
                            	<section class="panel">
                                	<div class="user-heading round" style="margin-left:10px;">
										
											<img class="tag-img-pp-pm" src="<?php echo base_url();?>images/pointmart-tag.png" />	
										
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
											
                                    		<a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management/editRetailerRequest/'.id_encrypt($organizationId); ?>" class="btn btn-primary pull-right" type="button" style="margin-left:20px;">
												<i class="fa fa-pencil"></i> Edit
											</a>										  
											<?php
											/*if($result['blockUnblock'])
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
											}		*/	
											
											
											if($this->session->userdata('userType')=='admin')
											{
											?>	
												<a class="btn btn-warning" type="button" href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management/request_assign_cse/'.id_encrypt($organizationId); ?>">
													Account Owner
												</a>
											<?php
											}
											?>
											<a class="btn btn-success" type="button" href="javascript:void(0);" id="acptBtn">
												Accept
											</a>
											<a class="btn btn-danger" type="button" href="javascript:void(0);" id="declBtn">
												Decline
											</a>
										</div>
										<div id="dropShip" style="display:none;" class="col-sm-6 pd">
											<?php /*	<form method="post" action="<?php echo base_url().$this->session->userdata('userType').'/retailer_management/accept_request/'.id_encrypt($organizationId); ?>">*/?>
												<?php echo form_open(base_url().$this->session->userdata('userType').'/retailer_management/accept_request/'.id_encrypt($organizationId));?>
													<select name="dropship" class="form-control accept_dropdown">
                                                    	<?php
														if(!empty($result['dropshipCentreList']))
														{
															foreach($result['dropshipCentreList'] as $row)
															{
														?>
                                                        <option value="<?php echo $row->dropCenterId; ?>">
                                                        	<?php echo $row->dropCenterName; ?>
                                                        </option>
                                                        <?php		
															}
														}
														else
														{
														?>
                                                        <option value="">No Dropship Center Available</option>
														<?php
														}
														?>
													</select>
													<?php echo form_error('dropship'); ?>
													<input type="submit" name="addDropShip" value="Submit" class="btn btn-primary" style="margin-left:5px;" />
												</form>
											</div>
											<div id="reasonBox" style="display:none;" class="col-sm-6 pd">
												<?php echo form_open();?>
													
													<textarea name="comment" class="decline-reason-text form-control" placeholder="Reason"><?php echo $reason; ?></textarea>
													<?php echo form_error('comment'); ?>
													<input type="submit" name="submit" value="Submit" class="btn btn-primary" style="margin-left:5px;" />
												</form>
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
function unblock_block(status)
{
	msg = 'Are you sure want to block this user ?';
	
	if(status)
	{
		msg = 'Are you sure want to unblock this user ?';
	}
	redirect = "<?php echo base_url().$this->session->userdata('userType').'/retailer_management/unblock_block/'.id_encrypt($result['employeeId']); ?>/"+status	
	confirm_box(redirect,msg);	
}

function accept_request()
{
	msg = 'Are you sure want to Accept this user ?';
	redirect = "<?php echo base_url().$this->session->userdata('userType').'/retailer_management/accept_request/'.id_encrypt($organizationId); ?>";
	//alert(redirect);
	confirm_box(redirect,msg);	
}

$(document).ready(function(){
	$('#declBtn').click(function(){
		$('#reasonBox').slideToggle();
		$('#dropShip').slideUp();
	});
	<?php 
	if(form_error('comment'))
	{
	?>
		$('#reasonBox').slideToggle();
	<?php
	}
	?>
	
	$('#acptBtn').click(function(){
		$('#dropShip').slideToggle();
		$('#reasonBox').slideUp();
	});
	<?php 
	if(form_error('dropship'))
	{
	?>
		$('#dropShip').slideToggle();
	<?php
	}
	?>
});


</script>