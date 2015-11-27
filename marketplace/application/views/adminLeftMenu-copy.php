<!--sidebar start-->
<style>
.sun-menu-active
{
	color:#ff6c60 !important;
}
</style>
<aside>
	<div id="sidebar"  class="nav-collapse " >
    	<!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion"> 
		<div style="height:600px;overflow-y:scroll;overflow-x:hidden;">	
			<?php
			$user_permission = $this->session->userdata('userpermission');
			$userRole 		 = $this->session->userdata('userRole');
			$uriSeg2  		 = $this->uri->segment(2);
			$uriSeg3     	 = $this->uri->segment(3);
			$uriSeg4     	 = $this->uri->segment(4);
			$uriSeg5     	 = $this->uri->segment(5);
			?>			
			<li>
				<a href="<?php echo base_url(); ?>admin/dashboard" <?php if(($uriSeg2=='dashboard')||($uriSeg2=='shipping_bounce')){ ?> class="dcjq-parent active" <?php } ?>>
                	<i class="fa fa-dashboard"></i>
	                <span>Dashboard</span>
                </a>
			</li>
			<?php
			if(!empty($user_permission) && (in_array('RM',$user_permission)))
			{
			?>
			<li>
				<a href="<?php echo base_url(); ?>admin/retailer_management" <?php if(($uriSeg2=='retailer_management')||($uriSeg3=='check_stocks')||(($uriSeg4!='')&&($uriSeg3=='index'))||($uriSeg3=='add_inventory')||($uriSeg3=='inventory_details')||(($uriSeg3=='view')&&($uriSeg5!=0))){ ?> class="active" <?php } ?>>
                	<i class="fa fa-user"></i>
	                <span>Retailer Management</span>
                </a>
			</li>
			<?php
			} 	
			if($userRole !='SVE')
			{
			?>
			<li>
				<a href="<?php echo base_url(); ?>admin/cse_management" <?php if($uriSeg2=='cse_management'){ ?> class="active" <?php } ?>>
                	<i class="fa fa-user"></i>
	                <span>CSE Management</span>
                </a>
			</li>
			<?php 
			}
			if(!empty($user_permission) && (in_array('CUSTOMER',$user_permission)))
			{
			?>
			<li>
				<a href="<?php echo base_url().'admin/customer_management'; ?>" <?php if($uriSeg2=='customer_management'){ ?> class="active" <?php } ?>>
					<i class="fa fa-book"></i>
					<span>Customer Management</span>
				</a>
			</li>
			<?php
			}
			if(!empty($user_permission) && (in_array('PFM',$user_permission)))
			{
			?>
			<li>
				<a href="<?php echo base_url().'admin/pointeforce_management'; ?>" <?php if($uriSeg2=='pointeforce_management'){ ?> class="active" <?php } ?>>
					<i class="fa fa-book"></i>
					<span>Pointe Force Management</span>
				</a>
			</li>
			<?php
			}
			if(!empty($user_permission) && (in_array('CM',$user_permission)))
			{
			?>
			<li>
				<a href="<?php echo base_url(); ?>admin/category_management/view_list" <?php if($uriSeg2=='category_management'){ ?> class="active" <?php } ?>>
					<i class="fa fa-book"></i>
					<span>Category Management</span>
				</a>
			</li>
			<li>
				<a href="<?php echo base_url(); ?>admin/marketing_category_management/view_list" <?php if($uriSeg2=='marketing_category_management'){ ?> class="active" <?php } ?>>
					<i class="fa fa-book"></i>
					<span>Merchandising  Category Mgt</span>
				</a>
			</li>
			<?php 
			}
			if(!empty($user_permission) && (in_array('BM',$user_permission)))
			{			
			?>
			<li>
				<a href="<?php echo base_url(); ?>admin/brand_management" <?php if($uriSeg2=='brand_management'){ ?> class="dcjq-parent active" <?php } ?>>
					<i class="fa fa-ticket"></i>
					Brand Management
				</a>
			</li>
			<li class="sub-menu">
            		<a href="<?php echo base_url(); ?>admin/marketing/slider_list" <?php if(($uriSeg2=='marketing')||($uriSeg2=='news_management')){ ?> class="dcjq-parent active" <?php } ?>>
                		<i class="fa fa-camera-retro"></i>
		                <span>Marketing Management</span>
	                </a>
                    <ul class="sub">
                   		<?php /*?> <li>
									<a href="<?php echo base_url(); ?>admin/marketing/slider_list" <?php if(($uriSeg3=='slider_list')||($uriSeg3=='addEditSliderList')){ ?> class="active" <?php } ?>>
										slider list
									</a>
						</li>
                         <li>
									<a href="<?php echo base_url(); ?>admin/marketing/left_section" <?php if(($uriSeg3=='left_section')||($uriSeg3=='addLeftSlider')){ ?> class="sun-menu-active" <?php } ?>>
										Left Section
									</a>
						</li>
                         <li>
									<a href="<?php echo base_url(); ?>admin/marketing/right_section" <?php if(($uriSeg3=='right_section')||($uriSeg3=='addRightSlider')){ ?> class="sun-menu-active" <?php } ?>>
										Right Section
									</a>
						</li><?php */?>
							 <?php /*?><li>
							<a href="<?php echo base_url(); ?>admin/news_management" <?php if($uriSeg2=='news_management'){ ?> class="sun-menu-active" <?php } ?>>
								Old NewsLetter
							</a>
						</li><?php */?>
                        <li>
                            <a href="<?php echo base_url(); ?>admin/news_subscription/test1" <?php if($uriSeg2=='news_subscription'&& $uriSeg3==''){ ?> class="sun-menu-active" <?php } ?>>
                               Newsletter Subscription
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>admin/news_subscription" <?php if($uriSeg2=='news_subscription'&& $uriSeg3==''){ ?> class="sun-menu-active" <?php } ?>>
                               Kate Henshaw campaign
                            </a>
                        </li>
					<li>
                            <a href="<?php echo base_url(); ?>admin/news_subscription/vip_listing" <?php if($uriSeg3=='vip_listing'){ ?> class="sun-menu-active" <?php } ?>>
                               Join VIP campaign
                            </a>
                        </li>
						
                    </ul>
				</li>
			<?php 
			}
			if(!empty($user_permission) && (in_array('LM',$user_permission)))
			{
			?>
			<li>
				<a href="javascript:void(0);" <?php if($uriSeg2=='location_management'){ ?> class="dcjq-parent active" <?php } ?>>
					<i class="fa fa-map-marker"></i>
					<span>Location Management</span>
				</a>
				<ul class="sub">
					<li>
						<a href="<?php echo base_url(); ?>admin/location_management" <?php if(($uriSeg2=='location_management')&&(($uriSeg3=='')||($uriSeg3=='index')||($uriSeg3=='addEditCountry'))){ ?> class="sun-menu-active" <?php } ?> >
							Country
						</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>admin/location_management/state_list_view" <?php if(($uriSeg3=='state_list_view')||($uriSeg3=='addEditState')){ ?> class="sun-menu-active" <?php } ?> >
							State
						</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>admin/location_management/area_list_view" <?php if(($uriSeg3=='area_list_view')||($uriSeg3=='addEditArea')){ ?> class="sun-menu-active" <?php } ?> >
							Area
						</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>admin/location_management/zip_list_view" <?php if(($uriSeg3=='zip_list_view')||($uriSeg3=='addEditZip')){ ?> class="sun-menu-active" <?php } ?> >
							City
						</a>
					</li>
				</ul>
			</li>
			<?php 
			} 
			if(!empty($user_permission) && (in_array('PM',$user_permission)))
			{			
			?>
			
			<li class="sub-menu">
				<a href="<?php echo base_url(); ?>admin/product_management" <?php if((($uriSeg2=='product_management')&&($uriSeg3!='check_stocks')&&($uriSeg3!='index')&&($uriSeg3!='add_inventory')&&($uriSeg3!='inventory_details')&&($uriSeg5==0))||($uriSeg2=='semantics')||($uriSeg2=='product_request_management')){ ?> class="dcjq-parent active" <?php } ?>>
					<i class="fa fa-laptop"></i>
					<span>Product Management</span>
				</a>
			</li>
			<?php /*?><li>
					<a href="<?php echo base_url(); ?>admin/finance_pointe_force_management" <?php if(($uriSeg2=='finance_pointe_force_management')||($uriSeg2=='finance_retailer_management')||($uriSeg2=='finance_vendor_management')){ ?> class="dcjq-parent active" <?php } ?>>
						<i class="fa fa-credit-card"></i>
						<span>Finance Management</span>
					</a>
					<ul class="sub">
						<li>
							<a href="<?php echo base_url(); ?>admin/finance_pointe_force_management" <?php if($uriSeg2=='finance_pointe_force_management'){ ?> class="sun-menu-active" <?php } ?> >
								PointeForce Agents
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/finance_retailer_management" <?php if($uriSeg2=='finance_retailer_management'){ ?> class="sun-menu-active" <?php } ?> >
								Retailers
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/finance_vendor_management" <?php if($uriSeg2=='finance_vendor_management'){ ?> class="sun-menu-active" <?php } ?> >
								Shipping Vendors
							</a>
						</li>
						
					</ul>
				</li><?php */?>
			<?php 
			}
			if(!empty($user_permission) && (in_array('FM',$user_permission)))
			{
			?>
			<li class="sub-menu">
				<a href="<?php echo base_url().'admin/finance_pointe_force_management'; ?>" <?php if(($uriSeg2=='finance_pointe_force_management')||($uriSeg2=='finance_retailer_management')||($uriSeg2=='finance_vendor_management')){ ?> class="dcjq-parent active" <?php } ?>>
					<i class="fa fa-credit-card"></i>
					<span>Finance Management</span>
				</a>
			</li>
			<?php
			}
			if(!empty($user_permission) && (in_array('SM',$user_permission)))
			{
			?>
			<li class="sub" style="padding-bottom:80px;">
				<a href="javascript:void(0);" <?php if(($uriSeg2=='new_order')||($uriSeg2=='confirm_order')||($uriSeg2=='ready_to_shipped')||($uriSeg2=='shipped_in_transit')||($uriSeg2=='delivered_order')||($uriSeg2=='history_order')||($uriSeg2=='vendor_management')||($uriSeg2=='new_pickup_order')||($uriSeg2=='ready_to_pickup')||($uriSeg2=='order_picked_up')||($uriSeg2=='confirm_pickup_order')||($uriSeg2=='history_order_pickup')||($uriSeg2=='order_management')){ ?> class="dcjq-parent active" <?php } ?>>
						<i class="fa fa-truck"></i>
						<span>Shipping Management</span>
					</a>
				<ul class="sub" style="height:450px;">
					<li>
						<a <?php if($uriSeg2=='order_management'){ ?> class="sun-menu-active" <?php } ?> href="<?php echo base_url().'admin/order_management'; ?>">
							<i class="fa fa-truck"></i>
							<span>Orders Management</span>
						</a>
					</li>
					<li>
						<a <?php if($uriSeg2=='vendor_management'){ ?> class="sun-menu-active" <?php } ?> href="<?php echo base_url(); ?>admin/vendor_management">
							<i class="fa fa-truck"></i>
							<span>Shipping Vendors</span>
						</a>
					</li>
						<li>
						<a <?php if($uriSeg2=='employee_management'){ ?> class="sun-menu-active" <?php } ?> href="<?php echo base_url(); ?>admin/employee_management">
							<i class="fa fa-truck"></i>
							<span>Shipping employee</span>
						</a>
					</li>
					<li>
						<a <?php if($uriSeg2=='search_order'){ ?> class="sun-menu-active" <?php } ?> href="<?php echo base_url(); ?>admin/search_order">
							<i class="fa fa-search"></i>
							<span>Search</span>
						</a>
					</li>		
                    							
				</ul>
			</li>
			<?php 
			}
			
			if($userRole=='SVE')
			{
			?>
				<li>
					<a href="javascript:void(0);" <?php if($uriSeg2=='location_management'){ ?> class="dcjq-parent active" <?php } ?>>
						<i class="fa fa-map-marker"></i>
						<span>Location Management</span>
					</a>
					<ul class="sub">
						<li>
							<a href="<?php echo base_url(); ?>admin/location_management" <?php if(($uriSeg2=='location_management')&&(($uriSeg3=='')||($uriSeg3=='index')||($uriSeg3=='addEditCountry'))){ ?> class="sun-menu-active" <?php } ?> >
								Country
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/location_management/state_list_view" <?php if(($uriSeg3=='state_list_view')||($uriSeg3=='addEditState')){ ?> class="sun-menu-active" <?php } ?> >
								State
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/location_management/area_list_view" <?php if(($uriSeg3=='area_list_view')||($uriSeg3=='addEditArea')){ ?> class="sun-menu-active" <?php } ?> >
								Area
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/location_management/zip_list_view" <?php if(($uriSeg3=='zip_list_view')||($uriSeg3=='addEditZip')){ ?> class="sun-menu-active" <?php } ?> >
								City
							</a>
						</li>
					</ul>
				</li>
				
				<li class="sub" style="padding-bottom:0;">
				<a href="javascript:void(0);" <?php if(($uriSeg2=='vendor_management')||($uriSeg2=='order_management')){ ?> class="dcjq-parent active" <?php } ?>>
						<i class="fa fa-truck"></i>
						<span>Shipping Management</span>
					</a>
					<li>
						<a <?php if($uriSeg2=='vendor_management'){ ?> class="sun-menu-active" <?php } ?> href="<?php echo base_url().'admin/vendor_management'; ?>">
							<i class="fa fa-truck"></i>
							<span>Shipping Vendors</span>
						</a>
					</li>
					<li class="sub">
						<a <?php if($uriSeg2=='order_management'){ ?> class="sun-menu-active" <?php } ?> href="<?php echo base_url().'admin/order_management'; ?>">
							<i class="fa fa-truck"></i>
							<span>Orders Management</span>
						</a>
					</li>
				
			</li>				
				<?php 
			}
			if(!empty($user_permission) && (in_array('POINTEPAYADMIN',$user_permission)))
			{
			?>
			<li>
				<a href="<?php echo base_url().'admin/pointepay_management/retailerList'; ?>" <?php if($uriSeg2=='pointepay_management'){ ?> class="active" <?php } ?>>
					<i class="fa fa-book"></i>
					<span>Pointe Pay Admin</span>
				</a>
			</li>
			<?php
			}
			?>
				
		</div>
	</ul>
	<!-- sidebar menu end-->
	</div>
</aside>
<!--sidebar end-->