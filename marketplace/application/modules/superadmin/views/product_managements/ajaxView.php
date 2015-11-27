<?php
if(!empty($product))
{
	$i 	   = $page+1;
	foreach($product as $row)
	{
?>
	<tr>
		<td><?php echo $i; ?></td>
		<td>
			<?php 
			if((!empty($row->imageName))&&(file_exists('uploads/product/thumb50/'.$row->imageName)))
			{
				echo '<img src="'.base_url().'uploads/product/thumb50/'.$row->imageName.'" height="70" width="70" />';
			}
			else
			{
				echo '<img src="'.base_url().'img/no_image.jpg" height="70" width="70"/>';
			}
			?>			
		</td>
        <td><?php echo $row->code; ?></td>
		<td><?php echo $row->productType; ?></td>
		<td>
			<a href="<?php echo base_url().'superadmin/product_management/view/'.id_encrypt($row->productId); ?>" class="btn btn-warning btn-xs tooltips" title="View details">
				<i class="fa fa-eye"></i>
			</a>
		</td>
	</tr>
	<?php
		$i++;
	}
	if(!empty($links))
	{
	?>
	<tr>
		<td colspan="5" align="right">
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
		<td colspan="5" align="center">No Product Available</td>
	</tr>
<?php
}
?>