<?php
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
	?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $row->countryName; ?></td>
		<td><?php echo $row->stateName; ?></td>
		<?php
		$userRole = $this->session->userdata ('userRole');
if(empty($userRole))
{
?>
		<td><center><a href="<?php echo base_url().$this->session->userdata('userType').'/location_management/addEditState/'.id_encrypt($row->stateId); ?>" class="btn btn-primary btn-xs tooltips"  data-toggle="tooltip" data-placement="top" data-original-title="Edit"  type="button"><i class="fa fa-pencil"></i></a></center></td>		
		<?php
		}
		?>
	</tr>
	<?php
		$i++;
	}
	if(!empty($result['links']))
	{
	?>
	<tr>
		<td colspan="5" align="right">
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
   	<td colspan="5" align="center">No State available</td>
</tr>	
<?php
}
?>