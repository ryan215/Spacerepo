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
						<a href="<?php echo base_url().$this->session->userdata('userType').'/news_management'; ?>">
							NewsLetter List
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
                	<div class="col-sm-12 panel-heading panel-heading1">NewsLetter Detail
					</div><div class="clearfix"></div>
					<div class="row">							
						 <aside class="profile-info col-lg-12">
								<section class="panel">
                                	
						        	<div class="panel-body bio-graph-info">
                                    	
										<table class="table table-invoice table-custom" style="margin-top:12px;">
						                	<thead>
						                    	<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
													Personal Information
												</th>
						                    </thead>                    
											<tbody>
 							                   	<tr>
						                        	<td width="35%">First Name : </td>
						                            <td>
													<?php 
														echo ucwords($result['firstName']); 
													?>
													</td>
                        						</tr>
                        						<tr>
                        							<td width="35%">Last Name : </td>
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
                        							<td width="35%">Phone No. : </td>
						                            <td>
														<?php 
															echo $result['phoneCode'].$result['phone'];
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
												
                      					</tbody>
                    				</table>
									
									<?php
												if(!empty($result['subscribeList']))
												{
												?>
									<table class="table table-invoice table-custom" style="margin-top:15px;">
						                	<thead>
						                    	<th colspan="3" style="background-color:#A9D86E; color:#FFF;">
													Refer Freind List
												</th>
						                    </thead>
                    
											<tbody>
											<tr>
						                    	<td><strong>Name</strong></td>
						                        <td><strong>Email</strong></td>
												<td><strong>Status</strong></td>
						                    </tr>
												<?php
													foreach($result['subscribeList'] as $row)
													{
											?>
											<tr>
												<td><?php echo $row->name; ?></td>
												<td><?php echo $row->subscription_email; ?></td>
												<td>
													<?php
													if($row->verified)
													{
														echo 'Verified';
													}
													else
													{
														echo 'Unverified';
													}
													?>
												</td>
											</tr>
											<?php		
													}
												
												?>
 							               </tbody>
                    				</table>
									<?php
									}
									?>
                            	</div>
                        	</section>
							 </aside>
                	</div>
            	</section>
        	</div>
        </div>
    	<!--contant end-->
	</section>
</section>
<!--main content end-->