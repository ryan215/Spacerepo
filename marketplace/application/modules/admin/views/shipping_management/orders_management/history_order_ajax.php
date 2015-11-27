<?php //echo "<pre>"; print_r($result['list']); exit;
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
		$customerName = '';
		$customerDet = $this->order_m->order_shipping_address_details($row->customerId,$row->orderId);
		if(!empty($customerDet))
		{
			$customerName = $customerDet->firstName.' '.$customerDet->lastName;
		}
?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row->createDt; ?></td>
	<td><?php echo $row->customOrderId; ?></td>
	<td>
		<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/view/'.id_encrypt($row->productId); ?>" target="_blank">
			<?php echo $row->code; ?>
		</a>
	</td>
    <td><?php echo $row->organizationName; ?>
	</td>
	<td>&#x20A6;<?php echo number_format(($row->chargedAmount*$row->quantity),2); ?></td>
	<td>
		<?php echo $customerName; ?>
	</td>
    <td>
		<?php 
		if($row->active)
		{
			echo 'Order Complete';
		}
		else
		{
			echo 'Order Cancel';	
		}
		?>
	</td>
    <td>
    	<center>
			<a href="<?php echo base_url().$this->session->userdata('userType').'/history_order/history_order_view/'.id_encrypt($row->orderId); ?>" class="btn btn-warning btn-xs" type="button" title="View Detail">
			<i class="fa fa-eye"></i>
		</a></center>
	</td>
	
</tr>	
<?php	
		$i++;
	}
	if(!empty($result['links']))
	{
?>
<tr>
	<td colspan="9" align="right">
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
	<td colspan="9" align="center">Data Not Found</td>
</tr>	
<?php
}