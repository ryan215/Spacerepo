<?php 
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
?>
<tr>
	<td><?php echo $i; ?></td>
	<?php
	if($this->session->userdata('userType')=='cse')
	{
	?>
	<td>
		<?php 
			if((!empty($row->imageName))&&(file_exists('uploads/product/thumb500_500/'.$row->imageName)))
			{
				echo '<img src="'.base_url().'uploads/product/thumb500_500/'.$row->imageName.'" height="70" width="70" />';
			}
			elseif((!empty($row->imageName))&&(file_exists('uploads/product/thumb50/'.$row->imageName)))
			{
				echo '<img src="'.base_url().'uploads/product/thumb50/'.$row->imageName.'" height="70" width="70" />';
			}
			else
			{
				echo '<img src="'.base_url().'img/no_image.jpg" height="70" width="70"/>';
			}
			?>	
	</td>
	<?php	
	}					
	?>
	<td><?php echo $row->productCodeOveride; ?></td>
	<?php
	if($this->session->userdata('userType')=='cse')
	{
	?>
		<td><?php echo $row->currentPrice; ?></td>
	<?php	
	}					
	?>
	<td><?php echo $row->currentQty; ?></td>
	<?php
	if($this->session->userdata('userType')=='cse')
	{
	?>
	<td>
	<a class="btn btn-warning btn-xs tooltips" title="View Detail" type="button" href="<?php echo base_url().$this->session->userdata('userType').'/product_management/inventory_details/'.id_encrypt($row->organizationProductId); ?>">
			Details
		</a>
	</td>  
	<?php
	}
	?>  
</tr>
<?php
		$i++;
	}
	if(!empty($result['links']))
	{
?>
<tr>
	<td colspan="7" align="right">
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
	<td colspan="7" align="center">No Data Found</td>
</tr>	
<?php
}
?>