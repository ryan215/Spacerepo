<?php
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
		<td>&#x20A6;<?php echo number_format(($row->quantity*$row->chargedAmount),2); ?></td>
		<td>
			<center><a href="<?php echo base_url().$this->session->userdata('userType').'/confirm_order/confirm_order_view/'.id_encrypt($row->orderId); ?>" class="btn btn-warning btn-xs">
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
		<td colspan="14" align="right">
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
		<td colspan="14" align="center">
			No Data Found
		</td>
	</tr>	
	<?php
}
?>