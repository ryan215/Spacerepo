<?php
if(!empty($result['user_list']))
{
	$i = $result['page']+1;
	foreach($result['user_list'] as $row)
	{
?>
<tr>
	<td><?php echo $i; ?></td>
	<td>
		<span class="img-cercle">
			<?php
			$image    = $row->imageName;
			if((!empty($image))&&(file_exists('uploads/admin/thumb50/'.$image)))
			{
				echo '<img src="'.base_url().'uploads/admin/thumb50/'.$image.'">';
			}
			else
			{
				echo '<img src="'.base_url().'images/default_user_image.jpg">';
			}
			?>
		</span>
	</td>
	<td class="numeric">
		<?php echo ucwords($row->firstName.' '.$row->middle.' '.$row->lastName); ?>
	</td>
	<td class="numeric">
		<?php echo $row->email; ?>
	</td>
	<td class="numeric">
		<?php 
		if($row->roleId==1)
		{
			echo 'superuser';
		}
		elseif($row->roleId==2)
		{
			echo 'Admin User';
		}
		?>
	</td>
	<td>
		<center>
			<a href="<?php echo base_url(); ?>superadmin/user_management/user_detail/<?php echo id_encrypt($row->employeeId); ?>" class="btn btn-warning btn-xs tooltips" type="button" title="View Details">
				<i class="fa fa-eye"></i>
			</a>
		</center>
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
    		<td colspan="6" align="center">No user available</td>
		</tr>	
		<?php
		}
		?>