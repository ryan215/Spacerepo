<?php //echo "<pre>"; print_r($result); exit;
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
?>
<tr>
	<td>
		<?php echo $i; ?>
	</td>
	<td>
		<?php 
		if((!empty($row['imageName']))&&(file_exists('uploads/product/'.$row['imageName'])))
		{
		?>
			<img src="<?php echo base_url().'uploads/product/'.$row['imageName']; ?>" height="70" width="70" />
		<?php
		}
		else
		{
		?>
			<img src="<?php echo base_url().'img/no_image.jpg'; ?>" height="70" width="70"/>
		<?php
		}
		?>	
	</td>	
	<td><?php echo $row['code']; ?></td>
	<td>&#x20A6;<?php echo number_format($row['displayPrice'],2); ?></td>
	<?php
	$organizationColors 	 = $this->product_m->organization_product_colors($row['organizationProductId']);
	$organizationSizes  	 = $this->product_m->organization_product_sizes($row['organizationProductId']); 
	$organizationColorsArray = array();
	$organizationSizesArray  = array();
	
	if(!empty($organizationColors))
	{
		foreach($organizationColors as $colorRow)
		{
			$organizationColorsArray[$colorRow->colorCode] = $colorRow->currentStock; 
		}
	}
	
	if(!empty($organizationSizes))
	{
		foreach($organizationSizes as $sizeRow)
		{
			if(!empty($sizeRow->size))
			{
				$organizationSizesArray[$sizeRow->size] = $sizeRow->currentStock;
			}
			elseif(!empty($sizeRow->sizes))
			{
				$expArr = explode(',',$sizeRow->sizes);
				foreach($expArr as $expRow)
				{
					$organizationSizesArray[$expRow] = $sizeRow->currentStock;
				}
				
			}	
		}
	}
	
	if((!empty($organizationColorsArray))&&(!empty($organizationSizesArray)))
	{
	?>
	<td>
		<table width="100%" class="table table-striped   stock_table">
		<tr>
        	<td><strong>Sizes</strong></td>
            <td><strong>Stock</strong></td>
       </tr>
		<?php
		foreach($organizationColorsArray as $colorKey=>$colorRow)
		{
		?>
		<tr>
        	<td colspan="2">
            	<small style="background-color:<?php echo $colorKey; ?>"></small>
            </td>
		</tr>
		<?php
			foreach($organizationSizesArray as $sizeKey=>$sizeRow)
			{
		?>
				<tr><td><?php echo $sizeKey; ?></td><td><?php echo $sizeRow; ?></td></tr>
	  	<?php
			}
		}
		?>
		</table>
    </td>
	<?php
	}
	elseif(!empty($organizationColorsArray))
	{
	?>
		<td>
			<table width="100%" class="table table-striped   stock_table">
				<tr><td><strong>color</strong></td><td><strong>Stock</strong></td></tr>
				<?php
				foreach($organizationColorsArray as $colorKey=>$colorRow)
				{
				?>
				<tr>
					<td>
						<small style="background-color:<?php echo $colorKey; ?>"></small>
					</td>
					<td><?php  echo $colorRow; ?></td>
				</tr>
				<?php
				}
				?> 
			</table>
		</td>
	<?php 
	}
	elseif(!empty($organizationSizesArray))
	{
	?>
		<td>
			<table width="100%" class="table table-striped   stock_table">
				<tr><td><strong>Size</strong></td><td><strong>Stock</strong></td></tr>
				<?php
				foreach($organizationSizesArray as $sizeKey=>$sizeRow)
				{
				?>
				<tr><td><?php echo $sizeKey; ?></td><td><?php echo $sizeRow; ?></td></tr>
	  			<?php
				}
				?> 
			</table>
		</td>
	<?php 
	}
	else
	{
	?>
		<td><?php echo $row['currentQty']; ?></td>
	<?php 
	}
	?>
	<td>
		<a class="btn btn-warning btn-xs tooltips" title="View Detail" type="button" href="<?php echo base_url().$this->session->userdata('userType').'/check_stock_management/inventory_details/'.id_encrypt($row['organizationProductId']).'/'.id_encrypt($row['organizationId']); ?>">
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
<style>
.stock_table tr td{ padding:5px !important;
}
</style>