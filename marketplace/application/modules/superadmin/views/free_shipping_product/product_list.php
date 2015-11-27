<?php
if(!empty($productList))
{
	$i = $page+1;
	foreach($productList as $row)
	{
?>
<tr>
	<td><input type="checkbox" name="productList[]" value="<?php echo $row->productId; ?>" style="display:inline-block;" /></td>
	<td>
		<?php 
		$imageUrl = base_url().'img/no_image.jpg';
		if((!empty($row->mainImage))&&(file_exists('uploads/product/thumb500_500/'.$row->mainImage)))
		{
			$imageUrl = base_url().'uploads/product/thumb500_500/'.$row->mainImage;
		}
		elseif((!empty($row->mainImage))&&(file_exists('uploads/product/'.$row->mainImage)))
		{
			$imageUrl = base_url().'uploads/product/'.$row->mainImage;
		}		
		?>
		<img src="<?php echo $imageUrl; ?>" height="70" width="70" />			
	</td>
	<td><?php echo $row->code; ?></td>
	<td><?php echo $row->categoryCode; ?></td>
	<td><?php echo $row->brandName; ?></td>
</tr>
	<?php
		$i++;
	}
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
else
{
?>
<tr>
	<td colspan="6" align="center">No Data Found</td>
</tr>	
<?php
}
?>