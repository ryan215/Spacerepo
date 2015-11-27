<?php
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo ucfirst($row->firstName); ?></td>
        <td><?php echo ucfirst($row->lastName); ?></td>
		<td><?php echo $row->email; ?></td>
		<td>
        	<center>
				<a href="<?php echo base_url().$this->session->userdata('userType').'/customer_management/user_detail/'.id_encrypt($row->customerId); ?>" class="btn btn-warning btn-xs" type="button" title="View Detail">
					<i class="fa fa-eye"></i>
				</a>
			</center>
        </td>
    </tr>
	<?php
		$i++;
	}
	if(!empty($result['links']))
	{
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
}
else
{
?>
	<tr>
		<td colspan="7" align="center">Data No Found</td>
	</tr>
<?php
}
?>