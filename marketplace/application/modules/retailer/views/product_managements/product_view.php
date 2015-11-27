<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
		<div class="col-md-12" style="padding-left:0px;">
			<ul class="breadcrumbs-alt animated fadeInLeft">
				<?php //echo $this->session->userdata('userType'); exit;
				if(($this->session->userdata('userType')=='cse')||($this->session->userdata('userType')=='superadmin')||($this->session->userdata('userType')=='admin'))
				{	
					if($organizationId)
						{
						?>
						<li>
							<a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management'; ?>">
								Retailer List
							</a>
						</li>
						<li>
							<a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management/user_detail/'.id_encrypt($organizationId); ?>">
								View
							</a>
						</li>
						<li>
							<a href="<?php echo base_url().$this->session->userdata('userType').'/check_stock_management/check_stock_list/'.id_encrypt($organizationId); ?>">
								Inventory
							</a>
						</li>
						<li>
							<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/index/'.id_encrypt($organizationId); ?>">
								Product Management
							</a>
						</li>
						
						<?php
						}
				
				}
				elseif($this->session->userdata('userType')=='retailer')
				{
				?>
				
				<?php
				}
				else
				{
				?>
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management'; ?>">Product Management</a>
					</li>
					
				<?php
				}
				?>
				<li>
							<a href="javascript:void(0);" class="current">Product View</a>
						</li>
			</ul>
			<?php 
			if($this->session->userdata('userType')=='cse')
			{
				if(!empty($result['marketing_product']))
				{
				?>
				<a class="btn btn-primary pull-left" type="button" href="javascript:void(0);">
					This product is already added in the Campaign Management products list
				</a>
			<?php
				}
				else
				{
			?>
				<a class="btn btn-primary pull-left" type="button" href="<?php echo base_url().$this->session->userdata('userType').'/product_marketing_management/addProductRetailer/'.id_encrypt($product_id); ?>">
				<i class="fa fa-pencil"></i> Add To Marketing Product
			</a>
			<?php
				}
			}
			?>
		</div>
		
		<div class="clearfix"></div><?php $this->load->view('success_error_message'); ?>
		
		<?php 
		$this->load->view('retailer/product_managements/product_details_view'); 
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
