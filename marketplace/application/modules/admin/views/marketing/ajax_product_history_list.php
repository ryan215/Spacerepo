<?php //echo "<pre>";print_r($result['list']); exit;
if(!empty($list))
{
	$i = $page+1;
	foreach($list as $row)
	{
		
		?>
		<tr>
		<td><?php echo $i; ?></td>
		<td><?php 
			if((!empty($row->imageName))&&(file_exists('uploads/product/thumb500_500/'.$row->imageName)))
			{
				echo '<img src="'.base_url().'uploads/product/thumb500_500/'.$row->imageName.'" height="70" width="70" />';
			}
			elseif((!empty($row->imageName))&&(file_exists('uploads/product/'.$row->imageName)))
			{
				echo '<img src="'.base_url().'uploads/product/'.$row->imageName.'" height="70" width="70" />';
			}
			else
			{
				echo '<img src="'.base_url().'img/no_image.jpg" height="70" width="70"/>';
			}
			?>			</td>
		<td><?php echo $row->code; ?></td>
		<td><?php echo $row->categoryCode; ?></td>
		<td>&#x20A6;<?php echo $row->currentPrice; ?></td>
		<td><?php echo $row->currentQty; ?></td>
		<td><a href="<?php echo base_url().$this->session->userdata('userType'); ?>/product_marketing_management/history_product_view/<?php echo id_encrypt($row->marketingProductId);?>" class="btn btn-warning btn-xs tooltips" title="View details">
				<i class="fa fa-eye"></i>
			</a></td>
		</tr>
		<?php
		$i++;
	}
	
	
	if(!empty($links))
	{
	?>
	<tr>
		<td colspan="7" align="right">
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
		<td colspan="7" align="center">No Product Available</td>
	</tr>
<?php
}