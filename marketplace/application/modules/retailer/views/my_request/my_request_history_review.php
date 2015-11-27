<section id="main-content">
	<section class="wrapper">
    	<div class="col-md-12" style="padding-left:0px;">
			<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().'retailer/my_request'; ?>">My Request</a>
					</li>
					<li>
						<a href="<?php echo base_url().'retailer/my_request/request_history'; ?>">Request History</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">Product View</a>
					</li>
			</ul>
		</div>
    	<!--contant start--> 
		<?php 
		$this->load->view('success_error_message'); 
		$this->load->view('retailer/product_managements/product_details_view'); 
		?>	
	</section>
</section>
