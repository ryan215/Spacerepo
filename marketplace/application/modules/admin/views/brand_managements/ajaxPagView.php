
<?php 
if(!empty($result['brand_list']))
{
	$i = $result['page']+1;
	foreach($result['brand_list'] as $row)
	{
?>
<tr>
	<td><?php echo $i; ?></td>
	<td>
		<?php
		$image = '<img height="60" width="60" class="img-circle" src="'.base_url().'images/default_user_image.jpg" height="100" width="100">';		
												if((!empty($row->imageName))&&(file_exists('uploads/brand/'.$row->imageName)))											
												{
													$image = '<img height="70" width="70" class="img-circle" src="'.base_url().'uploads/brand/thumb50/'.$row->imageName.'" alt="" />';													
												}
		echo $image;
												?>
	</td>
	<td><?php echo $row->brandName; ?></td>
    
	<td>
		<center><a href="<?php echo base_url().$this->session->userdata('userType').'/brand_management/addEditBrand/'.id_encrypt($row->brandId); ?>" class="btn btn-primary btn-xs tooltips"  data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a></center>
	</td>
	<td>
		<?php
		$change = 1;
		if($row->active)
		{
			$change = 0;
		}
		if($row->active)
		{
		?> 
		<center><button class="btn btn-success btn-sm tooltips"  data-toggle="tooltip" data-placement="top" data-original-title="" onclick="return activeDeac('<?php echo id_encrypt($row->brandId); ?>','<?php echo $change; ?>');">Unblocked</button></center>
		<?php 
		}
		else
		{ 
		?> 
		
		<center><button class="btn btn-danger btn-sm tooltips"  data-toggle="tooltip" data-placement="top" data-original-title="" onclick="return activeDeac('<?php echo id_encrypt($row->brandId); ?>','<?php echo $change; ?>');">Blocked</button></center>
		<?php 
		}
		?>
     </center>		
	</td>									
</tr>
<?php
		$i++;
	}
	if(!empty($result['links']))
	{
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
}
else
{
?>
<tr>
	<td colspan="6" align="center">No Brand Available</td>
</tr>	
<?php
}
?>