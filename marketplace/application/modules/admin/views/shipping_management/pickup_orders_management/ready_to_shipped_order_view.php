<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<?php $this->load->view('success_error_message'); ?>
		<!--contant start-->
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/ready_to_pickup'; ?>">Ready To pickup</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">View</a>
					</li>
				</ul>
			</div>
			
			<div class="col-lg-12">
				<section class="panel">
					
					<div style="padding-top:20px;">								
						<section>
							<div class="row">
								<aside class="profile-info col-lg-12" style="padding-bottom:20px;">
									<section class="panel">
                                		<div class="col-sm-12">
											<div class="col-sm-4">
												<span  style="margin: 0px; font-size:14px; font-weight:bold;">
													Order Id : 
													<span style="font-weight:normal;"><?php echo $result['customerOrderId']; ?></span>
												</span> <br>
												<span style="font-weight:bold;font-size:14px;">
													Order placed : <span style="font-weight:normal;">
													<?php echo $result['orderDate']; ?>
												</span><br>
												<?php
												if(!empty($result['newOrderTime']))
												{}
												if(!empty($result['confirmOrderTime']))
												{
												?>
												<span style="font-weight:bold;font-size:14px;">
													Confirm Order : <span style="font-weight:normal;">
													<?php echo date("d-m-Y H:i:s",$result['confirmOrderTime']); ?>
												</span><br />
												<?php
												}
												if(!empty($result['readyToShippedOrderTime']))
												{
												?>
												<span style="font-weight:bold;font-size:14px;">
													Ready To Shipped Order : <span style="font-weight:normal;">
													<?php echo date("d-m-Y H:i:s",$result['readyToShippedOrderTime']); ?>
												</span><br />
												<?php
												}
												?>
											</div>
                                            <div class="col-sm-8">
											
													<div class="col-sm-2" style="padding:0;">
														<h5 style="line-height:10px; font-size:1em; text-transform:uppercase;">
															Change Status
														</h5>
													</div>
													<div class="col-sm-4"  style="padding-left:5px;">
														<select class="selectpicker chosen-select form-control" name=""  style="display: inline-block;">	
															<option value="7">Pickup by Customer</option>
														</select>		 
													</div>
													<div class="col-sm-2 pull-right"  style="">
														<button class="btn btn-success" onclick="ready_to_shipped();">
															Submit
														</button>
													</div>
																							
                                    </div></div>
									</section>
								</aside>	
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
function ready_to_shipped()
{
	swal({   
	title: '',   
	text: 'Are You sure want to change pickup by customer',   
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
			window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/ready_to_pickup/change_status/'.id_encrypt($orderID); ?>';
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}

function print_page(orderID)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/ready_to_pickup/print_page'; ?>',
		data:'orderID=<?php echo id_encrypt($orderID); ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		success:function(result){
			var printWindow = window.open('', '','height=400,width=800');
				printWindow.document.write(result);
				printWindow.document.close();
				setTimeout(function () {
					printWindow.print();
				}, 500);
			return false;
		}
	});
}

function print_invoice(orderID)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/ready_to_pickup/print_invoice'; ?>',
		data:'orderID=<?php echo id_encrypt($orderID); ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		success:function(result){
			var printWindow = window.open('', '','height=400,width=800');
				printWindow.document.write(result);
				printWindow.document.close();
				setTimeout(function () {
					printWindow.print();
				}, 500);
			return false;
		}
	});
}

function auto_genrate()
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/ready_to_pickup/auto_genrate'; ?>',
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		success:function(result){
			$('#txtTrack').val(result);
			$('#autoForm').submit();
		}
	});
	return false;
}
</script>