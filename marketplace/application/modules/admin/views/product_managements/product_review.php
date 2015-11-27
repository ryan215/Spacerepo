<section id="main-content">
	<section class="wrapper">
    	<!--contant start--> 
		<?php $this->load->view('success_error_message'); ?>  
		<ul class="breadcrumb" style="font-size:18px; color:#F4873D; font-weight:600;">
			<li>Product Review</li>
		</ul>
		<div class="row panel" style="margin:5px 0 20px;">
			<div class="col-sm-12">
				<div class="progress progress-striped progress-sm" style="margin:5px 0; height:14px;">
					<div style = "width:100%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success">
						<span class="sr-only">40% Complete (success)</span>
					</div>
				</div>
				
				<div class="col-sm-3 pd">Product Description</div>
				<div class="col-sm-3 pd text-center">Images</div>
				<div class="col-sm-3 pd text-center">Attributes</div>
				<div class="col-sm-3 pd text-right">Review Product</div>
			</div>
		</div>
		
		<?php 
		$this->load->view('retailer/product_managements/admin_product_details_view'); 
		
		if((!empty($result['productTypeId']))&&($result['productTypeId']==3))
		{
		?>
        <div class="col-sm-12 save-div">
			<input type="button" class="btn btn-success btn-save" value="Save & Continue" onclick="pseudo_form_submit();" /> 
		</div>	 
		<?php
		}
		else
		{
		?>
        <div class="col-sm-12 save-div">
			<a class="btn btn-success btn-save" href="<?php echo base_url().'admin/product_management/productReview/'.id_encrypt($product_id).'/save'; ?>">
				Save & Continue
			</a>
		</div>	 
		<?php
		}
		?>
	<!--contant end-->
	</section>
</section>