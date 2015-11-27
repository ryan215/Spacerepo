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
											<?php echo form_open(); ?>
												<input type="submit" name="submit" value="Download List" />
											</form>
										</div>
									</section>
								</aside>
								<div class="clearfix"></div>	
								<aside class="profile-info col-lg-12">
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