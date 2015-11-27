<?php
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row->categoryCode; ?></td>
	<td>
		<center>
			<a href="<?php echo base_url().$this->session->userdata('userType').'/free_shipping_category/free_shipping_category_details/'.id_encrypt($row->freeShipCatId); ?>" class="btn btn-warning btn-xs tooltips" type="button" title="View Details">
				<i class="fa fa-eye" data-toggle="tooltip" title="View Details"></i>
			</a>&nbsp;
			<a href="javascript:void(0);" class="btn btn-danger btn-xs tooltips" type="button" title="Delete" onclick="return delete_free_cat('<?php echo id_encrypt($row->freeShipCatId); ?>');">
				<i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i>
			</a>
		</center>
	</td>
</tr>
	<?php
		$i++;
	}
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
else
{
?>
<tr>
	<td colspan="6" align="center">No Data Found</td>
</tr>	
<?php
}
?>