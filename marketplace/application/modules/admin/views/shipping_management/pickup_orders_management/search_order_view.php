<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<?php $this->load->view('success_error_message'); ?>
		<!--contant start-->
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/search_order'; ?>">
							Search Order
						</a>
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
											<div class="col-sm-6">
												<span  style="margin: 0px; font-size:14px; font-weight:bold;">
													Order Id : 
													<span style="font-weight:normal;"><?php echo $result['customerOrderId']; ?></span>
												</span> <br>
												<span style="font-weight:bold;font-size:14px;">
													Order placed : <span style="font-weight:normal;">
													<?php echo $result['orderDate']; ?>
												</span><br />
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
												if(!empty($result['readyToShippedOrderTime']))
												{
												?>
												<span style="font-weight:bold;font-size:14px;">
													Ready To Shipped Order : <span style="font-weight:normal;">
													<?php echo date("d-m-Y H:i:s",$result['readyToShippedOrderTime']); ?>
												</span>
												<?php
												}
												if(!empty($result['inTransitOrderTime']))
												{
												?>
												<span style="font-weight:bold;font-size:14px;">
													Shipped In Transit Order : <span style="font-weight:normal;">
													<?php echo date("d-m-Y H:i:s",$result['inTransitOrderTime']); ?>
												</span>
												<?php
												}
												if(!empty($result['deliveredOrderTime']))
												{
												?>
												<span style="font-weight:bold;font-size:14px;">
													Delivered Order : <span style="font-weight:normal;">
													<?php echo date("d-m-Y H:i:s",$result['deliveredOrderTime']); ?>
												</span>
												<?php
												}
												?>
											</div>
											
                                    </div>
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
