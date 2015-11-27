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
					<?php /*?><li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management'; ?>">Product Management</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">Product View</a>
					</li>
			</ul><?php */?>
		</div>
		
		<div class="clearfix"></div><?php $this->load->view('success_error_message'); ?> 
		 
		<div class="col-md-12 product_view_heading" style="font-size:18px; color:#F4873D; font-weight:600;">
		<?php 
		if($this->session->userdata('userType')=='admin')
		{
			if(empty($result['marketing_product']))
			{
				if((!empty($result['productTypeId']))&&($result['productTypeId']==3))
				{
				}
				else
				{
			?>
			<a class="btn btn-danger pull-left" type="button" href="<?php echo base_url().$this->session->userdata('userType').'/product_marketing_management/addProductRetailer/'.id_encrypt($product_id); ?>">
				<i class="fa fa-plus"></i> Add To Marketing Product
			</a>
			<?php
				}
			}
			?>
			<a class="btn btn-info pull-left" type="button" href="<?php echo base_url().$this->session->userdata('userType').'/product_management/inventory_list/'.id_encrypt($product_id); ?>" style="margin-left:10px;">
				Inventory
			</a>
			<?php
		}		
			if($result['active'])
			{
			?>
			<a href="javascript:void(0);" class="btn btn-success pull-right" type="button" style="margin-left:20px;" onclick="unblock_block('<?php echo id_encrypt($product_id); ?>',0);">
				UnBlocked
			</a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" class="btn btn-danger pull-right" type="button" style="margin-left:20px;" onclick="unblock_block('<?php echo id_encrypt($product_id); ?>',1);">
				Blocked
			</a>			
			<?php
			}			
			?>	
				<a class="btn btn-primary pull-right" type="button" href="<?php echo base_url().$this->session->userdata('userType').'/product_management/addEditProduct/'.id_encrypt($product_id); ?>">
				<i class="fa fa-pencil"></i> Edit Details
			</a>
			
		</div>		
		<?php 
		$this->load->view('retailer/product_managements/admin_product_details_view'); 
		?>
	<!--contant end-->
	</section>
</section>

<script type="text/javascript">
function unblock_block(product_id,status)
{
	msg = 'Are you sure want to block this product ?';
	
	if(status)
	{
		msg = 'Are you sure want to Unblock this product ?';
	}
	
	swal({   
	title: '',   
	text: msg,   
	type: "warning",   
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
			window.location.href = "<?php echo base_url().$this->session->userdata('userType').'/product_management/unblock_block/'; ?>"+product_id+'/'+status;
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}
</script>
<style>
.product_view_heading{
	padding: 8px 15px;
	margin-bottom: 20px;
  	list-style: none;
  	background-color: #fff;
  	border-radius: 4px;
}
</style>
