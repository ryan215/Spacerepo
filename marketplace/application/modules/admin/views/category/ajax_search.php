	<?php
	if(!empty($category_list))
	{
		$i = $page+1;
		foreach($category_list as $row)
		{
	?>
		<tr>
        	<td><?php echo $i; ?></td>
			<td><?php echo $row->categoryCode; ?></td>
            <td>
				<button href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="category_form('<?php echo $row->categoryId ;?>');">
					<i class="fa fa-edit"></i>
				</button>			
				<button class="btn btn-round btn-danger" type="button" onclick="delete_category('<?php echo id_encrypt($row->categoryId); ?>');">
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
			<td colspan="5" align="right">
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
			<td colspan="5" align="center">No Category Available</td>
		</tr>
	<?php
	}
	?>