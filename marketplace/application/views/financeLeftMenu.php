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
			<li class="sub-menu">
				<a <?php if($uriSeg2=='settlement_report'){ ?> class="active" <?php } ?> href="<?php echo base_url(); ?>finance/settlement_report">
					<i class="fa fa-money"></i>
					<span>Settlement Report</span>
				</a>
			</li>
			
    	</ul>
	</div>
</aside>
<!--sidebar end-->