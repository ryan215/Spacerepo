<?php 
//echo "<pre>"; print_r($result['list']);
if(!empty($employee_list))
{
	$i = $page+1;
	foreach($employee_list as $row)
	{
?>
<tr>
	<td><?php echo $i; ?></td>
	<td>
		<span class="img-cercle">
			<?php
			$image    = $row->imageName;
			if((!empty($image))&&(file_exists('uploads/cse/thumb50/'.$image)))
			{
				echo '<img src="'.base_url().'uploads/cse/thumb50/'.$image.'">';
			}
			else
			{
				echo '<img src="'.base_url().'images/default_user_image.jpg">';
			}
			?>
		</span>
	</td>
	<td class="numeric">
		<?php echo ucwords($row->firstName.' '.$row->lastName); ?>
	</td>
	<td>
		<a href="<?php echo base_url().$this->session->userdata('userType').'/cse_management/user_detail/'.id_encrypt($row->employeeId); ?>" class="btn btn-warning btn-xs" type="button" title="View Detail">
			<i class="fa fa-eye"></i>
		</a>
	</td>										
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
	<td colspan="5" align="center">No Data  Found</td>
</tr>	
<?php
}
?>