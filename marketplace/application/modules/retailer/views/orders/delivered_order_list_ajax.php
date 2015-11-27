<?php
if(!empty($list))
{
	$i = $page+1;
	foreach($list as $row)
	{
		
?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo date('d-m-Y',$row->order_time); ?></td>
    <td><?php echo $row->customer_order_id; ?></td>
	<td>
		<a class="pr_detail" onclick="product_details('<?php echo id_encrypt($row->order_id); ?>');">
			<?php echo $row->product_name; ?>
		</a>
	</td>
    <td>&#x20A6;<?php echo $row->total_amount; ?></td>
    <td>
		<a href="javascript:void(0);" onclick="show_popup('<?php echo $row->delivered_date; ?>');">
			Delivered
		</a>
	</td>
</tr>	
<?php
		$i++;	
	}
}
?>
