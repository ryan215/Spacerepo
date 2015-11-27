<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<?php $this->load->view('success_error_message'); ?>
		<!--contant start-->
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/confirm_order'; ?>">
							Confirmation Orders
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
											<div class="col-sm-6">
												<span  style="margin: 0px; font-size:14px; font-weight:bold;">
													Order Id : 
													<span style="font-weight:normal;">
													<?php echo $result['customerOrderId']; ?></span>
												</span> <br>
												<span style="font-weight:bold;font-size:14px;">
													Order placed : <span style="font-weight:normal;">
													<?php echo date("d-m-Y H:i:s",$result['newOrderTime']); ?>
												</span>
												<br />
												<?php
												if(!empty($result['newOrderTime']))
												{}
												if(!empty($result['confirmOrderTime']))
												{
												?>
												<span style="font-weight:bold;font-size:14px;">
													Confirm Order : <span style="font-weight:normal;">
													<?php echo date("d-m-Y H:i:s",$result['confirmOrderTime']); ?>
												</span>
												<?php
												}
												?>
											</div>
											<div class="col-sm-6">
											<?php
											if(($this->session->userdata('userType')=='admin')||($this->session->userdata('userType')=='cse'))
											{
											?>
											<div class="col-sm-4" style="padding:0;"><h5 style="line-height: 10px;  font-size: 1em;text-transform: uppercase;">Change Status</h5></div>
											<div class="col-sm-6"  style="padding-left:5px;">
												<select class="selectpicker chosen-select form-control" name=""  style="display: inline-block;">	
													<option value="3">Ready To Be Shipped</option>
												</select>		 
											</div>
											<div class="col-sm-2"  style="padding:0px;">
												<button class="btn btn-success" onclick="ready_to_shipped();">
													Submit
												</button>
											</div>
											<?php
											}
											?>
										</div>
                                        <?php
										   if($this->session->userdata('userType')=='admin') 
										   {
										   ?>
                                            <div class="col-sm-12">
                                            	<button class="pull-right" data-toggle="tooltip"  data-placement="left" title="Click here to Delete the order" onclick="return check_false();" style="  background-color: #fff;  border: none;"><img src="<?php echo base_url(); ?>images/Remove.png" width="80%" /></button>
                                            </div>
										  <?php
										   }
										   ?>
                                    </div>
									</section>
								</aside>	<div class="clearfix"></div>
								<aside class="profile-info col-lg-12">
									<?php $this->load->view('order_details_view'); ?>
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

<script type="text/javascript">
jQuery('.selectpicker').selectpicker('show');

function ready_to_shipped()
{
	swal({   
	title: '',   
	text: 'Are You sure want to change new order to ready to shipped',   
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
			window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/confirm_order/change_new_order_to_ready/'.id_encrypt($orderID); ?>';
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}
</script>
<script>
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
			window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/confirm_order/change_false/'.id_encrypt($orderID); ?>';
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
	
});
</script>