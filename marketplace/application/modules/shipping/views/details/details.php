<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<!--contant start-->
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="javascript:void(0);" class="current">Details</a>
					</li>
				</ul>
			</div>
			
			<div class="col-lg-12">
				<section class="panel">
					<div class="col-lg-12" style="padding:10px 5px 10px 25px;">
						<a href="<?php echo base_url().'shipping_vendor/edit_details'; ?>" class="btn btn-success">
							Edit
						</a>	
					</div>
					
					<div style="padding-top:20px;">								
						<section>
							<div class="row">							
								<aside class="profile-info col-lg-12">
									<aside class="profile-info col-lg-6">			    
										<section class="panel">
											<div class="panel-body bio-graph-info">
												<table class="table table-invoice table-custom">
													<thead>
														<tr>
															<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
																Personal Details 
															</th>
														</tr>
													</thead>                    
													
													<tbody>
														<tr>
															<td width="35%">First Name : </td>
															<td><?php echo $result['first_name']; ?></td>
														</tr>
														<tr>
															<td width="35%">last Name : </td>
															<td><?php echo $result['last_name']; ?></td>
														</tr> 
														<tr>
															<td width="35%">Email : </td>
															<td><?php echo $result['email']; ?></td>
														</tr>
														<tr>
															<td width="35%">POC Phone Number : </td>
															<td><?php echo $result['phone_no']; ?></td>
														</tr>
													</tbody>
												</table>
											</div>
										</section>
									</aside>
									
									<aside class="profile-info col-lg-6">
										<section class="panel">
											<div class="col-sm-12">
												<table class="table table-invoice table-custom" style="margin-top:20px;">
													<thead>
														<tr>
															<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
																Business  details 
															</th>
														</tr>
													</thead>                    
													<tbody>
														<tr>
															<td width="25%">Business Name : </td>
															<td><?php echo $result['bussiness_name']; ?></td>
														</tr>
														<tr>
															<td width="35%">Corporate Address : </td>
															<td><?php echo $result['street']; ?></td>
														</tr> 
														<tr>
															<td width="35%">Corporate Phone Number : </td>
															<td><?php echo $result['business_ph_no']; ?></td>
														</tr>
													</tbody>
												</table>
											</div>
										</section>									
									</aside>
									
									<aside class="profile-info col-lg-12">
										<section class="panel">
											<div class="panel-body">
												<table class="table table-invoice table-custom">
													<thead>
														<tr>
															<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
																Location Details 
															</th>
														</tr>
													</thead>                    
													<tbody>
														<tr>
															<td width="18%">Country : </td>
															<td>Nigeria</td>
														</tr>
														
														<tr>
															<td width="20%">State : </td>
															<td>
																<?php
																if(!empty($result['statesList']))
																{
																	foreach($result['statesList'] as $val)
																	{
																?>
																<span class="location_box">
																	<?php echo $val; ?>
																</span>	
																<?php
																	}
																}
																?>
															</td>
														</tr> 
														
														<tr>
															<td width="20%">Zone : </td>
															<td>
																<?php
																if(!empty($result['citiesList']))
																{
																	foreach($result['citiesList'] as $val)
																	{
																?>
																<span class="location_box">
																	<?php echo $val; ?>
																</span>	
																<?php
																	}
																}
																?>
															</td>
														</tr>
														
														<tr>
															<td width="20%">Area : </td>
															<td>
																<?php
																if(!empty($result['zonesList']))
																{
																	foreach($result['zonesList'] as $val)
																	{
																?>
																<span class="location_box">
																	<?php echo $val; ?>
																</span>	
																<?php
																	}
																}
																?>
															</td>
														</tr>
														
														<tr>
															<td width="20%">Area : </td>
															<td>
																<?php
																if(!empty($result['areasList']))
																{
																	foreach($result['areasList'] as $val)
																	{
																?>
																<span class="location_box">
																	<?php echo $val; ?>
																</span>	
																<?php
																	}
																}
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
				</section>
			</div>
		</div>		
	</section>
</section>		
<!--main content end-->