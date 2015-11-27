<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<?php $this->load->view('success_error_message'); ?>
		<!--contant start-->
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/orders_management'; ?>">
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
														<?php echo $result['customOrderId']; ?>
													</span>
												</span> <br>
												<span style="font-weight:bold;font-size:14px; margin-top:5px;">
													<?php 
													if(!empty($result['newOrderTime']))
													{
													?>
														Order placed : 
														<span style="font-weight:normal;">
															<?php echo $result['newOrderTime']; ?>
														</span><br>
													<?php
													}
													if(!empty($result['confirmOrderTime']))
													{
													?>
														Confirm Order : 
														<span style="font-weight:normal;">
															<?php echo $result['confirmOrderTime']; ?>
														</span><br />
													<?php
													}
													if(!empty($result['readyToShippedOrderTime']))
													{
													?>
														Ready To Shipped Order :
														<span style="font-weight:normal;">
															<?php echo $result['readyToShippedOrderTime']; ?>
														</span><br />
													<?php
													}
													if(!empty($result['inTransitOrderTime']))
													{
													?>
														Shipped In Transit Order : 
														<span style="font-weight:normal;">
															<?php echo $result['inTransitOrderTime']; ?>
														</span><br />
													<?php
													}
													if(!empty($result['deliveredOrderTime']))
													{
													?>
														Delivered Order :
														<span style="font-weight:normal;">
															<?php echo $result['deliveredOrderTime']; ?>
														</span><br />
													<?php
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
														if(($result['orderStatusId']==3)&&($result['orderActiveStatus']==1))
														{
														?>
														<button class="btn btn-danger btn-sm" onclick="delivery_print_invoice();">
															Print Invoice
														</button>
														&nbsp;
														<button class="btn btn-danger btn-sm" onclick="delivery_print_page();">
															shipping Label
														</button>
														<?php
														}																												
													}
													?>
												</span>
											</div>
											<div class="col-sm-7">
											<?php											
										   		
											   		if(($result['orderStatusId']==2)&&($result['orderActiveStatus']==1))
													{														
											?>
										   		<div class="col-sm-3" style="padding:0;">
													<h5 style="line-height: 10px; font-size:1em;text-transform:uppercase;">
														Change Status
													</h5>
												</div>
												<div class="col-sm-5"  style="padding-left:5px;">
													<select class="selectpicker chosen-select form-control" style="display: inline-block;">	
														<option value="3">Ready To Be Shipped</option>
													</select>		 
												</div>
												<div class="col-sm-2"  style="padding:0px;">
													<button class="btn btn-success" onclick="change_confirm_order_to_ready_order();">
														Submit
													</button>
												</div>
											<?php
													}
													elseif(($result['orderStatusId']==3)&&($result['orderActiveStatus']==1))
													{
														if($result['trackingNbr'])
														{
													?>
													<div class="col-sm-3" style="padding:0;">
														<h5 style="line-height: 10px; font-size:1em;text-transform:uppercase;">
															Change Status
														</h5>
													</div>
													<div class="col-sm-5"  style="padding-left:5px;">
														<select class="selectpicker chosen-select form-control" style="display: inline-block;">	
															<option value="4">
																Shipped / In Transit
															</option>
														</select>		 
													</div>
													<div class="col-sm-2"  style="padding:0px;">
														<button class="btn btn-success" onclick="change_ready_order_to_shipped_order();">
															Submit
														</button>
													</div>
												<?php
														}
													}
													elseif(($result['orderStatusId']==4)&&($result['orderActiveStatus']==1))
													{
														//if((!empty($result['deliveredDate']))&&($result['deliveredDate']!='0000-00-00'))
														{
													?>
													<div class="col-sm-12">
														<div class="col-sm-3" style="padding:0;">
															<h5 style="line-height:10px; font-size:1em; text-transform:uppercase;">
																Change Status
															</h5>
														</div>
														<div class="col-sm-6"  style="padding-left:5px;">
															<select class="selectpicker chosen-select form-control" style="display: inline-block;">	
																<option value="5">Delivered</option>
															</select>		 
														</div>
														<div class="col-sm-2"  style="padding:0px;">
        	                                            	<button class="btn btn-success" onclick="change_shipped_order_to_delivered_order();">
																Submit
															</button>
                                                        </div>
													</div>
													<?php
														}
													}
													elseif(($result['orderStatusId']==6)&&($result['orderActiveStatus']==1))
													{
														echo 'Declined';
													}
													elseif($result['orderActiveStatus']==0)
													{
														echo '<span style="font-size:20px; color:#79a83e;" class="pull-right"><i class="fa fa-check"></i> Cancel Order</span>';
													}
												
											
										   		if((($result['orderStatusId']==1)||($result['orderStatusId']==2))&&($result['orderActiveStatus']==1))
												{
										   ?>
                                           
                                           		<button class="pull-right" data-toggle="tooltip"  data-placement="left" title="Click here to Delete the order" onclick="return check_false();" style="  background-color: #fff;  border: none;">
													<img src="<?php echo base_url(); ?>images/Remove.png" width="80%" />
												</button>
                                            
										  	<?php
												}
										  	
											?>										
											</div>
											<?php
											
												
													if(($result['orderStatusId']==3)&&($result['orderActiveStatus']==1))
													{
											?>
											<div class="col-xs-6"></div>
                                            <div class="col-xs-6">
                                            	<span style="font-weight:bold;font-size:14px; margin-top:5px;">
													Tracking Number : 
													<span style="font-weight:normal;">
												<?php
												$attr=array('id' =>'autoForm');
												echo form_open('',$attr);?>
													<input type="text" class="form-control" name="track_number" value="<?php echo $result['trackingNbr']; ?>" style="width:72%; float:left; margin-right:5px;" id="txtTrack">
													<?php echo form_error('track_number'); ?>
													<button class="btn btn-success" onclick="return auto_genrate();">
														Auto Genrate
													</button>
												</form>
												</span>
                                            </div>
											<?php
													}
												
												
											
											?>
										</div>
									</section>
								</aside>
								<div class="clearfix"></div>	
								<aside class="profile-info col-lg-12">
									<?php $this->load->view('admin/orders_managements/single_shippment_order_details_view'); ?>
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

function check_false()
{
	swal({   
		title: '',   
		text: 'Are you sure you want to Delete this order?',   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Yes",   
		cancelButtonText: "No",   
		closeOnConfirm: false,   
		closeOnCancel: false 
	}, 
	function(isConfirm){   
		if(isConfirm) 
		{     
			window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/orders_management/single_shippment_cancel_order/'.id_encrypt($orderCustomPaymentId); ?>';
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}

function change_confirm_order_to_ready_order()
{
	swal({   
		title: '',   
		text: 'Are You sure want to change confirm to ready to be shipped order',   
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
			window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/orders_management/single_shippment_change_confirm_to_ready_order/'.id_encrypt($orderCustomPaymentId); ?>';
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}

function auto_genrate()
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/orders_management/auto_genrate'; ?>',
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		success:function(result){
			$('#txtTrack').val(result);
			$('#autoForm').submit();
		}
	});
	return false;
}

function change_ready_order_to_shipped_order()
{
	swal({   
		title: '',   
		text: 'Are You sure want to change ready to shipped order to Shipped/In Transit',   
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
			window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/orders_management/single_shippment_change_ready_to_shipped_order/'.id_encrypt($orderCustomPaymentId); ?>';
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}

function change_shipped_order_to_delivered_order()
{
	swal({   
		title: '',   
		text: 'Are You sure want to change shipped order to delivered',   
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
			window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/orders_management/single_shippment_change_shipped_to_delivered_order/'.id_encrypt($orderCustomPaymentId); ?>';
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}

</script>