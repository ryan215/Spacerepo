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
/*end of user detail page*/
</style>


<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
        	<div class="col-lg-12">
			
            	<section class="panel">
					<?php 
					$this->load->view('success_error_message'); 
					$this->load->view('last_update_view'); 
					?> 
                	<div class="col-sm-12 page-header">Profile Detail
					</div>
					<?php
					$imageUrl   = base_url().'images/default_user_image.jpg';
					$image_name = $users_details->image;
					if((!empty($image_name))&&(file_exists('uploads/retailer/thumb50/'.$image_name)))
					{
						$imageUrl = base_url().'uploads/retailer/thumb50/'.$image_name;
					}
					?>
						<div class="row">							
                            <aside class="profile-info col-lg-12">
								<section class="panel">
									<?php /*?><div class="col-sm-6">
										<a class="example-image-link" data-lightbox="example-1" href="<?php echo $imageUrl; ?>">
                        					<img src="<?php echo $imageUrl; ?>" class="example-image" />
										</a>
									</div><?php */?>
                            		<div class="col-sm-12">
                                		<a href="<?php echo base_url('retailer/profile/edit_profile');?>" class="btn btn-primary" type="button" data-toggle="modal" >
											Edit
										</a>
									</div>
								</section>
								
								<section class="panel">
								
						        	<div class="panel-body bio-graph-info">
										<table class="table table-invoice table-custom" style="margin-top:15px;">
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
														echo ucwords($users_details->first_name).' '.$users_details->last_name; 
													?>
													</td>
                        						</tr>
                        						<tr>
                        							<td width="35%">Business Phone Number : </td>
						                            <td>
														<?php 
															echo $users_details->business_ph_no; 
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
						                        	<td width="35%">Business Owner Name : </td>
						                            <td>
													<?php 
														echo ucwords($users_details->business_owner_name); 
													?>
													</td>
                        						</tr>
												<tr>
						                        	<td width="35%">Phone Number : </td>
						                            <td>
													<?php 
														echo $users_details->phone_no; 
													?>
													</td>
                        						</tr>
                        						<tr>
                        							<td width="35%">Email : </td>
						                            <td>
														<?php 
															echo $users_details->email; 
														?>
													</td>
                         						</tr>
												<tr>
                        							<td width="35%">Bank Name : </td>
						                            <td>
														<?php 
															echo $users_details->bank_name; 
														?>
													</td>
                         						</tr>
												<tr>
                        							<td width="35%">Account Name : </td>
						                            <td>
														<?php 
															echo $users_details->account_name; 
														?>
													</td>
                         						</tr>
												<tr>
                        							<td width="35%">Account Number : </td>
						                            <td>
														<?php 
															echo $users_details->account_number; 
														?>
													</td>
                         						</tr>
												<tr>
                        							<td width="35%">Branch Address : </td>
						                            <td>
														<?php 
															echo $users_details->branch_address; 
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
															echo $users_details->country_name; 
														?>
													</td>
						                         </tr>
												 
												 <tr>
						                         	<td width="35%">State Name : </td>
						                            <td>
														<?php 
															echo $users_details->state_name; 
														?>
													</td>
						                         </tr>
												 
												 <tr>
						                         	<td width="35%">Zone Name : </td>
						                            <td>
														<?php 
															echo $users_details->city_name; 
														?>
													</td>
						                         </tr>
												 
												  <tr>
						                         	<td width="35%">Area Name : </td>
						                            <td>
														<?php 
															echo $users_details->zone_name; 
														?>
													</td>
						                         </tr>
												 
												 <tr>
						                         	<td width="35%">Area : </td>
						                            <td>
														<?php 
															echo $users_details->area_name; 
														?>
													</td>
						                         </tr>
												 
												 <tr>
						                         	<td width="35%">Street : </td>
						                        <td>
													<?php 
														echo $users_details->street; 
													?>
												</td>
						                	</tr>
                      					</tbody>
                    				</table>
                                    <table class="table table-invoice table-custom" style="margin-top:15px;">
						                	<thead>
						                    	<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
													comment
												</th>
						                    </thead>
                                            <tbody>
                                            <tr>
                                            <td>
                                            <?php 
														echo $users_details->comment; 
													?>
                                            </td>
                                            </tr>
                                            </tbody>
                                            </table>
                    				
                            	</div>
                        	</section>
						
        	</div>
        </div>
    	<!--contant end-->
	</section>
</section>
<!--main content end-->


