<?php 	//echo "<pre>"; print_r($result['segment_list']); exit;
if(!empty($result['segment_list']))
{
	$i = $result['page']+1;
	foreach($result['segment_list'] as $row)
	{
?>
<tr>
	<td><?php echo $i; ?></td>
    <td><?php echo $row->categoryCode; ?></td>
    <td>
		<a class="btn btn-primary btn-xs tooltips"  data-toggle="tooltip" data-placement="top" data-original-title="Edit"  type="button"  href="<?php echo base_url().$this->session->userdata('userType').'/category_management/addEditCategory/'.id_encrypt($row->parentCategoryId).'/'.id_encrypt($row->categoryId); ?>"><i class="fa fa-pencil"></i>
		</a>&nbsp;&nbsp;
		<a class="btn btn-warning btn-xs tooltips"  data-toggle="tooltip" data-placement="top" data-original-title="View"  type="button" href="<?php echo base_url().$this->session->userdata('userType').'/category_management/view_list/'.id_encrypt($row->categoryId); ?>"><i class="fa fa-eye"></i>
		</a>
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
		<center><button class="btn btn-success btn-sm tooltips"  data-toggle="tooltip" data-placement="top" data-original-title="" onclick="return activeDeac('<?php echo id_encrypt($row->categoryId); ?>','<?php echo $change; ?>');">Unblocked</button></center>
		<?php 
		}
		else
		{ 
		?>
		<center><button class="btn btn-danger btn-sm tooltips"  data-toggle="tooltip" data-placement="top" data-original-title="" onclick="return activeDeac('<?php echo id_encrypt($row->categoryId); ?>','<?php echo $change; ?>');">Blocked</button></center>
		<?php 
		}
		?>
	</td>	
</tr>
<?php
		$i++;
	}		
	if(!empty($result['links']))
	{
	?>
<tr>
	<td colspan="4" align="right">
		<div class="pagination"><?php echo $result['links']; ?></div>
	</td>
</tr>
<?php
	}
}
else
{
?>
<tr>
	<td colspan="4" align="center">No Category Available</td>
</tr>
<?php
}
?>