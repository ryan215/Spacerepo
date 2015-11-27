<?php 
//echo "<pre>"; print_r($result['list']);
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
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
	<td class="numeric">
		<?php echo $row->email; ?>
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
			<?php echo $result['links']; ?>
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