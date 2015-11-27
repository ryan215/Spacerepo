<?php 
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
	<td><?php echo $row->totalHit; ?></td>
	<td><?php echo $row->totalWeight; ?></td>
    <td><?php echo date('Y-m-d H:i:s',$row->lastModifiedTime); ?></td>
    <td><a href="javascript:void(0);" onclick="delete_shipping_bounce('<?php echo id_encrypt($row->shippingBounceId); ?>');"><i class="fa fa-trash-o"></i></a></td>
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
?>