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
						<a href="<?php echo base_url().$this->session->userdata('userType').'/pointeforce_management'; ?>">
							Pointe Force List
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">
							Pointe Force View
						</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel" style="width:100%;  display: inline-block;">
					<?php $this->load->view('success_error_message'); ?>    
                	<div class="col-sm-12 panel-heading panel-heading1" style="height:48px;">
						Pointeforce member Details
					</div>
					<div class="row">							
                    	<aside class="profile-info col-lg-12" style="display: inline-flex;  padding-top: 20px;"><br />
							<aside class="profile-info col-lg-9">
								<section class="panel">
                                	<div class="col-sm-12">
										<div class="col-sm-12" style="padding:0 5px;">
											<?php
											if((!empty($result['verifiedCommision']))&&($result['verifiedCommision']))
											{
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
											}
											else
											{
											?>
												<a href="javascript:void(0);" class="btn btn-danger pull-right" type="button" style="margin-left:20px;" onclick="verified_commission();" title="Click to accept the request to Verify">
													Unverified Request
												</a>			
											<?php
											}			
											?>											
										</div>
                                      </div>
								</section>
								<section class="panel">
                                	<div class="col-sm-12" style="padding:0 20px 0 0;"></div>
						        	<div class="panel-body bio-graph-info">
                                    	<table class="table table-invoice table-custom" style="margin-top:12px;">
						                	<thead>
						                    	<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
													Pointe Force Information
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
                         						</tr>												                         					</tbody>
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
function verified_commission()
{	
	swal({   
	title: '',   
	text: 'Are you sure that you want to Verified this user?',
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Yes",   
	cancelButtonText: "No",   
	closeOnConfirm: false,   
	closeOnCancel: false 
	}, 
	function(isConfirm){   
		if (isConfirm) 
		{     
			window.location.href = "<?php echo base_url().$this->session->userdata('userType').'/pointeforce_management/verified_commission/'.id_encrypt($customerId); ?>";
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}


function unverified_commission()
{
	swal({   
	title: '',   
	text: 'Are you sure that you want to Unverified this user?',
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Yes",   
	cancelButtonText: "No",   
	closeOnConfirm: false,   
	closeOnCancel: false 
	}, 
	function(isConfirm){   
		if (isConfirm) 
		{     
			window.location.href = "<?php echo base_url().$this->session->userdata('userType').'/pointeforce_management/unverified_commission/'.id_encrypt($customerId); ?>";
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}

function unblock_block(status)
{
	msg = 'Are you sure that you want to block this user?';
	
	if(status)
	{
		msg = 'Are you sure that you want to unblock this user?';
	}
	
	swal({   
	title: '',   
	text: msg,
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Yes",   
	cancelButtonText: "No",   
	closeOnConfirm: false,   
	closeOnCancel: false 
	}, 
	function(isConfirm){   
		if (isConfirm) 
		{     
			window.location.href = "<?php echo base_url().$this->session->userdata('userType').'/pointeforce_management/unblock_block/'.id_encrypt($customerId); ?>/"+status;
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}

</script>