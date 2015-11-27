<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
		<div class="col-lg-12" style="padding-left:0px;">
			<ul class="breadcrumbs-alt animated fadeInLeft">
					<li>
						<a href="<?php echo base_url().'superadmin/product_management'; ?>">Product Management</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">Product View</a>
					</li>
			</ul>
		</div>
		
		<div class="clearfix"></div><?php $this->load->view('success_error_message'); ?> 
		 
		<div class="col-md-12 product_view_heading" style="font-size:18px; color:#F4873D; font-weight:600;">
			<?php
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
			<a class="btn btn-primary pull-right" type="button" href="<?php echo base_url().'superadmin/product_management/addEditProduct/'.id_encrypt($product_id); ?>">
				<i class="fa fa-pencil"></i> Edit Details
			</a>
		</div>		
		<?php 
		$this->load->view('retailer/product_managements/product_details_view'); 
		?>
	<!--contant end-->
	</section>
</section>

<script type="text/javascript" src="<?php echo base_url(); ?>js/confirmbox/sweet-alert.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/confirmbox/sweet-alert.css">
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
			window.location.href = "<?php echo base_url().'superadmin/product_management/unblock_block/'; ?>"+product_id+'/'+status;
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
