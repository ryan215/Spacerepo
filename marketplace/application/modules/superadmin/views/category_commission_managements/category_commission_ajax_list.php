<?php
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
?>
	<tr>
		<td><?php echo $i; ?></td>
        <td><?php echo $row->categoryCode; ?></td>
        <td><?php echo $row->commission; ?></td>
        <td>
			<a class="btn btn-primary btn-xs tooltips"  data-toggle="tooltip" data-placement="top" data-original-title="Edit"  type="button"  href="<?php echo base_url().$this->session->userdata('userType').'/category_commission_management/edit_commission/'.id_encrypt($row->categoryId); ?>"><i class="fa fa-pencil"></i>
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