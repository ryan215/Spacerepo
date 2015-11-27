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
                	<?php echo $row->productName; ?>
                </td>
			</tr>
			<tr>
            	<td>
                	<strong>Price</strong>
                </td>
                <td>
                	<?php echo '&#x20A6;'.number_format($row->totalCustomAmount,2);	?>
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
                	<?php echo $row->businessPhone; ?>
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
			<a href="<?php echo base_url().$this->session->userdata('userType').'/order_search_management/order_search_view/'.id_encrypt($row->orderCustomPaymentId); ?>" class="btn btn-warning btn-xs" type="button" title="View Detail">
				<i class="fa fa-eye"></i>
			</a>
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
