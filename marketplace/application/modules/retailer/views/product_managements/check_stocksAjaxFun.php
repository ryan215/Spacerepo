<?php //echo "<pre>"; print_r($result); exit;
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
			if((!empty($row['imageName']))&&(file_exists('uploads/product/'.$row['imageName'])))
			{
				echo '<img src="'.base_url().'uploads/product/'.$row['imageName'].'" height="70" width="70" />';
			}
			else
			{
				echo '<img src="'.base_url().'img/no_image.jpg" height="70" width="70"/>';
			}
			?>	
	</td>
	
	<td><?php echo $row['code']; ?></td>
	<td>&#x20A6;<?php echo number_format($row['displayPrice'],2); ?></td>
	<?php 
	$sizearr = str_replace(',','',$row['product_size']);
    if(isset($sizearr) && !empty($sizearr))
	{
		$colorArr = explode(',',$row['colorId']);	
	?>
	<td>
		<table width="100%" class="table table-striped   stock_table">
		<tr>
        	<td><strong>Sizes</strong></td>
            <td><strong>Stock</strong></td>
       </tr>
		<?php
		$sizeArr   = explode(',',$row['product_size']);
		$stockArr  = explode(',',$row['stock']);
		$colorcode = '';	
		foreach($sizeArr as $key=>$size)
		{
	  		if(!empty($colorArr))
			{ 
				if($colorcode !=$colorArr[$key])
				{
					$colorcode = $colorArr[$key];
					if(isset($result['color_list'][$colorArr[$key]]))
					{
		?>
		<tr>
        	<td colspan="2">
            	<small style="background-color:<?php if(isset($result['color_list'][$colorArr[$key]])){ echo $result['color_list'][$colorArr[$key]]; } ?>"></small>
            </td>
		</tr>
	  	<?php 
	  				} 
			  	} 
	  		}
	  		?>
			<tr><td><?php echo $size; ?></td><td><?php echo $stockArr[$key]; ?></td></tr>
		<?php 
		}
		?>
		</table>
    </td>
	<?php
	}
	elseif(isset($row['colorId']) && !empty($row['colorId']))
	{
		$stockArr = explode(',',$row['stock']);
	?>	<td><table width="100%" class="table table-striped   stock_table">
	
	
	<tr><td><strong>color</strong></td><td><strong>Stock</strong></td></tr>
	<?php 
	$colorArr=explode(',',$row['colorId']);
	
	foreach($colorArr as $key=> $colordetail)
	{
	?>
		<tr><td><small style="background-color:<?php echo $result['color_list'][$colorArr[$key]];?>"></small></td></td><td><?php  echo $stockArr[$key]; ?></td></tr>
		<?php 
	}
	?>
	</table></td>
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
	<a class="btn btn-warning btn-xs tooltips" title="View Detail" type="button" href="<?php echo base_url().$this->session->userdata('userType').'/product_management/inventory_details/'.id_encrypt($row['organizationProductId']).'/'.id_encrypt($row['organizationId']); ?>">
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