<!--sidebar start-->
<aside>
	<div id="sidebar"  class="nav-collapse " >
    	<!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion"> 
			<div style="height:600px;overflow-y:scroll;overflow-x:hidden;">	
				<?php
				$uriSeg2 = $this->uri->segment(2);
				$uriSeg3 = $this->uri->segment(3);
				$uriSeg4 = $this->uri->segment(4);
				$uriSeg5 = $this->uri->segment(5);
				?>			
				<li>
					<a href="<?php echo base_url().'pointeforce/dashboard'; ?>" <?php if($uriSeg2=='dashboard'){ ?> class="dcjq-parent active" <?php } ?>>
                		<i class="fa fa-dashboard"></i>
	                	<span>Dashboard</span>
                	</a>
				</li>
				<li>
					<a href="<?php echo base_url().'pointeforce/balance_management'; ?>" <?php if($uriSeg2=='balance_management'){ ?> class="dcjq-parent active" <?php } ?>>
                		<i class="fa fa-dashboard"></i>
	                	<span>Balance Management</span>
                	</a>
				</li>
			</div>
		</ul>
	<!-- sidebar menu end-->
	</div>
</aside>
<!--sidebar end-->