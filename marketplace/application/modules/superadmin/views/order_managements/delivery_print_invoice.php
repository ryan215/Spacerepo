<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/qr_code/kendo.all.min.js"></script>
<?php //echo "<pre>"; print_r($result); exit; ?>
<table class="table table-invoice table-custom" style="width:100%;margin-bottom:0px !important; border:none; border-top:2px solid #000;">
	<tbody>
		<tr>
			<td width="55%" style="padding-top:0px; padding-bottom:0px;"> 
				<img src="<?php echo base_url(); ?>images/logo.png"  class="img-responsive"/>
			</td>
			<td width="45%" style="padding-top:0px; padding-bottom:0px;"> 
				<div id="qrCode" style="float:right;"></div>				
			</td>
		</tr>	
	</tbody>	
</table>
<table class="table table-invoice table-custom" style="width:100%;  margin-bottom:0px !important;">
	<tbody>
		<tr>		<?php //echo "<pre>"; print_r($result); exit; ?>
			<td width="55%" style="padding-top:15px; vertical-align:top !important;">
				<p><b>Order Id</b> - <?php echo $result['customerOrderId']; ?></p>
				<p><b>Tracking No.</b> - <?php echo $result['trackingNbr']; ?></p>
				<p><b>Shipping Vendor </b> - <?php echo $result['vendorBusinessName']; ?></p>
				<p><b>Contact No.</b> - <?php echo $result['customerPhone']; ?></p>
				<p><b>Address</b> - <?php echo $result['shippingAddressLine1'].','.$result['shippingAddressLine2'].','.$result['shippingCity']?></p>
				<p><?php echo $result['shippingArea'].','.$result['shippingState']; ?></p>
				<p><b>Seller</b> - <?php echo $result['retailerOrganizationName']; ?></p>
				<p><b>Date</b> - <?php echo date('d M Y'); ?></p>
			</td>
			<td width="45%" style="padding-top:15px;vertical-align:top !important;">
				<h3 style="margin-top:0px !important;">Shipping Address</h3>
				<h4>
					<?php 
					echo $result['customerFirstName'].' '.$result['customerLastName'].' '.$result['customerLastName']; 
					?>
				</h4><br>
				<p>Phone No. - <?php echo $result['customerPhone']; ?></p>
				<p><?php echo $result['shippingAddressLine1']; ?>  <?php echo $result['shippingAddressLine2']; ?> , <?php echo $result['shippingCity']; ?></p>
				
				<p><?php echo $result['shippingArea']; ?></p>
				<p><?php echo $result['shippingState']; ?></p>
				<?php /*?><p><?php echo $result['shippingCountry']; ?></p><?php */?>
			</td>
		</tr>	
	</tbody>	
</table>

<table class="table table-invoice table-custom" style="width:100%;margin-bottom:0px !important;">
	<thead style="background-color:#A9D86E; color:#FFF;">
		<tr>
			
			<th width="20%">Product</th>
			<th width="10%">Qty</th>
			<th width="10%">Price/Qty</th>
			<th width="10%">Amount</th>
			
		</tr>	
	</thead>
	<tbody>
		<tr>
			
			<td><?php echo $result['productName']; ?></td>
			<td><?php echo $result['productQuantity']; ?></td>
			<td>&#x20A6;<?php echo number_format($result['chargedAmount'],2); ?>/<?php echo $result['productQuantity']; ?></td>
			<td>&#x20A6;<?php echo number_format(($result['chargedAmount']*$result['productQuantity']),2); 
			$totalAmt = $result['chargedAmount']*$result['productQuantity'];
			?></td>
			
		</tr>	
		<tr>
			<td colspan="2"></td>			
			<td>Shipping</td>
			<td><?php
				$shippingR = 0;
				if($result['freeShipPrdId'])
				{
					echo 'Free Shipping';
				}
				elseif($result['freeShipCatId'])
				{
					echo 'Free Shipping';
				}
				elseif($result['genuineShippFee'])
				{
					echo '&#x20A6;'.number_format(($result['shippingRate']*$result['productQuantity']),2);
					$shippingR = $result['shippingRate']*$result['productQuantity']; 
				}
				$totalAmt = $totalAmt+$shippingR;
				?>
			</td>
		</tr>
		<?php
		$cashHandFee = 0;
		if($result['paymentStatus'])
		{}
		else
		{			
		?>
		<tr>
			<td colspan="2"></td>			
			<td>Cash Handling Fee</td>
			<td>
				<?php
				if($result['orderID']>114)
				{							
					echo '&#x20A6;'.number_format($result['cashHandlingPrice'],2);
					$cashHandFee = $result['cashHandlingPrice'];	
				}
				else
				{
					$cashHandFee = ($totalAmt*$this->config->item('space_point_comission'))/100;
					echo '&#x20A6;'.number_format($cashHandFee,2);
				}
				?>
			</td>
		</tr>
        <?php
		}
		$totalAmt = $totalAmt+$cashHandFee;
		?>		
		<tr>	
			<td colspan="2"></td>
			<td><h2 style="margin:0px !important;">Total</h2></td>
			<td>
				<h2 style="margin:0px !important;">&#x20A6;<?php echo number_format($totalAmt,2); ?></h2>
			</td>
		</tr>	
	</tbody>	
</table>
<table class="table table-invoice table-custom" style="width:100%">
	<tbody>
		<tr>	
			<td width="30%">Ph: <?php echo $this->config->item('admin_phone_no'); ?></td>
			<td width="30%"><?php echo $this->config->item('site_name'); ?></td>
			<td width="40%">
				You Can use this label as the invoice .<br> 
				No Sign needed . Not for resale.
			</td>
		</tr>
	</tbody>
</table>
<style>
th,td{
	border:2px solid #000;
}
.table-invoice {
  margin-top: 0px !important; 
  
}
</style>
<script type="text/javascript">
$(document).ready(function () {
	$("#qrCode").kendoQRCode({
		value: "<?php echo $result['trackingNbr']; ?>",
        size: 120,
        color: "#000000",
        background: "transparent"
	});
});
</script>