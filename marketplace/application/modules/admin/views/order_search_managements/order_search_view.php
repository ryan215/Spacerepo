<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<?php $this->load->view('success_error_message'); ?>
		<!--contant start-->
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/order_search_management'; ?>">
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
												</span>
											</div>
											<div class="col-sm-7">
											</div>
										</div>
									</section>
								</aside>
								<div class="clearfix"></div>	
								<aside class="profile-info col-lg-12">
									<?php $this->load->view('admin/order_search_managements/order_details_view'); ?>
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