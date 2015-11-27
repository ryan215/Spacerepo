<!--sidebar start-->
<style>
.sun-menu-active
{
	color:#ff6c60 !important;
}
</style>
<aside>
	<div id="sidebar"  class="nav-collapse ">
    	<!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">       	
			<?php
			$user_permission = json_decode($this->session->userdata('userpermission'));
			$urlSegment  = $this->uri->segment(2);
			$urlSegment3 = $this->uri->segment(3);
			$flag        = FALSE;
			$catFlag     = FALSE;
			$locFlag     = FALSE;
			
			if(($urlSegment=='segment')||($urlSegment=='category')||($urlSegment=='sub_category')||($urlSegment=='sub_category2')||($urlSegment=='sub_category3')||($urlSegment=='sub_category4')||($urlSegment=='sub_category5')||($urlSegment=='sub_category6'))
			{
				$flag    = TRUE;
				$catFlag = TRUE;
			}
			elseif(($urlSegment=='brand'))
			{
				$flag = TRUE;
			}
			elseif($urlSegment=='location')
			{
				$flag    = TRUE;
				$locFlag = TRUE;
			}
			?>
			<li>
				<a href="<?php echo base_url(); ?>marketing/dashboard" <?php if($urlSegment=='dashboard'){ ?> class="dcjq-parent active" <?php } ?>>
                	<i class="fa fa-dashboard"></i>
	                <span>Dashboard</span>
                </a>
			</li>
			<li>
				<a href="<?php echo base_url(); ?>marketing/slider_list" <?php if($urlSegment=='slider_list'){ ?> class="dcjq-parent active" <?php } ?>>
                	<i class="fa fa-dashboard"></i>
	                <span>Slider</span>
                </a>
			</li>
            <li>
				<a href="<?php echo base_url(); ?>marketing/left_section" <?php if($urlSegment=='left_section'){ ?> class="dcjq-parent active" <?php } ?>>
                	<i class="fa fa-dashboard"></i>
	                <span>Left Section</span>
                </a>
			</li>
            <li>
				<a href="<?php echo base_url(); ?>marketing/right_section" <?php if($urlSegment=='slider_list'){ ?> class="dcjq-parent active" <?php } ?>>
                	<i class="fa fa-dashboard"></i>
	                <span>Right Section</span>
                </a>
			</li>
			
		</ul>
	<!-- sidebar menu end-->
	</div>
</aside>
<!--sidebar end-->