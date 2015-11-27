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
						<a href="<?php echo base_url().$this->session->userdata('userType').'/customer_management'; ?>">
							Customer List
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">
							Customer View
						</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel" style="width:100%;  display: inline-block;">
					<?php $this->load->view('success_error_message'); ?>    
                	<div class="col-sm-12 panel-heading panel-heading1" style="height:48px;">
						Customer Detail
					</div>
					<div class="row">							
                    	<aside class="profile-info col-lg-12" style="display: inline-flex;  padding-top: 20px;"><br />
							<aside class="profile-info col-lg-9">
								<section class="panel">
                                	<div class="col-sm-12">
										<div class="col-sm-12" style="padding:0 5px;">
											<?php
											if(((!empty($result['isBlock']))&&($result['isBlock']))&&((empty($result['blockDate']))||($result['blockDate']!=date('Y-m-d'))))
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
											
											if((!empty($result['isBlackList']))&&($result['isBlackList']))
											{
											?>
												<a href="javascript:void(0);" class="btn btn-success pull-right" type="button" style="margin-left:20px;" onclick="in_black_list(0);">
													In Black List
												</a>
											<?php
											}
											else
											{
											?>
												<a href="javascript:void(0);" class="btn btn-danger pull-right" type="button" style="margin-left:20px;" onclick="in_black_list(1);">
													Not In Black List
												</a>			
											<?php
											}			
											?>
											<a href="<?php echo base_url().$this->session->userdata('userType').'/customer_management/order_list/'.id_encrypt($customerId); ?>" class="btn btn-success pull-right" type="button" style="margin-left:20px;">
												Order List
											</a>
										</div>
                                      </div>
								</section>
								<section class="panel">
                                	<div class="col-sm-12" style="padding:0 20px 0 0;"></div>
						        	<div class="panel-body bio-graph-info">
                                    	<table class="table table-invoice table-custom" style="margin-top:12px;">
						                	<thead>
						                    	<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
													Customer Information
												</th>
						                    </thead>                    
											<tbody>
 							                   	<tr>
						                        	<td width="35%">First Name : </td>
						                            <td><?php echo ucfirst($result['firstName']); ?></td>
                        						</tr>
                        						<tr>
                        							<td width="35%">Last Name : </td>
						                            <td><?php echo ucfirst($result['lastName']); ?></td>
                         						</tr> 
												 
												<tr>
                        							<td width="35%">Email : </td>
						                            <td><?php echo $result['email']; ?></td>
                         						</tr>   
												<tr>
                        							<td width="35%">Phone No. : </td>
						                            <td><?php echo $result['phone']; ?></td>
                         						</tr>
												<tr>
                        							<td width="35%">Verify Status : </td>
						                            <td>
														<?php 
														if($result['verified'])
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
												<tr>
                        							<td width="35%">Block Status : </td>
						                            <td>
														<?php 
														if($result['isBlock'])
														{
															echo 'UnBlocked';
														}
														else
														{
															echo 'Blocked';
														}
														?>
													</td>
                         						</tr>
												<tr>
                        							<td width="35%">In Black List : </td>
						                            <td>
														<?php 
														if($result['isBlackList'])
														{
															echo 'Yes';
														}
														else
														{
															echo 'No';
														}
														?>
													</td>
                         						</tr>                         						
											</tbody>
                    					</table>
						            	
										<table class="table table-invoice table-custom" style="margin-top:15px;">
						                	<thead>
						                    	<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
													Address Information
												</th>
						                    </thead>
                    
											<tbody>
												<tr>
						                        	<td width="35%">State Name : </td>
						                            <td><?php echo $result['stateName']; ?></td>
                        						</tr>
 							                   	<tr>
						                        	<td width="35%">Area Name : </td>
						                            <td><?php echo $result['areaName']; ?></td>
                        						</tr>
												<tr>
						                        	<td width="35%">City Name: </td>
						                            <td><?php echo $result['cityName']; ?></td>
                        						</tr>
												<tr>
						                        	<td width="35%">Address: </td>
						                            <td><?php echo $result['addressLine1']; ?></td>
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
	redirect = "<?php echo base_url().$this->session->userdata('userType').'/customer_management/unblock_block/'.id_encrypt($customerId); ?>/"+status	
	confirm_box(redirect,msg);	
}

function in_black_list(status)
{
	msg = 'Are you sure that you want to remove this user from black list?';
	
	if(status)
	{
		msg = 'Are you sure that you want to add this user in black list?';
	}
	redirect = "<?php echo base_url().$this->session->userdata('userType').'/customer_management/in_black_list/'.id_encrypt($customerId); ?>/"+status	
	confirm_box(redirect,msg);	
}
</script>