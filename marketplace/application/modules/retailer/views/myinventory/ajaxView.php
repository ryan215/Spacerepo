<?php
if(!empty($product))
{
	$i 	   = $page+1;
	$array = product_attributes();
	
	foreach($product as $row)
	{
?>
	<tr>
		<td><?php echo $i; ?></td>
		<td>
			<?php 
			if((!empty($row->image_name))&&(file_exists('uploads/product/thumb50/'.$row->image_name)))
			{
				echo '<img src="'.base_url().'uploads/product/thumb50/'.$row->image_name.'" height="70" width="70" />';
			}
			else
			{
				echo '<img src="'.base_url().'img/no_image.jpg" height="70" width="70"/>';
			}
			?>			
		</td>
        <td><?php echo $row->product_name; ?></td>
		
		<td><?php echo $row->inventory; ?></td>
		<td>
			<a href="<?php echo base_url().'retailer/myinventory/view/'.id_encrypt($row->product_id).'/'.id_encrypt($row->product_detail_id); ?>" class="btn btn-success btn-sm">
				View
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
		<td colspan="6" align="right">
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
		<td colspan="6" align="center">No Product Available</td>
	</tr>
<?php
}
?>