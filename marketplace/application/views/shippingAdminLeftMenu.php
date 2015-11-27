<!--sidebar start-->
<style>
.sun-menu-active
{
	color:#ff6c60 !important;
}
ul.sidebar-menu li ul.sub li{padding-left:25px;
}
</style>
<?php
$uriSeg2  = $this->uri->segment(2);
$uriSeg3  = $this->uri->segment(3);
?>
<aside>
	<div id="sidebar"  class="nav-collapse ">
    	<!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <li>
            	<a <?php if($uriSeg2=='dashboard'){ ?> class="active" <?php } ?> href="<?php echo base_url().'shipping_admin/dashboard/'; ?>">
    	            <i class="fa fa-user"></i>
        	        <span>Dashboard</span>
            	</a>
			</li>
			
			<li class="sub">
				<a href="javascript:void(0);" <?php if(($uriSeg2=='order_management')||($uriSeg2=='ready_to_shipped')||($uriSeg2=='shipped_in_transit')||($uriSeg2=='delivered_order')||($uriSeg2=='history_order')){ ?> class="dcjq-parent active" <?php } ?>>
					<i class="fa fa-shopping-cart"></i>
					<span>Orders Management </span>
				</a>
				<ul class="sub">
					<li>
						<a href="<?php echo base_url().'shipping_admin/order_management'; ?>" <?php if(($uriSeg2=='order_management')&&(($uriSeg3=='')||($uriSeg3=='index')||($uriSeg3=='new_order_view'))){ ?> class="sun-menu-active" <?php } ?> >
							New Orders
						</a>
					</li>
					<li>
						<a href="<?php echo base_url().'shipping_admin/ready_to_shipped'; ?>" <?php if(($uriSeg2=='ready_to_shipped')&&(($uriSeg3=='')||($uriSeg3=='index')||($uriSeg3=='ready_to_shipped_order_view'))){ ?> class="sun-menu-active" <?php } ?> >
							Ready To Be Shipped
						</a>
					</li>
					<li>
						<a href="<?php echo base_url().'shipping_admin/shipped_in_transit'; ?>" <?php if(($uriSeg2=='shipped_in_transit')&&(($uriSeg3=='')||($uriSeg3=='index')||($uriSeg3=='shipped_in_transit_order_view'))){ ?> class="sun-menu-active" <?php } ?> >
							Shipped / In Transit
						</a>
					</li>
					<li>
						<a href="<?php echo base_url().'shipping_admin/delivered_order'; ?>" <?php if(($uriSeg2=='delivered_order')&&(($uriSeg3=='')||($uriSeg3=='index')||($uriSeg3=='delivered_order_view'))){ ?> class="sun-menu-active" <?php } ?> >
							Delivered
						</a>
					</li>
					<li>
						<a href="<?php echo base_url().'shipping_admin/history_order'; ?>" <?php if(($uriSeg2=='history_order')&&(($uriSeg3=='')||($uriSeg3=='index')||($uriSeg3=='history_order_view'))){ ?> class="sun-menu-active" <?php } ?> >
							History
						</a>
					</li>
				</ul>
			</li>
			
			<li class="sub-menu">
				<a <?php if($uriSeg2=='vendor_management'){ ?> class="active" <?php } ?> href="<?php echo base_url(); ?>shipping_admin/vendor_management">
					<i class="fa fa-truck"></i>
					<span>Shipping Vendors</span>
				</a>
			</li>
			<li class="sub-menu">
				<a <?php if($uriSeg2=='settlement_report'){ ?> class="active" <?php } ?> href="<?php echo base_url(); ?>shipping_admin/settlement_report">
					<i class="fa fa-money"></i>
					<span>Settlement Report</span>
				</a>
			</li>
			
    	</ul>
	</div>
</aside>
<!--sidebar end-->