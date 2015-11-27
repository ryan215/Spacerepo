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
$userRole= $this->session->userdata('userRole');
$userRole=trim($userRole);
?>
<aside>
	<div id="sidebar"  class="nav-collapse ">
		<ul class="sidebar-menu" id="nav-accordion">
		<?php if($userRole != 'SVE') { ?>
			<li class="sub-menu">
				<a <?php if($uriSeg2=='rate_list'){ ?> class="active" <?php } ?> href="<?php echo base_url().'shipping/rate_list'; ?>">
					<i class="fa fa-money"></i>
					<span>Rate List</span>
				</a>
			</li>
		<?php } ?>
			<li class="sub-menu">
				<a <?php if($uriSeg2=='ready_to_shipped'){ ?> class="active" <?php } ?> href="<?php echo base_url().'shipping/ready_to_shipped'; ?>">
					<i class="fa fa-shopping-cart"></i>
					<span>Current Orders</span>
				</a>
			</li>
			<li class="sub-menu">
				<a <?php if($uriSeg2=='shipped_in_transit'){ ?> class="active" <?php } ?> href="<?php echo base_url().'shipping/shipped_in_transit'; ?>">
					<i class="fa fa-truck"></i>
					<span>In Transit</span>
				</a>
			</li>
			<li class="sub-menu">
				<a <?php if($uriSeg2=='delivered_order'){ ?> class="active" <?php } ?> href="<?php echo base_url().'shipping/delivered_order'; ?>">
					<i class="fa fa-home"></i>
					<span>Delivered Orders</span>
				</a>
			</li>
			<li class="sub-menu">
				<a href="<?php echo base_url().'shipping/finance_vendor_management'; ?>" <?php if($uriSeg2=='finance_vendor_management'){ ?> class="dcjq-parent active" <?php } ?>>
					<i class="fa fa-credit-card"></i>
					<span>Wallet</span>
				</a>
			</li>
			<!--	<?php if($userRole != 'SVE') { ?>
			<li class="sub-menu">
				<a <?php if($uriSeg2=='employee_management'){ ?> class="active" <?php } ?> href="<?php echo base_url().'shipping/employee_management'; ?>">
					<i class="fa fa-home"></i>
					<span>Employee Management</span>
				</a>
			</li>
				<?php } ?>
				-->
		</ul>
		<!-- sidebar menu end-->
	</div>
</aside>