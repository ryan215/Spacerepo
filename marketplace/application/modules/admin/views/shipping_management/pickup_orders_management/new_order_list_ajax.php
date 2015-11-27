<?php //echo "<pre>"; print_r($result['list']); exit;
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
		
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
    <td>
		<?php 
		if($row->organizationName)
		{
			echo $row->organizationName; 
		}
		else
		{
			echo $row->firstName.' '.$row->lastName; 
		}
		?>
	</td>
	<td>&#x20A6;<?php echo number_format($row->chargedAmount*$row->quantity,2); ?></td>
    <td>
		<?php
		if($this->session->userdata('userType')=='retailer')
		{
			if($row->orderStatusId==6)
			{
				echo 'Declined';
			}
			else
			{
		?>
		<a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="return accept_decline('<?php echo id_encrypt($row->orderId); ?>',7);">
			Accept
		</a> 
		<a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="return accept_decline('<?php echo id_encrypt($row->orderId); ?>',11);">
			Decline
		</a>
		<?php	
			}
		}
		else
		{
		?>
		<center>
			<a href="<?php echo base_url().$this->session->userdata('userType').'/new_pickup_order/new_order_view/'.id_encrypt($row->orderId); ?>" class="btn btn-warning btn-xs" type="button" title="View Detail">
			<i class="fa fa-eye"></i>
		</a></center>
		<?php
			//echo 'A Waiting for retailer Confirmation';
		}
		?>
	</td>
	
</tr>	
<?php	
		$i++;
	}
	if(!empty($result['links']))
	{
?>
<tr>
	<td colspan="6" align="right">
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
	<td colspan="6" align="center">Data Not Found</td>
</tr>	
<?php
}
?>
