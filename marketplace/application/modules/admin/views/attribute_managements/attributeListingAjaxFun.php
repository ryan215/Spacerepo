<?php 
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row->description; ?></td>
	<td class="text-center">
		<a href="<?php echo base_url().$this->session->userdata('userType').'/attribute_management/view_attribute_list/'.id_encrypt($row->productTypeId); ?>" class="btn btn-warning btn-xs tooltips">
			<i class="fa fa-eye"></i>
		</a>
	</td>									
</tr>
<?php
		$i++;
	}
	if(!empty($result['links']))
	{
?>
<tr>
	<td colspan="5" align="right">
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
	<td colspan="5" align="center">No Attribute List Available</td>
</tr>	
<?php
}
?>