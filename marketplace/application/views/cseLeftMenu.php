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
$uriSeg4  = $this->uri->segment(4);
$uriSeg5  = $this->uri->segment(5);
?>
<aside>
	<div id="sidebar"  class="nav-collapse ">
    	<!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
        	<li>
            	<a <?php if(($uriSeg2=='retailer_management')||(($uriSeg2=='product_management')&&($uriSeg3!=''))){ ?> class="active" <?php } ?> href="<?php echo base_url().'cse/retailer_management/'; ?>">
    	        	<i class="fa fa-table"></i>
        	        <span>My Assigned Retailers</span>
            	</a>
			</li>
			<li>
			
				<a href="<?php echo base_url(); ?>cse/product_management" <?php if(($uriSeg2=='product_management')||($uriSeg2=='semantics')||($uriSeg2=='product_marketing_management')){ ?> class="active" <?php } ?>>
					<i class="fa fa-laptop"></i>
					<span>Product Management</span>
				</a>
			</li>
			<li>
				<a href="<?php echo base_url(); ?>cse/product_request_management" <?php if($uriSeg2=='product_request_management'){ ?> class="active" <?php } ?>>
					<i class="fa fa-laptop"></i>
					<span>My Request Product</span>
				</a>
			</li>			
			<li class="sub" style="padding-bottom:80px;">
				<a href="javascript:void(0);" 
					<?php 
					if(
						($uriSeg2=='new_order')||($uriSeg2=='confirm_order')||($uriSeg2=='ready_to_shipped')||
						($uriSeg2=='shipped_in_transit')||($uriSeg2=='delivered_order')||($uriSeg2=='history_order')||
						($uriSeg2=='new_pickup_order')||($uriSeg2=='ready_to_pickup')||($uriSeg2=='order_picked_up')||
						($uriSeg2=='confirm_pickup_order')||($uriSeg2=='history_order_pickup')||($uriSeg2=='search_order')||
						($uriSeg2=='order_management')
					)
					{ 
					?>
						class="dcjq-parent active"
					<?php 
					} 
					?>>
					<i class="fa fa-truck"></i>
					<span>Shipping Management</span>
				</a>
				<ul class="sub" style="height:450px;">
					<li>
						<a <?php if($uriSeg2=='order_management'){ ?> class="sun-menu-active" <?php } ?> href="<?php echo base_url().'cse/order_management'; ?>">
							<i class="fa fa-truck"></i>
							<span>Orders Management</span>
						</a>
					</li>
					<?php /*?><li class="sub" >
						<a href="javascript:void(0);" 
							<?php 
							if(
								($uriSeg2=='new_order')||($uriSeg2=='confirm_order')||($uriSeg2=='ready_to_shipped')||
								($uriSeg2=='shipped_in_transit')||($uriSeg2=='delivered_order')||
								($uriSeg2=='history_order')
							)
							{ 
							?>
								class="dcjq-parent active"
							<?php 
							} 
							?>>
							<i class="fa fa-shopping-cart"></i>
							<span>Orders Management </span>
						</a>
						<ul class="sub">
							<li>
								<a href="<?php echo base_url().'cse/new_order'; ?>" <?php if($uriSeg2=='new_order'){ ?> class="sun-menu-active" <?php } ?>>
									New Orders
								</a>
							</li>
							<li>
								<a href="<?php echo base_url().'cse/confirm_order'; ?>" <?php if($uriSeg2=='confirm_order'){ ?> class="sun-menu-active" <?php } ?>>
									Confirm Orders
								</a>
							</li>
							<li>
								<a href="<?php echo base_url().'cse/ready_to_shipped'; ?>" <?php if($uriSeg2=='ready_to_shipped'){ ?> class="sun-menu-active" <?php } ?> >
									Ready To Be Shipped
								</a>
							</li>
							<li>
								<a href="<?php echo base_url().'cse/shipped_in_transit'; ?>" <?php if($uriSeg2=='shipped_in_transit'){ ?> class="sun-menu-active" <?php } ?> >
									Shipped / In Transit
								</a>
							</li>
							<li>
								<a href="<?php echo base_url().'cse/delivered_order'; ?>" <?php if($uriSeg2=='delivered_order'){ ?> class="sun-menu-active" <?php } ?>>
									Delivered
								</a>
							</li>
							<li>
								<a href="<?php echo base_url().'cse/history_order'; ?>" <?php if($uriSeg2=='history_order'){ ?> class="sun-menu-active" <?php } ?>>
									History
								</a>
							</li>
						</ul>
					</li>					
					<li class="sub" >
						<a href="javascript:void(0);" 
							<?php 
							if(
								($uriSeg2=='new_pickup_order')||($uriSeg2=='ready_to_pickup')||
								($uriSeg2=='order_picked_up')||($uriSeg2=='confirm_pickup_order')||
								($uriSeg2=='history_order_pickup')
							)
							{
							?>
								class="dcjq-parent active"
							<?php 
							} 
						?>>
							<i class="fa fa-shopping-cart"></i>
							<span>Pickup Management </span>
						</a>
						<ul class="sub">
							<li>
								<a href="<?php echo base_url().'cse/new_pickup_order'; ?>" <?php if($uriSeg2=='new_pickup_order'){ ?> class="sun-menu-active" <?php } ?> >
									New  Pickup Orders
								</a>
							</li>
							<li>
								<a href="<?php echo base_url().'cse/confirm_pickup_order'; ?>" <?php if($uriSeg2=='confirm_pickup_order'){ ?> class="sun-menu-active" <?php } ?> >
									Confirm To Pickup
								</a>
							</li>
							<li>
								<a href="<?php echo base_url().'cse/ready_to_pickup'; ?>" <?php if($uriSeg2=='ready_to_pickup'){ ?> class="sun-menu-active" <?php } ?> >
									Ready To Be Pickup
								</a>
							</li>
							<li>
								<a href="<?php echo base_url().'cse/order_picked_up'; ?>" <?php if($uriSeg2=='order_picked_up'){ ?> class="sun-menu-active" <?php } ?>>
									Order Picked up
								</a>
							</li>
							<li>
								<a href="<?php echo base_url().'cse/history_order_pickup'; ?>" <?php if($uriSeg2=='history_order_pickup'){ ?> class="sun-menu-active" <?php } ?> >
									History
								</a>
							</li>
						</ul>
					</li>	<?php */?>				
					<li>
						<a <?php if($uriSeg2=='search_order'){ ?> class="sun-menu-active" <?php } ?> href="<?php echo base_url().'cse/search_order'; ?>">
							<i class="fa fa-search"></i>
							<span>Search</span>
						</a>
					</li>
				</ul>
			</li>			
		</ul>
	</div>
</aside>
<!--sidebar end-->