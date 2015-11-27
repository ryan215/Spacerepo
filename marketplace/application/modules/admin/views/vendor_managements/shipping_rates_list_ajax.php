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
		<td>
        <?php
		if($row->fromWeight<=10)
		{
			?>
		<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/edit_rate/'.id_encrypt($row->shippingRateId); ?>" class="btn btn-info btn-xs" type="button">
			<I class="fa fa-pencil"></I>
		</a>	
		<a href="javascript:void(0);" class="btn btn-danger btn-xs" type="button" onclick="return delete_rate('<?php echo id_encrypt($row->shippingRateId); ?>');">
			<i class="fa fa-trash-o"></i>
		</a>
        <?php
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