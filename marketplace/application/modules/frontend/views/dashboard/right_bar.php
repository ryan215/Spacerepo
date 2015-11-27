<?php
$uriSeg1 = $this->uri->segment(1);
$uriSeg2 = $this->uri->segment(2);
$uriSeg3 = $this->uri->segment(3);
?>
<aside class="col-right sidebar col-sm-3">
	<div class="block block-account">
    	<!--<div class="block-title">My Account</div>-->
        <div class="block-content">
        	<ul>
            	<li <?php if(($uriSeg2=='dashboard')&&($uriSeg3=='')){ echo 'class="current"'; } ?>>
					<a href="<?php echo base_url().'frontend/dashboard'; ?>">
						Account Dashboard
					</a>
				</li>
				<li <?php if(($uriSeg2=='order')&&($uriSeg3=='')){ echo 'class="current"'; } ?>>
					<a href="<?php echo base_url().'frontend/order'; ?>">
						My Orders
					</a>
				</li>
				<li <?php if(($uriSeg2=='dashboard')&&(($uriSeg3=='wishlist')||($uriSeg3=='wishlist'))){ echo 'class="current"'; } ?>>
					<a href="<?php echo base_url().'frontend/dashboard/wishlist'; ?>">
						My Wishlist
					</a>
				</li>
              	<li <?php if(($uriSeg2=='dashboard')&&($uriSeg3=='personal_info')){ echo 'class="current"'; } ?>>
					<a href="<?php echo base_url().'frontend/dashboard/personal_info'; ?>">
						My Profile
					</a>
				</li>
				<li <?php if(($uriSeg2=='dashboard')&&($uriSeg3=='change_password')){ echo 'class="current"'; } ?>>
					<a href="<?php echo base_url().'frontend/dashboard/change_password'; ?>">
						Change Password
					</a>
				</li>
              	<li <?php if(($uriSeg2=='dashboard')&&($uriSeg3=='billing_info')){ echo 'class="current"'; } ?>>
					<a href="<?php echo base_url().'frontend/dashboard/billing_info'; ?>">
						Billing Address
					</a>
				</li>
              	<li <?php if(($uriSeg2=='dashboard')&&($uriSeg3=='shipping_info')){ echo 'class="current"'; } ?> style="border-bottom:0;">
					<a href="<?php echo base_url().'frontend/dashboard/shipping_info'; ?>">
						Shipping Address
					</a>
				</li>
              	
			</ul>
		</div>
	</div>
</aside>