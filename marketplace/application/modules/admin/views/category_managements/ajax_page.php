<?php
$urisegment2 = $this->uri->segment(2);

if(!empty($result['segment_list']))
{
	$i = $result['page']+1;
	foreach($result['segment_list'] as $row)
	{
?>
	<tr>
	<button title="" data-placement="top" data-toggle="tooltip" class="btn btn-default tooltips" type="button" data-original-title="Tooltip on top">Tooltip on top</button>
        	<td><?php echo $i; ?></td>
            <td><?php echo $row->categoryCode; ?></td>
            <td>
				<a class="btn btn-primary btn-xs tooltips"  data-toggle="tooltip" data-placement="top" data-original-title="Edit"  type="button"  href="<?php echo base_url().$this->session->userdata('userType').'/'.$urisegment2.'/addEditCategory/'.id_encrypt($row->parentCategoryId).'/'.id_encrypt($row->categoryId); ?>"><i class="fa fa-pencil"></i>
				</a>&nbsp;&nbsp;
				
				<a class="btn btn-warning btn-xs tooltips"  data-toggle="tooltip" data-placement="top" data-original-title="View"  type="button" href="<?php echo base_url().$this->session->userdata('userType').'/'.$urisegment2.'/view_list/'.id_encrypt($row->categoryId); ?>">
					<i class="fa fa-eye"></i>
				</a>
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
			<td colspan="4" align="center">No Category Available</td>
		</tr>
	<?php
	}
	?>