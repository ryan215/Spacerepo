<!--sidebar start-->
<style>
.sub-menu-active
{
	color:#ff6c60 !important;
}
</style>
<?php
$uriSeg2 = $this->uri->segment(2);
$uriSeg3 = $this->uri->segment(3);
$isPointepay=$this->session->userdata('isPointepay');
$isPointemart=$this->session->userdata('ispointemart');
?>
<aside>
	<div id="sidebar"  class="nav-collapse ">
    	<!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
			
			
			<li>
				<a href="<?php echo base_url().'retailer/product_request_management'; ?>" <?php if(($uriSeg2=='product_request_management')||($uriSeg2=='semantics')||(($uriSeg2=='product_management')&&(($uriSeg3=='addEditProduct')||($uriSeg3=='addEditProductImage')||($uriSeg3=='addEditProductAttribute')||($uriSeg3=='productReview')))){ ?> class="active" <?php } ?>>
					<i class="fa fa-laptop"></i>
					<span>Product Management</span>
				</a>
			</li>
			
			<?php
			if($this->session->userdata('skip')==0)
			{
			?>
			<li class="sub">
				<a href="<?php echo base_url().'retailer/check_stock_management/add_check_stock_list/'; ?>" <?php if(($uriSeg2=='product_management')&&(($uriSeg3=='')||($uriSeg3=='add_inventory')||($uriSeg3=='view'))||($uriSeg2=='check_stock_management')){ ?> class="active" <?php } ?>>
					<i class="fa fa-laptop"></i>
					<span>Inventory Managment</span>
				</a>
			</li>
			<li class="sub">
				<a href="<?php echo base_url().'retailer/check_stock_management/check_stock_list'; ?>" <?php if((($uriSeg2=='product_management')&&(($uriSeg2=='check_stocks')||($uriSeg3=='inventory_details')))||($uriSeg2=='check_stock_management')){ ?> class="active" <?php } ?>>
					<i class="fa fa-laptop"></i>
					<span>My Inventory</span>
				</a>
			</li>
			
			<?php /*?><li class="sub">
				<a href="<?php echo base_url().'retailer/employee_management'; ?>" <?php if($uriSeg2=='employee_management'){ ?> class="active" <?php } ?>>
					<i class="fa fa-laptop"></i>
					<span>Employee Managment</span>
				</a>
			</li>
			<li class="sub">
				<a href="<?php echo base_url().'retailer/customer_management'; ?>" <?php if($uriSeg2=='customer_management'){ ?> class="active" <?php } ?>>
					<i class="fa fa-laptop"></i>
					<span>customer Managment</span>
				</a>
			</li><?php */?>
			
			<?php 
			if($this->session->userdata('active'))
			{
				 ?>
            <li class="sub">
                <a href="<?php echo base_url(); ?>retailer/order_management" <?php if($uriSeg2=='order_management'){ ?> class="dcjq-parent active" <?php } ?>>
                    <i class="fa fa-shopping-cart"></i>
                    <span>Orders Management</span>
                </a>
            </li>
			
			<li class="sub-menu">
				<a href="<?php echo base_url().'retailer/finance_retailer_management'; ?>" <?php if($uriSeg2=='finance_retailer_management'){ ?> class="dcjq-parent active" <?php } ?>>
					<i class="fa fa-credit-card"></i>
					<span>Wallet</span>
				</a>
			</li>
			<?php 
			} 
        }
		else
		{
		?>
			<li>
				<a href="<?php echo base_url().'retailer/dashboard'; ?>" <?php if(($uriSeg2=='dashboard')){ ?> class="active" <?php } ?>>
					<i class="fa fa-laptop"></i>
					<span>Verify user</span>
				</a>
			</li>
		<?php 
		}

        if(!empty($isPointepay))
        {
                /* */?><!--
                    <li>
                        <a href="<?php /*echo base_url().'retailer/category_Mgmt/category_listing'; */?>" <?php /*if(($uriSeg2=='dashboard')){ */?> class="active" <?php /*} */?>>
                            <i class="fa fa-laptop"></i>
                            <span>Category Management</span>
                        </a>
                    </li>
                    <li>
                    <a href="<?php /*echo base_url().'retailer/employee_management'; */?>" <?php /*if(($uriSeg2=='employee_Mgmt')){ */?> class="active" <?php /*} */?>>
                        <i class="fa fa-laptop"></i>
                        <span>Manage Employee</span>
                    </a>
                </li>
                    <li>
                        <a href="<?php /*echo base_url().'retailer/employee_Mgmt/employee_listing'; */?>" <?php /*if(($uriSeg2=='employee_Mgmt')){ */?> class="active" <?php /*} */?>>
                            <i class="fa fa-laptop"></i>
                            <span>Customer Employee</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php /*echo base_url().'retailer/employee_Mgmt/employee_listing'; */?>" <?php /*if(($uriSeg2=='employee_Mgmt')){ */?> class="active" <?php /*} */?>>
                            <i class="fa fa-laptop"></i>
                            <span>Make A Sale</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php /*echo base_url().'retailer/employee_Mgmt/employee_listing'; */?>" <?php /*if(($uriSeg2=='employee_Mgmt')){ */?> class="active" <?php /*} */?>>
                            <i class="fa fa-laptop"></i>
                            <span>Discount ManageMent</span>
                        </a>
                    </li>
            --><?php
                }

                ?>
		</ul>
		
		
        <!-- sidebar menu end-->
	</div>
</aside>
<!--sidebar end-->