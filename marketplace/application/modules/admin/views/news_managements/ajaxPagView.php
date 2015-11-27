<?php //echo "<pre>"; print_r($result['list']); exit;
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo ucwords($row->firstName); ?></td>
	<td><?php echo ucwords($row->lastName); ?></td>
	<td><?php echo $row->email; ?></td>
	<td><?php echo $row->stateName; ?></td>
	<td><?php echo $row->areaName; ?></td>
	<td>
	<a class="btn btn-warning btn-xs tooltips" title="View Detail" type="button" href="<?php echo base_url().$this->session->userdata('userType').'/news_management/user_detail/'.id_encrypt($row->newsletterId); ?>">
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
	<td colspan="10" align="right">
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
	<td colspan="10" align="center">No Data Found</td>
</tr>	
<?php
}
?>