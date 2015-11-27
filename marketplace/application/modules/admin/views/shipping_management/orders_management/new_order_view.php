<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<?php $this->load->view('success_error_message'); ?>
		<!--contant start-->
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/new_order'; ?>">
							New Order
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
													<span style="font-weight:normal;"><?php echo $result['customerOrderId']; ?></span>
												</span> <br>
												<span style="font-weight:bold;font-size:14px;">
													Order placed : <span style="font-weight:normal;">
													<?php echo date("d-m-Y H:i:s",$result['newOrderTime']); ?>
												</span><br />
												<?php /*?><?php
												if(!empty($result['newOrderTime']))
												{
												?>
												<span style="font-weight:bold;font-size:14px;">
													New Order : <span style="font-weight:normal;">
													<?php echo date("d-m-Y H:i:s",$result['newOrderTime']); ?>
												</span>
												<?php
												}<?php */
												//echo "<pre>"; print_r($result); exit;
												
												?>
											</div>
                                           <?php
										   if($this->session->userdata('userType')=='admin') 
										   {
										   ?>
                                            <div class="col-sm-6">
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
			window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/new_order/change_false/'.id_encrypt($orderID); ?>';
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