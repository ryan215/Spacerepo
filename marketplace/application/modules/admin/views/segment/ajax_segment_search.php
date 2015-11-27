	<?php
	if(!empty($segment_list))
	{
		$i = $page+1;
		foreach($segment_list as $row)
		{
	?>
		<tr>
        	<td><?php echo $i; ?></td>
            <td><?php echo $row->categoryCode; ?></td>
            <td>
				<button href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="segment_form('<?php echo $row->categoryId ;?>');">
					<i class="fa fa-edit"></i>
				</button>
				<button class="btn btn-round btn-danger" type="button" onclick="delete_segment('<?php echo id_encrypt($row->categoryId); ?>');">
					Delete
				</button>
				<a class="btn btn-round btn-danger" type="button" href="<?php echo base_url().'admin/category/index/'.id_encrypt($row->categoryId); ?>">
					View
				</a>
			</td>
    	</tr>
		<?php
			$i++;
		}
		
		if(!empty($links))
		{
		?>
		<tr>
			<td colspan="4" align="right">
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
			<td colspan="4" align="center">No Segment Available</td>
		</tr>
	<?php
	}
	?>