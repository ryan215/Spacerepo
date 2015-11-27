<?php
if(!empty($list))
{
	$i = $page+1;
	foreach($list as $row)
	{
	?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $row->name; ?></td>
		<?php
		$userRole = $this->session->userdata('userRole');
		if(empty($userRole))
		{
		?>
		<td><center><a href="<?php echo base_url().$this->session->userdata('userType').'/location_management/addEditCountry/'.id_encrypt($row->countryId); ?>" class="btn btn-primary btn-xs tooltips"  data-toggle="tooltip" data-placement="top" data-original-title="Edit"  type="button"><i class="fa fa-pencil"></i></a></center></td>									
		<?php
		}
		?>
	</tr>
	<?php
		$i++;
	}
	if(!empty($links))
	{
	?>
	<tr>
		<td colspan="3" align="right">
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
   	<td colspan="3" align="center">No Country available</td>
</tr>	
<?php
}
?>