<?php
$shippingOrgId		= $this->session->userdata('organizationId');
$totalAvailableAmt 	= $this->finance_vendor_m->vendor_available_total_amount($shippingOrgId);
$totalProcessingAmt = $this->finance_vendor_m->vendor_processing_total_amount($shippingOrgId);
$totalPaidAmt 	 	= $this->finance_vendor_m->vendor_paid_total_amount($shippingOrgId);
?>
<div class="row state-overview">
	<div class="col-lg-3 col-sm-6">
    	<section class="panel">
        	<div class="symbol blue" style="background-color:#78CD51;">
            	<i class="fa fa-usser">&#8358;</i>
            </div>
            <div class="value">
            	<h1>
                	<?php echo number_format($totalAvailableAmt,2); ?>
                </h1>
                <p>Available balance</p>
			</div>
		</section>
	</div>
	<div class="col-lg-3 col-sm-6">
    	<section class="panel">
        	<div class="symbol yellow">
            	<i class="fa fa-usser">&#8358;</i>
            </div>
            <div class="value">
            	<h1>
                	<?php echo number_format($totalProcessingAmt,2); ?>
                </h1>
                <p>Processing balance</p>
			</div>
		</section>
	</div>
	<div class="col-lg-3 col-sm-6">
		<section class="panel">
        	<div class="symbol red">
            	<i class="fa fa-usser">&#8358;</i>
			</div>
			<div class="value">
            	<h1>
                	<?php echo number_format($totalPaidAmt,2); ?>
                </h1>
				<p>Paid balance</p>
			</div>
		</section>
	</div>
</div>