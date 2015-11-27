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
		<?php
		if($row->accept_decline==1)
		{
			echo 'Accept';
		}
		elseif($row->accept_decline==2)
		{
			echo 'Decline';
		}
		?>
	</td>
</tr>	
<?php	
	}
}
?>
