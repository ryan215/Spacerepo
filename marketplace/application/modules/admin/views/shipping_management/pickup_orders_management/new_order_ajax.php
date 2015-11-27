<?php
if(!empty($list))
{
	$i = $page+1;
	foreach($list as $row)
	{
	?>
	<tr>
		<td><input type="checkbox" class="chkbx" name="change_status[<?php echo id_encrypt($row->order_id); ?>]"></td>
		<td><?php echo $i; ?></td>
		<td><?php echo date("d-m-Y",$row->order_time); ?></td>
		<td><?php echo $row->customer_order_id; ?></td>
		<td><?php echo ucwords($row->user_name); ?>,<br><?php echo $row->user_email; ?></td>
		<td><?php echo $row->shipping_vendor_name; ?>,<br> <?php echo $row->shipping_vendor_email; ?></td>
		<td>&#x20A6;<?php echo number_format($row->chargedAmount*$row->quantity,2); ?></td>
		
		
		<td>
			<center><a href="<?php echo base_url().'admin/order_management/new_order_view/'.id_encrypt($row->order_id); ?>" class="btn btn-warning btn-xs">
			<i class="fa fa-eye"></i>	
			</a></center>
		</td>
	</tr>
	<?php
		$i++;
	}
	
	if(!empty($links))
	{
	?>
	<tr>
		<td colspan="12" align="right">
			<div class="pagination">
				<?php echo $links; ?>
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
		<td colspan="12" align="center">
			No New Order Available
		</td>
	</tr>	
	<?php
}
?>