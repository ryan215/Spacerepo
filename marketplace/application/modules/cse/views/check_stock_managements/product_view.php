<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
		<div class="col-md-12" style="padding-left:0px;">
			<ul class="breadcrumbs-alt animated fadeInLeft">
				<li>
					<a href="<?php echo base_url().'cse/retailer_management'; ?>">
						Retailer List
					</a>
				</li>
				<li>
					<a href="<?php echo base_url().'cse/retailer_management/user_detail/'.id_encrypt($organizationId); ?>">
						View
					</a>
				</li>
				<li>
					<a href="<?php echo base_url().'cse/check_stock_management/check_stock_list/'.id_encrypt($organizationId); ?>">
						Inventory
					</a>
				</li>
				<li>
					<a href="<?php echo base_url().'cse/check_stock_management/add_check_stock_list/'.id_encrypt($organizationId); ?>">
						Product Management
					</a>
				</li>
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
