<?php //echo "<pre>"; print_r($result['list']); exit;
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
	?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $row->dropCenterName; ?></td>
		<td><?php echo $row->stateName; ?></td>
		<td><?php echo $row->areaName; ?></td>
		<td><?php echo $row->cityName; ?></td>
		<td><?php echo $row->fromWeight; ?></td>
		<td><?php echo $row->toWeight; ?></td>
		<td>&#x20A6;<?php echo number_format($row->amount,2); ?></td>
		<td><?php echo $row->ETA; ?></td>
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
	<td colspan="10" align="center">No Data Found</td>
</tr>	
<?php
}
?>