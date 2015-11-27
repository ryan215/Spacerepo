	<?php
	if(!empty($sub_cat_list))
	{
		$i = $page+1;
		foreach($sub_cat_list as $row)
		{
	?>
		<tr>
        	<td><?php echo $i; ?></td>            
			<td><?php echo $row->segment_name; ?></td>
			<td><?php echo $row->category_name; ?></td>
			<td><?php echo $row->sub_category_name; ?></td>
			<td><?php echo $row->sub_category2_name; ?></td>
			<td><?php echo $row->sub_category3_name; ?></td>
            <td>
				<a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="sub_category_form('<?php echo $row->sub_category3_id ;?>');">
					<i class="fa fa-edit"></i>
				</a>
			</td>
			<td>
				<button class="btn btn-round btn-danger" type="button" onclick="delete_sub_category3('<?php echo id_encrypt($row->sub_category3_id); ?>');">
					Delete
				</button>
			</td>
    	</tr>
		<?php
			$i++;
		}
		
		if(!empty($links))
		{
		?>
		<tr>
			<td colspan="8" align="right">
				<div class="pagination">
					<?php echo $links; ?>
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
			<td colspan="8" align="center">No Sub Category3 Available</td>
		</tr>
	<?php
	}
	?>