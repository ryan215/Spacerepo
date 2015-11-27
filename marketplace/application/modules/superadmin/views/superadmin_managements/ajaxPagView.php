<?php
if(!empty($user_list))
{
	$i = $page+1;
	foreach($user_list as $row)
	{
?>
<tr>
	<td><?php echo $i; ?></td>
	<td>
		<span class="img-cercle">
			<?php
			$image    = $row->image;
			if((!empty($image))&&(file_exists('uploads/superadmin/thumb50/'.$image)))
			{
				echo '<img src="'.base_url().'uploads/superadmin/thumb50/'.$image.'">';
			}
			else
			{
				echo '<img src="'.base_url().'images/default_user_image.jpg">';
			}
			?>
		</span>
	</td>
	<td class="numeric">
		<?php echo ucwords($row->first_name.' '.$row->last_name); ?>
	</td>
	<td class="numeric">
		<?php echo $row->email; ?>
	</td>
    <td>
		<?php
		if($row->gender)
		{
			echo 'Male';
		}
		else
		{
			echo 'Female'; 
		}
		?>
	</td>
			<td>
			<a href="<?php echo base_url(); ?>superadmin/superadmin_management/user_detail/<?php echo id_encrypt($row->user_id); ?>" class="btn btn-round btn-success" type="button">
				View
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
    		<td colspan="6" align="center">No user available</td>
		</tr>	
		<?php
		}
		?>