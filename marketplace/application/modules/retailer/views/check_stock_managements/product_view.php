<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
		<div class="col-md-12" style="padding-left:0px;">
			<ul class="breadcrumbs-alt animated fadeInLeft">
				<li>
					<a href="javascript:void(0);" class="current">Product View</a>
				</li>
			</ul>
		</div>
		
		<div class="clearfix"></div><?php $this->load->view('success_error_message'); ?> 
		 
		<div class="col-md-12 product_view_heading" style="font-size:18px; color:#F4873D; font-weight:600;">
		</div>		
		<?php 
		$this->load->view('retailer/product_managements/admin_product_details_view'); 
		?>
	<!--contant end-->
	</section>
</section>

<style>
.product_view_heading{
	padding: 8px 15px;
	margin-bottom: 20px;
  	list-style: none;
  	background-color: #fff;
  	border-radius: 4px;
}
</style>
