<?php
$organizationId		= $this->session->userdata('organizationId');
$totalAvailableAmt 	= $this->finance_retailer_m->retailer_available_total_amount($organizationId);
$totalProcessingAmt = $this->finance_retailer_m->retailer_processing_total_amount($organizationId);
$totalPaidAmt 	 	= $this->finance_retailer_m->retailer_paid_total_amount($organizationId);
?>
<div class="row state-overview">
	<div class="col-lg-3 col-sm-6">
    	<section class="panel">
        	<div class="symbol blue" style="background-color:#78CD51;">
            	<i class="fa fa-usser">&#8358;</i>
            </div>
            <div class="value">
            	<h1 class="count">
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
            	<h1 class=" count2">
                	<?php echo number_format($totalProcessingAmt,2); ?>
                </h1>
                <p>Current balance</p>
			</div>
		</section>
	</div>
	<div class="col-lg-3 col-sm-6">
		<section class="panel">
        	<div class="symbol red">
            	<i class="fa fa-usser">&#8358;</i>
			</div>
			<div class="value">
            	<h1 class=" count2">
                	<?php echo number_format($totalPaidAmt,2); ?>
                </h1>
				<p>Paid balance</p>
			</div>
		</section>
	</div>
</div>