<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<?php $this->load->view('success_error_message'); ?>
		<!--contant start-->
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/order_management'; ?>">
							Orders List
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">View</a>
					</li>
				</ul>
			</div>
			<div class="clearfix"></div>	
			<div class="col-lg-12">
				<section class="panel">					
					<div style="padding-top:20px;">								
						<section>
							<div class="row">
								<aside class="profile-info col-lg-12" style="padding-bottom:20px;">
									<section class="panel">
                                		<div class="col-sm-12">
											<div class="col-sm-5" style="padding-left:0px;">
												<span  style="margin: 0px; font-size:14px; font-weight:bold;">
													Order Id : 
													<span style="font-weight:normal;">
														<?php echo $result['customerOrderId']; ?>
													</span>
												</span> <br>
												<span style="font-weight:bold;font-size:14px; margin-top:5px;">
													<?php												
													if($result['isPickup'])
													{
													?>
													Order placed : 
													<span style="font-weight:normal;">
														<?php 
														if(!empty($result['newOrderTime']))
														{
															echo date("d-m-Y H:i:s",$result['newOrderTime']);
														}
														?>
													</span><br>
													<?php
														if(!empty($result['confirmOrderTime']))
														{
														?>
														Confirm Order : 
														<span style="font-weight:normal;">
															<?php echo date("d-m-Y H:i:s",$result['confirmOrderTime']); ?>
														</span><br />
														<?php
														}
														if(!empty($result['readyToShippedOrderTime']))
														{
														?>
														Ready To Be Pickup Order :
														<span style="font-weight:normal;">
															<?php echo date("d-m-Y H:i:s",$result['readyToShippedOrderTime']); ?>
														</span><br />
														<?php
														}	
														if(!empty($result['deliveredOrderTime']))
														{
														?>
														Order Pickup :
														<span style="font-weight:normal;">
															<?php echo date("d-m-Y H:i:s",$result['deliveredOrderTime']); ?>
														</span><br />
													<?php
														}																										
													}
													else
													{
													?>
													Order placed : 
													<span style="font-weight:normal;">
														<?php 
														if(!empty($result['newOrderTime']))
														{
															echo date("d-m-Y H:i:s",$result['newOrderTime']);
														}
														?>
													</span><br>
													<?php
													if(!empty($result['confirmOrderTime']))
													{
													?>
														Confirm Order : 
														<span style="font-weight:normal;">
															<?php echo date("d-m-Y H:i:s",$result['confirmOrderTime']); ?>
														</span><br />
													<?php
													}
													if(!empty($result['readyToShippedOrderTime']))
													{
													?>
														Ready To Shipped Order :
														<span style="font-weight:normal;">
															<?php echo date("d-m-Y H:i:s",$result['readyToShippedOrderTime']); ?>
														</span><br />
													<?php
													}
													if(!empty($result['inTransitOrderTime']))
													{
													?>
														Shipped In Transit Order : 
														<span style="font-weight:normal;">
															<?php echo date("d-m-Y H:i:s",$result['inTransitOrderTime']); ?>
														</span><br />
													<?php
													}
													if(!empty($result['deliveredOrderTime']))
													{
													?>
														Delivered Order :
														<span style="font-weight:normal;">
															<?php echo date("d-m-Y H:i:s",$result['deliveredOrderTime']); ?>
														</span><br />
													<?php
													}
													}
													if($result['trackingNbr'])
													{
													?>
													<span style="font-weight:bold;font-size:14px; margin-top:5px;">
														Tracking Number: 
														<span style="font-weight:normal;">
															<?php echo $result['trackingNbr']; ?>
														</span>
													</span>
													<?php
													}
													?>
												</span>
											</div>
											<div class="col-sm-7">
											<?php											
										   	
												if(($result['orderStatusId']==6)&&($result['orderActiveStatus']==1))
												{
													echo 'Declined';
												}
												elseif($result['orderActiveStatus']==0)
												{
												?>
												<span style="font-size:20px; color:#79a83e;" class="pull-right"><i class="fa fa-check"></i> Cancel Order</span>
												<?php
												}
												elseif(($result['orderStatusId']==1)&&($result['orderActiveStatus']==1))
												{
												?>
													<a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="return change_new_order_to_confirm_order();">
														Accept
													</a> 
													<a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="return declined_order();">
														Decline
													</a>
												<?php	
												}		
											
										  	?>										
											</div>											
										</div>
									</section>
								</aside>
								<div class="clearfix"></div>	
								<aside class="profile-info col-lg-12">
									<?php $this->load->view('superadmin/order_managements/economic_order_details_view'); ?>
                        		</aside>
                			</div>
						</section>
					</div>
				</section>
			</div>
		</div>
		<!--contant end-->
	</section>
</section>
<!--main content end-->
<script>
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();   
});

function declined_order()
{
	swal({   
		title: '',   
		text: 'Are You sure want to declined this order?',   
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
			window.location.href = '<?php echo base_url().'retailer/order_management/declined_economic_order/'.$orderId; ?>';
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}

function change_new_order_to_confirm_order()
{
	swal({   
		title: '',   
		text: 'Are You sure want to accept this order?',   
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
			window.location.href = '<?php echo base_url().'retailer/order_management/change_new_order_to_confirm_order_economic/'.$orderId; ?>';
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}
</script>