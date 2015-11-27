<?php //echo "<pre>"; print_r($result['list']); exit;
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
		
?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo substr($row->createDt,0,10).'<br>'.substr($row->createDt,11).'<br>'.$row->customOrderId; ?></td>
	<td>
    <table>
    
    <tr>
  	<td>
    
    
		<?php 
		if((!empty($row->productImageName))&&(file_exists('uploads/product/thumb500_500/'.$row->productImageName)))
		{
			echo '<img src="'.base_url().'uploads/product/thumb500_500/'.$row->productImageName.'" height="70" width="70" />';
		}
		elseif((!empty($row->productImageName))&&(file_exists('uploads/product/'.$row->productImageName)))
		{
			echo '<img src="'.base_url().'uploads/product/'.$row->productImageName.'" height="70" width="70" />';
		}
		else
		{
			echo '<img src="'.base_url().'img/no_image.jpg" height="70" width="70"/>';
		}
		?>
	
    </td>
    
    <td width="100%">
    <table width="100%">
    <tr>
    <th width="30%">Name</th> 
    <td width="70%"><?php echo $row->code; ?></td>   
    </tr>
    <tr>    
    <th>Price</th>
    <td><?php echo  number_format($row->chargedAmount,2); ?></td>
    </tr>
    <tr>
    <th>Shipping Price</th>
    <td><?php echo number_format($row->shippingAmount,2)?></td>
    </tr>
    <tr>
	<?php
	if(!empty($row->colorCode))
	{
	?>
    	<th>Color</th>
	    <td>
			<a class="btn btn-xs color_box active_color color_static" style="margin-left: 0px; margin-right: 0px;background-color:<?php echo $row->colorCode; ?>" href="javascript:void(0);">
			</a>
		</td>
    </tr>
	<?php
	}
	if(!empty($row->size))
	{
	?>
    <tr>
    <th>Size</th>
    <td> <?php echo  $row->size; ?> </td>
    </tr>
	<?php
	}
	?>
    </table>
    </td>
    </tr>
    </table>
	<td>
		<?php echo $row->trackingNbr; ?>
	</td>
    <td><?php 
		if($row->orderStatusId==1)
		{
			echo 'New Order';
		}
		elseif($row->orderStatusId==2)
		{
			echo 'Confirm Order';
		}
		elseif($row->orderStatusId==3)
		{
			echo 'Ready To Be Shipped Order';
		}
		elseif($row->orderStatusId==4)
		{
			echo 'In Transit Order';
		}
		else
		{
			echo 'Delivered';
		}
		
	?></td>
    <td>
		<center>
			<a href="<?php echo base_url().$this->session->userdata('userType').'/search_order/search_order_view/'.id_encrypt($row->orderId); ?>" class="btn btn-warning btn-xs" type="button" title="View Detail">
			<i class="fa fa-eye"></i>
		</a></center>
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
	<td colspan="7" align="center">Data Not Found</td>
</tr>	
<?php
}
?>
<style>
.color_box {margin-right:5px;  border: 2px #eee solid; padding:15px;}
.color_static {   padding: 8px;margin-left: 5px; }
</style>  	