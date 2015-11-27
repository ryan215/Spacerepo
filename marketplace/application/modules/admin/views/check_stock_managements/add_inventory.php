<style>
.inventory-form-group{margin-bottom:14px !important;
}
.popover-content{font-size:11px;
	font-weight:normal;
	text-transform:inherit !important;
}
.popover .arrow{top:100 !important;
}

.input-group-addon{background-color:#F0F0F0;
}
input[type=checkbox] {
  margin: 4px 8px 0px !important;
  line-height: normal;
}
.sizes_label{   top: -2px;
  position: relative}
  .color-filter small {
	border: 1px solid #DDDDDD;
	display: inline-block;
	height: 14px;
	margin: 0 3px 0 1px;
	width: 14px;
}
.block-element label {
  float: left;
  margin-right: 18px;
}
</style>

<section id="main-content">
	<section class="wrapper">
		<?php $this->load->view('success_error_message'); ?>  
    	<div class="row">
        	<div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					<li>
						<a href="<?php echo base_url().'admin/retailer_management'; ?>">Retailer List</a>
					</li>
					<li>
						<a href="<?php echo base_url().'admin/retailer_management/user_detail/'.id_encrypt($organizationId); ?>">View</a>
					</li>
					<li>
						<a href="<?php echo base_url().'admin/check_stock_management/check_stock_list/'.id_encrypt($organizationId); ?>">Inventory</a>
					</li>
					<li>
						<a href="javascript:void(0);">Product Management</a>
					</li>
					<li>
						<a class="current" href="javascript:void(0);">
							Add Inventory
						</a>
					</li>
				</ul>
			</div>
        </div>
		<?php $this->load->view('retailer/check_stock_managements/add_inventory_form'); ?> 
	</section>
</section>