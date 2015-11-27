<?php
$totalPointeForceAmt = $this->finance_pointe_porce_m->available_total_amount();
$totalRetailerAmt 	 = $this->finance_retailer_m->available_total_amount();
$totalVendorAmt      = $this->finance_vendor_m->available_total_amount();
$uriSeg2 			 = $this->uri->segment(2);
?>
<div class="row state-overview">
	<div class="col-lg-3 col-sm-6" data-toggle="tooltip" data-original-title="PointeForce Agents">
		<?php
		if((!empty($uriSeg2))&&($uriSeg2=='finance_pointe_force_management'))
		{
		?>
		<a href="javascript:void(0)" title="PointeForce Agents" class="active_tabs_pointefoce" >		
		<?php
		}
		else
		{
		?> 
		<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_pointe_force_management'; ?>" title="PointeForce Agents">
		<?php
		}
		?>
    		<section class="panel">
	        	<div class="symbol blue"  style="background-color:#78CD51;">
    	        	<img src="<?php echo base_url(); ?>images/new_images/force.png" />
        	    </div>
            	<div class="value">
	            	<h1 class="count"><?php echo '&#x20A6;'.number_format($totalPointeForceAmt,2); ?></h1>
					<p>PointeForce Agents</p>
				</div>
			</section>
		</a>
	</div>
	<div class="col-lg-3 col-sm-6" data-toggle="tooltip" data-original-title="Retailers">
		<?php
		if((!empty($uriSeg2))&&($uriSeg2=='finance_retailer_management'))
		{
		?>
		<a href="javascript:void(0)" title="Retailers" class="active_tabs_retailer" >		
		<?php
		}
		else
		{
		?>
		<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_retailer_management'; ?>" title="Retailers">
		<?php
		}
		?>
    		<section class="panel">
	        	<div class="symbol yellow">
    	        	<img src="<?php echo base_url(); ?>images/new_images/retailers.png" />
        	    </div>
            	<div class="value">
	            	<h1 class=" count2"><?php echo '&#x20A6;'.number_format($totalRetailerAmt,2); ?></h1>
					<p>Retailers</p>
				</div>
			</section>
		</a>
	</div>

	<div class="col-lg-3 col-sm-6" data-toggle="tooltip" data-original-title="Shipping Vendors">
		<?php
		if((!empty($uriSeg2))&&($uriSeg2=='finance_vendor_management'))
		{
		?>
		<a href="javascript:void(0)" title="Shipping Vendors" class="active_tabs_vendor" >		
		<?php
		}
		else
		{
		?>
		<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_vendor_management'; ?>" title="Shipping Vendors">
		<?php
		}
		?>
    		<section class="panel">
	        	<div class="symbol red">
    	        	<img src="<?php echo base_url(); ?>images/new_images/shipvndr.png" />
        	    </div>
	            <div class="value">
    	        	<h1 class=" count2"><?php echo '&#x20A6;'.number_format($totalVendorAmt,2); ?></h1>
					<p>Shipping Vendors</p>
				</div>
			</section>
		</a>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({
        placement : 'top'
    });
});
</script>

<style>
.active_tabs_pointefoce section{border-bottom:6px solid #78CD51; border-radius:5px;}
.active_tabs_pointefoce .symbol{ border-radius:5px 0px 0px 0px;}
.active_tabs_retailer section{border-bottom:6px solid #f8d347; border-radius:5px;}
.active_tabs_retailer .symbol{ border-radius:5px 0px 0px 0px;}
.active_tabs_vendor section{border-bottom:6px solid #ff6c60; border-radius:5px;}
.active_tabs_vendor .symbol{ border-radius:5px 0px 0px 0px;}
.state-overview .value h1 {
    font-size: 1.8em;
    font-weight: 300;
    padding-bottom: 12px;
}
</style>