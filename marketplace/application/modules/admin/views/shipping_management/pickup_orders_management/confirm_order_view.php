<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<?php $this->load->view('success_error_message'); ?>
		<!--contant start-->
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/confirm_pickup_order'; ?>">
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
											<div class="col-sm-4">
												<span  style="margin: 0px; font-size:14px; font-weight:bold;">
													Order Id : 
													<span style="font-weight:normal;">
													<?php echo $result['customerOrderId']; ?></span>
												</span> <br>
												<span style="font-weight:bold;font-size:14px;">
													Order placed : <span style="font-weight:normal;">
													<?php echo $result['orderDate']; ?>
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
												if(($this->session->userdata('userType')=='admin')||($this->session->userdata('userType')=='cse'))
												{
												?><br />
												<span style="font-weight:bold;font-size:14px;">
													Tracking Number : 
													<span style="font-weight:normal;">
								<?php
												$attr=array('id' =>'autoForm');
												echo form_open('',$attr);?>
													<input type="text" class="form-control" name="track_number" value="<?php echo $result['trackingNbr']; ?>" style="width:60%;" id="txtTrack">
													<?php echo form_error('track_number'); ?><br>
													<button class="btn btn-success" onclick="return auto_genrate();">Auto Genrate</button>
												</form>
												</span>
												
												<?php
												}
												?>
											</div>
											<div class="col-sm-8">
											<?php
											if(($this->session->userdata('userType')=='admin')||($this->session->userdata('userType')=='cse'))
											{
											?>
												<button class="btn btn-danger btn-sm" onclick="print_invoice('<?php echo id_encrypt($orderID); ?>');">Print Invoice</button>
                                             <?php
											} 
											if(!empty($result['trackingNbr']))
											{
											?>
												&nbsp;<button class="btn btn-danger btn-sm" onclick="print_page('<?php echo id_encrypt($orderID); ?>');">pickup Label</button>
												
											<?php
											}
										
											if(($this->session->userdata('userType')=='admin')||($this->session->userdata('userType')=='cse')) 
											{
												if(!empty($result['trackingNbr']))
												{
											?>
											&nbsp;<span style="line-height: 10px;  font-size: 1em;text-transform: uppercase;">Change Status</span>
											
											&nbsp;<select class=" chosen-select form-control" name=""  style="display: inline-block; width:175px;">	
													<option value="3">Ready To Pickup</option>
												</select>		 
											
										
												<button class="btn btn-success" onclick="ready_to_shipped();" style="position:relative; top:-3px;">
													Submit
												</button>
										
											<?php
												}
											}
											?>
									
                                        <?php
										if($this->session->userdata('userType')=='admin') 
										 {
										   ?>
                                            
                                            	<button class="pull-right" data-toggle="tooltip"  data-placement="left" title="Click here to Delete the order" onclick="return check_false();" style="  background-color: #fff;  border: none;"><img src="<?php echo base_url(); ?>images/Remove.png" width="80%" /></button>
                                           
										  <?php
										   }
										   ?>
                                    </div>	</div>
									</section>
								</aside><div class="clearfix"></div>	
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
	text: 'Are You sure want to change new order to ready to pickup',   
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
			window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/confirm_pickup_order/change_new_order_to_ready/'.id_encrypt($orderID); ?>';
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
			window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/confirm_pickup_order/change_false/'.id_encrypt($orderID); ?>';
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
		url:'<?php echo base_url().$this->session->userdata('userType').'/confirm_pickup_order/print_page'; ?>',
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
		url:'<?php echo base_url().$this->session->userdata('userType').'/confirm_pickup_order/print_invoice'; ?>',
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
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
	
});
</script>