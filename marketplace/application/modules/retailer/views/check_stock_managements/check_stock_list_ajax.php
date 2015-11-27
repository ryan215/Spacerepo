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
	<td><?php echo '&#x20A6;'.number_format($row['displayPrice'],2); ?></td>
	<td>
	<?php
	$organizationColorsSizes = $this->product_m->organization_color_size_details($row['organizationProductId']);
	$organizationColorsSizeArray = array();
	$organizationSizesArray		 = array();
	if(!empty($organizationColorsSizes))
	{
			foreach($organizationColorsSizes as $rowColorSize)
			{
				if(!empty($rowColorSize->colorId))
				{
					$organizationColorsSizeArray[$rowColorSize->colorId]['organizationProductColorId'] = $rowColorSize->organizationProductColorId;
					$organizationColorsSizeArray[$rowColorSize->colorId]['colorCode'] 	 = $rowColorSize->colorCode;
					$organizationColorsSizeArray[$rowColorSize->colorId]['currentStock'] = $rowColorSize->currentStock;
					
					if(!empty($rowColorSize->productSizeId))
					{
						if(!empty($rowColorSize->sizes))
						{
							$organizationColorsSizeArray[$rowColorSize->colorId]['sizes'][$rowColorSize->sizes]['currentStock'] = $rowColorSize->currentStock;
						}
					}
				}
			}
		}
		
	if((empty($organizationColorsSizeArray))&&(count($organizationColorsSizeArray)<1))
	{
			if(!empty($organizationColorsSizes))
			{
				foreach($organizationColorsSizes as $rowCol)
				{
					if(!empty($rowCol->productSizeId))
					{
						if(!empty($rowCol->sizes))
						{
							$organizationSizesArray[$rowCol->sizes]['currentStock'] = $rowCol->currentStock;
						}
					}
				}
			}
		}
		
	if(!empty($organizationColorsSizeArray))
	{
		$flag = 1;
		foreach($organizationColorsSizeArray as $colorKey=>$colorRow)
		{
			if(!empty($colorRow['sizes']))
			{
				foreach($colorRow['sizes'] as $sizeKey=>$sizeRow)
				{
					$flag = 0;
				}
			}
		}
		if($flag)
		{
		?>
			<table width="100%" class="table table-striped   stock_table">
				<tr><td><strong>color</strong></td><td><strong>Stock</strong></td></tr>
				<?php
				foreach($organizationColorsSizeArray as $colorKey=>$colorRow)
				{
				?>
				<tr>
					<td>
						<small style="background-color:<?php echo $colorRow['colorCode']; ?>"></small>
					</td>
					<td><?php echo $colorRow['currentStock']; ?></td>
				</tr>
				<?php
				}
				?> 
			</table>
		<?php
		}
		else
		{
		?>
		<table width="100%" class="table table-striped   stock_table">
			<tr>
	        	<td><strong>Sizes</strong></td>
	            <td><strong>Stock</strong></td>
	       </tr>
			<?php
			foreach($organizationColorsSizeArray as $colorKey=>$colorRow)
			{
			?>
			<tr>
	        	<td colspan="2">
					<small style="background-color:<?php echo $colorRow['colorCode']; ?>"></small>
        	    </td>
			</tr>
				<?php
				if(!empty($colorRow['sizes']))
				{
					foreach($colorRow['sizes'] as $sizeKey=>$sizeRow)
					{
					
				?>
					<tr>
						<td><?php echo $sizeKey; ?></td><td><?php echo $sizeRow['currentStock']; ?></td>
					</tr>
			  	<?php
					}
				}
			}
			?>
		</table>
		<?php
		}
	}
	elseif(!empty($organizationSizesArray))
	{
	?>
		<table width="100%" class="table table-striped   stock_table">
			<tr><td><strong>Size</strong></td><td><strong>Stock</strong></td></tr>
			<?php
			foreach($organizationSizesArray as $sizeKey=>$sizeRow)
			{
			?>
			<tr><td><?php echo $sizeKey; ?></td><td><?php echo $sizeRow['currentStock']; ?></td></tr>
	  		<?php
			}
			?> 
		</table>
	<?php
	}
	else
	{
		echo $row['currentQty'];
	}
	?>
	</td>
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