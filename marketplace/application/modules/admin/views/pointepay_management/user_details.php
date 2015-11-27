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
	
<div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background:#78CD51; border-radius:0px;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add Reference No.</h4>
                </div>
                <div class="modal-body">
                   <form action="#" method="post" accept-charset="utf-8">
									
										  <label class="pull-left" for="reference">Reference No.</label> <span class="error pull-left">*</span>
										  <div class="clearfix"></div>
										  <div class="form-group">
											  <input type="text" name="reference" id="reference" class="form-control" placeholder="Enter reference number">
										   </div>
									
									
							  </form>
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="saverefrence()">Save</button>
                </div>
            </div>
        </div>
    </div>

<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/pointepay_management/retailerList'; ?>">
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
									//	echo $result['isPointeMart'];
										//echo $result['isPointePay'];
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
                                      </div><br />
									  <div class="col-sm-12"><p class="text-center"><!--<strong>Reference No.</strong> : 87266531313<br>-->
									 
									  <a href="#myModal" data-toggle="modal" class="btn btn-success">Add Reference Number</a>
									  </p></div>
                                  </section>
                              </aside>
								<aside class="profile-info col-lg-9">
								
                            	<section class="panel">
                                	<div class="col-sm-12">
										<div class="col-sm-12" style="padding:0 5px;">
											<?php
											
										if(($result['requestStatus']==0)||($result['requestStatus']==2)||($result['requestStatus']==3))
										{
											if(($this->session->userdata('userType')=='cse')||($this->session->userdata('userType')=='superadmin')||($this->session->userdata('userType')=='admin'))
											{	
																																		
											}
											?>
                                    		<a href="<?php echo base_url().$this->session->userdata('userType').'/pointepay_management/editRetailer/'.id_encrypt($organizationId); ?>" class="btn btn-primary pull-right" type="button" style="margin-left:20px;">
												<i class="fa fa-pencil"></i> Edit
											</a>										  
											<?php
											if(($result['blockUnblock']))
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
													<span style="top: 12px; position: relative;">Status: </span>
													<?php if(!empty($result['pointepaySubscriptionId'])){
														echo '<span class="label label-success tooltips " style="top: 12px; position: relative;">paid</span>';
													}else
													{
														echo '<span class="label label-danger " style="top: 12px; position: relative;">unpaid</span>';
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
function saverefrence()
{
	var reference= $('#reference').val();
	console.log(reference);
	$.ajax({
		'url':'<?php echo base_url();?>admin/pointepay_management/addReference',
		'type':'POST',
		'data':{
		'refNo':reference,
		'organizationId':'<?php echo id_encrypt($organizationId);?>',
		'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>',	
		},
		success:function(resp)
		{
			$('#myModal').modal('hide');
			
		swal({title: resp,});
			location.reload();
			
		}
	})
}
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
	redirect = "<?php echo base_url().$this->session->userdata('userType').'/pointepay_management/unblock_block/'.id_encrypt($organizationId).'/'.id_encrypt($result['employeeId']); ?>/"+status	
	confirm_box(redirect,msg);	
}
</script>