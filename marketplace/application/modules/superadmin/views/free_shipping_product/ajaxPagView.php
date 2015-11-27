<?php
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
?>
<tr>
	<td><?php echo $i; ?></td>
	<td>
		<?php 
		$imageUrl = base_url().'img/no_image.jpg';
		if((!empty($row->imageName))&&(file_exists('uploads/product/thumb500_500/'.$row->imageName)))
		{
			$imageUrl = base_url().'uploads/product/thumb500_500/'.$row->imageName;
		}
		elseif((!empty($row->imageName))&&(file_exists('uploads/product/'.$row->imageName)))
		{
			$imageUrl = base_url().'uploads/product/'.$row->imageName;
		}		
		?>
		<img src="<?php echo $imageUrl; ?>" height="70" width="70" />	
	</td>
	<td><?php echo $row->code; ?></td>
	<td><?php echo $row->categoryCode; ?></td>
	<td><?php echo $row->brandName; ?></td>
	<td>
		<center>
			<a href="<?php echo base_url().$this->session->userdata('userType').'/free_shipping_product/free_shipping_product_details/'.id_encrypt($row->productId); ?>" class="btn btn-warning btn-xs tooltips" type="button" title="View Details">
				<i class="fa fa-eye"></i>
			</a>&nbsp;
			<a href="javascript:void(0);" class="btn btn-danger btn-xs tooltips" type="button" title="Delete" onclick="return delete_free_product('<?php echo id_encrypt($row->freeShipPrdId); ?>');">
				<i class="fa fa-trash-o"></i>
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