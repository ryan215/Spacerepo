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
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/cse_management'; ?>">
							CSE Managment
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">View</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
					<?php $this->load->view('success_error_message'); ?>    
                	<div class="col-sm-12 page-header">CSE Detail
					</div>
					<div class="row">							
                            <aside class="profile-info col-lg-12">
								<?php
								$imageUrl = base_url().'images/default_user_image.jpg';
								if((!empty($result['imageName']))&&(file_exists('uploads/cse/thumb50/'.$result['imageName'])))
								{
									$imageUrl = base_url().'uploads/cse/thumb50/'.$result['imageName'];
								}	
								?>
								
								<aside class="profile-nav col-lg-3">
                            	<section class="panel">
                                	<div class="user-heading round" style="margin-left:10px;">
										<a class="example-image-link" data-lightbox="example-1" href="<?php echo $imageUrl; ?>">
                        					<img src="<?php echo $imageUrl; ?>" class="example-image" />
										</a>
										<h1><?php echo ucwords($result['firstName'].' '.$result['middleName'].' '.$result['lastName']); ?></h1>
                                      </div>
                                  </section>
                              </aside>
								<aside class="profile-info col-lg-9">
								
                            	<section class="panel">
                                	<div class="col-sm-12">
										<div class="col-sm-12">
                                    		<a href="<?php echo base_url().$this->session->userdata('userType').'/cse_management/editCse/'.id_encrypt($employeeId); ?>" class="btn btn-primary pull-right" type="button" style="margin-left:20px;">
											<i class="fa fa-pencil"></i> Edit
											</a>
										  
											<?php
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
										?>
										</div>
                                      </div>
								</section>
								
								<section class="panel">
						        	<div class="panel-body bio-graph-info">
																            	
										<table class="table table-invoice table-custom" style="margin-top:15px;">
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
                        							<td width="35%">Date Of Birth : </td>
						                            <td>
														<?php 
															$date = date_create($result['birthDay']);
															echo date_format($date,"d M");
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
                      					</tbody>
                    				</table>
									
<table class="table table-invoice table-custom" style="margin-top:15px;">
	<thead>
		<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
			Retailer Lists
		</th>
	</thead>
    <tbody>
		<?php
		if(!empty($result['retailerList']))
		{
			$i = 1;
			foreach($result['retailerList'] as $row)
			{
		?>
			<tr>
				<td width="35%">Retailer<?php echo $i; ?> : </td>
				<td><?php echo $row->organizationName; ?></td>
			</tr>
		<?php
				$i++;
			}
		}
		?>
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
	redirect = "<?php echo base_url().$this->session->userdata('userType'); ?>/cse_management/unblock_block/<?php echo id_encrypt($employeeId); ?>/"+status	
	confirm_box(redirect,msg);	
}
</script>