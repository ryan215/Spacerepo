<?php
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
	?>
	<tr>
		<td><?php echo $i; ?></td>		
		<td><?php echo $row->name; ?></td>
		<td><?php echo $row->stateName; ?></td>
		<td><?php echo $row->area; ?></td>
		<td><?php echo $row->city; ?></td>
		<?php
		$userRole = $this->session->userdata ('userRole');
if(empty($userRole))
{
?>
		<td><a href="<?php echo base_url().$this->session->userdata('userType').'/location_management/addEditZip/'.id_encrypt($row->zipId); ?>" class="btn btn-primary btn-xs tooltips"  data-toggle="tooltip" data-placement="top" data-original-title="Edit"  type="button"><i class="fa fa-pencil"></i></a></td>		
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
		<td colspan="7" align="right">
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
   	<td colspan="7" align="center">No Data Found</td>
</tr>	
<?php
}
?>