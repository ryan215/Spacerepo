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