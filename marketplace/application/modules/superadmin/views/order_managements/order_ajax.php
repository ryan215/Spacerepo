<?php //echo "<pre>"; print_r($result['list']); exit;
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
		
?>
<tr>
	<td>
		<?php echo $i; ?>
	</td>
	<td>
		<table width="100%" class="table table-striped   stock_table cus_table">
    		<tr>
            	<td style="border-top:none;">
                	<strong>Date & Time</strong>
                </td>
                <td style="border-top:none;">
                	<?php echo $row->createDt; ?>
                </td>
			</tr>
			<tr>
            	<td>
                	<strong>Order Id</strong>
                </td>
                <td>
                	<?php echo $row->customOrderId; ?>
                </td>
            </tr>
			<?php
			if($this->session->userdata('userType')!='retailer')
			{
			?>
			<tr>
            	<td><strong>Order Type</strong></td>
                <td>
					<?php 
					if($row->isPickup)
					{
						echo 'Pick Up';
					}
					else
					{
						if($row->isEconomicDelivery)
						{
							echo 'Single Shipment';
						}
						else
						{
							echo 'Quick Shipment';
						}
					} 
					?>
				</td>
            </tr>
			<tr>
            	<td>
                	<strong>Payment Mode</strong>
                </td>
                <td>
					<?php 
					if($row->isPickup)
					{
						if($row->paymentStatus)
						{
							echo 'Pay Online';
						}
						else
						{
							echo 'Pay On Pickup';
						}
					}
					else
					{
						if($row->paymentStatus)
						{
							echo 'Pay Online';
						}
						else
						{
							echo 'Cash On Delivery';
						}
					}					
					?>
				</td>
            </tr>
			<?php
			}
			?>
		</table>
	</td>
	<td>
		<table width="100%" class="table table-striped   stock_table cus_table">
    		<tr>
            	<td style="border-top:none;">
                	<strong>Product Name</strong>
                </td>
                <td style="border-top:none;">
                	<?php echo $row->code; ?>
                </td>
			</tr>
			<tr>
            	<td>
                	<strong>Price</strong>
                </td>
                <td>
                	<?php 
					if($this->session->userdata('userType')!='retailer')
					{
						$totalAmt =($row->chargedAmount*$row->quantity);
						if($row->isPickup)
						{
						}
						else
						{
							if($row->isEconomicDelivery)
							{
								$totalAmt = $row->totalAmount;
								if($row->isCalculateShipp)
								{/*
									if($row->totalProductWeight>10)
									{
										$totalAmt = $totalAmt+($row->shippingRate*$row->totalProductWeight);
									}
									else
									{
										$totalAmt = $totalAmt+$row->shippingRate;
									}								
								*/}
							}
							else
							{
								if($row->freeShipPrdId)
								{}
								elseif($row->freeShipCatId)
								{}
								elseif($row->genuineShippFee)
								{
									if($row->productWeight>10)
									{
										$totalAmt = $totalAmt+($row->shippingRate*$row->productWeight*$row->quantity);
									}
									else
									{
										$totalAmt = $totalAmt+($row->shippingRate*$row->quantity);
									} 
								}
							}
							
							if($row->paymentStatus)
							{
							}
							else
							{
								if($row->isEconomicDelivery)
								{
									$totalAmt = $row->totalAmount;
								}
								else
								{
									if($row->orderId>114)
									{							
										$totalAmt = $totalAmt+$row->cashHandlingPrice;
									}
									else
									{
										$handlingPrice = ($totalAmt*$this->config->item('space_point_comission'))/100;
										$totalAmt = $totalAmt+$handlingPrice;
									}
								}
							}
						}
						echo '&#x20A6;'.number_format($totalAmt,2); 
					}
					else
					{
						echo '&#x20A6;'.number_format($row->retailerPrice,2);					
					}
					?>
                </td>
            </tr>
		</table>
	</td>
	<?php
	if($this->session->userdata('userType')!='retailer')
	{
	?>
	<td>
		<table width="100%" class="table table-striped   stock_table cus_table">
    		<tr>
            	<td style="border-top:none;">
                	<strong>Name</strong>
                </td>
                <td style="border-top:none;">
                	<?php echo $row->organizationName; ?>
                </td>
			</tr>
			<tr>
            	<td>
                	<strong>Phone No.</strong>
                </td>
                <td>
                	<?php echo $row->businessPhoneCode.''.$row->businessPhone; ?>
                </td>
            </tr>
		</table>
	</td>
	<td>
		<table width="100%" class="table table-striped   stock_table cus_table">
    		<tr>
            	<td style="border-top:none;">
                	<strong>Name</strong>
                </td>
                <td style="border-top:none;">
                	<?php echo $row->firstName.' '.$row->lastName; ?>
                </td>
			</tr>
			<tr>
            	<td>
                	<strong>Phone No.</strong>
                </td>
                <td>
                	<?php 
					echo $row->phone;
					?>
                </td>
            </tr>
			<?php
			if($row->isPickup)
			{
			}
			else
			{
			?>
				<tr>
            	<td>
                	<strong>State</strong>
                </td>
                <td>
                	<?php echo $row->stateName; ?>
                </td>
            </tr>
				<tr>
            	<td>
                	<strong>Area</strong>
                </td>
                <td>
                	<?php echo $row->areaName; ?>
                </td>
            </tr>
				<tr>
            	<td>
                	<strong>City</strong>
                </td>
                <td>
                	<?php echo $row->cityName; ?>
                </td>
            </tr>
			<?php
			}
			?>
		</table>
	</td>
	<?php
	}
	?>
	<td>
		<?php
		if($row->isPickup)
		{	
			if(($row->orderStatusId==1)&&($row->active))
			{
				echo 'New Pickup Order';
			}
			elseif(($row->orderStatusId==2)&&($row->active))
			{
				echo 'Confirm Pickup Order';
			}
			elseif(($row->orderStatusId==3)&&($row->active))
			{
				echo 'Ready To Pickup Order';
			}
			elseif(($row->orderStatusId==5)&&($row->active))
			{
				echo 'Order Picked Up';
			}
			elseif(($row->orderStatusId==6)&&($row->active))
			{
				echo 'Order Declined';
			}
			elseif($row->active==0)		
			{
				echo 'Cancel Order';
			}
		}
		else
		{
			if(($row->orderStatusId==1)&&($row->active))
			{
				echo 'New Order';
			}
			elseif(($row->orderStatusId==2)&&($row->active))
			{
				echo 'Confirm Order';
			}
			elseif(($row->orderStatusId==3)&&($row->active))
			{
				echo 'Ready To Shipped';
			}
			elseif(($row->orderStatusId==4)&&($row->active))
			{
				echo 'Shipped In Transit';
			}
			elseif(($row->orderStatusId==5)&&($row->active))
			{
				echo 'Delivered Order';
			}
			elseif(($row->orderStatusId==6)&&($row->active))
			{
				echo 'Order Declined';
			}
			elseif($row->active==0)		
			{
				echo 'Cancel Order';
			}
		}
		?>
	</td>
	<td>
    	<?php echo $row->dropCenterName; ?>
    </td>
    <td>
		<center>
			<?php
			if($row->isEconomicDelivery)
			{
			?>
			<a href="<?php echo base_url().$this->session->userdata('userType').'/order_management/economic_order_view/'.$row->customOrderId; ?>" class="btn btn-warning btn-xs" type="button" title="View Detail">
				<i class="fa fa-eye"></i>
			</a>
			<?php
			}
			else
			{
			?>
			<a href="<?php echo base_url().$this->session->userdata('userType').'/order_management/order_view/'.id_encrypt($row->orderId); ?>" class="btn btn-warning btn-xs" type="button" title="View Detail">
				<i class="fa fa-eye"></i>
			</a>
			<?php
			}
			?>			
		</center>
	</td>
</tr>	
<?php	
		$i++;
	}
	if(!empty($result['links']))
	{
?>
<tr>
	<td colspan="10" align="right">
		<div class="pagination">
			<?php echo $result['links']; ?>
		</div>
	</td>
</tr>	
<?php
	}
}
else
{
?>
<tr>
	<td colspan="10" align="center">Data Not Found</td>
</tr>	
<?php
}
?>
<style>
.cus_table tbody tr td{ padding:5px; border-radius:0px;}
</style>
