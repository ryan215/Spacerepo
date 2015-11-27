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
$uriSeg2 = $this->uri->segment(2);
$uriSeg3 = $this->uri->segment(3);
$uriSeg4 = $this->uri->segment(4);
$uriSeg5 = $this->uri->segment(5);
?>
<aside>
	<div id="sidebar"  class="nav-collapse ">
    	<!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
        <div style="height:600px;overflow-y:scroll;overflow-x:hidden;">	
			<li>
            	<a <?php if(($uriSeg2=='dashboard')||($uriSeg2=='shipping_bounce')){ ?> class="active" <?php } ?> href="<?php echo base_url(); ?>superadmin/dashboard/">
    	            <i class="fa fa-dashboard"></i>
        	        <span>Dashboard</span>
                </a>
			</li>
        	<li>
			
            	<a <?php if($uriSeg2=='user_management'){ ?> class="active" <?php } ?> href="<?php echo base_url(); ?>superadmin/user_management/">
    	            <i class="fa fa-user"></i>
        	        <span>User Management</span>
                </a>
			</li>
			<li>
				<a href="<?php echo base_url(); ?>superadmin/cse_management" <?php if($uriSeg2=='cse_management'){ ?> class="active" <?php } ?>>
                	 <i class="fa fa-user"></i>
	                <span>CSE Management</span>
                </a>
			</li>
			<li>
				<a href="<?php echo base_url(); ?>superadmin/retailer_management" <?php if(($uriSeg2=='retailer_management')||($uriSeg2=='check_stock_management')||($uriSeg3=='check_stocks')||(($uriSeg4!='')&&($uriSeg3=='index'))||($uriSeg3=='add_inventory')||($uriSeg3=='inventory_details')||(($uriSeg3=='view')&&($uriSeg5!=0))){ ?> class="active" <?php } ?>>
                	 <i class="fa fa-user"></i>
	                <span>Retailer Management</span>
                </a>
			</li>
			<li>
				<a href="<?php echo base_url(); ?>superadmin/customer_management" <?php if($uriSeg2=='customer_management'){ ?> class="active" <?php } ?>>
                	 <i class="fa fa-user"></i>
	                <span>Customer Management</span>
                </a>
			</li>
			<li>
				<a href="<?php echo base_url(); ?>superadmin/pointeforce_management" <?php if($uriSeg2=='pointeforce_management'){ ?> class="active" <?php } ?>>
                	 <i class="fa fa-user"></i>
	                <span>Pointe Force Management</span>
                </a>
			</li>
			<li>
				<a href="<?php echo base_url(); ?>superadmin/category_management/view_list" <?php if($uriSeg2=='category_management'){ ?> class="active" <?php } ?>>
					<i class="fa fa-book"></i>
					<span>Category Management</span>
				</a>
			</li>
			<li>
				<a href="javascript:void(0);" <?php if(($uriSeg2=='category_commission_management')||($uriSeg2=='category_commission_management2')){ ?> class="dcjq-parent active" <?php } ?>>
					<i class="fa fa-map-marker"></i>
					<span>Commission Management</span>
				</a>
				<ul class="sub">
					<li>
						<a href="<?php echo base_url(); ?>superadmin/category_commission_management" <?php if($uriSeg2=='category_commission_management'){ ?> class="sun-menu-active" <?php } ?> >
							Customer Commission
						</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>superadmin/category_commission_management2" <?php if($uriSeg2=='category_commission_management2'){ ?> class="sun-menu-active" <?php } ?> >
							Retailer Commission
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="<?php echo base_url(); ?>superadmin/brand_management" <?php if($uriSeg2=='brand_management'){ ?> class="active" <?php } ?>>
					<i class="fa fa-ticket"></i>
					Brand Management
				</a>
			</li>
			<li>
				<a href="javascript:void(0);" <?php if($uriSeg2=='location_management'){ ?> class="dcjq-parent active" <?php } ?>>
					<i class="fa fa-map-marker"></i>
					<span>Location Management</span>
				</a>
				<ul class="sub">
					<li>
						<a href="<?php echo base_url(); ?>superadmin/location_management" <?php if(($uriSeg2=='location_management')&&(($uriSeg3=='')||($uriSeg3=='index')||($uriSeg3=='addEditCountry'))){ ?> class="sun-menu-active" <?php } ?> >
							Country
						</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>superadmin/location_management/state_list_view" <?php if(($uriSeg3=='state_list_view')||($uriSeg3=='addEditState')){ ?> class="sun-menu-active" <?php } ?> >
							State
						</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>superadmin/location_management/area_list_view" <?php if(($uriSeg3=='area_list_view')||($uriSeg3=='addEditArea')){ ?> class="sun-menu-active" <?php } ?> >
							Area
						</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>superadmin/location_management/zip_list_view" <?php if(($uriSeg3=='zip_list_view')||($uriSeg3=='addEditZip')){ ?> class="sun-menu-active" <?php } ?> >
							City
						</a>
					</li>
				</ul>
			</li>
			<li class="sub-menu">
				<a href="<?php echo base_url(); ?>superadmin/product_management" <?php if((($uriSeg2=='product_management')&&($uriSeg3!='check_stocks')&&($uriSeg3!='index')&&($uriSeg3!='add_inventory')&&($uriSeg3!='inventory_details')&&($uriSeg5==0))||($uriSeg2=='semantics')){ ?> class="dcjq-parent active" <?php } ?>>
					<i class="fa fa-laptop"></i>
					<span>Product Management</span>
				</a>
			</li>			
			<li class="sub-menu">
            	<a href="<?php echo base_url(); ?>superadmin/news_management" <?php if(($uriSeg2=='marketing')||($uriSeg2=='news_management')){ ?> class="dcjq-parent active" <?php } ?>>
                	<i class="fa fa-camera-retro"></i>
		               <span>Marketing Management</span>
	            </a>
                    <ul class="sub">
                   		 <li>
							<a href="<?php echo base_url(); ?>superadmin/news_management" <?php if($uriSeg2=='news_management'){ ?> class="sun-menu-active" <?php } ?>>
								NewsLetter
							</a>
						</li>
                    </ul>
				</li>		
<li class="sub-menu">
	<a href="<?php echo base_url(); ?>superadmin/price_management" <?php if($uriSeg2=='price_management'){ ?> class="dcjq-parent active" <?php } ?>>
		<i class="fa fa-lapstop">&#x20A6;</i>
		<span>Price Management</span>
	</a>
</li>

<li class="sub-menu">
	<a href="<?php echo base_url(); ?>superadmin/product_rating_review" <?php if($uriSeg2=='product_rating_review'){ ?> class="dcjq-parent active" <?php } ?>>
		<i class="fa fa-star"></i>
	    <span>Rating & Reveiw Management</span>
	</a>
</li>
<?php /*?>
<li class="sub-menu">
	<a href="<?php echo base_url(); ?>superadmin/finance_management" <?php if(($uriSeg2=='finance_management')||($uriSeg2=='finance_pointe_force_management')||($uriSeg2=='finance_retailer_management')||($uriSeg2=='finance_vendor_management')){ ?> class="dcjq-parent active" <?php } ?>>
		<i class="fa fa-credit-card"></i>
		<span>Finance Management</span>
	</a>
</li>
<?php */?>				
			<li class="sub">
				<a href="javascript:void(0);" <?php if(($uriSeg2=='free_shipping_category')||($uriSeg2=='free_shipping_product')){ ?> class="dcjq-parent active" <?php } ?>>
					<i class="fa fa-truck"></i>
					<span>Free Shipping Management</span>
				</a>
				<ul class="sub">					
					<li class="sub-menu">
						<a href="<?php echo base_url(); ?>superadmin/free_shipping_category" <?php if($uriSeg2=='free_shipping_category'){ ?> class="dcjq-parent active sun-menu-active" <?php } ?>><i class="fa fa-book"></i><span>Free Shipping Category</span></a>
					</li>
					<li class="sub-menu">
						<a href="<?php echo base_url(); ?>superadmin/free_shipping_product" <?php if($uriSeg2=='free_shipping_product'){ ?> class="dcjq-parent active sun-menu-active" <?php } ?>>
							<i class="fa fa-laptop"></i><span>Free Shipping Product</span>
						</a>
					</li>	
				</ul>
			</li>

			<li class="sub" style="padding-bottom:80px;">
				<a href="javascript:void(0);" <?php if(($uriSeg2=='new_order')||($uriSeg2=='confirm_order')||($uriSeg2=='ready_to_shipped')||($uriSeg2=='shipped_in_transit')||($uriSeg2=='delivered_order')||($uriSeg2=='history_order')||($uriSeg2=='vendor_management')||($uriSeg2=='search_order')||($uriSeg2=='order_management')){ ?> class="dcjq-parent active" <?php } ?>>
					<i class="fa fa-truck"></i>
					<span>Shipping Management</span>
				</a>
				<ul class="sub" style="height:450px;">
					<li>
						<a <?php if($uriSeg2=='order_management'){ ?> class="sun-menu-active" <?php } ?> href="<?php echo base_url().'superadmin/order_management'; ?>">
							<i class="fa fa-truck"></i>
							<span>Orders Management</span>
						</a>
					</li>
					<li>
						<a <?php if($uriSeg2=='vendor_management'){ ?> class="sun-menu-active" <?php } ?> href="<?php echo base_url(); ?>superadmin/vendor_management">
							<i class="fa fa-truck"></i>
							<span>Shipping Vendors</span>
						</a>
					</li>	
                    <li>
						<a <?php if($uriSeg2=='search_order'){ ?> class="sun-menu-active" <?php } ?> href="<?php echo base_url(); ?>superadmin/search_order">
							<i class="fa fa-search"></i>
							<span>Search</span>
						</a>
					</li>							                   	
				</ul>
			</li>	
			
				
			</ul>
    		<!-- sidebar menu end-->
		</div>
	</div>
</aside>
<!--sidebar end-->